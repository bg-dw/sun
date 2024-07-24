<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\M_home;
use App\Models\M_presensi;
use App\Models\M_kelas;
use App\Models\M_siswa;
use App\Models\M_dashboard;

class Dashboard extends BaseController
{
	protected $home, $presensi, $dashboard, $kelas, $siswa;
	public function __construct()
	{
		$this->home = new M_home();
		$this->presensi = new M_presensi();
		$this->dashboard = new M_dashboard();
		$this->kelas = new M_kelas();
		$this->siswa = new M_siswa();
	}

	public function index()
	{
		$data['key'] = $this->get_mac();
		if ($this->itr()) {
			return redirect()->route(bin2hex('login'));
		} else {
			return view('V_reg', $data);
		}
	}

	public function generate()
	{
		$res = $this->gen_code();
		$data['in_key'] = $this->enc($this->get_mac());
		$data['unc'] = $this->enc($this->get_mac() . ".BUDI-UTOMO");

		if ($res["cek"]) {
			$data["status"] = 1;
			$data["pesan"] = "Kode Berhasil Dibuat!";
		} else {
			$data["status"] = 0;
			$data["pesan"] = "Kode Gagal Dibuat!";
		}

		return json_encode($data);
	}
	public function unlock()
	{
		if ($this->request->isAJAX()) {
			$inp_key = $this->request->getPost('in_key');
			$get_key = explode('.', $this->dec($inp_key));
			$res = $this->gen_code();
			$mc = explode('.', $this->dec($res['unc']));

			//dir key
			$dir = realpath($_SERVER["DOCUMENT_ROOT"]) . '\sun\app\Code';

			$cek = false;
			if ($res['cek']) {
				if ($this->enc($mc[0]) === $this->enc($get_key[0])) {
					$file = $dir . '\key.txt';
					$hash = $res['unc'];
					// using the FILE_APPEND flag to append the content to the end of the file
					// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
					file_put_contents($file, $hash, FILE_APPEND | LOCK_EX);
					$cek = true;
				}
			}
			return json_encode($cek);
		}
	}

	public function scan()
	{
		$rec = $this->dashboard->get_all_data();
		$total = 0;
		if ($rec) {
			$total = $rec['L'] + $rec['P'];
		}
		$data['total_siswa'] = $total;
		return view('V_scan', $data);
	}

	//update siswa yang tidak melakukan absensi
	public function auto_task()
	{
		if (!$this->isSunday("Y-m-d")): //jika bukan hari minggu
			$rec = $this->presensi->get_today(); //id yang sudah absen
			$aTmp1[] = "";
			$aTmp2[] = "";
			foreach ($rec as $aV) {
				$aTmp1[] = $aV['id_absensi'];
			}
			$master = $this->presensi->get_id_presensi(); //semua data id
			foreach ($master as $aV) {
				$aTmp2[] = $aV['id_absensi'];
			}

			$tmp = array_diff($aTmp2, $aTmp1); //id yang belum absen
			$data_input = array_values($tmp); //reindex array
			$suc = 0;
			$err = 0;
			$skip = 0;
			if ($data_input) {
				for ($i = 0; $i < count($data_input); $i++) { //looping sebanyak id_absensi
					$cek = $this->home->sudah_absen($data_input[$i]);
					if ($cek) {
						$skip += 1;
					} else {
						if ($data_input[$i] != "") {
							$data = [
								'id_detail_absensi' => md5(microtime()),
								'id_absensi' => $data_input[$i],
								'jam_absensi' => date('H:i:s'),
								'tgl_absensi' => date('Y-m-d'),
								'absensi' => "alpha",
								'jenis_absensi' => 'auto'
							];
							$set_data = $this->home->simpan($data);
							if ($set_data) {
								$suc += 1;
							} else {
								$err += 1;
							}
						}
					}
				}
			}
			return json_encode(['success' => $suc, 'failed' => $err, 'skiped' => $skip]);
		endif;
	}

	//get absensi hari ini
	public function get_absen()
	{
		if ($this->request->isAJAX()) {
			// microtime();
			$kelas = $this->request->getPost('d_kelas');
			$get_data = $this->home->get_presensi($kelas);
			return json_encode($get_data);
		}
	}
	public function put_absen()
	{
		$tot_today = $this->home->get_tot_today(); //get before input
		if ($this->request->isAJAX()) {
			$rfid = $this->request->getPost('in_rfid');
			$get_data = $this->home->get_presensi_by_rfid($rfid);
			$end = strtotime('08:00:00');
			$start = strtotime('04:59:00');
			$batas = strtotime('07:00:59');
			$now = strtotime(date('H:i:s'));
			$absen = "";
			if (($now < $end) && ($now > $start)): //waktu perekaman presensi
				if ($get_data) { //get rfid
					$cek = $this->home->sudah_absen($get_data[0]->id_absensi);
					$pic = $this->siswa->get_pic($get_data[0]->id_siswa);
					$pic_result = "";
					if ($pic) {
						$pic_result = $pic['pic_siswa'];
					}
					if ($cek) { //jika data sudah absen
						return json_encode(['status' => 'failed', 'isi' => 'Sudah Absen', 'kelas' => '', 'total' => $tot_today['total']]);
					} else { //jika belum absen
						if ($now > $batas) {
							$absen = "telat";
						} else {
							$absen = "hadir";
						}
						$data = [
							'id_detail_absensi' => md5(microtime()),
							'id_absensi' => $get_data[0]->id_absensi,
							'jam_absensi' => date('H:i:s'),
							'tgl_absensi' => date('Y-m-d'),
							'absensi' => $absen,
							'jenis_absensi' => 'rfid'
						];
						$set_data = $this->home->simpan($data);
						$tot_today = $this->home->get_tot_today();
						return json_encode(['status' => 'success', 'isi' => $set_data, 'kelas' => $get_data[0]->kelas, 'jam' => date('H:i:s'), 'pic' => $pic_result, 'nama' => $pic['nama'], 'total' => $tot_today['total']]);
					}
				} else {
					return json_encode(['status' => 'failed', 'isi' => 'no rfid', 'kelas' => '', 'total' => $tot_today['total']]);
				}
			else:
				return json_encode(['status' => 'failed', 'isi' => 'lewat jam', 'kelas' => '', 'total' => $tot_today['total']]);
			endif;
		} else {
			return json_encode(['status' => 'failed', 'isi' => 'Bukan Ajax Req', 'kelas' => '', 'total' => $tot_today['total']]);
		}
	}

	//get total absensi terakhir
	public function get_total()
	{
		if ($this->request->isAJAX()) {
			$kelas = $this->request->getPost('d_kelas');
			$get_data = $this->home->get_total_absensi($kelas);
			return json_encode($get_data);
		} else {
			return json_encode("Bukan Ajax Req");
		}
	}
}
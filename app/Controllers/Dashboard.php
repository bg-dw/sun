<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\M_home;
use App\Models\M_kelas;
use App\Models\M_siswa;
use App\Models\M_dashboard;

class Dashboard extends BaseController
{
	protected $home, $dashboard, $kelas, $siswa;
	public function __construct()
	{
		$this->home = new M_home();
		$this->dashboard = new M_dashboard();
		$this->kelas = new M_kelas();
		$this->siswa = new M_siswa();
	}
	public function index()
	{
		return view('V_dashboard');
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
		// return view('V_scan');
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
			$end = strtotime('14:30:00');
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
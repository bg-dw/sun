<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\M_home;
use App\Models\M_kelas;

class Dashboard extends BaseController
{
	protected $home, $kelas;
	public function __construct()
	{
		$this->home = new M_home();
		$this->kelas = new M_kelas();
	}
	public function index()
	{
		return view('V_dashboard');
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
		if ($this->request->isAJAX()) {
			$rfid = $this->request->getPost('in_rfid');
			$get_data = $this->home->get_presensi_by_rfid($rfid);
			$end = strtotime('07:30:00');
			$start = strtotime('05:59:00');
			$batas = strtotime('07:00:59');
			$now = strtotime(date('H:i:s'));
			$absen = "";
			if (($now < $end) && ($now > $start)): //jika kurang dari jam 7:30 pagi
				if ($get_data) { //get rfid
					$cek = $this->home->sudah_absen($get_data[0]->id_absensi);
					if ($cek) { //jika data sudah absen
						return json_encode(['status' => 'failed', 'isi' => '', 'kelas' => '']);
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
						return json_encode(['status' => 'success', 'isi' => $set_data, 'kelas' => $get_data[0]->kelas]);
					}
				} else {
					return json_encode(['status' => 'failed', 'isi' => 'no rfid', 'kelas' => '']);
				}
			else:
				return json_encode(['status' => 'failed', 'isi' => 'lewat jam', 'kelas' => '']);
			endif;
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
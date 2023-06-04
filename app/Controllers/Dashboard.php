<?php

namespace App\Controllers;

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
			if ($get_data) {
				$data = [
					'id_detail_absensi' => md5(microtime()),
					'id_absensi' => $get_data[0]->id_absensi,
					'jam_absensi' => date('H:i:s'),
					'tgl_absensi' => date('Y-m-d'),
					'absensi' => 'hadir',
					'jenis_absensi' => 'rfid'
				];
				$set_data = $this->home->simpan($data);
				return json_encode(['status' => 'success', 'isi' => $set_data, 'kelas' => $get_data[0]->kelas]);
			} else {
				return json_encode(['status' => 'failed', 'isi' => '', 'kelas' => '']);
			}
		}
	}

	//get total absensi terakhir
	public function get_total()
	{
		if ($this->request->isAJAX()) {
			$kelas = $this->request->getPost('d_kelas');
			$get_data = $this->home->get_total_absensi($kelas);
			return json_encode($get_data);
		}
	}
}
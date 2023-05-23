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
		// $kelas = $this->request->getVar('kelas');
		// $get_data = $this->home->get_presensi($kelas = null);
		if ($this->request->isAJAX()) {
			// microtime();
			$kelas = $this->request->getPost('d_kelas');
			// var_dump($this->request->getPost('d_kelas'));
			$get_data = $this->home->get_presensi($kelas);
			// 	return json_encode(['success' => 'success', 'csrf' => csrf_hash(), 'query' => $get_data]);
			return json_encode($get_data);
		}
	}
	public function put_absen()
	{
		if ($this->request->isAJAX()) {
			$rfid = $this->request->getPost('in_rfid');
			// var_dump($this->request->getPost('d_kelas'));
			$get_data = $this->home->get_presensi_by_rfid($rfid);
			if ($get_data) {
				$data = [
					'id_detail_absensi' => md5(microtime()),
					'id_absensi' => $get_data[0]->id_absensi,
					'jam_absensi' => date('H:i:s'),
					'tgl_absensi' => date('Y-m-d'),
					'absensi' => 'hadir',
					'jenis_absensi' => 'rfid'
					// 'bukti_absensi' => $this->request->getVar('periode'),
					// 'id_guru' => strtoupper($this->request->getVar('guru')),
					// 'kelas' => $this->request->getVar('kelas')
				];
				$set_data = $this->home->simpan($data);
				return json_encode(['status' => 'success', 'isi' => $set_data]);
				// return json_encode($set_data);
			} else {
				return json_encode(['status' => 'failed', 'isi' => '']);
			}
			// return json_encode(['isi' => $get_data[0]->id_absensi]);
		}
	}
}
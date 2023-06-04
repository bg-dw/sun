<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;

use App\Models\M_home;
use App\Models\M_kelas;

class Presensi extends BaseController
{
    protected $home, $kelas;
    public function __construct()
    {
        $this->home = new M_home();
        $this->kelas = new M_kelas();
    }
    //index presensi
    public function index()
    {
        $data['title'] = 'Hari Ini';
        $set = $this->request->getPost('kelas');
        if (isset($set)) {
            $kelas = $set;
        } else {
            $kelas = "I";
        }
        $data['sel'] = $set;
        $data['absen'] = $this->home->get_presensi($kelas);
        $data['kelas'] = $this->kelas->findAll();
        return view('v_admin/presensi/V_presensi', $data);
    }

    //rekap presensi
    public function rekap()
    {
        $data['title'] = 'Data Rekap';
        return view('v_admin/presensi/V_rekap', $data);
    }
}
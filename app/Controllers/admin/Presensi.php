<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;

class Presensi extends BaseController
{
    //index presensi
    public function index()
    {
        $data['title'] = 'Hari Ini';
        return view('v_admin/presensi/V_presensi', $data);
    }

    //rekap presensi
    public function rekap()
    {
        $data['title'] = 'Data Rekap';
        return view('v_admin/presensi/V_rekap', $data);
    }
}
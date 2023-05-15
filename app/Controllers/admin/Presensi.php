<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;

class Presensi extends BaseController
{
    //index presensi
    public function index()
    {
        $data['page'] = 'x';
        return view('v_admin/presensi/V_presensi', $data);
    }

    //rekap presensi
    public function rekap()
    {
        $data['page'] = 'x';
        return view('v_admin/presensi/V_rekap', $data);
    }
}
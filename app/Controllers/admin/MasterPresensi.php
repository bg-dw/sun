<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;

class MasterPresensi extends BaseController
{
    //index presensi
    public function index()
    {
        $data['title'] = 'Master Presensi';
        return view('v_admin/data/V_absensi', $data);
    }
}
<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;

class MasterKelas extends BaseController
{
    //index presensi
    public function index()
    {
        $data['title'] = 'Master Kelas';
        return view('v_admin/data/V_kelas', $data);
    }
}
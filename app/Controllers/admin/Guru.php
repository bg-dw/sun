<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;

class Guru extends BaseController
{
    //index presensi
    public function index()
    {
        $data['title'] = 'Data Guru';
        return view('v_admin/data/V_guru', $data);
    }
}
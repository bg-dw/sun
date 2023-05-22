<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;

class MasterPeriode extends BaseController
{
    //index presensi
    public function index()
    {
        $data['title'] = 'Master Periode';
        return view('v_admin/data/V_periode', $data);
    }
}
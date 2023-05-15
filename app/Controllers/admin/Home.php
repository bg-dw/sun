<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        $data['page'] = 'x';
        return view('v_admin/V_home', $data);
    }
}
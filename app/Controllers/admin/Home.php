<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\M_dashboard;

class Home extends BaseController
{
    protected $dashboard;
    public function __construct()
    {
        $this->dashboard = new M_dashboard();
    }
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['home'] = $this->dashboard->get_all_data();
        return view('v_admin/V_home', $data);
    }
}
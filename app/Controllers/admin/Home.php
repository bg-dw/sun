<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\M_dashboard;
use App\Models\M_guru;

class Home extends BaseController
{
    protected $dashboard, $guru;
    public function __construct()
    {
        $this->is_session_available();
        $this->dashboard = new M_dashboard();
        $this->guru = new M_guru();

    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $where = "(level_login='GR' OR level_login='KS') AND status_guru='aktif'";
        $data['guru'] = count($this->guru->where($where)->findAll());
        $data['home'] = $this->dashboard->get_all_data();
        return view('v_admin/V_home', $data);
    }
}
<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\M_periode;

class MasterPeriode extends BaseController
{
    protected $periode;
    public function __construct()
    {
        $this->is_session_available();
        $this->periode = new M_periode();
    }
    //index periode
    public function index()
    {
        $data['title'] = 'Master Periode';
        $data['periode'] = $this->periode->findAll();
        return view('v_admin/data/V_periode', $data);
    }
}
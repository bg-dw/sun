<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\M_dashboard;
use App\Models\M_guru;
use App\Models\M_home;
use App\Models\M_presensi;

class Home extends BaseController
{
    protected $dashboard, $guru, $home, $presensi;
    public function __construct()
    {
        if (!$this->itr()) {
            redirect()->route('/');
        }
        $this->is_session_available();
        $this->dashboard = new M_dashboard();
        $this->guru = new M_guru();
        $this->home = new M_home();
        $this->presensi = new M_presensi();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $where = "(level_login='GR' OR level_login='KS') AND status_guru='aktif'";
        $data['guru'] = count($this->guru->where($where)->findAll());
        $data['home'] = $this->dashboard->get_all_data();
        return view('v_admin/V_home', $data);
    }

    //Mengambil data siswa per-kelas

    public function get_siswa_kelas()
    {
        if ($this->request->isAJAX()) {
            $get_data = $this->presensi->get_data_presensi_kelas();
            return json_encode($get_data);
        }
    }

    //data absensi hari ini
    public function get_absen_today()
    {
        if ($this->request->isAJAX()) {
            $get_data = $this->home->get_rekap_today(date("Y-m-d"));
            return json_encode($get_data);
        }
    }
}
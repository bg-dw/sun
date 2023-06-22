<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\M_periode;
use App\Models\M_kelas;
use App\Models\M_guru;

class MasterKelas extends BaseController
{
    protected $kelas, $periode, $guru;
    public function __construct()
    {
        $this->is_session_available();
        $this->periode = new M_periode();
        $this->kelas = new M_kelas();
        $this->guru = new M_guru();
    }
    //index presensi
    public function index()
    {
        $data['title'] = 'Master Kelas';
        $data['periode'] = $this->periode->where('status_periode', 'aktif')->findAll();
        $data['guru'] = $this->guru->findAll();
        $data['kelas'] = $this->kelas->get_data_kelas();
        return view('v_admin/data/V_kelas', $data);
    }

    //tambah kelas
    public function add()
    {
        $this->kelas->save([
            'id_periode' => $this->request->getVar('periode'),
            'id_guru' => strtoupper($this->request->getVar('guru')),
            'kelas' => $this->request->getVar('kelas')
        ]);
        return redirect()->route('admin/data-kelas');
    }
}
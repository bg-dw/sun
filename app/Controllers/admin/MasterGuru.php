<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\M_guru;

class MasterGuru extends BaseController
{
    protected $guru;
    public function __construct()
    {
        $this->guru = new M_guru();
    }
    //index presensi
    public function index()
    {
        $data['title'] = 'Data Guru';
        $data['guru'] = $this->guru->findAll();
        return view('v_admin/data/V_guru', $data);
    }

    //tambah guru
    public function add()
    {
        $this->guru->save([
            'nip' => $this->request->getVar('nip'),
            'nama_guru' => strtoupper($this->request->getVar('nama')),
            'gelar_guru' => $this->request->getVar('gelar'),
            'level_login' => $this->request->getVar('akses'),
            'status_guru' => 'aktif'
        ]);
        return redirect()->route('admin/data-guru');
    }
}
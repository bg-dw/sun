<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\M_guru;

class MasterGuru extends BaseController
{
    protected $guru;
    public function __construct()
    {
        $this->is_session_available();
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
        $send = $this->guru->save([
            'nip' => $this->request->getVar('nip'),
            'nama_guru' => strtoupper($this->request->getVar('nama')),
            'gelar_guru' => $this->request->getVar('gelar'),
            'level_login' => $this->request->getVar('akses'),
            'status_guru' => 'aktif'
        ]);
        if ($send):
            session()->setFlashdata('success', ' Data berhasil ditambahkan.');
        else:
            session()->setFlashdata('warning', ' Data gagal ditambahkan.');
        endif;
        return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-guru'));
    }

    //update guru
    public function update()
    {
        $send = $this->guru->save([
            'id_guru' => $this->request->getVar('id'),
            'nip' => $this->request->getVar('nip'),
            'nama_guru' => $this->request->getVar('nama'),
            'gelar_guru' => $this->request->getVar('gelar'),
            'level_login' => $this->request->getVar('akses')
        ]);
        if ($send):
            session()->setFlashdata('success', ' Data berhasil diperbaharui.');
        else:
            session()->setFlashdata('warning', ' Data gagal diperbaharui.');
        endif;
        return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-guru'));
    }

    //delete guru
    public function delete()
    {
        $send = $this->guru->where('id_guru', $this->request->getVar('id'))->delete();
        if ($send):
            session()->setFlashdata('success', ' Data berhasil dihapus.');
        else:
            session()->setFlashdata('warning', ' Data gagal dihapus.');
        endif;
        return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-guru'));
    }
}
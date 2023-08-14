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
        $send = $this->kelas->save([
            'id_periode' => $this->request->getVar('periode'),
            'id_guru' => $this->request->getVar('guru'),
            'kelas' => $this->request->getVar('kelas')
        ]);
        if ($send) {
            session()->setFlashdata('success', ' Data berhasil disimpan.');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-kelas'));
        } else {
            session()->setFlashdata('warning', ' Data gagal ditambahkan.');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-kelas'));
        }
    }

    //update Kelas
    public function update()
    {
        $send = $this->kelas->save([
            'id_kelas' => $this->request->getVar('id'),
            'id_guru' => $this->request->getVar('guru'),
            'kelas' => $this->request->getVar('kelas')
        ]);
        if ($send) {
            session()->setFlashdata('success', ' Data berhasil disimpan.');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-kelas'));
        } else {
            session()->setFlashdata('warning', ' Data gagal diperbaharui.');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-kelas'));
        }
    }

    //delete kelas
    public function delete()
    {
        $send = $this->kelas->where('id_kelas', $this->request->getVar('id'))->delete();
        if ($send):
            session()->setFlashdata('success', ' Data berhasil dihapus.');
        else:
            session()->setFlashdata('warning', ' Data gagal dihapus.');
        endif;
        return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-kelas'));
    }
}
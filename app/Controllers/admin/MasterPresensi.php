<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\M_presensi;
use App\Models\M_kelas;
use App\Models\M_siswa;

class MasterPresensi extends BaseController
{
    protected $presensi, $kelas, $siswa;
    public function __construct()
    {
        $this->is_session_available();
        $this->presensi = new M_presensi();
        $this->kelas = new M_kelas();
        $this->siswa = new M_siswa();
    }
    //index presensi
    public function index()
    {
        $data['title'] = 'Master Presensi';
        $data['presensi'] = $this->presensi->get_data_presensi();
        $data['kelas'] = $this->kelas->get_data_kelas();
        $data['siswa'] = $this->siswa->findAll();
        return view('v_admin/data/V_absensi', $data);
    }

    //tambah presensi
    public function add()
    {
        $cek = $this->presensi->where(['id_siswa' => $this->request->getVar('siswa'), 'id_kelas' => $this->request->getVar('kelas')])->first();

        if ($cek) {
            session()->setFlashdata('warning', ' Data sudah ada!');
            return redirect()->route('admin/data-presensi');
        } else {
            $cek_rfid = $this->presensi->cek_rfid_by_period($this->request->getVar('rfid'));
            if ($cek_rfid) {
                session()->setFlashdata('warning', ' RFID Terpakai!');
                return redirect()->route('admin/data-presensi');
            } else {
                $data = [
                    'id_absensi' => base64_encode($this->request->getVar('rfid') . date('U')),
                    'id_siswa' => $this->request->getVar('siswa'),
                    'id_kelas' => $this->request->getVar('kelas'),
                    'rfid' => $this->request->getVar('rfid')
                ];
                $send = $this->presensi->simpan($data);
                if ($send) {
                    session()->setFlashdata('success', ' Data berhasil disimpan.');
                    return redirect()->route('admin/data-presensi');
                } else {
                    session()->setFlashdata('warning', ' Data gagal ditambahkan.');
                    return redirect()->route('admin/data-presensi');
                }
            }
        }
    }

    //edit rfid
    public function edit_rfid()
    {
        $this->presensi->save([
            'id_absensi' => $this->request->getVar('id_absensi'),
            'rfid' => $this->request->getVar('rfid')
        ]);
        session()->setFlashdata('success', ' Data berhasil diperbaharui.');
        return redirect()->route('admin/data-presensi');
    }
}
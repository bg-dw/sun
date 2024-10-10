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
        // SELECT nama FROM tbl_siswa WHERE id_siswa NOT IN (SELECT id_siswa FROM tbl_absensi);
        return view('v_admin/data/V_absensi', $data);
    }

    //tambah presensi
    public function add()
    {
        $cek = $this->presensi->where(['id_siswa' => $this->request->getVar('siswa'), 'id_kelas' => $this->request->getVar('kelas')])->first();

        if ($cek) {
            session()->setFlashdata('warning', ' Data sudah ada!');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-presensi'));
        } else {
            $cek_rfid = $this->presensi->cek_rfid_by_period($this->request->getVar('rfid'));
            if ($cek_rfid) {
                session()->setFlashdata('warning', ' RFID Terpakai!');
                return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-presensi'));
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
                    return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-presensi'));
                } else {
                    session()->setFlashdata('warning', ' Data gagal ditambahkan.');
                    return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-presensi'));
                }
            }
        }
    }

    // update presensi
    public function update()
    {
        $cek = $this->presensi->where(['id_siswa' => $this->request->getVar('siswa'), 'id_kelas' => $this->request->getVar('kelas')])->first();

        if ($cek) {
            session()->setFlashdata('warning', ' Data sudah ada!');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-presensi'));
        } else {
            $cek_rfid = $this->presensi->cek_rfid_by_period($this->request->getVar('rfid'));
            if ($cek_rfid) {
                session()->setFlashdata('warning', ' RFID Terpakai!');
                return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-presensi'));
            } else {
                $data = [
                    'id_absensi' => $this->request->getVar('id'),
                    'id_siswa' => $this->request->getVar('siswa'),
                    'id_kelas' => $this->request->getVar('kelas')
                ];
                $send = $this->presensi->save($data);
                if ($send) {
                    session()->setFlashdata('success', ' Data berhasil disimpan.');
                    return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-presensi'));
                } else {
                    session()->setFlashdata('warning', ' Data gagal perbaharui.');
                    return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-presensi'));
                }
            }
        }
    }

    //delete presensi
    public function delete()
    {
        $send = $this->presensi->where('id_absensi', $this->request->getVar('id'))->delete();
        if ($send):
            session()->setFlashdata('success', ' Data berhasil dihapus.');
        else:
            session()->setFlashdata('warning', ' Data gagal dihapus.');
        endif;
        return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-presensi'));
    }

    //edit rfid
    public function edit_rfid()
    {
        $send = $this->presensi->save([
            'id_absensi' => $this->request->getVar('id_absensi'),
            'rfid' => $this->request->getVar('rfid')
        ]);
        if ($send) {
            session()->setFlashdata('success', ' Data berhasil disimpan.');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-presensi'));
        } else {
            session()->setFlashdata('warning', ' Data gagal diperbaharui.');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-presensi'));
        }
    }
}
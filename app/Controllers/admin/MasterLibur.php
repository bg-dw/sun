<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\M_libur;

class MasterLibur extends BaseController
{
    protected $libur;
    public function __construct()
    {
        $this->is_session_available();
        $this->libur = new M_libur();
    }
    //index libur
    public function index()
    {
        $data['title'] = 'Hari Libur';
        $data['libur'] = $this->libur->where("id_periode", session()->get('id_periode'))->orderBy("tgl_awal", "ASC")->findAll();
        return view('v_admin/data/V_libur', $data);
    }

    //aksi tambah hari libur
    public function ac_add()
    {
        $x = $this->request->getVar('tgl');
        $ket = $this->request->getVar('ket');
        $tgl = explode(" - ", $x);

        $tgl_a = $tgl[0];
        $tgl_b = $tgl[1];
        if ($tgl_b < $tgl_a) {//jika tgl akhir lebih besar dari tgl awal
            $tgl_a = $tgl[1];
            $tgl_b = $tgl[0];
        }
        $data = [
            'id_periode' => session()->get('id_periode'),
            'tgl_awal' => date("Y-m-d", strtotime($tgl_a)),
            'tgl_akhir' => date("Y-m-d", strtotime($tgl_b)),
            'ket_libur' => $ket
        ];
        $send = $this->libur->save($data);
        if ($send) {
            session()->setFlashdata('success', ' Data berhasil disimpan.');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('hari-libur'));
        } else {
            session()->setFlashdata('warning', ' Data gagal ditambahkan.');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('hari-libur'));
        }
    }
    public function ac_update()
    {
        $id = $this->request->getVar('id');
        $x = $this->request->getVar('tgl');
        $ket = $this->request->getVar('ket');
        $tgl = explode(" - ", $x);
        $tgl_a = $tgl[0];
        $tgl_b = $tgl[1];
        if ($tgl_b < $tgl_a) {//jika tgl akhir lebih besar dari tgl awal
            $tgl_a = $tgl[1];
            $tgl_b = $tgl[0];
        }
        $data = [
            'id_libur' => $id,
            'tgl_awal' => date("Y-m-d", strtotime($tgl_a)),
            'tgl_akhir' => date("Y-m-d", strtotime($tgl_b)),
            'ket_libur' => $ket
        ];
        $send = $this->libur->save($data);
        if ($send) {
            session()->setFlashdata('success', ' Data berhasil diperbaharui.');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('hari-libur'));
        } else {
            session()->setFlashdata('warning', ' Data gagal diperbaharui.');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('hari-libur'));
        }
    }

    //delete libur
    public function ac_delete()
    {
        $send = $this->libur->where('id_libur', $this->request->getVar('id'))->delete();
        if ($send):
            session()->setFlashdata('success', ' Data berhasil dihapus.');
        else:
            session()->setFlashdata('warning', ' Data gagal dihapus.');
        endif;
        return redirect()->route(bin2hex('admin') . '/' . bin2hex('hari-libur'));
    }
}
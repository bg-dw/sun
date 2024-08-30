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

    //aksi tambha periode
    public function ac_add()
    {
        $cek = $this->periode->where(['tahun_awal' => $this->request->getVar('tahun')])->first();

        if ($cek) {
            session()->setFlashdata('warning', ' Data sudah ada!');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-periode'));
        } else {
            $data = [
                'tahun_awal' => $this->request->getVar('tahun'),
                'tahun_akhir' => (intval($this->request->getVar('tahun')) + 1),
                'status_periode' => "non-aktif"
            ];
            $send = $this->periode->save($data);
            if ($send) {
                session()->setFlashdata('success', ' Data berhasil disimpan.');
                return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-periode'));
            } else {
                session()->setFlashdata('warning', ' Data gagal ditambahkan.');
                return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-periode'));
            }
        }
    }

    //aksi update periode
    //edit rfid
    public function ac_update()
    {
        $cek = $this->periode->where(['tahun_awal' => $this->request->getVar('tahun')])->first();

        if ($cek) {
            session()->setFlashdata('warning', ' Data sudah ada!');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-periode'));
        } else {
            $data = [
                'id_periode' => $this->request->getVar('id'),
                'tahun_awal' => $this->request->getVar('tahun'),
                'tahun_akhir' => (intval($this->request->getVar('tahun')) + 1),
            ];
            $send = $this->periode->save($data);
            if ($send) {
                session()->setFlashdata('success', ' Data berhasil disimpan.');
                return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-periode'));
            } else {
                session()->setFlashdata('warning', ' Data gagal ditambahkan.');
                return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-periode'));
            }
        }
    }
    public function ac_update_status()
    {
        $cek = $this->periode->where(['status_periode' => "aktif"])->first();

        if ($cek) {
            $periode_lama = [
                'id_periode' => $cek['id_periode'],
                'status_periode' => "non-aktif"
            ];
            $this->periode->save($periode_lama);
            $data = [
                'id_periode' => $this->request->getVar('id'),
                'status_periode' => "aktif"
            ];
            $send = $this->periode->save($data);
            if ($send) {
                session()->setFlashdata('success', ' Data berhasil disimpan.');
                return redirect()->route(bin2hex('logout'));
            } else {
                session()->setFlashdata('warning', ' Data gagal ditambahkan.');
                return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-periode'));
            }
        } else {
            session()->setFlashdata('warning', ' Data sudah ada!');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-periode'));
        }
    }
}
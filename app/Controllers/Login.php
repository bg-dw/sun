<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\M_guru;
use App\Models\M_periode;

class Login extends BaseController
{
    protected $guru;
    public function __construct()
    {
        $this->guru = new M_guru();
        $this->periode = new M_periode();
    }

    public function index()
    {
        if ($this->itr()) {
            return view('V_login');
        } else {
            return redirect()->route('/');
        }
    }
    public function auth()
    {
        $cek = $this->guru->where(['username' => md5($this->request->getVar('user')), 'password' => md5($this->request->getVar('pass'))])->first();
        if ($cek):
            $kelas = $this->guru->get_guru_by($cek['id_guru']);
            $set = $kelas['kelas'];
            $periode = $this->periode->where('status_periode', "aktif")->first();
            $set_id_p = $periode['id_periode'];
            $set_periode = $periode['tahun_awal'] . "-" . $periode['tahun_akhir'];
            $ses = [
                'id' => $cek['id_guru'],
                'nama' => $cek['nama_guru'],
                'user' => $cek['username'],
                'pass' => $cek['password'],
                'level' => $cek['level_login'],
                'id_periode' => $set_id_p,
                'periode' => $set_periode,
                'kelas' => $set,
                'passed' => true,
            ];
            $this->session->set($ses);
            if ($cek['level_login'] === "ADM"):
                session()->setFlashdata('success', ' Selamat Datang!');
                return redirect()->route(bin2hex('admin') . '/' . bin2hex('home'));
            elseif ($cek['level_login'] === "KS"):
                session()->setFlashdata('success', ' Selamat Datang!');
                // return redirect()->route(bin2hex('ks') . '/' . bin2hex('home'));
            elseif ($cek['level_login'] === "GR"):
                session()->setFlashdata('success', ' Selamat Datang!');
                return redirect()->route(bin2hex('guru') . '/' . bin2hex('home'));
            endif;
        else:
            return redirect()->back()->with('warning', ' Username atau password salah.');
        endif;
    }
    public function logout()
    {
        $this->session->destroy();
        return redirect()->route(bin2hex('login'));
    }
}
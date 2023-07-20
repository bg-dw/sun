<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\M_guru;

class Login extends BaseController
{
    protected $guru;
    public function __construct()
    {
        $this->guru = new M_guru();
    }

    public function index()
    {
        return view('V_login');
    }
    public function auth()
    {
        $cek = $this->guru->where(['username' => md5($this->request->getVar('user')), 'password' => md5($this->request->getVar('pass'))])->first();
        if ($cek):
            $kelas = $this->guru->get_guru_by($cek['id_guru']);
            $set = $kelas['kelas'];
            $ses = [
                'id' => $cek['id_guru'],
                'nama' => $cek['nama_guru'],
                'user' => $cek['username'],
                'pass' => $cek['password'],
                'level' => $cek['level_login'],
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
        return redirect()->route('/');
    }
}
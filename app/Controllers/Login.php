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
            $ses = [
                'id' => $cek['id_guru'],
                'nama' => $cek['nama_guru'],
                'user' => $cek['username'],
                'pass' => $cek['password'],
                'level' => $cek['level_login'],
                'passed' => true,
            ];

            $this->session->set($ses);
            session()->setFlashdata('success', ' Selamat Datang!');
            return redirect()->route('admin/home');
        else:
            // session()->setFlashdata('warning', ' Username atau password salah.');
            // return redirect()->route('/login');
            return redirect()->back()->with('warning', ' Username atau password salah.');
        endif;
    }
    public function logout()
    {
        // $ses = ['id', 'nama', 'user', 'pass', 'level', 'logged_in'];
        $this->session->destroy();
        return redirect()->route('/');
        // return redirect()->to(base_url('logout'));
    }
}
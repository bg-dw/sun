<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\M_guru;

class MasterGuru extends BaseController
{
    protected $guru;
    public function __construct()
    {
        if (!$this->itr()) {
            redirect()->route('/');
        }
        $this->is_session_available();
        $this->guru = new M_guru();
    }
    //index presensi
    public function index()
    {
        $data['proc'] = $this;
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

    //update status guru
    public function ac_update_status()
    {
        $data = [
            'id_guru' => $this->request->getVar('id'),
            'status_guru' => $this->request->getVar('status')
        ];
        $send = $this->guru->save($data);
        if ($send) {
            session()->setFlashdata('success', ' Data berhasil disimpan.');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-guru'));
        } else {
            session()->setFlashdata('warning', ' Data gagal ditambahkan.');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-guru'));
        }
    }

    public function cek_uname()
    {
        if ($this->request->isAJAX()) {
            $uname = $this->request->getVar('uname');
            $get_data = $this->guru->where('username', md5($uname))->first();
            return json_encode($get_data);
        } else {
            return json_encode("Bukan Ajax Req");
        }
    }

    public function ac_set_uname()
    {
        $id = $this->dec($this->request->getVar('id'));
        $uname = $this->request->getVar('uname');
        if (strlen($uname) < 5):
            session()->setFlashdata('warning', ' Username Kurang dari 5 Karakter!.');
        else:
            $data = [
                'id_guru' => $id,
                'username' => md5($uname)
            ];
            $cek_uname = $this->guru->where('username', md5($uname))->first();
            if (!$cek_uname):
                $send = $this->guru->save($data);
                if ($send):
                    session()->setFlashdata('success', ' Data berhasil disimpan.');
                else:
                    session()->setFlashdata('warning', 'Gagal Menyimpan Data!.');
                endif;
            else:
                session()->setFlashdata('warning', ' Pilih Username yang Lain!.');
            endif;
        endif;
        return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-guru'));
    }
    public function ac_set_password()
    {
        $id = $this->dec($this->request->getVar('id'));
        $pwd = $this->request->getVar('pwd');
        if (strlen($pwd) < 6):
            session()->setFlashdata('warning', ' Password Kurang dari 6 Karakter!.');
        else:
            $data = [
                'id_guru' => $id,
                'password' => md5($pwd)
            ];
            $send = $this->guru->save($data);
            if ($send):
                session()->setFlashdata('success', ' Data berhasil disimpan.');
            else:
                session()->setFlashdata('warning', 'Gagal Menyimpan Data!.');
            endif;
        endif;
        return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-guru'));
    }
}
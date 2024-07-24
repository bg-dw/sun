<?php

namespace App\Controllers\guru;

use App\Controllers\BaseController;
use App\Models\M_guru;

class Akun extends BaseController
{
    protected $guru;
    public function __construct()
    {
        $this->is_session_available();
        $this->guru = new M_guru();
    }

    //update username
    public function update_uname()
    {
        $data['proc'] = $this;
        $data['title'] = 'Update Username';
        return view('v_guru/V_username', $data);
    }

    public function cek_uname_lama()
    {
        $id = session()->get('id');
        if ($this->request->isAJAX()) {
            $uname = $this->request->getVar('uname');
            $where = ['id_guru' => $id, 'username' => md5($uname)];
            $get_data = $this->guru->where($where)->first();
            return json_encode($get_data);
        } else {
            return json_encode("Bukan Ajax Req");
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
        $id = session()->get('id');
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
                    return redirect()->route(bin2hex('logout'));
                else:
                    session()->setFlashdata('warning', 'Gagal Menyimpan Data!.');
                endif;
            else:
                session()->setFlashdata('warning', ' Username tidak berubah!.');
            endif;
        endif;
        return redirect()->route('/' . bin2hex('guru') . '/' . bin2hex('update-username'));
    }

    //update password
    public function update_pass()
    {
        $data['proc'] = $this;
        $data['title'] = 'Update Password';
        return view('v_guru/V_password', $data);
    }
    public function cek_pass_lama()
    {
        $id = session()->get('id');
        if ($this->request->isAJAX()) {
            $pass = $this->request->getVar('pass');
            $where = ['id_guru' => $id, 'password' => md5($pass)];
            $get_data = $this->guru->where($where)->first();
            return json_encode($get_data);
        } else {
            return json_encode("Bukan Ajax Req");
        }
    }
    public function ac_set_password()
    {
        $id = session()->get('id');
        $pwd = $this->request->getVar('pass');
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
                return redirect()->route(bin2hex('logout'));
            else:
                session()->setFlashdata('warning', 'Gagal Menyimpan Data!.');
            endif;
        endif;
        return redirect()->route(bin2hex('guru') . '/' . bin2hex('update-password'));
    }
}
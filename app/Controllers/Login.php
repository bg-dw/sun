<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function auth()
    {
        return redirect()->route('admin/home');
    }
    public function logout()
    {
        echo "Tes1";
        return redirect()->route('/');
        // return redirect()->to(base_url('logout'));
    }
}
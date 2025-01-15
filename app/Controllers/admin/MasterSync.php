<?php

namespace App\Controllers\admin;
use ZipArchive;

use App\Controllers\BaseController;

class MasterSync extends BaseController
{
    public function __construct()
    {
        $this->is_session_available();
    }
    //index Update
    public function index()
    {
        $data['title'] = 'Sinkron File';
        return view('v_admin/data/V_sync', $data);
    }

    public function cek_data()
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Accept:application/vnd.github+json',
            'User-Agent: bg-dw',
            'Content-Type: application/json',
        ]);
        // Sending GET request to reqres.in
        // server to get JSON data
        curl_setopt(
            $curl,
            CURLOPT_URL,
            "https://api.github.com/repos/bg-dw/sun-update/commits/master"
        );

        // Telling curl to store JSON
        // data in a variable instead
        // of dumping on screen
        curl_setopt(
            $curl,
            CURLOPT_RETURNTRANSFER,
            true
        );

        // Executing curl
        $response = json_decode(curl_exec($curl));
        curl_close($curl);
        return $response;
    }

    public function cek_file()
    {
        $res = $this->cek_data();
        if (!$res) {
            return json_encode(false);
        }

        $ver = $res->files[0]->filename;
        $msg = $res->commit->message;
        $raw = $res->files[0]->raw_url;
        $data['ver'] = $ver;
        $data['raw'] = $raw;
        $data['msg'] = $msg;

        return json_encode($data);
    }

    public function perbaharui()
    {
        // Mendapatkan data dari POST
        $inp_ver = $this->request->getPost('ver');
        $url = $this->request->getPost('url');
        $msg = $this->request->getPost('msg');

        $save_to = $inp_ver;
        $dir = "./";

        $temp_ver = explode(".", $inp_ver);
        $ver = $temp_ver[0] . "." . $temp_ver[1] . "." . $temp_ver[2];

        $x = file_put_contents($save_to, file_get_contents($url));
        if (!$x) {
            return json_encode(false);
        }
        $zip = new ZipArchive;
        $old_name = "./app";
        $new_name = "./app_" . rand();
        rename($old_name, $new_name);
        $res = $zip->open($save_to);
        if ($res === TRUE) {
            $rep = $zip->extractTo($dir);
            $zip->close();
            return json_encode("Berhasil diterapkan!");
        } else {
            return json_encode("Gagal Mengganti Resource File!");
        }
    }

}
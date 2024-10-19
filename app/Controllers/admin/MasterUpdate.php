<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;

class MasterUpdate extends BaseController
{
    public function __construct()
    {
        $this->is_session_available();
    }
    //index Update
    public function index()
    {
        $data['title'] = 'Pembaruan';
        return view('v_admin/data/V_pembaruan', $data);
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
            "https://api.github.com/repos/bg-dw/sun/commits/master"
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

    public function cek_pembaruan()
    {
        $res = $this->cek_data();
        if (!$res) {
            return json_encode(false);
        }

        $msg = $res->commit->message;

        $files = array();
        foreach ($res->files as $val) {
            $temp_file = explode("/", $val->filename);//membuat nama file menjadi array
            $name_file = end($temp_file);//mengambil nilai terakhir dari array
            array_pop($temp_file);// menghilangkan nilai terakhir dari array
            $path_file = implode("/", $temp_file);// membuat array menjadi string

            $files['url'][] = $val->raw_url;
            $files['filepath'][] = $path_file;
            $files['filename'][] = $name_file;
            $files['status'][] = $val->status;
        }

        $data['msg'] = $msg;
        $data['files'] = $files;

        return json_encode($data);
    }

    public function terapkan_pembaruan()
    {
        // Mendapatkan data dari POST
        $file_path = $this->request->getPost('path');
        $file_url = $this->request->getPost('url');
        $file_name = $this->request->getPost('name');
        $status = $this->request->getPost('status');
        if ($status == "removed") {
            return json_encode($file_name . " telah dihapus oleh admin!");
        }
        $save_to = $file_path . "/" . $file_name;
        // // // Cek apakah direktori dapat ditulis
        if (!is_writable(dirname($file_path))) {
            return json_encode("Directory is not writable.");
        }
        $x = file_put_contents($save_to, file_get_contents($file_url));
        if (!$x) {
            return json_encode("Gagal : " . $save_to);
        }
        return json_encode($file_name);
    }

}
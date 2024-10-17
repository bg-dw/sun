<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use ZipArchive;
// use App\Models\M_libur;

class MasterUpdate extends BaseController
{
    // protected $libur;
    public function __construct()
    {
        $this->is_session_available();
        // $this->libur = new M_libur();
    }
    //index libur
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
            'Authorization:token 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',
            // 'Authorization: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', PUBLIC REPO
            'Content-Type: application/json',
        ]);
        // Sending GET request to reqres.in
        // server to get JSON data
        curl_setopt(
            $curl,
            CURLOPT_URL,
            "https://api.github.com/repos/bg-dw/sun/commits/master"
            // "https://api.github.com/repos/bg-dw/sun-update/commits/master"//PUBLIC REPO
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
        if (!$response) {
            return json_encode("gagal update");
        }
        return $response;
    }

    public function cek_pembaruan()
    {
        $res = $this->cek_data();
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
        }

        $data['msg'] = $msg;
        $data['files'] = $files;

        return json_encode($data);
    }

    // public function unduh_pembaruan()
    // {
    //     $to = "app/Temp/Update/";
    //     $url = $this->request->getPost('url');
    //     $file_name = $to . basename($url);
    //     if (!file_put_contents($file_name, file_get_contents($url))) {
    //         return json_encode("Gagal Download Pembaruan!");
    //     }
    //     return json_encode($file_name);
    // }
    public function terapkan_pembaruan()
    {
        $dir = "app/Temp/Update/";
        $file_path = $this->request->getPost('path');
        $zip = new ZipArchive;
        $res = $zip->open($file_path);
        if ($res === TRUE) {
            $zip->extractTo($dir);
            $zip->close();
            // unlink($dir . "*");
        } else {
            return json_encode($res);
        }
        $path = scandir($dir);
        return json_encode($path);
    }


}
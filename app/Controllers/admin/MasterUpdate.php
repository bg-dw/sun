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


    public function cek_pembaruan()
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Accept:application/vnd.github+json',
            'User-Agent: bg-dw',
            'Authorization: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',
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
        if (!$response) {
            return json_encode("gagal update");
        }

        $url = $response->files[0]->raw_url;
        $msg = $response->commit->message;

        // Use basename() function to return the base name of file
        curl_close($curl);
        $data['msg'] = $msg;
        $data['url'] = $url;

        return json_encode($data);
    }

    public function unduh_pembaruan()
    {
        $to = "app/Temp/Update/";
        $url = $this->request->getPost('url');
        $file_name = $to . basename($url);
        if (!file_put_contents($file_name, file_get_contents($url))) {
            return json_encode("Gagal Download Pembaruan!");
        }
        return json_encode($file_name);
    }
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
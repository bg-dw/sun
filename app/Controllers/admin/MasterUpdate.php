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
            // 'Authorization:token ' . getenv('PAT'),
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
            return json_encode("gagal update");
        }
        // dd($res);
        $msg = $res->commit->message;

        $files = array();
        foreach ($res->files as $val) {
            $temp_file = explode("/", $val->filename);//membuat nama file menjadi array
            $name_file = end($temp_file);//mengambil nilai terakhir dari array
            array_pop($temp_file);// menghilangkan nilai terakhir dari array
            $path_file = implode("/", $temp_file);// membuat array menjadi string


            // $x = explode("/", $val->raw_url);
            // array_splice($x, 5, 1);
            // $x[2] = "raw.githubusercontent.com";
            // $temp_url = implode("/", $x);
            $files['url'][] = $val->raw_url;
            $files['filepath'][] = $path_file;
            $files['filename'][] = $name_file;
            $files['status'][] = $val->status;
        }
        // $x = explode("/", $res->files[0]->raw_url);

        $data['msg'] = $msg;
        $data['files'] = $files;

        return json_encode($data);
    }

    public function get_files($file_url)
    { // Inisialisasi cURL
        $ch = curl_init();

        // Set opsi cURL untuk mengarahkan output langsung ke file
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept:application/vnd.github+json',
            'User-Agent: bg-dw',
            'Authorization:token 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',
            'Content-Type: application/json',
        ]);
        // Sending GET request to reqres.in
        // server to get JSON data
        curl_setopt(
            $ch,
            CURLOPT_URL,
            $file_url
        );

        // Telling curl to store JSON
        // data in a variable instead
        // of dumping on screen
        curl_setopt(
            $ch,
            CURLOPT_RETURNTRANSFER,
            true
        );

        // Executing curl
        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        return $response;
    }

    function downloadFile($url, $saveTo)
    {
        // Inisialisasi cURL
        $ch = curl_init($url);

        // Membuka file untuk ditulis
        $fp = fopen($saveTo, 'w+');

        // Set opsi cURL
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);  // Ikuti redirect jika ada
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);  // Set timeout 50 detik
        curl_setopt($ch, CURLOPT_FAILONERROR, true);  // Beri error jika HTTP status code >= 400

        // Jalankan cURL
        $success = curl_exec($ch);

        // Periksa apakah ada error
        if ($success === false) {
            return "Gagal mendownload file: " . curl_error($ch);
        } else {
            return "File berhasil didownload ke: " . $saveTo;
        }

        // Tutup resource
        curl_close($ch);
        fclose($fp);
    }


    public function terapkan_pembaruan()
    {
        // Mendapatkan data dari POST
        $file_path = $this->request->getPost('path');
        $file_url = $this->request->getPost('url');
        $file_name = $this->request->getPost('name');
        $status = $this->request->getPost('status');
        // $url = "https://raw.githubusercontent.com/bg-dw/sun/614bb78aadb709d326ebcbc77c442b138c34d350/app/Controllers/admin/MasterUpdate.php";
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
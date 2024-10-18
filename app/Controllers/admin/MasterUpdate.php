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
            'Authorization:token ' . getenv('PAT'),
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
        dd($res);
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

    public function downloadFileFromPrivateRepo($apiUrl, $token)
    {

        // Inisialisasi cURL
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: token ' . $token,
            'User-Agent: YourAppName' // GitHub API memerlukan User-Agent
        ]);

        // Jalankan cURL dan ambil respons
        $response = curl_exec($ch);
        curl_close($ch);

        // Mengonversi JSON respons menjadi array
        $data = json_decode($response, true);
        return $response;

        // Memeriksa apakah ada konten file dalam base64
        if (isset($data['content'])) {
            $fileContent = base64_decode($data['content']); // Decode base64 menjadi konten asli
            $saveTo = "/"; // Path lokal tempat menyimpan file

            // Simpan konten file ke file lokal
            file_put_contents($saveTo, $fileContent);
            return "File berhasil disimpan di: $saveTo";
        } else {
            return "Gagal mendapatkan konten file.";
        }
    }

    // Contoh penggunaan
    // $username = 'your-username'; // Ganti dengan username GitHub
    // $repo = 'your-private-repo'; // Ganti dengan nama repository
    // $path = 'path/to/your/file.txt'; // Path file di dalam repo
    // $token = 'your-personal-access-token'; // Ganti dengan token akses GitHub


    public function terapkan_pembaruan()
    {
        // Mendapatkan data dari POST
        $file_path = $this->request->getPost('path');
        $file_url = $this->request->getPost('url');
        $file_name = $this->request->getPost('name');
        $status = $this->request->getPost('status');

        $x = $this->downloadFileFromPrivateRepo($file_url, "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");
        return json_encode($x);
        // Cek status file
        if ($status == "removed") {
            return json_encode("File " . $file_path . "/" . $file_name . " telah dihapus!");
        }

        // Personal Access Token dari GitHub (pastikan untuk mengamankan token ini)
        $token = getenv('PAT'); // Ganti dengan token kamu

        // Lokasi untuk menyimpan file
        // $save_to = $file_path;
        $save_to = "/";

        // Cek apakah direktori dapat ditulis
        // if (!is_writable(dirname($save_to))) {
        //     return json_encode("Directory is not writable.");
        // }

        // Inisialisasi cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $file_url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: token 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',
            'User-Agent: bg-dw',  // GitHub API memerlukan user-agent
        ]);
        $redirect_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

        // Jalankan cURL dan dapatkan respon
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return json_encode($redirect_url);

        // Tutup cURL
        // Periksa kode HTTP
        if ($http_code !== 200) {
            return json_encode("Gagal mendownload file. HTTP Status Code: $http_code");
        }

        // Mengubah respon JSON dari GitHub menjadi array
        $data = json_decode($response, true);
        if (!isset($data['content'])) {
            return json_encode("Konten tidak ditemukan dalam respon.");
        }

        // Data file terkode dalam base64, kita perlu mendekode file tersebut
        $file_content = base64_decode($data['content']);

        // Simpan file ke folder lokal
        if (file_put_contents($save_to, $file_content)) {
            return json_encode("File berhasil didownload dan disimpan di: $save_to");
        } else {
            return json_encode("Gagal menyimpan file.");
        }
        curl_close($ch);
    }

}
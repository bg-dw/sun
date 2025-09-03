<?php

namespace App\Controllers\api;

use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\M_home;
use App\Models\M_guru;
use App\Models\M_presensi;
use App\Models\M_periode;

class Presensi extends BaseController
{
    use ResponseTrait;
    protected $periode, $home, $guru, $kelas, $presensi, $detail;
    public function __construct()
    {
        // $this->is_session_available();
        $this->home = new M_home();
        $this->guru = new M_guru();
        $this->presensi = new M_presensi();
        $this->periode = new M_periode();
    }

    function today_by($id_guru)
    {
        $response = service('response');

        // Force set CORS headers
        $response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->setHeader('Content-Type', 'application/json')
            ->setHeader('Access-Control-Allow-Credentials', 'true');
        $kelas = $this->guru->get_guru_by("8");
        $absen = $this->home->get_presensi($kelas);
        $siswa = $this->presensi->get_data_presensi_by($kelas);

        $x = 0;
        $rec = array();
        foreach ($siswa as $row) {
            $jam = "00:00:00";
            $hadir = "";
            $id_detail = "";
            foreach ($absen as $bar) {
                if ($row['id_siswa'] == $bar['id_siswa']) {
                    $jam = $bar['jam_absensi'];
                    $hadir = $bar['absensi'];
                    $id_detail = $bar['id_detail_absensi'];
                    continue;
                }
            }
            $x++;
            $item = array(
                "id_detail_absensi" => $id_detail,
                "id_absensi" => $row['id_absensi'],
                "nama" => $row['nama'],
                "absensi" => $hadir,
                "jam_absensi" => $jam,
                "tgl_absensi" => date("d-m-Y"),
                "update_at" => ""
            );
            $data[] = $item;
        }
        return $this->respond(json_encode($data));
    }

    // METHOD INI SANGAT PENTING UNTUK PREFLIGHT
    public function options()
    {
        $response = service('response');

        $response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->setHeader('Access-Control-Allow-Credentials', 'true')
            ->setHeader('Access-Control-Max-Age', '86400')
            ->setHeader('Content-Type', 'application/json')
            ->setStatusCode(200);
        // Return empty response untuk OPTIONS
        return $response->setBody('');
    }

    public function auth()
    {
        $username = $this->request->getVar('user');
        $password = $this->request->getVar('pass');

        // hash dulu dengan md5
        $cek = $this->guru
            ->where([
                'username' => md5($username),
                'password' => md5($password),
                'status_guru' => 'aktif' // tambahkan validasi aktif
            ])
            ->first();

        if ($cek) {
            return $this->respond([
                'success' => true,
                'message' => 'Login berhasil',
                'data' => [
                    'id' => $cek['id_guru'],
                    'user' => $username,
                    'nama' => $cek['nama_guru'],
                    'level' => $cek['level_login'],
                    'token' => bin2hex(random_bytes(16)) // contoh token dummy
                ]
            ]);
        } else {
            return $this->respond([
                'success' => false,
                'message' => 'Username atau password salah / akun tidak aktif'
            ]);
        }
    }

}
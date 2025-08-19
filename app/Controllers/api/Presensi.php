<?php

namespace App\Controllers\api;

use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\M_home;
use App\Models\M_guru;
use App\Models\M_presensi;

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
    }

    function today_by($id_guru)
    {
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
                // "id_detail_absensi" => $id_detail,
                // "id_absensi" => $row['id_absensi'],
                "nama" => $row['nama'],
                // "absensi" => $hadir,
                // "jam_absensi" => $jam,
                // "tgl_absensi" => date("d-m-Y"),
                // "update_at" => ""
            );
            $data[] = $item;
        }
        return $this->respond(json_encode($data));
    }
}
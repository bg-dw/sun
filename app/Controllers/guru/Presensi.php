<?php

namespace App\Controllers\guru;

use App\Controllers\BaseController;

use App\Models\M_periode;
use App\Models\M_home;
use App\Models\M_kelas;
use App\Models\M_guru;
use App\Models\M_presensi;
use App\Models\M_detail_presensi;

class Presensi extends BaseController
{
    protected $periode, $home, $guru, $kelas, $presensi, $detail;
    public function __construct()
    {
        $this->is_session_available();
        $this->periode = new M_periode();
        $this->home = new M_home();
        $this->kelas = new M_kelas();
        $this->guru = new M_guru();
        $this->presensi = new M_presensi();
        $this->detail = new M_detail_presensi();
    }
    //index presensi
    public function index()
    {
        $data['title'] = 'Hari Ini';

        $kelas = $this->guru->get_guru_by(session()->get('id'));
        $set = $kelas['kelas'];
        $data['sel'] = $set;
        $absen = $this->home->get_presensi($kelas);
        $siswa = $this->presensi->get_data_presensi_by($kelas);
        $x = 0;
        $rec = array();
        foreach ($siswa as $row) {
            $jam = "00:00:00";
            $hadir = "";
            $rec[$x]['id_siswa'] = $row['id_siswa'];
            $rec[$x]['id_absensi'] = $row['id_absensi'];
            $rec[$x]['nama'] = $row['nama'];
            foreach ($absen as $bar) {
                if ($row['id_siswa'] == $bar['id_siswa']) {
                    $jam = $bar['jam_absensi'];
                    $hadir = $bar['absensi'];
                    continue;
                }
            }
            $rec[$x]['jam'] = $jam;
            $rec[$x]['absensi'] = $hadir;
            $x++;
        }
        $data['absen'] = $rec;
        $data['kelas'] = $this->kelas->findAll();
        return view('v_guru/presensi/V_presensi', $data);
    }

    //rekap presensi
    public function rekap()
    {
        $daftar_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $kelas = $this->guru->get_guru_by(session()->get('id'));
        $set = $kelas['kelas'];
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $bulan_now = date('m');
        $tahun_now = date('Y');
        if (isset($bulan) && isset($tahun)) {
            $bulan_now = $bulan;
            $tahun_now = $tahun;
        }
        $kelas = "I";
        if (isset($set)) {
            $kelas = $set;
        }

        $tot_hari = cal_days_in_month(CAL_GREGORIAN, $bulan_now, $tahun_now);
        $siswa = $this->presensi->get_data_presensi_by($kelas);
        $rekap = $this->home->get_rekap($kelas, $bulan_now, $tahun_now);

        $rec = array();
        $i = 0;
        foreach ($siswa as $row) {
            $j = 0;
            foreach ($rekap as $col) {
                if ($row["id_siswa"] == $col["id_siswa"]):
                    $rec[$i][$j] = [
                        "nama" => $col["nama"],
                        "jk" => $col["jk"],
                        "jam" => $col["jam_absensi"],
                        "tgl" => $col["tgl_absensi"],
                        "absensi" => $col["absensi"]
                    ];
                    $j++;
                endif;
            }
            $i++;
        }


        $hari = array();
        $i = 0;
        foreach ($siswa as $row) {
            for ($j = 0; $j < $tot_hari; $j++) {
                $hari[$i][$j] = $j + 1;
            }
            $i++;
        }

        $data['title'] = 'Data Rekap';
        $data['sel_kelas'] = $set;
        $data['sel_bulan'] = $bulan_now;
        $data['sel_tahun'] = $tahun_now;
        $data['tot_hari'] = $tot_hari;
        $data['siswa'] = $siswa; //daftar siswa
        $data['rec'] = $rec; //data absensi
        $data['hari'] = $hari; //daftar hari per siswa
        $data['bulan'] = $daftar_bulan;
        $data['kelas'] = $this->kelas->findAll();
        $data['guru'] = $this->kelas->get_data_guru($kelas);
        $data['kepsek'] = $this->guru->where('level_login', "KS")->first();
        $data['periode'] = $this->periode->findAll();
        return view('v_guru/presensi/V_rekap', $data);
    }

    function set_presensi()
    {
        $cek = $this->home->sudah_absen($this->request->getVar('id_absen'));
        if ($cek):
            $data = [
                'id_detail_absensi' => $cek['id_detail_absensi'],
                'id_absensi' => $this->request->getVar('id_absen'),
                'jam_absensi' => "07:00:01",
                'tgl_absensi' => date('Y-m-d'),
                'absensi' => $this->request->getVar('absensi'),
                'jenis_absensi' => "manual"
            ];
            $send = $this->detail->save($data);
            if ($send):
                session()->setFlashdata('success', ' Data berhasil diperbaharui.');
            else:
                session()->setFlashdata('warning', ' Data gagal diperbaharui.');
            endif;
        else:
            $data = [
                'id_detail_absensi' => md5(microtime()),
                'id_absensi' => $this->request->getVar('id_absen'),
                'jam_absensi' => "07:01:00",
                'tgl_absensi' => date('Y-m-d'),
                'absensi' => $this->request->getVar('absensi'),
                'jenis_absensi' => "manual"
            ];
            $send = $this->detail->simpan($data);
            if ($send):
                session()->setFlashdata('success', ' Data berhasil diperbaharui.');
            else:
                session()->setFlashdata('warning', ' Data gagal diperbaharui.');
            endif;
        endif;
        return redirect()->route(bin2hex('guru') . '/' . bin2hex('presensi'));
    }

    //Edit Presensi
    public function update($month = '', $years = '', $id_ab = '')
    {
        $daftar_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $kelas = $this->guru->get_guru_by(session()->get('id'));
        $set = $kelas['kelas'];
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $sel_siswa = $this->request->getPost('ps');
        $bulan_now = date('m');
        $tahun_now = date('Y');
        if (isset($bulan) && isset($tahun)) {
            $bulan_now = $bulan;
            $tahun_now = $tahun;
        } else if ($month != '') {
            $bulan_now = $month;
            $tahun_now = $years;
            $sel_siswa = $id_ab;
        }
        $kelas = "I";
        if (isset($set)) {
            $kelas = $set;
        }

        $tot_hari = cal_days_in_month(CAL_GREGORIAN, $bulan_now, $tahun_now);
        $siswa = $this->presensi->get_data_presensi_by($kelas);
        $rekap = $this->home->get_rekap_by($sel_siswa, $kelas, $bulan_now, $tahun_now);

        $rec = array();
        $hari = array();
        // dd($rekap);
        $nama = "";
        for ($i = 0; $i < $tot_hari; $i++) {
            if (($rekap)):
                foreach ($rekap as $col) {
                    $day = date("d", strtotime($col["tgl_absensi"]));
                    if (($i + 1) == intval($day)):
                        $nama = $col["nama"];
                        $rec[$i] = [
                            "nama" => $col["nama"],
                            "jk" => $col["jk"],
                            "jam" => $col["jam_absensi"],
                            "tgl" => $col["tgl_absensi"],
                            "absensi" => $col["absensi"]
                        ];
                        break;
                    else:
                        $rec[$i] = [
                            "nama" => "",
                            "jk" => "",
                            "jam" => "",
                            "tgl" => "",
                            "absensi" => "-"
                        ];
                    endif;
                }
            else:
                if ($sel_siswa) {
                    $nama = $this->request->getPost('sel_nama');
                }
                $rec[$i] = [
                    "nama" => "",
                    "jk" => "",
                    "jam" => "",
                    "tgl" => "",
                    "absensi" => "-"
                ];
            endif;
            $hari[$i] = $i + 1;
        }
        // dd($rec);

        $data['title'] = 'Data Rekap';
        $data['sel_bulan'] = $bulan_now;
        $data['sel_tahun'] = $tahun_now;
        $data['sel_siswa'] = $sel_siswa;
        $data['sel_nama'] = $nama;
        $data['tot_hari'] = $tot_hari;
        $data['rec'] = $rec; //data absensi
        $data['hari'] = $hari; //daftar hari per siswa
        $data['bulan'] = $daftar_bulan;
        $data['siswa'] = $siswa;
        $data['periode'] = $this->periode->findAll();
        return view('v_guru/presensi/V_update_presensi', $data);
    }

    //aksi update
    function ac_update($bulan = '', $tahun = '')
    {
        $cek = $this->home->sudah_absen_by($this->request->getVar('id_absen'), $this->request->getVar('tgl'));
        $id = $this->request->getVar('id_absen');
        if ($cek):
            $data = [
                'id_detail_absensi' => $cek['id_detail_absensi'],
                'id_absensi' => $this->request->getVar('id_absen'),
                'jam_absensi' => "07:00:59",
                'tgl_absensi' => $this->request->getVar('tgl'),
                'absensi' => $this->request->getVar('absensi'),
                'jenis_absensi' => "manual"
            ];
            $send = $this->detail->save($data);
            if ($send):
                session()->setFlashdata('success', ' Data berhasil diperbaharui.');
            else:
                session()->setFlashdata('warning', ' Data gagal diperbaharui.');
            endif;
        else:
            $data = [
                'id_detail_absensi' => md5(microtime()),
                'id_absensi' => $this->request->getVar('id_absen'),
                'jam_absensi' => "07:01:00",
                'tgl_absensi' => $this->request->getVar('tgl'),
                'absensi' => $this->request->getVar('absensi'),
                'jenis_absensi' => "manual"
            ];
            $send = $this->detail->simpan($data);
            if ($send):
                session()->setFlashdata('success', ' Data berhasil diperbaharui.');
            else:
                session()->setFlashdata('warning', ' Data gagal diperbaharui.');
            endif;
        endif;
        // var_dump(session());
        // echo session()->has('warning');
        // dd($data);
        return redirect()->to('/' . bin2hex('guru') . '/' . bin2hex('edit-presensi') . '/' . $bulan . '/' . $tahun . '/' . $id);
    }

}
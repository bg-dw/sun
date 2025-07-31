<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;

use App\Models\M_periode;
use App\Models\M_home;
use App\Models\M_kelas;
use App\Models\M_guru;
use App\Models\M_presensi;
use App\Models\M_libur;
use App\Models\M_detail_presensi;

class Presensi extends BaseController
{
    protected $periode, $home, $guru, $kelas, $presensi, $libur, $detail_presensi;
    public function __construct()
    {
        $this->is_session_available();
        $this->periode = new M_periode();
        $this->home = new M_home();
        $this->kelas = new M_kelas();
        $this->guru = new M_guru();
        $this->presensi = new M_presensi();
        $this->detail_presensi = new M_detail_presensi();
        $this->libur = new M_libur();
    }
    //index presensi
    public function index()
    {
        $data['title'] = 'Hari Ini';
        $set = $this->request->getPost('kelas');
        $kelas = "I";
        if (isset($set)) {
            $kelas = $set;
        }
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
        return view('v_admin/presensi/V_presensi', $data);
    }

    //rekap presensi
    public function rekap()
    {
        $set = $this->request->getPost('kelas');
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        $list_libur = $this->libur->get_data_libur($bulan, $tahun);
        $tgl_libur = array();
        foreach ($list_libur as $val) {//create array of hari libur
            $tgl_1 = date("d", strtotime($val['tgl_awal']));
            $tgl_2 = date("d", strtotime($val['tgl_akhir']));
            if ($tgl_1 != $tgl_2) {// if there is an range between two date
                for ($i = $tgl_1; $i <= $tgl_2; $i++) {
                    array_push($tgl_libur, intval($i));
                }
            } else {
                array_push($tgl_libur, intval($tgl_1));
            }
        }

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
                else:
                    $rec[$i][$j] = [
                        "nama" => "",
                        "jk" => "",
                        "jam" => "",
                        "tgl" => "",
                        "absensi" => ""
                    ];
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
        $data['list_libur'] = $list_libur;
        $data['libur'] = $tgl_libur;
        $data['sel_kelas'] = $set;
        $data['sel_bulan'] = $bulan_now;
        $data['sel_tahun'] = $tahun_now;
        $data['tot_hari'] = $tot_hari;
        $data['siswa'] = $siswa; //daftar siswa
        $data['rec'] = $rec; //data absensi
        $data['hari'] = $hari; //daftar hari per siswa
        $data['bulan'] = $this->bulan();
        $data['kelas'] = $this->kelas->get_data_kelas();
        $data['guru'] = $this->kelas->get_data_guru($kelas);
        $data['kepsek'] = $this->guru->where('level_login', "KS")->first();
        $data['periode'] = $this->periode->findAll();
        return view('v_admin/presensi/V_rekap', $data);
    }

    public function edit()
    {
        $set = $this->request->getPost('kelas');
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        $list_libur = $this->libur->get_data_libur($bulan, $tahun);
        $tgl_libur = array();
        foreach ($list_libur as $val) {//create array of hari libur
            $tgl_1 = date("d", strtotime($val['tgl_awal']));
            $tgl_2 = date("d", strtotime($val['tgl_akhir']));
            if ($tgl_1 != $tgl_2) {// if there is an range between two date
                for ($i = $tgl_1; $i <= $tgl_2; $i++) {
                    array_push($tgl_libur, intval($i));
                }
            } else {
                array_push($tgl_libur, intval($tgl_1));
            }
        }

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
                else:
                    $rec[$i][$j] = [
                        "nama" => "",
                        "jk" => "",
                        "jam" => "",
                        "tgl" => "",
                        "absensi" => ""
                    ];
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

        $data['title'] = 'Edit Multiple';
        $data['list_libur'] = $list_libur;
        $data['libur'] = $tgl_libur;
        $data['sel_kelas'] = $set;
        $data['sel_bulan'] = $bulan_now;
        $data['sel_tahun'] = $tahun_now;
        $data['tot_hari'] = $tot_hari;
        $data['siswa'] = $siswa; //daftar siswa
        $data['rec'] = $rec; //data absensi
        $data['hari'] = $hari; //daftar hari per siswa
        $data['bulan'] = $this->bulan();
        $data['kelas'] = $this->kelas->get_data_kelas();
        $data['guru'] = $this->kelas->get_data_guru($kelas);
        $data['kepsek'] = $this->guru->where('level_login', "KS")->first();
        $data['periode'] = $this->periode->findAll();
        return view('v_admin/presensi/V_edit', $data);
    }


    // update presensi multiple
    public function update_multiple()
    {
        $tgl = explode(" - ", $this->request->getVar('inp-tgl'));
        $tgl_awal = date("Y-m-d", strtotime($tgl[0]));
        $tgl_akhir = date("Y-m-d", strtotime($tgl[1]));
        $pil = $this->request->getVar('inp-presensi');
        if ($pil === "hadir"):
            $res = $this->detail_presensi->where('tgl_absensi BETWEEN "' . $tgl_awal . '" AND "' . $tgl_akhir . '"')->set(['absensi' => "hadir"])->update();
            if ($res):
                session()->setFlashdata('success', ' Data berhasil disimpan.');
                return redirect()->route(bin2hex('admin') . '/' . bin2hex('edit-presensi'));
            else:
                session()->setFlashdata('warning', ' Gagal memperbaharui data!');
                return redirect()->route(bin2hex('admin') . '/' . bin2hex('edit-presensi'));
            endif;
        elseif ($pil == "hapus"):
            $res = $this->detail_presensi->where('tgl_absensi BETWEEN "' . $tgl_awal . '" AND "' . $tgl_akhir . '"')->delete();
            if ($res):
                session()->setFlashdata('success', ' Data berhasil dihapus.');
                return redirect()->route(bin2hex('admin') . '/' . bin2hex('edit-presensi'));
            else:
                session()->setFlashdata('warning', ' Gagal menghapus data!');
                return redirect()->route(bin2hex('admin') . '/' . bin2hex('edit-presensi'));
            endif;
        else:
            session()->setFlashdata('danger', ' Galat!');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('edit-presensi'));
        endif;
    }
}
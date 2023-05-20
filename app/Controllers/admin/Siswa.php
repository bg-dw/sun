<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\M_siswa;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Siswa extends BaseController
{
    protected $siswa;
    public function __construct()
    {
        $this->siswa = new M_siswa();
    }
    //index presensi
    public function index()
    {
        $data['title'] = 'Data Peserta Didik';
        $data['siswa'] = $this->siswa->findAll();
        return view('v_admin/data/V_siswa', $data);
    }

    //import excel to DB
    public function importCsv()
    {
        $file = $this->request->getFile('excel');
        $extension = $file->getClientExtension();
        if ($extension == 'xlsx' || $extension == 'xls') {
            if ($extension == 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($file);
            $excel_data = $spreadsheet->getActiveSheet()->toArray();
            $arr = array();
            $i = 0;
            $nis = $nisn = $tmpt = $tgl = $asis = $ayah = $ibu = $p_ayah = $p_ibu = $al_ort = $nm_wali = $al_wali = "-";
            foreach ($excel_data as $key => $value) {
                $nis = empty($value[2]) ? "-" : $value[2];
                $nisn = empty($value[4]) ? "-" : $value[4];
                $tmpt = empty($value[5]) ? "-" : $value[5];
                $tgl = empty($value[6]) ? "-" : $value[6];
                $asis = empty($value[9]) ? "-" : $value[9];
                $ayah = empty($value[24]) ? "-" : $value[24];
                $ibu = empty($value[30]) ? "-" : $value[30];
                $p_ayah = empty($value[27]) ? "-" : $value[27];
                $p_ibu = empty($value[33]) ? "-" : $value[33];
                $al_ort = empty($value[9]) ? "-" : $value[9];
                $nm_wali = empty($value[36]) ? "-" : $value[36];
                $al_wali = empty($value[9]) ? "-" : $value[9];
                $id = md5(date('U'));
                if ($key <= 5) {
                    continue;
                }
                $arr = [
                    'id_siswa' => ($i . $id),
                    'nama' => $value[1],
                    'nis' => $nis,
                    'jk' => $value[3],
                    'nisn' => $nisn,
                    'tmp_lahir' => $tmpt,
                    'tgl_lahir' => $tgl,
                    'alamat_siswa' => $asis,
                    'ayah_kandung' => $ayah,
                    'ibu_kandung' => $ibu,
                    'p_ayah' => $p_ayah,
                    'p_ibu' => $p_ibu,
                    'alamat_ortu' => $al_ort,
                    'nama_wali' => $nm_wali,
                    'alamat_wali' => $al_wali
                ];
                $result = $this->siswa->inp($arr);
                if ($result) {
                    $i++;
                }
            }
            session()->setFlashdata('success', $i . ' Data berhasil diimport.');
            return redirect()->route('admin/siswa');
        } else {
            return redirect()->back()->with('error', 'File harus berupa Excel.');
        }
    }
}
<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\M_siswa;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class MasterSiswa extends BaseController
{
    protected $siswa, $validation;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->is_session_available();
        $this->siswa = new M_siswa();
    }
    //index siswa
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
                $tmpt = empty($value[5]) ? "-" : strtoupper($value[5]);
                $tgl = empty($value[6]) ? "-" : $value[6];
                $asis = empty($value[9]) ? "-" : $value[9];
                $ayah = empty($value[24]) ? "-" : strtoupper($value[24]);
                $ibu = empty($value[30]) ? "-" : strtoupper($value[30]);
                $p_ayah = empty($value[27]) ? "-" : strtoupper($value[27]);
                $p_ibu = empty($value[33]) ? "-" : strtoupper($value[33]);
                $al_ort = empty($value[9]) ? "-" : $value[9];
                $nm_wali = empty($value[36]) ? "-" : strtoupper($value[36]);
                $al_wali = empty($value[9]) ? "-" : $value[9];
                $id = md5($i . date('U'));
                if ($key <= 5) {
                    continue;
                }
                $arr = [
                    'id_siswa' => ($id),
                    'nama' => strtoupper($value[1]),
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
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-siswa'));
        } else {
            return redirect()->back()->with('error', 'File harus berupa Excel.');
        }
    }

    //tambah siswa
    public function ac_add()
    {
        $data = [
            'id_siswa' => md5(random_int(0, 9) . date('U')),
            'nis' => $this->request->getVar('nis'),
            'nisn' => $this->request->getVar('nisn'),
            'nama' => strtoupper($this->request->getVar('nama')),
            'jk' => strtoupper($this->request->getVar('jk')),
            'tmp_lahir' => strtoupper($this->request->getVar('tl')),
            'tgl_lahir' => date('Y-m-d', strtotime($this->request->getVar('tgl'))),
            'alamat_siswa' => $this->request->getVar('alamat'),
            'ayah_kandung' => strtoupper($this->request->getVar('bapak')),
            'ibu_kandung' => strtoupper($this->request->getVar('ibu')),
            'p_ayah' => strtoupper($this->request->getVar('p_bapak')),
            'p_ibu' => strtoupper($this->request->getVar('p_ibu')),
            'alamat_ortu' => $this->request->getVar('alamat_o'),
            'nama_wali' => strtoupper($this->request->getVar('wali')),
            'alamat_wali' => $this->request->getVar('alamat_wl')
        ];
        $send = $this->siswa->inp($data);
        if ($send) {
            session()->setFlashdata('success', ' Data berhasil disimpan.');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-siswa'));
        } else {
            session()->setFlashdata('warning', ' Data gagal ditambahkan.');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-siswa'));
        }
        // dd($send);
    }

    //update siswa
    public function ac_update()
    {
        $data = [
            'id_siswa' => $this->request->getVar('id'),
            'nis' => $this->request->getVar('nis'),
            'nisn' => $this->request->getVar('nisn'),
            'nama' => strtoupper($this->request->getVar('nama')),
            'jk' => strtoupper($this->request->getVar('jk')),
            'tmp_lahir' => strtoupper($this->request->getVar('tl')),
            'tgl_lahir' => date('Y-m-d', strtotime($this->request->getVar('tgl'))),
            'alamat_siswa' => $this->request->getVar('alamat'),
            'ayah_kandung' => strtoupper($this->request->getVar('bapak')),
            'ibu_kandung' => strtoupper($this->request->getVar('ibu')),
            'p_ayah' => strtoupper($this->request->getVar('p_bapak')),
            'p_ibu' => strtoupper($this->request->getVar('p_ibu')),
            'alamat_ortu' => $this->request->getVar('alamat_o'),
            'nama_wali' => strtoupper($this->request->getVar('wali')),
            'alamat_wali' => $this->request->getVar('alamat_wl')
        ];
        $send = $this->siswa->save($data);
        if ($send) {
            session()->setFlashdata('success', ' Data berhasil disimpan.');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-siswa'));
        } else {
            session()->setFlashdata('warning', ' Perubahan Data gagal!');
            return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-siswa'));
        }
    }

    //delete siswa
    public function ac_delete()
    {
        $pic = $this->siswa->find($this->request->getVar('id'));
        $send = $this->siswa->where('id_siswa', $this->request->getVar('id'))->delete();
        if ($send):
            if ($pic['pic_siswa']) { //if image exist
                unlink('public/assets/img/siswa/' . $pic['pic_siswa']);
            }
            session()->setFlashdata('success', ' Data berhasil dihapus.');
        else:
            session()->setFlashdata('warning', ' Data gagal dihapus.');
        endif;
        return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-siswa'));
    }

    //update foto siswa
    public function ac_upload_foto()
    {
        $dataBerkas = $this->request->getFile('foto');
        $id = $this->request->getVar('id');
        $temp_name = md5($id . $dataBerkas->getRandomName());
        $ext = $dataBerkas->getExtension(); //get file extension
        $valid = $this->validate([
            'foto' => [
                'uploaded[foto]',
                'max_size[foto,1000]',
                'mime_in[foto,image/png,image/jpg,image/gif]',
                'ext_in[foto,png,jpg,gif]'
            ],
        ]);
        $fileName = $temp_name . "." . $ext;
        $dataBerkas->move('public/assets/img/siswa/', $fileName); //move file and rename
        if ($dataBerkas->hasMoved()) {
            $data = [
                'id_siswa' => $this->request->getVar('id'),
                'pic_siswa' => $fileName
            ];
            $send = $this->siswa->save($data);
            if ($send) {
                session()->setFlashdata('success', ' Berhasil Upload Foto.');
                return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-siswa'));
            } else {
                session()->setFlashdata('warning', ' Perubahan Foto gagal!');
                return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-siswa'));
            }
        } else {
            session()->setFlashdata('warning', 'Gagal Upload foto.');
        }
    }

}
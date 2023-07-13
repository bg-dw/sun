<?php

namespace App\Controllers\guru;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\M_siswa;
use App\Models\M_guru;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class MasterSiswa extends BaseController
{
    protected $siswa, $guru;
    public function __construct()
    {
        $this->is_session_available();
        $this->siswa = new M_siswa();
        $this->guru = new M_guru();
    }
    //index siswa
    public function index()
    {
        $data['title'] = 'Data Peserta Didik';
        $kelas = $this->guru->get_guru_by(session()->get('id'));
        $set = $kelas['kelas'];
        $data['siswa'] = $this->siswa->get_siswa($set);
        return view('v_guru/V_siswa', $data);
    }

}
<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\M_periode;
use App\Models\M_kelas;
use App\Models\M_guru;
use App\Models\M_siswa;
use App\Models\M_presensi;

class MasterKelasSiswa extends BaseController
{
    protected $kelas, $periode, $guru;
    public function __construct()
    {
        $this->is_session_available();
        $this->periode = new M_periode();
        $this->kelas = new M_kelas();
        $this->guru = new M_guru();
        $this->siswa = new M_siswa();
        $this->presensi = new M_presensi();
    }
    //index presensi
    public function index()
    {
        $data['title'] = 'Data Peserta Didik';
        $id_kelas = $this->request->getVar('id_kelas');
        $data_kelas = $this->kelas->get_kelas_orderby('ASC');//to set default kelas
        $pil_kelas = $this->kelas->where('id_kelas', $id_kelas)->first();//to set kelas by
        $def_id = $data_kelas['id_kelas'];//store value
        $def_kelas = $data_kelas['kelas'];
        $def_tingkat = 1;//default tingkat

        if ($id_kelas != "" || $id_kelas != null) {
            $def_id = $id_kelas;
            $def_kelas = $pil_kelas['kelas'];
            $def_tingkat = $pil_kelas['tingkat'];
        }

        $tahun_awal = explode('-', session()->get('periode'));
        $siswa = $this->siswa->get_siswa_periode($def_id);
        $siswa_lama = $this->siswa->get_siswa_lama(($def_tingkat - 1), (intval($tahun_awal[0]) - 1));//data siswa pada tahun sebelumnya 1 tingkat dibawahnya

        $data['pil_id'] = $def_id;
        $data['pil_kelas'] = $def_kelas;
        $data['pil_tingkat'] = $def_tingkat;
        $data['kelas'] = $this->kelas->where('id_periode', session()->get('id_periode'))->findAll();
        $data['siswa'] = $siswa;
        $data['siswa_lama'] = $siswa_lama;
        return view('v_admin/data/V_kelas_siswa', $data);
    }
    //update Siswa Kelas
    public function update_siswa_kelas()
    {
        $id_kelas = $this->request->getVar('id_kelas');
        $id_siswa = $this->request->getVar('id_siswa');

        if ($id_kelas) {
            $sql = $this->presensi->whereIn('id_siswa', $id_siswa)->set(['id_kelas' => $id_kelas])->update();
            if ($sql) {
                $hasil = 1;
            } else {
                $hasil = $sql;
            }
            return json_encode($hasil);
        } else {
            return json_encode($id_siswa);
        }
    }

    //delete kelas
    public function delete()
    {
        $send = $this->kelas->where('id_kelas', $this->request->getVar('id'))->delete();
        if ($send):
            session()->setFlashdata('success', ' Data berhasil dihapus.');
        else:
            session()->setFlashdata('warning', ' Data gagal dihapus.');
        endif;
        return redirect()->route(bin2hex('admin') . '/' . bin2hex('data-kelas'));
    }

    public function get_kelas()
    {
        $id_kelas = $this->request->getVar('id_kelas');
        $pil_kelas = $this->kelas->where('id_kelas', $id_kelas)->first();

        $where = array(
            'id_periode' => ($pil_kelas['id_periode'] - 1),
            'tingkat' => ($pil_kelas['tingkat'] - 1)
        );
        $kelas_lama = $this->kelas->where($where)->first();
        return json_encode($kelas_lama);
    }
}
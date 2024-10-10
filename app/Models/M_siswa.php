<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class M_siswa extends Model
{
    protected $table = 'tbl_siswa';
    protected $primaryKey = 'id_siswa';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_siswa',
        'status_siswa',
        'nik',
        'nis',
        'nisn',
        'nama',
        'pic_siswa',
        'jk',
        'tmp_lahir',
        'tgl_lahir',
        'alamat_siswa',
        'ayah_kandung',
        'ibu_kandung',
        'p_ayah',
        'p_ibu',
        'alamat_ortu',
        'nama_wali',
        'alamat_wali'
    ];

    public function inp($data)
    {
        // Inserts data and returns true on success and false on failure
        $exc = $this->db->table('tbl_siswa')->insert($data);
        return $exc;
    }

    function get_siswa($kelas)
    {
        $this->select('tbl_kelas.kelas,tbl_siswa.nis,tbl_siswa.nisn,tbl_siswa.nama');
        $this->join('tbl_absensi', 'tbl_siswa.id_siswa = tbl_absensi.id_siswa');
        $this->join('tbl_kelas', 'tbl_absensi.id_kelas = tbl_kelas.id_kelas');
        $this->join('tbl_periode', 'tbl_kelas.id_periode = tbl_periode.id_periode');
        $this->where('tbl_kelas.kelas', $kelas);
        $this->orderBy('tbl_siswa.nama', 'ASC');
        return $this->findAll();
    }
    function get_siswa_periode($id_k)
    {
        $this->select('tbl_kelas.id_kelas,tbl_kelas.kelas,tbl_siswa.id_siswa,tbl_siswa.nis,tbl_siswa.nisn,tbl_siswa.nama');
        $this->join('tbl_absensi', 'tbl_siswa.id_siswa = tbl_absensi.id_siswa');
        $this->join('tbl_kelas', 'tbl_absensi.id_kelas = tbl_kelas.id_kelas');
        $this->join('tbl_periode', 'tbl_kelas.id_periode = tbl_periode.id_periode');
        $this->where('tbl_kelas.id_kelas', $id_k);
        $this->where('tbl_periode.status_periode', 'aktif');
        $this->orderBy('tbl_siswa.nama', 'ASC');
        return $this->findAll();
    }
    function get_siswa_lama($tingkat, $tahun_awal)
    {
        $this->select('tbl_kelas.id_kelas,tbl_kelas.kelas,tbl_kelas.tingkat,tbl_siswa.id_siswa,tbl_siswa.nis,tbl_siswa.nisn,tbl_siswa.nama');
        $this->join('tbl_absensi', 'tbl_siswa.id_siswa = tbl_absensi.id_siswa');
        $this->join('tbl_kelas', 'tbl_absensi.id_kelas = tbl_kelas.id_kelas');
        $this->join('tbl_periode', 'tbl_kelas.id_periode = tbl_periode.id_periode');
        $this->where('tbl_kelas.tingkat', $tingkat);
        $this->where('tbl_periode.tahun_awal', $tahun_awal);
        $this->orderBy('tbl_siswa.nama', 'ASC');
        return $this->findAll();
    }
    function get_pic($id)
    {
        $this->select('tbl_siswa.pic_siswa,tbl_siswa.nama');
        $this->where('tbl_siswa.id_siswa', $id);
        return $this->first();
    }
}
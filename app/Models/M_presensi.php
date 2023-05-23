<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class M_presensi extends Model
{
    protected $table = 'tbl_absensi';
    protected $primaryKey = 'id_absensi';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_absensi',
        'id_siswa',
        'id_kelas',
        'rfid'
    ];

    //simpan
    public function simpan($data)
    {
        // Inserts data and returns true on success and false on failure
        $exc = $this->db->table($this->table)->insert($data);
        return $exc;
    }
    function get_data_presensi()
    {
        $this->select('tbl_absensi.id_absensi,tbl_absensi.rfid,tbl_siswa.id_siswa,tbl_siswa.nis,tbl_siswa.nama,tbl_kelas.kelas');
        $this->join('tbl_siswa', 'tbl_absensi.id_siswa = tbl_siswa.id_siswa');
        $this->join('tbl_kelas', 'tbl_absensi.id_kelas = tbl_kelas.id_kelas');
        return $this->findAll();
    }

    function cek_rfid_by_period($rfid)
    {
        $this->select('tbl_periode.status_periode,tbl_kelas.kelas,tbl_absensi.rfid,tbl_siswa.nama');
        $this->join('tbl_kelas', 'tbl_absensi.id_kelas = tbl_kelas.id_kelas');
        $this->join('tbl_periode', 'tbl_kelas.id_periode = tbl_periode.id_periode');
        $this->join('tbl_siswa', 'tbl_absensi.id_siswa = tbl_siswa.id_siswa');
        $this->where(['tbl_periode.status_periode' => 'aktif', 'tbl_absensi.rfid' => $rfid]);
        return $this->first();
    }
}
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
        $this->select('tbl_absensi.id_absensi,tbl_absensi.rfid,tbl_siswa.id_siswa,tbl_siswa.nis,tbl_siswa.nama,tbl_kelas.id_kelas,tbl_kelas.kelas');
        $this->join('tbl_siswa', 'tbl_absensi.id_siswa = tbl_siswa.id_siswa');
        $this->join('tbl_kelas', 'tbl_absensi.id_kelas = tbl_kelas.id_kelas');
        $this->join('tbl_periode', 'tbl_periode.id_periode = tbl_kelas.id_periode');
        $this->where(['tbl_periode.status_periode' => 'aktif']);
        $this->orderBy('tbl_kelas.kelas', 'ASC');
        $this->orderBy('tbl_siswa.nama', 'ASC');
        return $this->findAll();
    }

    function get_id_presensi()
    {
        $this->select('tbl_absensi.id_absensi');
        $this->join('tbl_siswa', 'tbl_absensi.id_siswa = tbl_siswa.id_siswa');
        $this->join('tbl_kelas', 'tbl_absensi.id_kelas = tbl_kelas.id_kelas');
        $this->join('tbl_periode', 'tbl_periode.id_periode = tbl_kelas.id_periode');
        $this->where(['tbl_periode.status_periode' => 'aktif']);
        return $this->findAll();
    }

    function get_today()
    {
        $this->select('tbl_detail_absensi.id_absensi');
        $this->join('tbl_detail_absensi', 'tbl_absensi.id_absensi=tbl_detail_absensi.id_absensi');
        $this->join('tbl_kelas', 'tbl_absensi.id_kelas = tbl_kelas.id_kelas');
        $this->join('tbl_periode', 'tbl_periode.id_periode = tbl_kelas.id_periode');
        $this->where(['tbl_periode.status_periode' => "aktif", 'tbl_detail_absensi.tgl_absensi' => date("Y-m-d")]);
        return $this->findAll();
    }

    function get_data_presensi_kelas()
    {
        $sql = $this->db->query("select count(tbl_siswa.id_siswa) as tot, tbl_kelas.kelas from tbl_absensi join tbl_siswa on tbl_absensi.id_siswa = tbl_siswa.id_siswa join tbl_kelas on tbl_absensi.id_kelas = tbl_kelas.id_kelas join tbl_periode on tbl_kelas.id_periode = tbl_periode.id_periode where tbl_periode.status_periode='aktif'group by tbl_kelas.kelas ORDER BY tbl_kelas.kelas ASC");
        return $sql->getResult();
    }

    function get_data_presensi_by($kelas)
    {
        $this->select('tbl_absensi.id_absensi,tbl_absensi.rfid,tbl_siswa.id_siswa,tbl_siswa.nis,tbl_siswa.nama,tbl_siswa.jk,tbl_kelas.kelas');
        $this->join('tbl_siswa', 'tbl_absensi.id_siswa = tbl_siswa.id_siswa');
        $this->join('tbl_kelas', 'tbl_absensi.id_kelas = tbl_kelas.id_kelas');
        $this->join('tbl_periode', 'tbl_periode.id_periode = tbl_kelas.id_periode');
        $this->where(['tbl_periode.status_periode' => 'aktif', 'tbl_kelas.kelas' => $kelas]);
        $this->orderBy('tbl_siswa.nama', 'ASC');
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
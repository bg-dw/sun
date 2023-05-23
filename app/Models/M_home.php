<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class M_home extends Model
{
    protected $table = 'tbl_detail_absensi';
    protected $primaryKey = 'id_detail_absensi';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_detail_absensi',
        'id_absensi',
        'jam_absensi',
        'tgl_absensi',
        'absensi',
        'jenis_absensi',
        'bukti_absensi',
        'updated_at'
    ];

    //simpan
    public function simpan($data)
    {
        // Inserts data and returns true on success and false on failure
        $exc = $this->db->table($this->table)->insert($data);
        return $exc;
    }

    function get_presensi($kelas)
    {
        $this->select('tbl_periode.status_periode,tbl_kelas.kelas,tbl_absensi.rfid,tbl_siswa.nama,tbl_detail_absensi.jam_absensi');
        $this->join('tbl_absensi', 'tbl_detail_absensi.id_absensi = tbl_absensi.id_absensi');
        $this->join('tbl_kelas', 'tbl_absensi.id_kelas = tbl_kelas.id_kelas');
        $this->join('tbl_periode', 'tbl_kelas.id_periode = tbl_periode.id_periode');
        $this->join('tbl_siswa', 'tbl_absensi.id_siswa = tbl_siswa.id_siswa');
        $this->where(['tbl_periode.status_periode' => 'aktif', 'tbl_kelas.kelas' => $kelas, 'tbl_detail_absensi.tgl_absensi' => date('Y-m-d')]);
        return $this->findAll();
    }
    function get_presensi_by_rfid($rfid)
    {
        // $this->select('tbl_periode.status_periode,tbl_kelas.kelas,tbl_absensi.id_absensi,tbl_absensi.rfid');
        // $this->from('tbl_absensi');
        // $this->join('tbl_kelas', 'tbl_absensi.id_kelas = tbl_kelas.id_kelas');
        // $this->join('tbl_periode', 'tbl_kelas.id_periode = tbl_periode.id_periode');
        // $this->where(['tbl_periode.status_periode' => 'aktif', 'tbl_absensi.rfid' => $rfid]);
        // return $this->first();
        $sql = $this->db->query("select tbl_periode.status_periode,tbl_kelas.kelas,tbl_absensi.id_absensi,tbl_absensi.rfid from tbl_absensi join tbl_kelas on tbl_absensi.id_kelas = tbl_kelas.id_kelas join tbl_periode on tbl_kelas.id_periode = tbl_periode.id_periode where tbl_periode.status_periode='aktif'and tbl_absensi.rfid='" . $rfid . "'");
        return $sql->getResult();
    }
}
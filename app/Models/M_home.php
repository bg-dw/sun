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
        $this->select('tbl_periode.status_periode,tbl_kelas.kelas,tbl_absensi.rfid,tbl_siswa.id_siswa,tbl_siswa.nama,tbl_detail_absensi.jam_absensi,tbl_detail_absensi.absensi,tbl_detail_absensi.id_detail_absensi');
        $this->join('tbl_absensi', 'tbl_detail_absensi.id_absensi = tbl_absensi.id_absensi');
        $this->join('tbl_kelas', 'tbl_absensi.id_kelas = tbl_kelas.id_kelas');
        $this->join('tbl_periode', 'tbl_kelas.id_periode = tbl_periode.id_periode');
        $this->join('tbl_siswa', 'tbl_absensi.id_siswa = tbl_siswa.id_siswa');
        $this->where(['tbl_periode.status_periode' => 'aktif', 'tbl_kelas.kelas' => $kelas, 'tbl_detail_absensi.tgl_absensi' => date('Y-m-d')]);
        $this->orderBy('tbl_siswa.nama', 'ASC');
        return $this->findAll();
    }

    function get_rekap($kelas, $bulan, $tahun)
    {
        $this->select('tbl_periode.status_periode,tbl_kelas.kelas,tbl_absensi.rfid,tbl_siswa.id_siswa,tbl_siswa.nama,tbl_siswa.jk,tbl_detail_absensi.jam_absensi,tbl_detail_absensi.tgl_absensi,tbl_detail_absensi.absensi');
        $this->join('tbl_absensi', 'tbl_detail_absensi.id_absensi = tbl_absensi.id_absensi');
        $this->join('tbl_kelas', 'tbl_absensi.id_kelas = tbl_kelas.id_kelas');
        $this->join('tbl_periode', 'tbl_kelas.id_periode = tbl_periode.id_periode');
        $this->join('tbl_siswa', 'tbl_absensi.id_siswa = tbl_siswa.id_siswa');
        $this->where('tbl_kelas.kelas', $kelas);
        $this->where('MONTH(tbl_detail_absensi.tgl_absensi)', $bulan);
        $this->where('YEAR(tbl_detail_absensi.tgl_absensi)', $tahun);
        $this->orderBy('tbl_siswa.nama', 'ASC');
        $this->orderBy('tbl_detail_absensi.tgl_absensi', 'ASC');
        return $this->findAll();
    }

    function get_rekap_today($date)
    {
        $this->select('tbl_kelas.kelas,count(tbl_siswa.id_siswa) as tot');
        $this->join('tbl_absensi', 'tbl_detail_absensi.id_absensi = tbl_absensi.id_absensi');
        $this->join('tbl_kelas', 'tbl_absensi.id_kelas = tbl_kelas.id_kelas');
        $this->join('tbl_periode', 'tbl_kelas.id_periode = tbl_periode.id_periode');
        $this->join('tbl_siswa', 'tbl_absensi.id_siswa = tbl_siswa.id_siswa');
        $this->where('tbl_detail_absensi.tgl_absensi', $date);
        $this->orderBy('tbl_kelas.kelas', 'ASC');
        $this->orderBy('tbl_detail_absensi.tgl_absensi', 'ASC');
        $this->groupBy('tbl_kelas.kelas');
        return $this->findAll();
    }

    function get_total_absensi($kelas)
    {
        $this->select('COUNT(tbl_detail_absensi.id_detail_absensi) as total');
        $this->join('tbl_absensi', 'tbl_detail_absensi.id_absensi = tbl_absensi.id_absensi');
        $this->join('tbl_kelas', 'tbl_absensi.id_kelas = tbl_kelas.id_kelas');
        $this->join('tbl_periode', 'tbl_kelas.id_periode = tbl_periode.id_periode');
        $this->join('tbl_siswa', 'tbl_absensi.id_siswa = tbl_siswa.id_siswa');
        $this->where(['tbl_periode.status_periode' => 'aktif', 'tbl_kelas.kelas' => $kelas, 'tbl_detail_absensi.tgl_absensi' => date('Y-m-d')]);
        return $this->first();
    }
    function get_presensi_by_rfid($rfid)
    {
        $sql = $this->db->query("select tbl_periode.status_periode,tbl_kelas.kelas,tbl_absensi.id_absensi,tbl_absensi.rfid from tbl_absensi join tbl_kelas on tbl_absensi.id_kelas = tbl_kelas.id_kelas join tbl_periode on tbl_kelas.id_periode = tbl_periode.id_periode where tbl_periode.status_periode='aktif'and tbl_absensi.rfid='" . $rfid . "'");
        return $sql->getResult();
    }

    function sudah_absen($id)
    {
        $this->select('id_absensi,id_detail_absensi');
        $this->where(['id_absensi' => $id, 'tgl_absensi' => date('Y-m-d')]);
        return $this->first();
    }
}
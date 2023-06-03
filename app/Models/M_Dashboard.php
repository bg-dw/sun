<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class M_Dashboard extends Model
{
    protected $table = 'tbl_siswa';
    protected $primaryKey = 'id_siswa';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_siswa',
        'nama_siswa'
    ];

    function get_all_data()
    {
        $this->select('SUM(case tbl_siswa.jk when "L" then 1 else 0 end) as L,SUM(case tbl_siswa.jk when "P" then 1 else 0 end) as P');
        $this->join('tbl_absensi', 'tbl_absensi.id_siswa = tbl_siswa.id_siswa');
        $this->join('tbl_kelas', 'tbl_absensi.id_kelas = tbl_kelas.id_kelas');
        $this->join('tbl_periode', 'tbl_kelas.id_periode = tbl_periode.id_periode');
        $this->where(['tbl_periode.status_periode' => 'aktif']);
        return $this->first();
    }
}
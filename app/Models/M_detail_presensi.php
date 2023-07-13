<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class M_detail_presensi extends Model
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
        'bukti_absensi'
    ];

    public function simpan($data)
    {
        // Inserts data and returns true on success and false on failure
        $exc = $this->db->table($this->table)->insert($data);
        return $exc;
    }
}
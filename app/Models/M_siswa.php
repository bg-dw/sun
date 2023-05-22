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
        'nis',
        'nisn',
        'nama',
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
}
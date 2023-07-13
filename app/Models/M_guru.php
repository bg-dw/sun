<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class M_guru extends Model
{
    protected $table = 'tbl_guru';
    protected $primaryKey = 'id_guru';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_guru',
        'nip',
        'nama_guru',
        'gelar_guru',
        'level_login',
        'status_guru'
    ];

    function get_guru_by($id)
    {
        $this->select('tbl_kelas.kelas');
        $this->join('tbl_kelas', 'tbl_kelas.id_guru = tbl_guru.id_guru');
        $this->join('tbl_periode', 'tbl_kelas.id_periode = tbl_periode.id_periode');
        $this->where(['tbl_periode.status_periode' => 'aktif']);
        $this->where(['tbl_guru.id_guru' => $id]);
        return $this->first();
    }
}
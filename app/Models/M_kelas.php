<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class M_kelas extends Model
{
    protected $table = 'tbl_kelas';
    protected $primaryKey = 'id_kelas';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_kelas',
        'id_periode',
        'id_guru',
        'kelas',
        'updated_at'
    ];

    function get_data_kelas()
    {
        $this->select('tbl_kelas.id_kelas,tbl_kelas.kelas,tbl_periode.tahun_awal,tbl_periode.tahun_akhir,tbl_guru.nama_guru,tbl_guru.gelar_guru');
        $this->join('tbl_periode', 'tbl_kelas.id_periode = tbl_periode.id_periode');
        $this->join('tbl_guru', 'tbl_kelas.id_guru = tbl_guru.id_guru');
        return $this->findAll();
    }
    function get_data_guru($kelas)
    {
        $this->select('tbl_guru.*');
        $this->join('tbl_periode', 'tbl_kelas.id_periode = tbl_periode.id_periode');
        $this->join('tbl_guru', 'tbl_kelas.id_guru = tbl_guru.id_guru');
        $this->where(['tbl_kelas.kelas' => $kelas]);
        return $this->first();
    }
}
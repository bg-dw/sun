<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class M_libur extends Model
{
    protected $table = 'tbl_libur';
    protected $primaryKey = 'id_libur';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_libur',
        'id_periode',
        'tgl_awal',
        'tgl_akhir',
        'ket_libur',
    ];

    function get_data_libur($bulan, $tahun)
    {
        $this->select('tbl_libur.*');
        $this->join('tbl_periode', 'tbl_libur.id_periode = tbl_periode.id_periode');
        $this->where(['MONTH(tbl_libur.tgl_awal)' => $bulan]);
        $this->where(['YEAR(tbl_libur.tgl_awal)' => $tahun]);
        $this->orderBy('tbl_libur.tgl_awal', 'ASC');
        return $this->findAll();
    }
    function get_data_libur_by($id_periode, $date)
    {
        $this->select('tbl_libur.id_libur');
        $this->where('"' . $date . '" BETWEEN tgl_awal AND tgl_akhir');
        $this->where('id_periode="' . $id_periode . '"');
        return $this->findAll();
    }
}
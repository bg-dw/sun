<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class M_periode extends Model
{
    protected $table = 'tbl_periode';
    protected $primaryKey = 'id_periode';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_periode',
        'tahun_awal',
        'tahun_akhir'
    ];
}
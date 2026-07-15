<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriPembayaranModel extends Model
{
    protected $table            = 'kategori_pembayaran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_kategori', 'nominal_std'];
}
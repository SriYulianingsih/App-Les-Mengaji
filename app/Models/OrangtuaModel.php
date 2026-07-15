<?php

namespace App\Models;

use CodeIgniter\Model;

class OrangtuaModel extends Model
{
    protected $table = 'orangtua';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id','nama_ayah','nama_ibu','no_hp','email',
        'pekerjaan_ayah','pekerjaan_ibu','alamat','rt','rw',
        'kelurahan','kecamatan','kabupaten','provinsi','kode_pos'
    ];

    protected $useTimestamps = true;

    public function getWithUser()
    {
        // Diubah menjadi left join agar ortu tanpa akun tetap tampil
        return $this->select('orangtua.*, users.username')
            ->join('users', 'users.id = orangtua.user_id', 'left')
            ->findAll();
    }
}
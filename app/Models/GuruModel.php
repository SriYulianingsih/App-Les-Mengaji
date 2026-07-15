<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table = 'guru';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id','nip','nama','jenis_kelamin',
        'no_hp','alamat','pendidikan','foto','status'
    ];

    protected $useTimestamps = true;

    public function getWithUser()
    {
        // Diubah menjadi left join agar guru tanpa akun tetap tampil
        return $this->select('guru.*, users.username')
            ->join('users', 'users.id = guru.user_id', 'left')
            ->findAll();
    }
}
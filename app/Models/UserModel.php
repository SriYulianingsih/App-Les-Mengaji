<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username', 'password', 'role', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = true;

    // Relasi ke Guru
    public function guru()
    {
        return $this->db->table('guru')
            ->where('user_id', $this->attributes['id'])
            ->get()->getRow();
    }

    // Relasi ke Orangtua
    public function orangtua()
    {
        return $this->db->table('orangtua')
            ->where('user_id', $this->attributes['id'])
            ->get()->getRow();
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class SantriModel extends Model
{
    protected $table = 'santri';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'orangtua_id', 'kelas_id', 'nis', 'nama', 'jenis_kelamin',
        'tempat_lahir', 'tanggal_lahir', 'alamat',
        'pendidikan_terakhir', 'tanggal_daftar',
        'status', 'foto'
    ];

    protected $useTimestamps = true;

    public function getFull()
    {
        return $this->select('santri.*, orangtua.nama_ayah, orangtua.no_hp, kelas.nama_kelas')
            ->join('orangtua', 'orangtua.id = santri.orangtua_id')
            ->join('kelas', 'kelas.id = santri.kelas_id', 'left')
            ->findAll();
    }

    public function getFullById($id)
    {
        return $this->select('santri.*, orangtua.nama_ayah, orangtua.no_hp as no_hp_ortu, kelas.nama_kelas')
            ->join('orangtua', 'orangtua.id = santri.orangtua_id', 'left')
            ->join('kelas', 'kelas.id = santri.kelas_id', 'left')
            ->where('santri.id', $id)
            ->first();
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'guru_id', 'mapel_id', 'kelas_id', 'hari', 'jam_mulai', 'jam_selesai'
    ];

    protected $useTimestamps = true;

    public function getFull()
    {
        return $this->select('jadwal.*, guru.nama as nama_guru, mapel.nama_mapel, kelas.nama_kelas')
            ->join('guru', 'guru.id = jadwal.guru_id')
            ->join('mapel', 'mapel.id = jadwal.mapel_id', 'left')
            ->join('kelas', 'kelas.id = jadwal.kelas_id', 'left')
            ->findAll();
    }
}
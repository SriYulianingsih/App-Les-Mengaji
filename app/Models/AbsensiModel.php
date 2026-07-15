<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'santri_id', 'jadwal_id', 'tanggal', 'status', 'keterangan'
    ];

    protected $useTimestamps = true;

    /**
     * Mengambil data absensi lengkap dengan nama santri, 
     * hari, nama mapel, dan nama kelas.
     */
    public function getFull()
    {
        return $this->select('absensi.*, santri.nama as nama_santri, jadwal.hari, mapel.nama_mapel, kelas.nama_kelas')
            ->join('santri', 'santri.id = absensi.santri_id')
            ->join('jadwal', 'jadwal.id = absensi.jadwal_id')
            ->join('mapel', 'mapel.id = jadwal.mapel_id', 'left') // Ambil nama materi
            ->join('kelas', 'kelas.id = jadwal.kelas_id', 'left') // Ambil nama kelas
            ->findAll();
    }

public function getHistoryBySantri($santri_id)
{
    return $this->select('
            absensi.*, 
            jadwal.hari, 
            mapel.nama_mapel, 
            presensi_materi.materi_mulai, 
            presensi_materi.materi_selesai, 
            presensi_materi.catatan_guru
        ')
        ->join('jadwal', 'jadwal.id = absensi.jadwal_id')
        ->join('mapel', 'mapel.id = jadwal.mapel_id', 'left')
        ->join('presensi_materi', 'presensi_materi.absensi_id = absensi.id', 'left')
        ->where('absensi.santri_id', $santri_id)
        ->orderBy('absensi.tanggal', 'DESC')
        ->findAll();
}
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table      = 'laporan';
    protected $primaryKey = 'id';

    // Pastikan semua kolom yang kita buat tadi terdaftar di sini
    protected $allowedFields = [
        'user_id', 
        'kategori_id', 
        'jadwal_id', 
        'absensi_id', 
        'tipe_laporan', 
        'periode_bulan', 
        'periode_tahun', 
        'tanggal_cetak', 
        'keterangan', 
        'file_pdf'
    ];

    protected $useTimestamps = true;

    /**
     * getFull()
     * Mengambil semua riwayat laporan dengan join ke tabel terkait.
     * Menggunakan LEFT JOIN agar data laporan tetap muncul meskipun salah satu relasi kosong.
     */
    public function getFull()
{
    return $this->select('
            laporan.*, 
            users.username as nama_admin, 
            kategori_pembayaran.nama_kategori, 
            mapel.nama_mapel, 
            kelas.nama_kelas,
            santri.nama -- GANTI DI SINI (Hapus _santri)
        ')
        ->join('users', 'users.id = laporan.user_id')
        ->join('kategori_pembayaran', 'kategori_pembayaran.id = laporan.kategori_id', 'left')
        ->join('jadwal', 'jadwal.id = laporan.jadwal_id', 'left')
        ->join('mapel', 'mapel.id = jadwal.mapel_id', 'left')
        ->join('kelas', 'kelas.id = jadwal.kelas_id', 'left')
        ->join('absensi', 'absensi.id = laporan.absensi_id', 'left')
        ->join('santri', 'santri.id = absensi.santri_id', 'left') 
        ->orderBy('laporan.created_at', 'DESC')
        ->findAll();
}
}
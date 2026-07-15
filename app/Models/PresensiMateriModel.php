<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiMateriModel extends Model
{
    protected $table            = 'presensi_materi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true; // Karena tadi ada created_at & updated_at
    protected $allowedFields    = [
        'absensi_id', 
        'materi_mulai', 
        'materi_selesai', 
        'catatan_guru'
    ];

    /**
     * Fungsi buat ambil detail progres ngaji per santri
     */
    public function getProgresSantri($absensi_id)
    {
        return $this->select('presensi_materi.*, absensi.tanggal, santri.nama as nama_santri, mapel.nama_mapel')
                    ->join('absensi', 'absensi.id = presensi_materi.absensi_id')
                    ->join('santri', 'santri.id = absensi.santri_id')
                    ->join('jadwal', 'jadwal.id = absensi.jadwal_id')
                    ->join('mapel', 'mapel.id = jadwal.mapel_id', 'left')
                    ->where('presensi_materi.absensi_id', $absensi_id)
                    ->first();
    }

    /**
 * Ambil progres terakhir santri (untuk Dashboard)
 */
public function getLastProgress($santri_id)
{
    return $this->select('presensi_materi.*, mapel.nama_mapel, absensi.tanggal')
        ->join('absensi', 'absensi.id = presensi_materi.absensi_id')
        ->join('jadwal', 'jadwal.id = absensi.jadwal_id')
        ->join('mapel', 'mapel.id = jadwal.mapel_id', 'left')
        ->where('absensi.santri_id', $santri_id)
        ->orderBy('absensi.tanggal', 'DESC')
        ->first();
}
}
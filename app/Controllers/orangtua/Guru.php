<?php

namespace App\Controllers\Orangtua;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\JadwalModel;
use App\Models\SantriModel; // Asumsi abang punya model Santri untuk cek kelas_id

class Guru extends BaseController
{
    public function index()
    {
        $santriId = session()->get('active_santri_id');
        
        if (!$santriId) {
            return redirect()->to('orangtua/dashboard')->with('error', 'Silahkan pilih anak terlebih dahulu.');
        }

        $db = \Config\Database::connect();
        
        // Ambil guru yang mengajar di kelas santri tersebut melalui tabel jadwal
        // Kita join: Guru -> Jadwal -> Santri (berdasarkan kelas_id)
        $data['guru'] = $db->table('guru')
            ->select('guru.*, mapel.nama_mapel, kelas.nama_kelas')
            ->join('jadwal', 'jadwal.guru_id = guru.id')
            ->join('kelas', 'kelas.id = jadwal.kelas_id')
            ->join('mapel', 'mapel.id = jadwal.mapel_id', 'left')
            ->join('santri', 'santri.kelas_id = kelas.id')
            ->where('santri.id', $santriId)
            ->where('guru.status', 'aktif')
            ->groupBy('guru.id') // Agar guru yang sama tidak muncul double jika mengajar 2 mapel
            ->get()->getResultArray();

        return view('orangtua/guru/index', $data);
    }
}
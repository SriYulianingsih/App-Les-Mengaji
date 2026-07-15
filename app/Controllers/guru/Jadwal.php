<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\AbsensiModel; // Tambahkan ini

class Jadwal extends BaseController
{
    protected $jadwalModel;
    protected $absensiModel;

    public function __construct() {
        $this->jadwalModel = new JadwalModel();
        $this->absensiModel = new AbsensiModel(); // Inisialisasi
    }

    public function index()
    {
        $idGuru = session()->get('id_guru'); 

        if (!$idGuru) {
            return redirect()->to('/login')->with('error', 'Sesi guru tidak ditemukan.');
        }

        // Ambil hari ini dalam bahasa Indonesia untuk validasi
        $hariIni = $this->getHariIndo(date('l'));
        $tanggalHariIni = date('Y-m-d');
        $jamSekarang = date('H:i:s');

        // Ambil semua jadwal guru
        $jadwal = $this->jadwalModel->select('jadwal.*, kelas.nama_kelas, mapel.nama_mapel')
            ->join('kelas', 'kelas.id = jadwal.kelas_id', 'left')
            ->join('mapel', 'mapel.id = jadwal.mapel_id', 'left')
            ->where('jadwal.guru_id', $idGuru)
            ->orderBy("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_mulai', 'ASC')
            ->findAll();

        // Loop untuk menentukan status absensi setiap jadwal
        foreach ($jadwal as &$j) {
            // 1. Cek apakah sudah absen hari ini
            $sudahAbsen = $this->absensiModel->where([
                'jadwal_id' => $j['id'],
                'tanggal'   => $tanggalHariIni
            ])->first();

            $j['is_done'] = $sudahAbsen ? true : false;

            // 2. Cek apakah jadwalnya hari ini atau bukan
            $j['is_today'] = ($j['hari'] == $hariIni);

            // 3. Logic tambahan: Cek jam operasional (Opsional)
            // Biar guru tahu mana yang lagi berlangsung sekarang
            $j['is_now'] = ($j['is_today'] && $jamSekarang >= $j['jam_mulai'] && $jamSekarang <= $j['jam_selesai']);
        }

        $data = [
            'title'   => 'Jadwal Mengajar Saya',
            'jadwal'  => $jadwal,
            'tanggal' => $tanggalHariIni,
            'hariIni' => $hariIni
        ];

        return view('guru/jadwal/index', $data);
    }

    /**
     * Helper untuk translate hari ke Indonesia
     */
    private function getHariIndo($day) {
        $days = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        return $days[$day] ?? $day;
    }
}
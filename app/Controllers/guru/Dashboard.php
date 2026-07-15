<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\SantriModel;
use App\Models\AbsensiModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $id_guru = session()->get('id_guru');
        
        if (!$id_guru) {
            return redirect()->to('/login')->with('error', 'Sesi tidak ditemukan.');
        }

        $jadwalModel  = new JadwalModel();
        $santriModel  = new SantriModel();
        $absensiModel = new AbsensiModel();

        // Helper hari Indonesia
        $hari_list = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $hari_ini = $hari_list[date('l')];
        $tanggal_sekarang = date('Y-m-d');

        // 1. Ambil Jadwal Hari Ini dengan Join Kelas & Mapel
        $jadwal_hari_ini = $jadwalModel->select('jadwal.*, kelas.nama_kelas, mapel.nama_mapel')
                                        ->join('kelas', 'kelas.id = jadwal.kelas_id')
                                        ->join('mapel', 'mapel.id = jadwal.mapel_id', 'left')
                                        ->where('jadwal.guru_id', $id_guru)
                                        ->where('jadwal.hari', $hari_ini)
                                        ->orderBy('jadwal.jam_mulai', 'ASC')
                                        ->findAll();

        // 2. Tambahkan status "is_done" untuk tiap jadwal hari ini
        foreach ($jadwal_hari_ini as &$j) {
            $cek = $absensiModel->where([
                'jadwal_id' => $j['id'], 
                'tanggal'   => $tanggal_sekarang
            ])->first();
            
            $j['is_done'] = $cek ? true : false;
        }

        // 3. Ambil Daftar ID Kelas yang diajar guru (untuk hitung total santri)
        $daftar_kelas = $jadwalModel->where('guru_id', $id_guru)
                                    ->distinct()
                                    ->findColumn('kelas_id') ?: [0]; 

        // 4. Hitung Total Santri yang berada di bawah bimbingan guru ini
        $total_santri = $santriModel->whereIn('kelas_id', $daftar_kelas)->countAllResults();

        // 5. Hitung total absensi masuk hari ini (untuk progress bar/stats)
        $all_jadwal_ids = $jadwalModel->where('guru_id', $id_guru)->findColumn('id') ?: [0];
        $absensi_today  = $absensiModel->whereIn('jadwal_id', $all_jadwal_ids)
                                       ->where('tanggal', $tanggal_sekarang)
                                       ->countAllResults();

        $data = [
            'title'          => 'Dashboard Pengajar',
            'hari_ini'       => $hari_ini,
            'total_santri'   => $total_santri,
            'total_jadwal'   => count($jadwal_hari_ini),
            'absensi_count'  => $absensi_today,
            'jadwal_list'    => $jadwal_hari_ini,
            'tanggal_indo'   => date('d M Y')
        ];

        return view('guru/dashboard', $data);
    }

    /**
     * Pencarian santri via AJAX untuk fitur Quick Search di Dashboard
     */
    public function searchAjax()
    {
        $request = \Config\Services::request();
        $keyword = $request->getGet('q');
        
        if (empty($keyword) || strlen($keyword) < 2) {
            return $this->response->setJSON([]);
        }

        $db = \Config\Database::connect();
        
        $santri = $db->table('santri')
                     ->select('santri.id, santri.nama, santri.nis, kelas.nama_kelas')
                     ->join('kelas', 'kelas.id = santri.kelas_id', 'left')
                     ->like('santri.nama', $keyword)
                     ->orLike('santri.nis', $keyword)
                     ->limit(10)
                     ->get()
                     ->getResultArray();

        $hasil = [];
        foreach ($santri as $s) {
            $hasil[] = [
                'id'    => $s['id'],
                'nama'  => $s['nama'],
                'nis'   => $s['nis'] ?? '-',
                'kelas' => $s['nama_kelas'] ?? 'Tanpa Kelas',
                'tipe'  => 'santri'
            ];
        }

        return $this->response->setJSON($hasil);
    }
}
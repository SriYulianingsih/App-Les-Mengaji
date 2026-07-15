<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\JadwalModel;

class Santri extends BaseController
{
    protected $santriModel;
    protected $jadwalModel;

    public function __construct() {
        $this->santriModel = new SantriModel();
        $this->jadwalModel = new JadwalModel();
    }

    public function index()
    {
        $idGuru = session()->get('id_guru');
        
        // 1. Ambil daftar kelas_id yang diajar guru ini (unik)
        // Kita ganti 'kelas' menjadi 'kelas_id' agar sesuai database
        $kelasAjar = $this->jadwalModel->where('guru_id', $idGuru)
                                      ->distinct()
                                      ->select('kelas_id') 
                                      ->findAll();
        
        // Mengambil array kumpulan ID kelas saja
        $listKelasId = array_column($kelasAjar, 'kelas_id');

        // 2. Ambil data santri binaan
        if (!empty($listKelasId)) {
            // Kita gunakan join dari model agar data orang tua dan nama_kelas terbawa
            $santri = $this->santriModel->select('santri.*, kelas.nama_kelas, orangtua.no_hp')
                                        ->join('kelas', 'kelas.id = santri.kelas_id')
                                        ->join('orangtua', 'orangtua.id = santri.orangtua_id', 'left')
                                        ->whereIn('santri.kelas_id', $listKelasId)
                                        ->orderBy('santri.nama', 'ASC')
                                        ->findAll();
        } else {
            $santri = [];
        }

        $data = [
            'title'  => 'Data Santri Binaan',
            'santri' => $santri
        ];

        return view('guru/santri/index', $data);
    }

    public function detail($id)
    {
        // Menggunakan method getFullById yang sudah abang buat di model
        $santri = $this->santriModel->getFullById($id);

        if (!$santri) {
            return redirect()->to('/guru/santri')->with('error', 'Afwan, data santri tidak ditemukan.');
        }

        $data = [
            'title'  => 'Profil Santri: ' . $santri['nama'],
            'santri' => $santri
        ];

        return view('guru/santri/detail', $data);
    }
}
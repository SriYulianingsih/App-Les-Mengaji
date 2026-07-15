<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\JadwalModel;
use App\Models\SantriModel;
use App\Models\PresensiMateriModel;

class Absensi extends BaseController
{
    protected $absensiModel;
    protected $jadwalModel;
    protected $santriModel;
    protected $materiModel;

    public function __construct() {
        $this->absensiModel = new AbsensiModel();
        $this->jadwalModel  = new JadwalModel();
        $this->santriModel  = new SantriModel();
        $this->materiModel  = new PresensiMateriModel();
        helper(['form', 'url']);
    }

    public function cekJadwal()
    {
        $idGuru = session()->get('id_guru');
        $hari_ini = $this->getHariIndo(date('l'));
        $tanggal_sekarang = date('Y-m-d');

        $jadwal = $this->jadwalModel->select('jadwal.*, kelas.nama_kelas, mapel.nama_mapel')
                                    ->join('kelas', 'kelas.id = jadwal.kelas_id')
                                    ->join('mapel', 'mapel.id = jadwal.mapel_id', 'left')
                                    ->where(['guru_id' => $idGuru, 'hari' => $hari_ini])
                                    ->findAll();

        foreach ($jadwal as &$j) {
            $j['is_done'] = $this->absensiModel->where(['jadwal_id' => $j['id'], 'tanggal' => $tanggal_sekarang])->first() ? true : false;
        }

        if (!$jadwal) {
            return redirect()->to('/guru/dashboard')->with('error_popup', 'Afwan, jadwal mengajar Anda tidak ditemukan untuk hari ' . $hari_ini);
        }

        $data = [
            'title'  => 'Pilih Jadwal Absensi',
            'jadwal' => $jadwal,
            'hari'   => $hari_ini
        ];

        return view('guru/absensi/cekJadwal', $data);
    }

    public function input($param)
    {
        $idGuru = session()->get('id_guru');
        $hari_realtime = $this->getHariIndo(date('l'));

        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $param)) {
            $tanggal = $param;
            $cekAbsen = $this->absensiModel->select('jadwal_id')
                                           ->join('jadwal', 'jadwal.id = absensi.jadwal_id')
                                           ->where(['absensi.tanggal' => $tanggal, 'jadwal.guru_id' => $idGuru])
                                           ->first();

            if (!$cekAbsen) {
                return redirect()->to('/guru/absensi/riwayat')->with('error_popup', 'Data riwayat tidak ditemukan!');
            }
            $idJadwal = $cekAbsen['jadwal_id'];
            $isEditMode = true; 
        } else {
            $idJadwal = $param;
            $tanggal  = date('Y-m-d');
            $isEditMode = false;
        }

        $jadwal = $this->jadwalModel->select('jadwal.*, kelas.nama_kelas, mapel.nama_mapel')
                                    ->join('kelas', 'kelas.id = jadwal.kelas_id')
                                    ->join('mapel', 'mapel.id = jadwal.mapel_id', 'left')
                                    ->where(['jadwal.id' => $idJadwal, 'jadwal.guru_id' => $idGuru])
                                    ->first();

        if (!$jadwal) {
            return redirect()->to('/guru/dashboard')->with('error_popup', 'Akses ditolak! Jadwal tidak valid.');
        }

        if (!$isEditMode) {
            if (trim(strtolower($jadwal['hari'])) !== trim(strtolower($hari_realtime))) {
                return redirect()->to('/guru/absensi/cekJadwal')->with('error_popup', 'Gagal! Hari ini ' . $hari_realtime . '. Jadwal Anda adalah hari ' . $jadwal['hari']);
            }
        }

        $santri = $this->santriModel->where('kelas_id', $jadwal['kelas_id'])
                                    ->orderBy('nama', 'ASC')
                                    ->findAll();

        $existing = $this->absensiModel->select('absensi.*, presensi_materi.materi_mulai, presensi_materi.materi_selesai, presensi_materi.catatan_guru')
                                       ->join('presensi_materi', 'presensi_materi.absensi_id = absensi.id', 'left')
                                       ->where(['jadwal_id' => $idJadwal, 'tanggal' => $tanggal])
                                       ->findAll();

        $existing_data = [];
        foreach ($existing as $ex) {
            $existing_data[$ex['santri_id']] = $ex;
        }

        $data = [
            'title'            => 'Presensi ' . $jadwal['nama_kelas'],
            'jadwal'           => $jadwal,
            'santri'           => $santri,
            'existing_absensi' => $existing_data,
            'tanggal'          => $tanggal,
            'hari_ini'         => $isEditMode ? $jadwal['hari'] : $hari_realtime,
            'is_edit'          => $isEditMode
        ];

        return view('guru/absensi/input', $data);
    }

    // ... (bagian atas sama)

    public function simpan()
    {
        $db = \Config\Database::connect();
        $jadwalId   = $this->request->getPost('jadwal_id');
        $tanggal    = $this->request->getPost('tanggal');
        
        $jadwal = $this->jadwalModel->find($jadwalId);
        $allSantri = $this->santriModel->where('kelas_id', $jadwal['kelas_id'])->findAll();

        $kehadiran      = $this->request->getPost('status') ?? []; 
        $materi_mulai   = $this->request->getPost('materi_mulai') ?? [];
        $materi_selesai = $this->request->getPost('materi_selesai') ?? [];
        $catatan_guru   = $this->request->getPost('catatan_guru') ?? [];
        $keterangan     = $this->request->getPost('keterangan') ?? [];

        $db->transStart();
        try {
            foreach ($allSantri as $s) {
                $santriId = $s['id'];
                
                // SINKRONISASI: Pakai 'Alpa' sesuai value di View Abang
                $status = $kehadiran[$santriId] ?? 'alpha'; 

                $existingAbsen = $this->absensiModel->where([
                    'santri_id' => $santriId,
                    'jadwal_id' => $jadwalId,
                    'tanggal'   => $tanggal
                ])->first();

                $dataAbsen = [
                    'santri_id'  => $santriId,
                    'jadwal_id'  => $jadwalId,
                    'tanggal'    => $tanggal,
                    'status'     => $status,
                    'keterangan' => $keterangan[$santriId] ?? ''
                ];

                if ($existingAbsen) {
                    $this->absensiModel->update($existingAbsen['id'], $dataAbsen);
                    $absensi_id = $existingAbsen['id'];
                } else {
                    $this->absensiModel->insert($dataAbsen);
                    $absensi_id = $this->absensiModel->getInsertID();
                }

                if (strtolower($status) == 'hadir') {
                    $dataMateri = [
                        'absensi_id'     => $absensi_id,
                        'materi_mulai'   => $materi_mulai[$santriId] ?? '',
                        'materi_selesai' => $materi_selesai[$santriId] ?? '',
                        'catatan_guru'   => $catatan_guru[$santriId] ?? ''
                    ];

                    $existingMateri = $this->materiModel->where('absensi_id', $absensi_id)->first();
                    if ($existingMateri) {
                        $this->materiModel->update($existingMateri['id'], $dataMateri);
                    } else {
                        $this->materiModel->insert($dataMateri);
                    }
                } else {
                    // Bersihkan data materi kalau statusnya bukan hadir
                    $this->materiModel->where('absensi_id', $absensi_id)->delete();
                }
            }
            
            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                return redirect()->back()->with('error_popup', 'Gagal menyimpan data ke database.');
            }

            return redirect()->to('/guru/absensi/riwayat')->with('success', 'Presensi & materi berhasil diperbarui.');
            
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error_popup', 'Error: ' . $e->getMessage());
        }
    }

// ... (sisanya sudah oke banget)

    public function riwayat()
    {
        $idGuru = session()->get('id_guru');
        $filterBulan = $this->request->getGet('bulan');
        $filterKelas = $this->request->getGet('kelas');

        $query = $this->absensiModel->select('
                absensi.tanggal, 
                absensi.jadwal_id, 
                kelas.nama_kelas, 
                mapel.nama_mapel,
                jadwal.hari, 
                COUNT(absensi.id) as total_santri
            ')
            ->join('jadwal', 'jadwal.id = absensi.jadwal_id')
            ->join('kelas', 'kelas.id = jadwal.kelas_id')
            ->join('mapel', 'mapel.id = jadwal.mapel_id', 'left')
            ->where('jadwal.guru_id', $idGuru);

        if (!empty($filterBulan)) {
            $query->where("DATE_FORMAT(absensi.tanggal, '%Y-%m') =", $filterBulan);
        }
        
        if (!empty($filterKelas)) {
            $query->where('jadwal.kelas_id', $filterKelas);
        }

        $riwayat = $query->groupBy('absensi.tanggal, absensi.jadwal_id, kelas.nama_kelas, mapel.nama_mapel, jadwal.hari')
                         ->orderBy('absensi.tanggal', 'DESC')
                         ->findAll();

        $listKelas = $this->jadwalModel->select('kelas.id, kelas.nama_kelas')
                                       ->join('kelas', 'kelas.id = jadwal.kelas_id')
                                       ->where('jadwal.guru_id', $idGuru)
                                       ->groupBy('kelas.id')
                                       ->findAll();

        $data = [
            'title'        => 'Riwayat Presensi',
            'riwayat'      => $riwayat,
            'listKelas'    => $listKelas,
            'filterBulan'  => $filterBulan,
            'filterKelas'  => $filterKelas
        ];

        return view('guru/absensi/riwayat', $data);
    }

    public function viewByDate($jadwalId, $tanggal)
{
    $idGuru = session()->get('id_guru');

    // Update query untuk tarik data Kelas, Mapel, dan Jam dari tabel Jadwal
    $absensi = $this->absensiModel->select('
            absensi.id as id_absensi,
            absensi.status,
            absensi.keterangan,
            absensi.tanggal,
            santri.nama, 
            santri.nis, 
            presensi_materi.materi_mulai, 
            presensi_materi.materi_selesai, 
            presensi_materi.catatan_guru,
            kelas.nama_kelas,
            mapel.nama_mapel,
            jadwal.jam_mulai
        ')
        ->join('santri', 'santri.id = absensi.santri_id')
        ->join('jadwal', 'jadwal.id = absensi.jadwal_id')
        ->join('kelas', 'kelas.id = jadwal.kelas_id') // Tambahkan join kelas
        ->join('mapel', 'mapel.id = jadwal.mapel_id', 'left') // Tambahkan join mapel
        ->join('presensi_materi', 'presensi_materi.absensi_id = absensi.id', 'left')
        ->where([
            'absensi.tanggal'   => $tanggal,
            'absensi.jadwal_id' => $jadwalId,
            'jadwal.guru_id'    => $idGuru
        ])
        ->orderBy('santri.nama', 'ASC')
        ->findAll();

    if (!$absensi) {
        return redirect()->to('/guru/absensi/riwayat')->with('error_popup', 'Data presensi tidak ditemukan.');
    }

    $data = [
        'title'     => 'Detail Presensi & Materi',
        'absensi'   => $absensi,
        'tanggal'   => $tanggal,
        'jadwal_id' => $jadwalId 
    ];

    return view('guru/absensi/view', $data);
}

    private function getHariIndo($day)
    {
        $map = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        return $map[$day] ?? $day;
    }
}
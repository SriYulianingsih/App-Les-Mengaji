<?php

namespace App\Controllers\Orangtua;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\AbsensiModel;
use App\Models\PembayaranModel;
use App\Models\PresensiMateriModel;

class Dashboard extends BaseController
{
    protected $santriModel;
    protected $absensiModel;
    protected $pembayaranModel;
    protected $materiModel;

    public function __construct()
    {
        $this->santriModel     = new SantriModel();
        $this->absensiModel    = new AbsensiModel();
        $this->pembayaranModel = new PembayaranModel();
        $this->materiModel     = new PresensiMateriModel();
    }

    public function index()
    {
        $active_santri_id = session()->get('active_santri_id');
        $id_orangtua      = session()->get('id_user_detail'); 

        // Ambil Detail Santri
        $data_santri = $this->santriModel->where([
            'id'          => $active_santri_id,
            'orangtua_id' => $id_orangtua
        ])->first();

        // Siapkan data default
        $data = [
            'title'      => 'Dashboard Wali Santri',
            'santri'     => $data_santri, 
            'hadir'      => 0,
            'total_guru' => 0,
            'tagihan'    => null,
            'progres'    => null
        ];

        if ($data_santri) {
            $db = \Config\Database::connect();

            // 1. Hitung Kehadiran 
            $data['hadir'] = $this->absensiModel
                                  ->where('santri_id', $active_santri_id)
                                  ->where('status', 'hadir') 
                                  ->countAllResults();

            // 2. Hitung Total Guru Pengajar (Berdasarkan Kelas Santri)
            $data['total_guru'] = $db->table('guru')
                                 ->select('guru.id')
                                 ->join('jadwal', 'jadwal.guru_id = guru.id')
                                 ->join('santri', 'santri.kelas_id = jadwal.kelas_id')
                                 ->where('santri.id', $active_santri_id)
                                 ->where('guru.status', 'aktif')
                                 ->groupBy('guru.id')
                                 ->get()
                                 ->getNumRows();

            // 3. Ambil Tagihan Terakhir
            $data['tagihan'] = $this->pembayaranModel
                                    ->where('santri_id', $active_santri_id)
                                    ->where('status', 'belum') 
                                    ->orderBy('tahun', 'DESC')
                                    ->orderBy('bulan', 'DESC')
                                    ->first();

            // 4. Ambil Progres Materi Terakhir
            $data['progres'] = $db->table('presensi_materi')
                                  ->select('presensi_materi.*, absensi.tanggal')
                                  ->join('absensi', 'absensi.id = presensi_materi.absensi_id')
                                  ->where('absensi.santri_id', $active_santri_id)
                                  ->orderBy('absensi.tanggal', 'DESC')
                                  ->get()
                                  ->getRow(); 
        }

        return view('orangtua/dashboard', $data);
    }

    public function switchAnak($id_santri)
    {
        $listAnak = session()->get('list_anak');
        if ($listAnak) {
            foreach ($listAnak as $anak) {
                if ((int)$anak['id_santri'] == (int)$id_santri) {
                    session()->set([
                        'active_santri_id'   => $anak['id_santri'],
                        'active_santri_nama' => $anak['nama_santri']
                    ]);
                    break;
                }
            }
        }
        return redirect()->to(base_url('orangtua/dashboard'))->with('success', 'Berhasil beralih ke data ' . session()->get('active_santri_nama'));
    }

    /**
     * AJAX Search untuk mencari Nama Santri (Anak) dan Nama Guru
     */
    public function searchAjax()
{
    $q = $this->request->getGet('q');
    $id_orangtua = session()->get('id_user_detail');
    $active_santri_id = session()->get('active_santri_id');

    if (!$q || strlen($q) < 2) return $this->response->setJSON([]);

    $db = \Config\Database::connect();
    $allResults = [];

    // 1. Cari di Data Santri (Anak dari Orang Tua ini)
    $santri = $this->santriModel
                    ->select('id, nama, "Anak Saya" as tipe')
                    ->where('orangtua_id', $id_orangtua)
                    ->like('nama', $q)
                    ->limit(3)
                    ->findAll();
    
    foreach($santri as $s) {
        $allResults[] = [
            'id'   => $s['id'],
            'nama' => $s['nama'],
            'tipe' => $s['tipe'],
            // Langsung arahkan ke menu utama Santri
            'url'  => base_url('orangtua/santri')
        ];
    }

    // 2. Cari di Data Guru (Yang mengajar santri aktif)
    $guru = $db->table('guru')
               ->select('guru.id, guru.nama, "Guru Privat" as tipe')
               ->join('jadwal', 'jadwal.guru_id = guru.id')
               ->join('santri', 'santri.kelas_id = jadwal.kelas_id')
               ->where('santri.id', $active_santri_id)
               ->like('guru.nama', $q)
               ->groupBy('guru.id')
               ->limit(3)
               ->get()
               ->getResultArray();

    foreach($guru as $g) {
        $allResults[] = [
            'id'   => $g['id'],
            'nama' => $g['nama'],
            'tipe' => $g['tipe'],
            // Langsung arahkan ke menu utama Guru
            'url'  => base_url('orangtua/guru') 
        ];
    }

    return $this->response->setJSON($allResults);
}
}
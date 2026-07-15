<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\PresensiMateriModel;

class AbsensiController extends BaseController
{
    protected $absensiModel;
    protected $presensiMateriModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->presensiMateriModel = new PresensiMateriModel();
    }

    public function index()
    {
        // Ambil filter dari request
        $tanggal = $this->request->getGet('tanggal') ?: date('Y-m-d');
        $kelas = $this->request->getGet('kelas');

        // Query Utama dengan Relasi Baru
        $query = $this->absensiModel->select('
                absensi.*, 
                santri.nama as nama_santri, 
                kelas.nama_kelas, 
                mapel.nama_mapel,
                presensi_materi.materi_mulai,
                presensi_materi.materi_selesai,
                presensi_materi.catatan_guru
            ')
            ->join('santri', 'santri.id = absensi.santri_id')
            ->join('jadwal', 'jadwal.id = absensi.jadwal_id')
            ->join('kelas', 'kelas.id = jadwal.kelas_id', 'left') // Mengambil nama kelas dari tabel kelas
            ->join('mapel', 'mapel.id = jadwal.mapel_id', 'left') // Mengambil nama mapel
            ->join('presensi_materi', 'presensi_materi.absensi_id = absensi.id', 'left') // Data progres ngaji
            ->where('absensi.tanggal', $tanggal);

        if (!empty($kelas)) {
            $query->where('jadwal.kelas_id', $kelas);
        }

        $dataAbsensi = $query->findAll();

        // List kelas buat dropdown filter (Ambil dari tabel kelas biar konsisten)
        $db = \Config\Database::connect();
        $listKelas = $db->table('kelas')->select('id, nama_kelas')->get()->getResultArray();

        $data = [
            'title'      => 'Rekap Presensi & Progres',
            'absensi'    => $dataAbsensi,
            'filter_tgl' => $tanggal,
            'filter_kls' => $kelas,
            'list_kelas' => $listKelas
        ];

        return view('admin/absensi/index', $data);
    }
}
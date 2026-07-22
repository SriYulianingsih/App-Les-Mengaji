<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LaporanModel;

class LaporanController extends BaseController
{
    protected $laporanModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
    }

    // 1. TAMPILAN UTAMA
    public function index()
    {
        $db = \Config\Database::connect();

        $totalSantri = $db->table('santri')->countAllResults();
        $totalKasMasuk = $db->table('pembayaran')
                            ->where('status', 'Lunas')
                            ->selectSum('jumlah_bayar')
                            ->get()->getRow()->jumlah_bayar ?? 0;

        $absensiHariIni = $db->table('absensi')
                             ->where('tanggal', date('Y-m-d'))
                             ->countAllResults();

        $dataKategori = $db->table('kategori_pembayaran')->get()->getResultArray();
        $dataJadwal   = $db->table('jadwal')
                           ->select('jadwal.id, mapel.nama_mapel, kelas.nama_kelas')
                           ->join('mapel', 'mapel.id = jadwal.mapel_id')
                           ->join('kelas', 'kelas.id = jadwal.kelas_id')
                           ->get()->getResultArray();

        $bulan_list = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $data = [
            'title'         => 'Laporan & Rekapitulasi',
            'ringkasan'     => [
                'total_santri'     => $totalSantri,
                'total_kas'        => $totalKasMasuk,
                'absensi_hari_ini' => $absensiHariIni
            ],
            'kategori_list' => $dataKategori,
            'jadwal_list'   => $dataJadwal,
            'bulan_list'    => $bulan_list
        ];

        return view('admin/laporan/index', $data);
    }

    // 2. PROSES GENERATE (Ditambahkan Cek Data)
    public function generate()
    {
        $db = \Config\Database::connect();
        $tipe = $this->request->getPost('tipe_laporan'); 
        $bulan = $this->request->getPost('periode_bulan');
        $tahun = $this->request->getPost('periode_tahun');
        
        $rules = [
            'tipe_laporan'  => 'required',
            'periode_bulan' => 'required',
            'periode_tahun' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // --- VALIDASI: Cek dulu datanya ada gak di DB sebelum dicatat ---
        if ($tipe === 'pembayaran') {
            $check = $db->table('pembayaran')
                        ->where('bulan', (int)$bulan)
                        ->where('tahun', (int)$tahun)
                        ->countAllResults();
        } else {
            $check = $db->table('absensi')
                        ->where('MONTH(tanggal)', (int)$bulan)
                        ->where('YEAR(tanggal)', (int)$tahun)
                        ->countAllResults();
        }

        if ($check === 0) {
            return redirect()->back()->withInput()->with('error', "Gagal! Data untuk periode " . $this->getNamaBulan($bulan) . " $tahun tidak ditemukan di database.");
        }

        $data = [
            'user_id'       => session()->get('id') ?: 1, 
            'tipe_laporan'  => $tipe,
            'periode_bulan' => $bulan,
            'periode_tahun' => $tahun,
            'tanggal_cetak' => date('Y-m-d'),
            'keterangan'    => $this->request->getPost('keterangan') ?: 'Laporan digenerate otomatis.',
        ];

        if ($tipe === 'pembayaran') {
            $data['kategori_id'] = $this->request->getPost('kategori_id') ?: null;
            $data['jadwal_id']   = null;
        } else {
            $data['jadwal_id']   = $this->request->getPost('jadwal_id') ?: null;
            $data['kategori_id'] = null;
        }

        $this->laporanModel->save($data);
        $laporanId = $this->laporanModel->getInsertID();

        // Jika permintaan via AJAX, kembalikan JSON agar frontend bisa mengunduh PDF tanpa pindah tab
        $filename = "Laporan_" . ucfirst($tipe) . "_" . str_replace(' ', '_', $this->getNamaBulan($bulan)) . "_" . $tahun . ".pdf";
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'id' => $laporanId, 'filename' => $filename]);
        }

        return redirect()->to('/admin/laporan/cetakPdf/' . $laporanId);
    }

    // AJAX: Periksa apakah data untuk periode yang dipilih ada di DB
    public function check()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['exists' => false, 'message' => 'Invalid request']);
        }

        $db = \Config\Database::connect();
        $tipe = $this->request->getPost('tipe_laporan');
        $bulan = (int)$this->request->getPost('periode_bulan');
        $tahun = (int)$this->request->getPost('periode_tahun');

        if (empty($tipe) || empty($bulan) || empty($tahun)) {
            return $this->response->setJSON(['exists' => false, 'message' => 'Periode tidak lengkap']);
        }

        if ($tipe === 'pembayaran') {
            $query = $db->table('pembayaran')
                        ->where('bulan', $bulan)
                        ->where('tahun', $tahun);

            $kategori = $this->request->getPost('kategori_id');
            if (!empty($kategori)) {
                $query->where('kategori_id', $kategori);
            }

            $count = $query->countAllResults();
        } else {
            $query = $db->table('absensi')
                        ->where('MONTH(tanggal)', $bulan)
                        ->where('YEAR(tanggal)', $tahun);

            $jadwal = $this->request->getPost('jadwal_id');
            if (!empty($jadwal)) {
                $query->where('jadwal_id', $jadwal);
            }

            $count = $query->countAllResults();
        }

        return $this->response->setJSON(['exists' => ($count > 0), 'count' => $count]);
    }

    // 3. FUNGSI CETAK PDF (FIKSED QUERY)
    public function cetakPdf($id)
    {
        $laporan = $this->laporanModel->find($id);
        if (!$laporan) return redirect()->back()->with('error', 'Data tidak ditemukan!');

        $db = \Config\Database::connect();
        $tipe = (string)$laporan['tipe_laporan'];
        
        $data['laporan'] = $laporan;
        $data['nama_bulan'] = $this->getNamaBulan($laporan['periode_bulan']);
        
        if ($tipe === 'pembayaran') {
            // FIX: Gunakan (int)periode_bulan, bukan nama teks bulan
            $builder = $db->table('pembayaran')
                          ->select('pembayaran.*, santri.nama as nama_santri, kategori_pembayaran.nama_kategori') 
                          ->join('santri', 'santri.id = pembayaran.santri_id')
                          ->join('kategori_pembayaran', 'kategori_pembayaran.id = pembayaran.kategori_id', 'left')
                          ->where('pembayaran.bulan', (int)$laporan['periode_bulan']) // Pakai angka
                          ->where('pembayaran.tahun', (int)$laporan['periode_tahun']);
            
            if (!empty($laporan['kategori_id'])) {
                $builder->where('pembayaran.kategori_id', $laporan['kategori_id']);
            }
            
            $data['detail'] = $builder->get()->getResultArray();
        } else {
            $builder = $db->table('absensi')
                          ->select('absensi.*, santri.nama as nama_santri, mapel.nama_mapel, kelas.nama_kelas')
                          ->join('santri', 'santri.id = absensi.santri_id')
                          ->join('jadwal', 'jadwal.id = absensi.jadwal_id', 'left')
                          ->join('mapel', 'mapel.id = jadwal.mapel_id', 'left')
                          ->join('kelas', 'kelas.id = jadwal.kelas_id', 'left')
                          ->where('MONTH(absensi.tanggal)', (int)$laporan['periode_bulan'])
                          ->where('YEAR(absensi.tanggal)', (int)$laporan['periode_tahun']);
            
            if (!empty($laporan['jadwal_id'])) {
                $builder->where('absensi.jadwal_id', $laporan['jadwal_id']);
            }

            $data['detail'] = $builder->get()->getResultArray();
        }

        if (empty($data['detail'])) {
            return redirect()->back()->with('error', 'Data periode ' . $data['nama_bulan'] . ' ' . $laporan['periode_tahun'] . ' kosong.');
        }

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');
        
        $dompdf = new \Dompdf\Dompdf($options);
        $html = view('admin/laporan/cetak_pdf', $data);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = "Laporan_" . ucfirst($tipe) . "_" . str_replace(' ', '_', $data['nama_bulan']) . "_" . $laporan['periode_tahun'] . ".pdf";
        return $dompdf->stream($filename, ["Attachment" => true]); 
    }

    private function getNamaBulan($angka) {
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $bulan[(int)$angka] ?? '';
    }

    public function delete($id)
    {
        if ($this->laporanModel->find($id)) {
            $this->laporanModel->delete($id);
            return redirect()->to('/admin/laporan')->with('success', 'Riwayat berhasil dihapus!');
        }
        return redirect()->to('/admin/laporan')->with('error', 'Data tidak ditemukan!');
    }
}
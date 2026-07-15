<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PembayaranModel;
use App\Models\KategoriPembayaranModel;
use App\Models\SantriModel;

class PembayaranController extends BaseController
{
    protected $pembayaranModel;
    protected $kategoriModel;
    protected $santriModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->kategoriModel = new KategoriPembayaranModel();
        $this->santriModel = new SantriModel();
    }

    public function index()
    {
        $data = [
            'title'      => 'Daftar Pembayaran Santri',
            'pembayaran' => $this->pembayaranModel->getFull(),
            'kategori'   => $this->kategoriModel->findAll(),
            // Tambahkan list santri untuk modal/form filter jika butuh
            'santri'     => $this->santriModel->where('status', 'aktif')->findAll()
        ];

        return view('admin/pembayaran/index', $data);
    }

    /**
     * TRIGGER MASAL: Generate Tagihan SPP Bulanan untuk semua santri aktif
     */
    public function generateTagihan()
{
    // 1. Tangkap input dari modal
    $bulan       = $this->request->getPost('bulan');
    $tahun       = $this->request->getPost('tahun');
    $kategori_id = $this->request->getPost('kategori_id');

    // 2. Validasi input
    if (!$bulan || !$tahun || !$kategori_id) {
        return redirect()->back()->with('error', 'Data tidak lengkap. Pilih Bulan, Tahun, dan Kategori!');
    }

    // 3. Ambil data kategori untuk nominal dan nama (buat pesan sukses nanti)
    $kategori = $this->kategoriModel->find($kategori_id);
    if (!$kategori) {
        return redirect()->back()->with('error', 'Kategori tidak ditemukan!');
    }
    $nominal = $kategori['nominal_std'];
    $namaKategori = $kategori['nama_kategori'];

    // 4. Ambil semua santri yang statusnya 'aktif'
    $listSantri = $this->santriModel->where('status', 'aktif')->findAll();
    
    $countGenerated = 0;
    $countSkipped = 0;

    foreach ($listSantri as $santri) {
        // 5. VALIDASI DOUBLE: Cek apakah tagihan santri ini dengan KATEGORI ini di periode ini sudah ada?
        $exists = $this->pembayaranModel->where([
            'santri_id'   => $santri['id'],
            'kategori_id' => $kategori_id, // Tambahkan ini agar validasi per kategori
            'bulan'       => $bulan,
            'tahun'       => $tahun
        ])->first();

        if (!$exists) {
            // 6. Insert data tagihan baru jika belum ada
            $this->pembayaranModel->insert([
                'santri_id'         => $santri['id'],
                'kategori_id'       => $kategori_id,
                'bulan'             => $bulan,
                'tahun'             => $tahun,
                'jumlah_bayar'      => $nominal,
                'status'            => 'belum',
                'metode_pembayaran' => '-', 
                'bukti_pembayaran'  => null,
                'tanggal_bayar'     => null,
                'keterangan'        => 'Tagihan otomatis sistem: ' . $namaKategori
            ]);
            $countGenerated++;
        } else {
            // Jika sudah ada, kita skip
            $countSkipped++;
        }
    }

    // 7. Selesai, berikan feedback yang lebih detail
    if ($countGenerated > 0) {
        return redirect()->to('/admin/pembayaran')->with('success', "$countGenerated tagihan $namaKategori berhasil dibuat. ($countSkipped santri dilewati karena sudah ada tagihan/lunas).");
    } else {
        return redirect()->to('/admin/pembayaran')->with('error', "Gagal generate! Semua santri aktif sudah memiliki tagihan $namaKategori untuk periode ini.");
    }
}

    public function create()
    {
        $data = [
            'title'    => 'Tambah Pembayaran Manual',
            'santri'   => $this->santriModel->where('status', 'aktif')->orderBy('nama', 'ASC')->findAll(),
            'kategori' => $this->kategoriModel->findAll(),
            'bulan'    => [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ]
        ];

        return view('admin/pembayaran/create', $data);
    }

    public function store()
    {
        // 1. Bersihkan nominal Rp
        $rawJumlah = $this->request->getPost('jumlah_bayar');
        $bersihJumlah = preg_replace('/[^0-9]/', '', $rawJumlah);

        // 2. Validasi
        if (!$this->validate([
            'santri_id'         => 'required',
            'kategori_id'       => 'required',
            'bulan'             => 'required',
            'tahun'             => 'required',
            'status'            => 'required',
            'metode_pembayaran' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 3. Simpan data
        // Jika status LUNAS tapi tanggal bayar kosong, otomatis isi hari ini
        $tanggalBayar = $this->request->getPost('tanggal_bayar');
        if ($this->request->getPost('status') == 'lunas' && empty($tanggalBayar)) {
            $tanggalBayar = date('Y-m-d');
        }

        $this->pembayaranModel->save([
            'santri_id'         => $this->request->getPost('santri_id'),
            'kategori_id'       => $this->request->getPost('kategori_id'),
            'bulan'             => $this->request->getPost('bulan'),
            'tahun'             => $this->request->getPost('tahun'),
            'jumlah_bayar'      => $bersihJumlah,
            'status'            => $this->request->getPost('status'),
            'metode_pembayaran' => $this->request->getPost('metode_pembayaran'),
            'keterangan'        => $this->request->getPost('keterangan'),
            'tanggal_bayar'     => $tanggalBayar,
        ]);

        return redirect()->to('/admin/pembayaran')->with('success', 'Pembayaran berhasil dicatat!');
    }

    // --- TAMBAHKAN KODE INI DI DALAM CONTROLLER BANG ---

    public function edit($id)
    {
        $pembayaran = $this->pembayaranModel->find($id);
        
        if (!$pembayaran) {
            return redirect()->to('/admin/pembayaran')->with('error', 'Data tidak ditemukan!');
        }

        $data = [
            'title'      => 'Edit Pembayaran',
            'pembayaran' => $pembayaran,
            'santri'     => $this->santriModel->findAll(),
            'kategori'   => $this->kategoriModel->findAll(),
            'bulan'      => [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ]
        ];

        return view('admin/pembayaran/edit', $data);
    }

    public function update($id)
    {
        // 1. Bersihkan nominal Rp
        $rawJumlah = $this->request->getPost('jumlah_bayar');
        $bersihJumlah = preg_replace('/[^0-9]/', '', $rawJumlah);

        // 2. Simpan update
        $this->pembayaranModel->update($id, [
            'santri_id'         => $this->request->getPost('santri_id'),
            'kategori_id'       => $this->request->getPost('kategori_id'),
            'bulan'             => $this->request->getPost('bulan'),
            'tahun'             => $this->request->getPost('tahun'),
            'jumlah_bayar'      => $bersihJumlah,
            'status'            => $this->request->getPost('status'),
            'metode_pembayaran' => $this->request->getPost('metode_pembayaran'),
            'keterangan'        => $this->request->getPost('keterangan'),
            'tanggal_bayar'     => $this->request->getPost('tanggal_bayar'),
        ]);

        return redirect()->to('/admin/pembayaran')->with('success', 'Data pembayaran berhasil diperbarui!');
    }

    // Fungsi Verifikasi (Konfirmasi pembayaran dari Ortu)
    public function verifikasi($id)
    {
        $pembayaran = $this->pembayaranModel->find($id);
        if (!$pembayaran) return redirect()->back()->with('error', 'Data tidak ditemukan');

        $this->pembayaranModel->update($id, [
            'status'            => 'lunas',
            'tanggal_bayar'     => date('Y-m-d'),
            'metode_pembayaran' => $pembayaran['metode_pembayaran'] ?? 'transfer', // default transfer kalau dari ortu
            'keterangan'        => ($pembayaran['keterangan'] ?? '') . ' (Diverifikasi Admin)'
        ]);

        return redirect()->to('/admin/pembayaran')->with('success', 'Pembayaran telah dikonfirmasi!');
    }

    public function delete($id)
    {
        $pembayaran = $this->pembayaranModel->find($id);
        if ($pembayaran && !empty($pembayaran['bukti_pembayaran'])) {
            $path = FCPATH . 'uploads/pembayaran/' . $pembayaran['bukti_pembayaran'];
            if (file_exists($path)) unlink($path);
        }
        $this->pembayaranModel->delete($id);
        return redirect()->to('/admin/pembayaran')->with('success', 'Data transaksi berhasil dihapus!');
    }

    // Fungsi pendukung untuk AJAX ambil nominal standar kategori
    public function getNominalKategori($id)
    {
        $kategori = $this->kategoriModel->find($id);
        return $this->response->setJSON($kategori);
    }
}
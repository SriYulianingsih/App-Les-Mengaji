<?php

namespace App\Controllers\Orangtua;

use App\Controllers\BaseController;
use App\Models\PembayaranModel;
use App\Models\KategoriPembayaranModel;
use App\Models\SantriModel;
use App\Models\OrangtuaModel;

class Pembayaran extends BaseController
{
    protected $pembayaranModel;
    protected $kategoriModel;
    protected $santriModel;
    protected $orangtuaModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
        $this->kategoriModel   = new KategoriPembayaranModel();
        $this->santriModel     = new SantriModel();
        $this->orangtuaModel   = new OrangtuaModel();
    }

    /**
     * Tampilan utama riwayat pembayaran
     */
    public function index()
    {
        $santriId = session()->get('active_santri_id');
        if (!$santriId) return redirect()->to('orangtua/dashboard');

        $santri = $this->santriModel->find($santriId);
        
        // Ambil histori dengan join kategori
        $histori = $this->pembayaranModel->select('pembayaran.*, kategori_pembayaran.nama_kategori')
            ->join('kategori_pembayaran', 'kategori_pembayaran.id = pembayaran.kategori_id', 'left')
            ->where('pembayaran.santri_id', $santriId)
            ->orderBy('pembayaran.tahun', 'DESC')
            ->orderBy('pembayaran.bulan', 'DESC')
            ->findAll();

        // Hitung total yang sudah lunas
        $totalLunas = $this->pembayaranModel->where(['santri_id' => $santriId, 'status' => 'lunas'])
            ->selectSum('jumlah_bayar')->get()->getRow()->jumlah_bayar ?? 0;

        $data = [
            'title'      => 'Pembayaran & Tagihan',
            'santri'     => $santri,
            'pembayaran' => $histori,
            'totalLunas' => $totalLunas,
            'listBulan'  => [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ]
        ];

        return view('orangtua/pembayaran/index', $data);
    }

    /**
     * Form bayar (Bisa untuk tagihan baru atau bayar tagihan yang sudah ada)
     */
    public function formBayar($id = null)
    {
        $santriId = session()->get('active_santri_id');
        if (!$santriId) return redirect()->to('orangtua/dashboard');

        $tagihan = $id ? $this->pembayaranModel->find($id) : null;
        
        $data = [
            'title'     => 'Konfirmasi Pembayaran',
            'santri'    => $this->santriModel->find($santriId),
            'kategori'  => $this->kategoriModel->findAll(),
            'tagihan'   => $tagihan,
            // Rekening statis (Bisa dipindah ke config/database jika mau dinamis)
            'rekening'  => [
                'nama_bank' => 'MANDIRI',
                'nomor_rekening' => '00123456789', 
                'atas_nama' => 'CAHAYA HIDAYAH QURANI'
            ]
        ];

        return view('orangtua/pembayaran/bayar', $data);
    }

    /**
     * Proses simpan konfirmasi pembayaran
     */
    public function simpan()
    {
        $jumlahRaw = str_replace('.', '', $this->request->getPost('jumlah_bayar'));
        $id = $this->request->getPost('id');

        // 1. Validasi input & File
        if (!$this->validate([
            'bukti_pembayaran' => 'uploaded[bukti_pembayaran]|max_size[bukti_pembayaran,2048]|is_image[bukti_pembayaran]',
            'kategori_id'      => 'required',
            'jumlah_bayar'     => 'required',
            'bulan'            => 'required',
            'tahun'            => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Cek kembali format foto (Max 2MB) dan kelengkapan form.');
        }

        // 2. Upload Bukti ke folder public/uploads/pembayaran
        $bukti = $this->request->getFile('bukti_pembayaran');
        $namaBukti = $bukti->getRandomName();
        
        if ($bukti->isValid() && !$bukti->hasMoved()) {
            $bukti->move('uploads/pembayaran', $namaBukti);
        }

        // 3. Siapkan Data (Kunci otomatis ke 'transfer' & 'lunas' sesuai ENUM)
        $dataSave = [
            'santri_id'         => session()->get('active_santri_id'),
            'kategori_id'       => $this->request->getPost('kategori_id'),
            'bulan'             => $this->request->getPost('bulan'),
            'tahun'             => $this->request->getPost('tahun'),
            'jumlah_bayar'      => $jumlahRaw,
            'metode_pembayaran' => 'transfer', // Kunci otomatis jalur transfer
            'status'            => 'lunas',    // Langsung lunas (Ubah 'pending' jika butuh cek admin)
            'tanggal_bayar'     => date('Y-m-d'),
            'bukti_pembayaran'  => $namaBukti,
            'keterangan'        => $this->request->getPost('keterangan')
        ];

        // Jika ini adalah update dari tagihan yang sudah ada
        if ($id) { 
            $dataSave['id'] = $id; 
        }

        try {
            $this->pembayaranModel->save($dataSave);
            return redirect()->to('/orangtua/pembayaran')->with('success', 'Konfirmasi pembayaran berhasil dikirim!');
        } catch (\Exception $e) {
            // Rollback: Hapus file jika gagal insert ke database
            if (file_exists('uploads/pembayaran/' . $namaBukti)) {
                unlink('uploads/pembayaran/' . $namaBukti);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem saat menyimpan data.');
        }
    }
}
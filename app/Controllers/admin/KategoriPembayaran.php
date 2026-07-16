<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriPembayaranModel;

class KategoriPembayaran extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriPembayaranModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kategori Pembayaran',
            'kategori' => $this->kategoriModel->findAll()
        ];
        return view('admin/kategori_pembayaran/index', $data);
    }

    public function create()
    {
        return view('admin/kategori_pembayaran/create', ['title' => 'Tambah Kategori']);
    }

    public function store()
    {
        $namaKategori = trim((string) $this->request->getPost('nama_kategori'));

        if ($this->kategoriExists($namaKategori)) {
            return redirect()->back()
                ->withInput()
                ->with('popup_alert', [
                    'icon' => 'warning',
                    'title' => 'Jenis biaya sudah ada',
                    'text' => 'Jenis biaya tools telah ada di database.',
                    'confirmButtonText' => 'OK',
                ]);
        }

        // Bersihkan titik dari nominal sebelum simpan (100.000 -> 100000)
        $nominalRaw = $this->request->getPost('nominal_std');
        $nominalClean = str_replace(['.', ','], '', $nominalRaw);

        $this->kategoriModel->save([
            'nama_kategori' => $namaKategori,
            'nominal_std'   => $nominalClean,
        ]);

        return redirect()->to('/admin/kategori-pembayaran')->with('success', 'Kategori pembayaran berhasil dibuat.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Kategori',
            'kategori' => $this->kategoriModel->find($id)
        ];
        return view('admin/kategori_pembayaran/edit', $data);
    }

    public function update($id)
    {
        $namaKategori = trim((string) $this->request->getPost('nama_kategori'));

        if ($this->kategoriExists($namaKategori, (int) $id)) {
            return redirect()->back()
                ->withInput()
                ->with('popup_alert', [
                    'icon' => 'warning',
                    'title' => 'Jenis biaya sudah ada',
                    'text' => 'Jenis biaya tools telah ada di database.',
                    'confirmButtonText' => 'OK',
                ]);
        }

        // Bersihkan titik dari nominal sebelum update
        $nominalRaw = $this->request->getPost('nominal_std');
        $nominalClean = str_replace(['.', ','], '', $nominalRaw);

        $this->kategoriModel->update($id, [
            'nama_kategori' => $namaKategori,
            'nominal_std'   => $nominalClean,
        ]);

        return redirect()->to('/admin/kategori-pembayaran')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->kategoriModel->delete($id);
        return redirect()->to('/admin/kategori-pembayaran')->with('success', 'Kategori berhasil dihapus.');
    }

    private function kategoriExists(string $namaKategori, ?int $ignoreId = null): bool
    {
        $builder = $this->kategoriModel->where('nama_kategori', $namaKategori);

        if ($ignoreId !== null) {
            $builder->where('id !=', $ignoreId);
        }

        return $builder->first() !== null;
    }
}
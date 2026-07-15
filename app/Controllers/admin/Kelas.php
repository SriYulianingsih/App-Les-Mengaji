<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\SantriModel;

class Kelas extends BaseController
{
    protected $kelasModel;
    protected $santriModel;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->santriModel = new SantriModel();
    }

    public function index()
    {
        // Ambil semua data kelas
        $dataKelas = $this->kelasModel->findAll();

        // Hitung total santri per kelas secara dinamis
        foreach ($dataKelas as &$k) {
            $k['total_santri'] = $this->santriModel->where('kelas_id', $k['id'])->countAllResults();
        }

        $data = [
            'title' => 'Manajemen Kelas',
            'kelas' => $dataKelas
        ];

        return view('admin/kelas/index', $data);
    }

    public function create()
    {
        return view('admin/kelas/create', ['title' => 'Tambah Kelas']);
    }

    public function store()
    {
        // Validasi sederhana agar data tidak kosong
        if (!$this->validate([
            'nama_kelas' => 'required',
            'tingkat'    => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $namaKelas = trim($this->request->getPost('nama_kelas'));
        $tingkat = trim($this->request->getPost('tingkat'));

        $duplikat = $this->kelasModel
            ->where('nama_kelas', $namaKelas)
            ->where('tingkat', $tingkat)
            ->first();

        if ($duplikat) {
            return redirect()->back()
                ->withInput()
                ->with('popup_error', 'Data kelas dengan nama dan jenjang yang sama sudah ada di database.');
        }

        $this->kelasModel->save([
            'nama_kelas' => $namaKelas,
            'tingkat'    => $tingkat,
        ]);

        return redirect()->to('/admin/kelas')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kelas = $this->kelasModel->find($id);

        if (!$kelas) {
            return redirect()->to('/admin/kelas')->with('errors', ['Data kelas tidak ditemukan.']);
        }

        $data = [
            'title' => 'Edit Kelas',
            'kelas' => $kelas
        ];
        return view('admin/kelas/edit', $data);
    }

    public function update($id)
    {
        // Validasi input
        if (!$this->validate([
            'nama_kelas' => 'required',
            'tingkat'    => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $namaKelas = trim($this->request->getPost('nama_kelas'));
        $tingkat = trim($this->request->getPost('tingkat'));

        $duplikat = $this->kelasModel
            ->where('nama_kelas', $namaKelas)
            ->where('tingkat', $tingkat)
            ->where('id !=', $id)
            ->first();

        if ($duplikat) {
            return redirect()->back()
                ->withInput()
                ->with('popup_error', 'Data kelas dengan nama dan jenjang yang sama sudah ada di database.');
        }

        $this->kelasModel->update($id, [
            'nama_kelas' => $namaKelas,
            'tingkat'    => $tingkat,
        ]);

        return redirect()->to('/admin/kelas')->with('success', 'Data kelas berhasil diupdate.');
    }

    public function delete($id)
    {
        // Cek apakah ada santri di kelas ini sebelum dihapus (opsional tapi aman)
        $cekSantri = $this->santriModel->where('kelas_id', $id)->countAllResults();
        
        if ($cekSantri > 0) {
            return redirect()->to('/admin/kelas')->with('errors', ['Kelas tidak bisa dihapus karena masih memiliki santri aktif.']);
        }

        $this->kelasModel->delete($id);
        return redirect()->to('/admin/kelas')->with('success', 'Data kelas berhasil dihapus.');
    }
}
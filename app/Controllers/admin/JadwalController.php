<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\KelasModel;
use App\Models\MapelModel;

class JadwalController extends BaseController
{
    protected $jadwalModel;
    protected $kelasModel;
    protected $mapelModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->kelasModel  = new KelasModel();
        $this->mapelModel  = new MapelModel();
    }

    // 1. TAMPILAN UTAMA JADWAL
    public function index()
    {
        $data = [
            'title'  => 'Manajemen Jadwal Pelajaran',
            'jadwal' => $this->jadwalModel->getFull() // Sudah include join di model
        ];

        return view('admin/jadwal/index', $data);
    }

    // 2. FORM TAMBAH JADWAL
    public function create()
    {
        $db = \Config\Database::connect();
        
        $data = [
            'title'     => 'Tambah Jadwal Baru',
            'guru'      => $db->table('guru')->where('status', 'aktif')->get()->getResultArray(),
            'kelas'     => $this->kelasModel->findAll(),
            'mapel'     => $this->mapelModel->findAll(),
            'hari_list' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']
        ];

        return view('admin/jadwal/create', $data);
    }

    // 3. PROSES SIMPAN JADWAL
    public function store()
    {
        $rules = [
            'guru_id'     => 'required',
            'mapel_id'    => 'required',
            'kelas_id'    => 'required',
            'hari'        => 'required',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $mulai   = $this->request->getPost('jam_mulai');
        $selesai = $this->request->getPost('jam_selesai');

        if ($selesai <= $mulai) {
            return redirect()->back()->withInput()->with('errors', ['jam_selesai' => 'Jam selesai tidak boleh mendahului atau sama dengan jam mulai.']);
        }

        $this->jadwalModel->save([
            'guru_id'     => $this->request->getPost('guru_id'),
            'mapel_id'    => $this->request->getPost('mapel_id'),
            'kelas_id'    => $this->request->getPost('kelas_id'),
            'hari'        => $this->request->getPost('hari'),
            'jam_mulai'   => $mulai,
            'jam_selesai' => $selesai,
        ]);

        return redirect()->to('/admin/jadwal')->with('success', 'Jadwal pelajaran berhasil ditambahkan!');
    }

    // 4. FORM EDIT JADWAL
    public function edit($id)
    {
        $jadwal = $this->jadwalModel->find($id);

        if (!$jadwal) {
            return redirect()->to('/admin/jadwal')->with('errors', ['Data jadwal tidak ditemukan!']);
        }

        $db = \Config\Database::connect();

        $data = [
            'title'     => 'Edit Jadwal Pelajaran',
            'jadwal'    => $jadwal,
            'guru'      => $db->table('guru')->where('status', 'aktif')->get()->getResultArray(),
            'kelas'     => $this->kelasModel->findAll(),
            'mapel'     => $this->mapelModel->findAll(),
            'hari_list' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']
        ];

        return view('admin/jadwal/edit', $data);
    }

    // 5. PROSES UPDATE JADWAL
    public function update($id)
    {
        $rules = [
            'guru_id'     => 'required',
            'mapel_id'    => 'required',
            'kelas_id'    => 'required',
            'hari'        => 'required',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $mulai   = $this->request->getPost('jam_mulai');
        $selesai = $this->request->getPost('jam_selesai');

        if ($selesai <= $mulai) {
            return redirect()->back()->withInput()->with('errors', ['jam_selesai' => 'Jam selesai tidak boleh mendahului atau sama dengan jam mulai.']);
        }

        $this->jadwalModel->update($id, [
            'guru_id'     => $this->request->getPost('guru_id'),
            'mapel_id'    => $this->request->getPost('mapel_id'),
            'kelas_id'    => $this->request->getPost('kelas_id'),
            'hari'        => $this->request->getPost('hari'),
            'jam_mulai'   => $mulai,
            'jam_selesai' => $selesai,
        ]);

        return redirect()->to('/admin/jadwal')->with('success', 'Jadwal pelajaran berhasil diperbarui!');
    }

    // 6. PROSES HAPUS JADWAL
    public function delete($id)
    {
        if ($this->jadwalModel->find($id)) {
            $this->jadwalModel->delete($id);
            return redirect()->to('/admin/jadwal')->with('success', 'Jadwal berhasil dihapus!');
        }

        return redirect()->to('/admin/jadwal')->with('errors', ['Gagal menghapus! Jadwal tidak ditemukan.']);
    }
}
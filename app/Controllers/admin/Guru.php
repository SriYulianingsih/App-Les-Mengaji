<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GuruModel;

class Guru extends BaseController
{
    protected $guru;

    public function __construct()
    {
        $this->guru = new GuruModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('q');

        // Mengambil data guru dan username dari tabel users
        $query = $this->guru
            ->select('guru.*, users.username')
            ->join('users', 'users.id = guru.user_id', 'left');

        if ($keyword) {
            $query->groupStart()
                  ->like('guru.nama', $keyword)
                  ->orLike('guru.nip', $keyword)
                  ->orLike('users.username', $keyword)
                  ->groupEnd();
        }

        $data = [
            'guru' => $query->paginate(5, 'guru'),
            'pager' => $this->guru->pager,
            'keyword' => $keyword
        ];

        return view('admin/guru/index', $data);
    }

    public function create()
    {
        // Karena relasinya ke users dibuat fleksibel (bisa null),
        // kita tidak perlu melempar data users apapun ke view create.
        return view('admin/guru/create');
    }

    public function store()
    {
        $nip = trim((string) $this->request->getPost('nip'));

        if ($this->guruNipExists($nip)) {
            return redirect()->back()
                ->withInput()
                ->with('popup_alert', [
                    'icon' => 'warning',
                    'title' => 'NIP telah digunakan',
                    'text' => 'NIP guru ini sudah ada di database.',
                    'confirmButtonText' => 'OK',
                ]);
        }

        // 1. Aturan validasi: 'user_id' dihapus dari list required!
        if (!$this->validate([
            'nip'  => 'required',
            'nama' => 'required',
            'foto' => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('foto');
        $namaFoto = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFoto = $file->getRandomName();
            $file->move('uploads/guru', $namaFoto);
        }

        // 2. Ambil user_id dari post, jika tidak ada/kosong, otomatis jadi null
        $userId = $this->request->getPost('user_id') ?: null;

        $this->guru->save([
            'user_id'       => $userId, // Berhasil dinull-kan jika kosong
            'nip'           => $nip,
            'nama'          => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'alamat'        => $this->request->getPost('alamat'),
            'pendidikan'    => $this->request->getPost('pendidikan'),
            'status'        => 'aktif', // Default aktif
            'foto'          => $namaFoto,
        ]);

        return redirect()->to('/admin/guru')->with('success', 'Data guru berhasil ditambahkan');
    }

    public function edit($id)
    {
        $guru = $this->guru->find($id);
        if (!$guru) {
            return redirect()->to('/admin/guru')->with('error', 'Data tidak ditemukan');
        }

        return view('admin/guru/edit', [
            'guru' => $guru
        ]);
    }

    public function update($id)
    {
        $nip = trim((string) $this->request->getPost('nip'));

        if ($this->guruNipExists($nip, (int) $id)) {
            return redirect()->back()
                ->withInput()
                ->with('popup_alert', [
                    'icon' => 'warning',
                    'title' => 'NIP telah digunakan',
                    'text' => 'NIP guru ini sudah ada di database.',
                    'confirmButtonText' => 'OK',
                ]);
        }

        if (!$this->validate([
            'nip'  => 'required',
            'nama' => 'required',
            'foto' => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $guru = $this->guru->find($id);
        $file = $this->request->getFile('foto');
        $namaFoto = $guru['foto'];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            if ($namaFoto && file_exists('uploads/guru/' . $namaFoto)) {
                unlink('uploads/guru/' . $namaFoto);
            }
            $namaFoto = $file->getRandomName();
            $file->move('uploads/guru', $namaFoto);
        }

        // Pertahankan user_id yang lama saat update profil guru
        $this->guru->update($id, [
            'nip'           => $nip,
            'nama'          => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'alamat'        => $this->request->getPost('alamat'),
            'pendidikan'    => $this->request->getPost('pendidikan'),
            'status'        => $this->request->getPost('status'),
            'foto'          => $namaFoto
        ]);

        return redirect()->to('/admin/guru')->with('success', 'Data guru berhasil diupdate');
    }

    public function detail($id)
    {
        $guru = $this->guru
            ->select('guru.*, users.username')
            ->join('users', 'users.id = guru.user_id', 'left')
            ->find($id);

        if (!$guru) {
            return redirect()->to('/admin/guru')->with('error', 'Data guru tidak ditemukan');
        }

        $data = [
            'guru' => $guru
        ];

        return view('admin/guru/detail', $data);
    }

    public function delete($id)
    {
        $guru = $this->guru->find($id);
        if ($guru) {
            if ($guru['foto'] && file_exists('uploads/guru/' . $guru['foto'])) {
                unlink('uploads/guru/' . $guru['foto']);
            }
            $this->guru->delete($id);
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        }
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    private function guruNipExists(string $nip, ?int $ignoreId = null): bool
    {
        $builder = $this->guru->where('nip', $nip);

        if ($ignoreId !== null) {
            $builder->where('id !=', $ignoreId);
        }

        return $builder->first() !== null;
    }
}
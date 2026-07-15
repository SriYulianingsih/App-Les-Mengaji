<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrangtuaModel;

class Orangtua extends BaseController
{
    protected $orangtua;

    public function __construct()
    {
        $this->orangtua = new OrangtuaModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('q');

        // Mengambil data orangtua dan username dari tabel users
        $query = $this->orangtua
            ->select('orangtua.*, users.username')
            ->join('users', 'users.id = orangtua.user_id', 'left');

        if ($keyword) {
            $query->groupStart()
                  ->like('orangtua.nama_ayah', $keyword)
                  ->orLike('orangtua.nama_ibu', $keyword)
                  ->orLike('orangtua.no_hp', $keyword)
                  ->orLike('users.username', $keyword)
                  ->groupEnd();
        }

        $data = [
            'orangtua' => $query->paginate(5, 'orangtua'),
            'pager' => $this->orangtua->pager,
            'keyword' => $keyword
        ];

        return view('admin/orangtua/index', $data);
    }

    public function create()
    {
        // View create tanpa perlu melempar data users
        return view('admin/orangtua/create');
    }

    public function store()
    {
        // Validasi data input sesuai field orangtua
        if (!$this->validate([
            'nama_ayah' => 'required',
            'nama_ibu'  => 'required',
            'no_hp'     => 'required',
            'email'     => 'permit_empty|valid_email'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil user_id dari post, jika tidak ada/kosong, otomatis jadi null
        $userId = $this->request->getPost('user_id') ?: null;

        $this->orangtua->save([
            'user_id'        => $userId, 
            'nama_ayah'      => $this->request->getPost('nama_ayah'),
            'nama_ibu'       => $this->request->getPost('nama_ibu'),
            'no_hp'          => $this->request->getPost('no_hp'),
            'email'          => $this->request->getPost('email'),
            'pekerjaan_ayah' => $this->request->getPost('pekerjaan_ayah'),
            'pekerjaan_ibu'  => $this->request->getPost('pekerjaan_ibu'),
            'alamat'         => $this->request->getPost('alamat'),
            'rt'             => $this->request->getPost('rt'),
            'rw'             => $this->request->getPost('rw'),
            'kelurahan'      => $this->request->getPost('kelurahan'),
            'kecamatan'      => $this->request->getPost('kecamatan'),
            'kabupaten'      => $this->request->getPost('kabupaten'),
            'provinsi'       => $this->request->getPost('provinsi'),
            'kode_pos'       => $this->request->getPost('kode_pos'),
        ]);

        return redirect()->to('/admin/orangtua')->with('success', 'Data orang tua berhasil ditambahkan');
    }

    public function edit($id)
    {
        $orangtua = $this->orangtua->find($id);
        if (!$orangtua) {
            return redirect()->to('/admin/orangtua')->with('error', 'Data tidak ditemukan');
        }

        return view('admin/orangtua/edit', [
            'orangtua' => $orangtua
        ]);
    }

    public function update($id)
    {
        // Validasi update
        if (!$this->validate([
            'nama_ayah' => 'required',
            'nama_ibu'  => 'required',
            'no_hp'     => 'required',
            'email'     => 'permit_empty|valid_email'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->orangtua->update($id, [
            'nama_ayah'      => $this->request->getPost('nama_ayah'),
            'nama_ibu'       => $this->request->getPost('nama_ibu'),
            'no_hp'          => $this->request->getPost('no_hp'),
            'email'          => $this->request->getPost('email'),
            'pekerjaan_ayah' => $this->request->getPost('pekerjaan_ayah'),
            'pekerjaan_ibu'  => $this->request->getPost('pekerjaan_ibu'),
            'alamat'         => $this->request->getPost('alamat'),
            'rt'             => $this->request->getPost('rt'),
            'rw'             => $this->request->getPost('rw'),
            'kelurahan'      => $this->request->getPost('kelurahan'),
            'kecamatan'      => $this->request->getPost('kecamatan'),
            'kabupaten'      => $this->request->getPost('kabupaten'),
            'provinsi'       => $this->request->getPost('provinsi'),
            'kode_pos'       => $this->request->getPost('kode_pos'),
        ]);

        return redirect()->to('/admin/orangtua')->with('success', 'Data orang tua berhasil diupdate');
    }

    public function detail($id)
    {
        $orangtua = $this->orangtua
            ->select('orangtua.*, users.username')
            ->join('users', 'users.id = orangtua.user_id', 'left')
            ->find($id);

        if (!$orangtua) {
            return redirect()->to('/admin/orangtua')->with('error', 'Data orang tua tidak ditemukan');
        }

        $data = [
            'orangtua' => $orangtua
        ];

        return view('admin/orangtua/detail', $data);
    }

    public function delete($id)
    {
        $orangtua = $this->orangtua->find($id);
        if ($orangtua) {
            $this->orangtua->delete($id);
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        }
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }
}
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
        $namaAyah = trim((string) $this->request->getPost('nama_ayah'));
        $namaIbu = trim((string) $this->request->getPost('nama_ibu'));
        $noHp = trim((string) $this->request->getPost('no_hp'));

        if ($this->orangtuaExists('nama_ayah', $namaAyah)) {
            return redirect()->back()
                ->withInput()
                ->with('popup_alert', [
                    'icon' => 'warning',
                    'title' => 'Nama telah ada',
                    'text' => 'Nama orang tua ini sudah ada di database.',
                    'confirmButtonText' => 'OK',
                ]);
        }

        if ($this->orangtuaExists('nama_ibu', $namaIbu)) {
            return redirect()->back()
                ->withInput()
                ->with('popup_alert', [
                    'icon' => 'warning',
                    'title' => 'Nama telah ada',
                    'text' => 'Nama orang tua ini sudah ada di database.',
                    'confirmButtonText' => 'OK',
                ]);
        }

        if ($this->orangtuaExists('no_hp', $noHp)) {
            return redirect()->back()
                ->withInput()
                ->with('popup_alert', [
                    'icon' => 'warning',
                    'title' => 'No telah digunakan',
                    'text' => 'Nomor handphone ini sudah ada di database.',
                    'confirmButtonText' => 'OK',
                ]);
        }

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
            'nama_ayah'      => $namaAyah,
            'nama_ibu'       => $namaIbu,
            'no_hp'          => $noHp,
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
        $namaAyah = trim((string) $this->request->getPost('nama_ayah'));
        $namaIbu = trim((string) $this->request->getPost('nama_ibu'));
        $noHp = trim((string) $this->request->getPost('no_hp'));

        if ($this->orangtuaExists('nama_ayah', $namaAyah, (int) $id) || $this->orangtuaExists('nama_ibu', $namaIbu, (int) $id)) {
            return redirect()->back()
                ->withInput()
                ->with('popup_alert', [
                    'icon' => 'warning',
                    'title' => 'Nama telah ada',
                    'text' => 'Nama orang tua ini sudah ada di database.',
                    'confirmButtonText' => 'OK',
                ]);
        }

        if ($this->orangtuaExists('no_hp', $noHp, (int) $id)) {
            return redirect()->back()
                ->withInput()
                ->with('popup_alert', [
                    'icon' => 'warning',
                    'title' => 'No telah digunakan',
                    'text' => 'Nomor handphone ini sudah ada di database.',
                    'confirmButtonText' => 'OK',
                ]);
        }

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
            'nama_ayah'      => $namaAyah,
            'nama_ibu'       => $namaIbu,
            'no_hp'          => $noHp,
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

    private function orangtuaExists(string $field, string $value, ?int $ignoreId = null): bool
    {
        $builder = $this->orangtua->where($field, $value);

        if ($ignoreId !== null) {
            $builder->where('id !=', $ignoreId);
        }

        return $builder->first() !== null;
    }
}
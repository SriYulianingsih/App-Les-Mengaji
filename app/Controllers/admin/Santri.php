<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\OrangtuaModel;
use App\Models\KelasModel;

class Santri extends BaseController
{
    protected $santri;
    protected $orangtua;
    protected $kelas;

    public function __construct()
    {
        $this->santri = new SantriModel();
        $this->orangtua = new OrangtuaModel();
        $this->kelas = new KelasModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('q');

        $query = $this->santri
            ->select('santri.*, orangtua.nama_ayah, orangtua.no_hp, kelas.nama_kelas')
            ->join('orangtua', 'orangtua.id = santri.orangtua_id', 'left')
            ->join('kelas', 'kelas.id = santri.kelas_id', 'left');

        if ($keyword) {
            $query->groupStart()
                  ->like('santri.nama', $keyword)
                  ->orLike('santri.nis', $keyword)
                  ->orLike('orangtua.nama_ayah', $keyword)
                  ->groupEnd();
        }

        $data = [
            'santri'  => $query->orderBy('santri.created_at', 'DESC')->paginate(10, 'santri'),
            'pager'   => $this->santri->pager,
            'keyword' => $keyword
        ];

        return view('admin/santri/index', $data);
    }

    public function create()
    {
        return view('admin/santri/create', [
            // Mengambil semua data orang tua agar bisa dipilih berkali-kali (untuk kakak-beradik)
            'orangtua' => $this->orangtua->orderBy('nama_ayah', 'ASC')->findAll(),
            'kelas'    => $this->kelas->orderBy('nama_kelas', 'ASC')->findAll()
        ]);
    }

    public function store()
    {
        $nis = trim((string) $this->request->getPost('nis'));
        $nama = trim((string) $this->request->getPost('nama'));

        if ($this->santriFieldExists('nis', $nis)) {
            return redirect()->back()
                ->withInput()
                ->with('popup_alert', [
                    'icon' => 'warning',
                    'title' => 'NIS telah ada',
                    'text' => 'Nomor induk santri ini sudah digunakan di database.',
                    'confirmButtonText' => 'OK',
                ]);
        }

        if ($this->santriFieldExists('nama', $nama)) {
            return redirect()->back()
                ->withInput()
                ->with('popup_alert', [
                    'icon' => 'warning',
                    'title' => 'Nama telah digunakan',
                    'text' => 'Nama santri ini sudah ada di database.',
                    'confirmButtonText' => 'OK',
                ]);
        }

        // Validasi: orangtua_id, status, dan kelas boleh sama antar santri
        if (!$this->validate([
            'nis'         => 'required|min_length[3]',
            'nama'        => 'required|min_length[3]',
            'orangtua_id' => 'required|numeric',
            'kelas_id'    => 'required|numeric',
            'foto'        => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('foto');
        $namaFoto = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFoto = $file->getRandomName();
            $file->move('uploads/santri', $namaFoto);
        }

        $this->santri->save([
            'nis'                 => $nis,
            'nama'                => $nama,
            'orangtua_id'         => $this->request->getPost('orangtua_id'),
            'kelas_id'            => $this->request->getPost('kelas_id'),
            'jenis_kelamin'       => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir'        => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir'       => $this->request->getPost('tanggal_lahir'),
            'alamat'              => $this->request->getPost('alamat'),
            'pendidikan_terakhir' => $this->request->getPost('pendidikan_terakhir'),
            'tanggal_daftar'      => $this->request->getPost('tanggal_daftar') ?: date('Y-m-d'),
            'status'              => 'aktif',
            'foto'                => $namaFoto,
        ]);

        return redirect()->to('/admin/santri')->with('success', 'Data santri berhasil ditambahkan');
    }

    public function edit($id)
    {
        $santri = $this->santri->find($id);
        if (!$santri) {
            return redirect()->to('/admin/santri')->with('error', 'Data tidak ditemukan');
        }

        return view('admin/santri/edit', [
            'santri'   => $santri,
            // Menampilkan semua orang tua tanpa filter agar bebas edit relasi
            'orangtua' => $this->orangtua->orderBy('nama_ayah', 'ASC')->findAll(),
            'kelas'    => $this->kelas->orderBy('nama_kelas', 'ASC')->findAll()
        ]);
    }

    public function update($id)
    {
        $nis = trim((string) $this->request->getPost('nis'));
        $nama = trim((string) $this->request->getPost('nama'));

        if ($this->santriFieldExists('nis', $nis, (int) $id)) {
            return redirect()->back()
                ->withInput()
                ->with('popup_alert', [
                    'icon' => 'warning',
                    'title' => 'NIS telah ada',
                    'text' => 'Nomor induk santri ini sudah digunakan di database.',
                    'confirmButtonText' => 'OK',
                ]);
        }

        if ($this->santriFieldExists('nama', $nama, (int) $id)) {
            return redirect()->back()
                ->withInput()
                ->with('popup_alert', [
                    'icon' => 'warning',
                    'title' => 'Nama telah digunakan',
                    'text' => 'Nama santri ini sudah ada di database.',
                    'confirmButtonText' => 'OK',
                ]);
        }

        // Validasi: orangtua_id, status, dan kelas boleh sama antar santri
        if (!$this->validate([
            'nis'         => 'required|min_length[3]',
            'nama'        => 'required',
            'orangtua_id' => 'required|numeric',
            'kelas_id'    => 'required',
            'foto'        => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $santri = $this->santri->find($id);
        $file = $this->request->getFile('foto');
        $namaFoto = $santri['foto'];
        $status = $this->request->getPost('status');
        $kelasId = $this->request->getPost('kelas_id');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            if ($namaFoto && file_exists('uploads/santri/' . $namaFoto)) {
                unlink('uploads/santri/' . $namaFoto);
            }
            $namaFoto = $file->getRandomName();
            $file->move('uploads/santri', $namaFoto);
        }

        if ($status === 'non-aktif') {
            $kelasId = null;
        }

        $this->santri->update($id, [
            'nis'                 => $nis,
            'nama'                => $nama,
            'orangtua_id'         => $this->request->getPost('orangtua_id'),
            'kelas_id'            => $kelasId,
            'jenis_kelamin'       => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir'        => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir'       => $this->request->getPost('tanggal_lahir'),
            'alamat'              => $this->request->getPost('alamat'),
            'pendidikan_terakhir' => $this->request->getPost('pendidikan_terakhir'),
            'tanggal_daftar'      => $this->request->getPost('tanggal_daftar'),
            'status'              => $status,
            'foto'                => $namaFoto
        ]);

        return redirect()->to('/admin/santri')->with('success', 'Data santri berhasil diupdate');
    }

    public function detail($id)
    {
        $santri = $this->santri
            ->select('santri.*, orangtua.nama_ayah, orangtua.nama_ibu, orangtua.no_hp, orangtua.alamat as alamat_ortu, kelas.nama_kelas')
            ->join('orangtua', 'orangtua.id = santri.orangtua_id', 'left')
            ->join('kelas', 'kelas.id = santri.kelas_id', 'left')
            ->find($id);

        if (!$santri) {
            return redirect()->to('/admin/santri')->with('error', 'Data santri tidak ditemukan');
        }

        return view('admin/santri/detail', ['santri' => $santri]);
    }

    public function delete($id)
    {
        $santri = $this->santri->find($id);
        if ($santri) {
            if ($santri['foto'] && file_exists('uploads/santri/' . $santri['foto'])) {
                unlink('uploads/santri/' . $santri['foto']);
            }
            $this->santri->delete($id);
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        }
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    private function santriFieldExists(string $field, string $value, ?int $ignoreId = null): bool
    {
        $builder = $this->santri->where($field, $value);

        if ($ignoreId !== null) {
            $builder->where('id !=', $ignoreId);
        }

        return $builder->first() !== null;
    }
}
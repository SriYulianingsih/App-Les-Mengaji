<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $guruModel;
    protected $userModel;

    public function __construct() {
        $this->guruModel = new GuruModel();
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        $guru = $this->guruModel->where('user_id', $userId)->first();

        $data = [
            'title' => 'Profil Saya',
            'guru'  => $guru,
            'user'  => $user
        ];

        return view('guru/profile/index', $data);
    }

    public function update()
    {
        $idGuru = $this->request->getPost('id_guru');
        $guruLama = $this->guruModel->find($idGuru);

        // 1. Validasi Input & File Foto
        $validation = $this->validate([
            'nama' => 'required|min_length[3]',
            'foto' => [
                'rules' => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran foto maksimal 2MB Bang!',
                    'is_image' => 'Yang Abang upload bukan gambar nih.',
                    'mime_in'  => 'Format foto harus JPG, JPEG, atau PNG.'
                ]
            ]
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Handle Upload Foto
        $fileFoto = $this->request->getFile('foto');
        $namaFotoBaru = $guruLama['foto']; // Default pakai yang lama

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            // Hapus foto lama dari folder jika ada (dan bukan file default jika ada)
            if (!empty($guruLama['foto']) && file_exists('uploads/guru/' . $guruLama['foto'])) {
                unlink('uploads/guru/' . $guruLama['foto']);
            }

            // Generate nama random biar gak bentrok
            $namaFotoBaru = $fileFoto->getRandomName();
            $fileFoto->move('uploads/guru', $namaFotoBaru);
        }

        // 3. Siapkan Data
        $nama = $this->request->getPost('nama');
        $data = [
            'nama'       => $nama,
            'no_hp'      => $this->request->getPost('no_hp'),
            'alamat'     => $this->request->getPost('alamat'),
            'pendidikan' => $this->request->getPost('pendidikan'),
            'foto'       => $namaFotoBaru, // Simpan nama file foto
        ];

        if ($this->guruModel->update($idGuru, $data)) {
            session()->set('nama', $nama);
            // Simpan foto ke session juga biar di sidebar/navbar otomatis berubah
            session()->set('foto', $namaFotoBaru);
            
            return redirect()->back()->with('success', 'Profil & Foto berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui profil.');
    }

    public function updatePassword()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        $passLama = $this->request->getPost('old_password');
        $passBaru = $this->request->getPost('new_password');

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

       // Tambahkan (string) di depan variabelnya
        if (!password_verify($passLama, (string)$user['password'])) {
            return redirect()->back()->with('error', 'Password lama salah Bang!');
        }

        if (strlen($passBaru) < 6) {
            return redirect()->back()->with('error', 'Password baru minimal 6 karakter.');
        }

        $updatePass = $this->userModel->update($userId, [
            'password' => password_hash($passBaru, PASSWORD_DEFAULT)
        ]);

        if ($updatePass) {
            return redirect()->back()->with('success', 'Password berhasil diganti!');
        }

        return redirect()->back()->with('error', 'Gagal ganti password.');
    }
}
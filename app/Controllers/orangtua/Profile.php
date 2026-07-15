<?php

namespace App\Controllers\Orangtua;

use App\Controllers\BaseController;
use App\Models\OrangtuaModel;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $orangtuaModel;
    protected $userModel;

    public function __construct()
    {
        $this->orangtuaModel = new OrangtuaModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $data['orangtua'] = $this->orangtuaModel->where('user_id', $userId)->first();
        $data['title'] = "Profil Saya";

        if (!$data['orangtua']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data profil tidak ditemukan.");
        }

        return view('orangtua/profile/index', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        
        $rules = [
            'nama_ayah' => 'required|min_length[3]',
            'nama_ibu'  => 'required|min_length[3]',
            'no_hp'     => 'required|numeric|min_length[10]',
            'email'     => 'required|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataUpdate = [
            'nama_ayah'      => $this->request->getPost('nama_ayah'),
            'nama_ibu'       => $this->request->getPost('nama_ibu'),
            'pekerjaan_ayah' => $this->request->getPost('pekerjaan_ayah'),
            'pekerjaan_ibu'  => $this->request->getPost('pekerjaan_ibu'),
            'no_hp'          => $this->request->getPost('no_hp'),
            'email'          => $this->request->getPost('email'),
            'alamat'         => $this->request->getPost('alamat'),
            'rt'             => $this->request->getPost('rt'),
            'rw'             => $this->request->getPost('rw'),
            'kelurahan'      => $this->request->getPost('kelurahan'),
            'kecamatan'      => $this->request->getPost('kecamatan'),
            'kabupaten'      => $this->request->getPost('kabupaten'), // Tambahan
            'provinsi'       => $this->request->getPost('provinsi'),  // Tambahan
            'kode_pos'       => $this->request->getPost('kode_pos'),
        ];

        if ($this->orangtuaModel->update($id, $dataUpdate)) {
            return redirect()->to('/orangtua/profile')->with('success', 'Profil berhasil diperbarui!');
        } else {
            return redirect()->back()->with('errors', ['Gagal memperbarui database.']);
        }
    }

    public function updatePassword()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $oldPassword = $this->request->getPost('old_password');
        $newPassword = $this->request->getPost('new_password');

        if (!password_verify((string)$oldPassword, (string)$user['password'])) {
            return redirect()->back()->with('errors', ['Password lama tidak sesuai.']);
        }

        if (strlen((string)$newPassword) < 6) {
            return redirect()->back()->with('errors', ['Password baru minimal 6 karakter.']);
        }

        $this->userModel->update($userId, [
            'password' => password_hash((string)$newPassword, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/orangtua/profile')->with('success', 'Password berhasil diganti!');
    }
}
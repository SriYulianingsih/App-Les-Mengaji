<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = (int) session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        /** @var array<string, mixed>|null $user */
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User tidak ditemukan');
        }

        return view('admin/profile/index', [
            'user' => $user
        ]);
    }

    public function updatePassword()
    {
        $userId = (int) session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        // Validasi
        $rules = [
            'password_lama'       => 'required',
            'password_baru'       => 'required|min_length[5]',
            'konfirmasi_password' => 'required|matches[password_baru]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        /** @var array<string, mixed>|null $user */
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User tidak ditemukan');
        }

        $passwordLama = (string) $this->request->getPost('password_lama');
        $passwordHash = (string) ($user['password'] ?? '');

        // Cek password lama
        if (!password_verify($passwordLama, $passwordHash)) {
            return redirect()->back()
                ->with('error', 'Password lama yang Anda masukkan salah!');
        }

        // Password baru
        $passwordBaru = (string) $this->request->getPost('password_baru');

        $this->userModel->update($userId, [
            'password' => password_hash($passwordBaru, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/admin/profile')
            ->with('success', 'Password berhasil diperbarui!');
    }
}
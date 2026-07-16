<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AkunController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // 1. TAMPILAN UTAMA (SISTEM TAB)
    public function index()
    {
        $allUsers = $this->userModel->findAll();
        
        $data = [
            'adminUsers' => [],
            'guruUsers'  => [],
            'ortuUsers'  => []
        ];

        foreach ($allUsers as $user) {
            if ($user['role'] === 'admin') {
                $data['adminUsers'][] = $user;
            } elseif ($user['role'] === 'guru') {
                // Tarik nama dari tabel guru
                $guruData = $this->userModel->db->table('guru')->where('user_id', $user['id'])->get()->getRow();
                $user['nama_lengkap'] = $guruData ? $guruData->nama : 'Belum Terkoneksi';
                $data['guruUsers'][] = $user;
            } elseif ($user['role'] === 'orangtua') {
                // Tarik nama dari tabel orangtua
                $ortuData = $this->userModel->db->table('orangtua')->where('user_id', $user['id'])->get()->getRow();
                $user['nama_lengkap'] = $ortuData ? "Bpk. {$ortuData->nama_ayah} / Ibu {$ortuData->nama_ibu}" : 'Belum Terkoneksi';
                $data['ortuUsers'][] = $user;
            }
        }

        return view('admin/akun/index', $data);
    }

    // 2. FORM TAMBAH AKUN
    public function create($role)
    {
        if (!in_array($role, ['admin', 'guru', 'orangtua'])) {
            return redirect()->to('/admin/akun')->with('errors', ['Role tidak valid!']);
        }

        $data = [
            'role' => $role,
            'dataTersedia' => []
        ];

        // Ambil data guru/ortu yang BELUM punya user_id
        if ($role === 'guru') {
            $data['dataTersedia'] = $this->userModel->db->table('guru')->where('user_id', null)->get()->getResultArray();
        } elseif ($role === 'orangtua') {
            $data['dataTersedia'] = $this->userModel->db->table('orangtua')->where('user_id', null)->get()->getResultArray();
        }

        return view('admin/akun/create', $data);
    }

    // 3. PROSES SIMPAN AKUN
    public function store()
    {
        $username = trim($this->request->getPost('username'));
        $password = trim($this->request->getPost('password'));
        $role = $this->request->getPost('role');

        $rules = [
            'username' => 'required|min_length[4]',
            'password' => 'required|min_length[6]',
            'role'     => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $existingUsername = $this->userModel->where('username', $username)->first();
        if ($existingUsername) {
            return redirect()->back()
                ->withInput()
                ->with('popup_alert', [
                    'icon' => 'warning',
                    'title' => 'Username sudah ada',
                    'text' => 'Username ini sudah terdaftar di database. Silakan gunakan username lain.',
                    'confirmButtonText' => 'OK',
                ]);
        }

        $allUsers = $this->userModel->findAll();
        foreach ($allUsers as $user) {
            if (!empty($user['password']) && password_verify($password, $user['password'])) {
                return redirect()->back()
                    ->withInput()
                    ->with('popup_alert', [
                        'icon' => 'warning',
                        'title' => 'Password sudah ada',
                        'text' => 'Password ini sudah digunakan oleh akun lain di database. Silakan gunakan password yang berbeda.',
                        'confirmButtonText' => 'OK',
                    ]);
            }
        }

        $userData = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role'     => $role
        ];

        $this->userModel->save($userData);
        $newUserId = $this->userModel->getInsertID();

        // Ambil target ID yang mau dikoneksikan
        $terhubungKe = $this->request->getPost('target_id');
        
        if ($role === 'guru' && $terhubungKe) {
            $this->userModel->db->table('guru')->where('id', $terhubungKe)->update(['user_id' => $newUserId]);
        } elseif ($role === 'orangtua' && $terhubungKe) {
            $this->userModel->db->table('orangtua')->where('id', $terhubungKe)->update(['user_id' => $newUserId]);
        }

        return redirect()->to('/admin/akun')->with('success', "Akun {$role} berhasil dibuat!");
    }

    // 5. FORM EDIT AKUN
    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/akun')->with('errors', ['Akun tidak ditemukan!']);
        }

        $nama_lengkap = '';
        if ($user['role'] === 'guru') {
            $guruData = $this->userModel->db->table('guru')->where('user_id', $id)->get()->getRow();
            $nama_lengkap = $guruData ? $guruData->nama : 'Belum Terkoneksi';
        } elseif ($user['role'] === 'orangtua') {
            $ortuData = $this->userModel->db->table('orangtua')->where('user_id', $id)->get()->getRow();
            $nama_lengkap = $ortuData ? "Bpk. {$ortuData->nama_ayah} / Ibu {$ortuData->nama_ibu}" : 'Belum Terkoneksi';
        }

        $data = [
            'user' => $user,
            'nama_lengkap' => $nama_lengkap
        ];

        return view('admin/akun/edit', $data);
    }

    // 6. PROSES UPDATE AKUN
    public function update($id)
    {
        $username = trim($this->request->getPost('username'));
        $newPassword = trim($this->request->getPost('password'));

        $rules = [
            'username' => "required|min_length[4]"
        ];

        if ($newPassword) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $existingUsername = $this->userModel->where('username', $username)->where('id !=', $id)->first();
        if ($existingUsername) {
            return redirect()->back()
                ->withInput()
                ->with('popup_alert', [
                    'icon' => 'warning',
                    'title' => 'Username sudah ada',
                    'text' => 'Username ini sudah terdaftar di database. Silakan gunakan username lain.',
                    'confirmButtonText' => 'OK',
                ]);
        }

        $userData = [
            'id' => $id,
            'username' => $username
        ];

        if ($newPassword) {
            $userData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $this->userModel->save($userData);

        return redirect()->to('/admin/akun')->with('success', 'Akun berhasil diperbarui!');
    }

    // 4. HAPUS AKUN
    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if ($user) {
            // Putuskan relasi dulu sebelum dihapus
            if ($user['role'] === 'guru') {
                $this->userModel->db->table('guru')->where('user_id', $id)->update(['user_id' => null]);
            } elseif ($user['role'] === 'orangtua') {
                $this->userModel->db->table('orangtua')->where('user_id', $id)->update(['user_id' => null]);
            }

            $this->userModel->delete($id);
            return redirect()->to('/admin/akun')->with('success', 'Akun berhasil dihapus!');
        }
        return redirect()->to('/admin/akun')->with('errors', ['Akun tidak ditemukan!']);
    }
}
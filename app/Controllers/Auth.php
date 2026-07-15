<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GuruModel;
use App\Models\OrangtuaModel;
use App\Models\SantriModel; // Tambahkan import Model Santri

class Auth extends BaseController
{
    public function login()
    {
        helper(['cookie']);
        return view('auth/login');
    }

    public function processLogin()
    {
        $session = session();
        helper(['cookie']);

        $rules = [
            'username' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Username wajib diisi',
                    'min_length' => 'Username minimal 3 karakter'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => 'Password wajib diisi',
                    'min_length' => 'Password minimal 5 karakter'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Username tidak ditemukan');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Password salah');
        }

        // --- FITUR INGAT SAYA (REMEMBER ME) ---
        $remember = $this->request->getPost('remember');
        if ($remember) {
            set_cookie('remember_username', $username, 2592000);
            set_cookie('remember_check', 'checked', 2592000);
        } else {
            delete_cookie('remember_username');
            delete_cookie('remember_check');
        }

        // --- INISIALISASI DATA SESSION ---
        $id_user_detail = null; 
        $nama_display = $user['username'];
        $jenis_kelamin = null;
        $foto = null;
        
        // Inisialisasi variabel nama ortu spesifik
        $nama_ibu = null;
        $nama_ayah = null;

        // Data khusus untuk fitur Switcher Anak
        $list_anak = [];
        $active_santri_id = null;
        $active_santri_nama = null;

        // Logika detail berdasarkan Role
        if ($user['role'] === 'guru') {
            $guruModel = new GuruModel();
            $guru = $guruModel->where('user_id', $user['id'])->first();
            
            if ($guru) {
                $id_user_detail = $guru['id'];
                $nama_display = $guru['nama'];
                $jenis_kelamin = $guru['jenis_kelamin'];
                $foto = $guru['foto'];
            }
        } 
        else if ($user['role'] === 'orangtua') {
            $ortuModel = new OrangtuaModel();
            $santriModel = new SantriModel();
            $ortu = $ortuModel->where('user_id', $user['id'])->first();

            if ($ortu) {
                $id_user_detail = $ortu['id'];
                
                // Ambil nama spesifik untuk session
                $nama_ibu = $ortu['nama_ibu'];
                $nama_ayah = $ortu['nama_ayah'];

                // Logika nama display tetap (Ayah > Ibu > Username)
                $nama_display = $ortu['nama_ayah'] ?: ($ortu['nama_ibu'] ?: $user['username']);

                // Ambil semua anak yang terikat dengan ID Orang Tua ini
                $data_anak = $santriModel->where('orangtua_id', $ortu['id'])->findAll();

                if (!empty($data_anak)) {
                    foreach ($data_anak as $s) {
                        $list_anak[] = [
                            'id_santri'   => $s['id'],
                            'nama_santri' => $s['nama']
                        ];
                    }
                    // Secara otomatis aktifkan anak pertama saat pertama kali login
                    $active_santri_id   = $list_anak[0]['id_santri'];
                    $active_santri_nama = $list_anak[0]['nama_santri'];
                }
            }
        }

        // --- SIMPAN SEMUA KE SESSION ---
        $session->set([
            'user_id'            => $user['id'],
            'username'           => $user['username'],
            'nama'               => $nama_display,
            'role'               => $user['role'],
            'jenis_kelamin'      => $jenis_kelamin,
            'foto'               => $foto,
            'id_user_detail'     => $id_user_detail, 
            'id_guru'            => $id_user_detail, // Fallback untuk controller lama guru
            'isLoggedIn'         => true,
            
            // Session khusus Wali Santri (Data Nama Spesifik)
            'nama_ibu'           => $nama_ibu,
            'nama_ayah'          => $nama_ayah,

            // Data khusus untuk fitur Switcher Anak
            'list_anak'          => $list_anak,
            'active_santri_id'   => $active_santri_id,
            'active_santri_nama' => $active_santri_nama
        ]);

        // REDIRECT BERDASARKAN ROLE
        switch ($user['role']) {
            case 'admin':
                return redirect()->to('/admin/dashboard');
            case 'guru':
                return redirect()->to('/guru/dashboard');
            case 'orangtua':
                return redirect()->to('/orangtua/dashboard');
            default:
                return redirect()->to('/login');
        }
    }

    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    public function processForgotPassword()
    {
        $rules = [
            'username' => [
                'rules' => 'required',
                'errors' => ['required' => 'Username wajib diisi']
            ],
            'password' => [
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => 'Password wajib diisi',
                    'min_length' => 'Password minimal 5 karakter'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi',
                    'matches' => 'Konfirmasi password tidak sama'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Username tidak ditemukan');
        }

        $model->update($user['id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/login')->with('success', 'Password berhasil direset, silakan login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
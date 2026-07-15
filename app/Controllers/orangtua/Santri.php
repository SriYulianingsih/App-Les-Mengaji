<?php

namespace App\Controllers\Orangtua;

use App\Controllers\BaseController;
use App\Models\SantriModel;

class Santri extends BaseController
{
    protected $santriModel;

    public function __construct()
    {
        $this->santriModel = new SantriModel();
    }

    public function index()
    {
        // Ambil ID dari session (Hasil Switch Anak)
        $active_santri_id = session()->get('active_santri_id');
        $id_orangtua      = session()->get('id_user_detail');

        // Jika session kosong (antisipasi), arahkan balik ke dashboard
        if (!$active_santri_id) {
            return redirect()->to(base_url('orangtua/dashboard'));
        }

        $data = [
            'title'  => 'Data Ananda',
            'santri' => $this->santriModel->getFullById($active_santri_id)
        ];

        // Proteksi: Pastikan santri ini memang milik orang tua yang login
        if (!$data['santri'] || $data['santri']['orangtua_id'] != $id_orangtua) {
            return redirect()->to(base_url('orangtua/dashboard'))->with('error', 'Akses tidak diizinkan.');
        }

        return view('orangtua/santri/index', $data);
    }

    public function uploadFoto($id)
    {
        // Validasi kepemilikan sebelum upload
        $id_orangtua = session()->get('id_user_detail');
        $santri = $this->santriModel->where(['id' => $id, 'orangtua_id' => $id_orangtua])->first();

        if (!$santri) {
            return redirect()->back()->with('error', 'Aksi tidak diizinkan.');
        }

        $file = $this->request->getFile('foto');

        // Validasi apakah file diupload dengan benar
        if ($file && $file->isValid() && !$file->hasMoved()) {
            
            // Validasi format & ukuran (max 2MB)
            $validationRules = [
                'foto' => [
                    'rules' => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'max_size' => 'Ukuran foto terlalu besar (Max 2MB).',
                        'is_image' => 'Yang Anda upload bukan gambar.',
                        'mime_in'  => 'Format foto harus JPG, JPEG, atau PNG.'
                    ]
                ]
            ];

            if (!$this->validate($validationRules)) {
                return redirect()->back()->with('error', $this->validator->getError('foto'));
            }

            // Hapus foto lama jika ada (biar gak menumpuk di server)
            if ($santri['foto'] && file_exists('uploads/santri/' . $santri['foto'])) {
                unlink('uploads/santri/' . $santri['foto']);
            }

            // Upload file baru
            $namaFotoBaru = $file->getRandomName();
            $file->move('uploads/santri/', $namaFotoBaru);

            // Update nama file di database
            $this->santriModel->update($id, ['foto' => $namaFotoBaru]);

            return redirect()->back()->with('success', 'Foto ananda berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal mengupload foto.');
    }
}
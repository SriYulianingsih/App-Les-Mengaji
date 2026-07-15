<?php

namespace App\Controllers\Orangtua;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;

class Absensi extends BaseController
{
    protected $absensiModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
    }

    public function index()
    {
        // Ambil ID Santri aktif dari hasil Switch Anak
        $active_santri_id = session()->get('active_santri_id');
        $id_orangtua      = session()->get('id_user_detail');

        if (!$active_santri_id) {
            return redirect()->to(base_url('orangtua/dashboard'));
        }

        // Ambil history menggunakan method getHistoryBySantri dari model yang abang kirim
        // Kita modifikasi query-nya sedikit di view untuk memanggil detail materi
        $history = $this->absensiModel->getHistoryBySantri($active_santri_id);

        $data = [
            'title'   => 'Presensi & Progres Hafalan',
            'history' => $history
        ];

        return view('orangtua/absensi/index', $data);
    }
}
<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\GuruModel;
use App\Models\PembayaranModel;
use App\Models\AbsensiModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // PANGGIL MODEL
        $santriModel = new SantriModel();
        $guruModel   = new GuruModel();
        $bayarModel  = new PembayaranModel();
        $absensiModel= new AbsensiModel();

        // DATA CARD
        $data = [
            'title' => 'Dashboard Admin',
            'total_santri' => $santriModel->countAllResults(),
            'total_guru'   => $guruModel->countAllResults(),
            'total_bayar'  => $bayarModel->countAllResults(),
            'total_absensi'=> $absensiModel->countAllResults(),

            // data terbaru (optional biar hidup)
            'santri_terbaru' => $santriModel->orderBy('id','DESC')->limit(5)->find(),
        ];

        return view('admin/dashboard/index', $data);
    }
}
<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class SearchController extends BaseController
{
    public function index()
    {
        $request = \Config\Services::request();
        $keyword = $request->getGet('q');
        
        // Kalau keyword kosong atau kurang dari 2 huruf, langsung stop biar ga boros query
        if (empty($keyword) || strlen($keyword) < 2) {
            return $this->response->setJSON([]);
        }

        $db = \Config\Database::connect();
        $hasil = [];

        // 1. CARI DI TABEL SANTRI
        $santri = $db->table('santri')
                     ->select('id, nama, nis')
                     ->like('nama', $keyword)
                     ->limit(5)
                     ->get()->getResultArray();

        foreach ($santri as $s) {
            $hasil[] = [
                'id'   => $s['id'],
                'nama' => $s['nama'],
                'nis'  => $s['nis'] ?? '-',
                'tipe' => 'santri'
            ];
        }

        // 2. CARI DI TABEL GURU
        // Pastikan nama tabel lu emang 'guru' di database
        if ($db->tableExists('guru')) {
            $guru = $db->table('guru')
                       ->select('id, nama, nip')
                       ->like('nama', $keyword)
                       ->limit(3)
                       ->get()->getResultArray();

            foreach ($guru as $g) {
                $hasil[] = [
                    'id'   => $g['id'],
                    'nama' => $g['nama'],
                    'nis'  => $g['nip'] ?? '-', // NIP kita tampung ke variabel nis biar di JS seragam
                    'tipe' => 'guru'
                ];
            }
        }

        // 3. CARI DI TABEL ORANG TUA (DIPERBAIKI)
        if ($db->tableExists('orangtua')) {
            $orangtua = $db->table('orangtua')
                           ->select('id, nama_ayah, nama_ibu')
                           ->groupStart()
                               ->like('nama_ayah', $keyword)
                               ->orLike('nama_ibu', $keyword)
                           ->groupEnd()
                           ->limit(3)
                           ->get()->getResultArray();

            foreach ($orangtua as $o) {
                // Kita gabungkan nama ayah & ibu untuk ditampilkan di dropdown
                $namaTampil = "";
                if (!empty($o['nama_ayah']) && !empty($o['nama_ibu'])) {
                    $namaTampil = $o['nama_ayah'] . " & " . $o['nama_ibu'];
                } else {
                    $namaTampil = $o['nama_ayah'] ?: $o['nama_ibu'];
                }

                $hasil[] = [
                    'id'   => $o['id'],
                    'nama' => "Wali: " . $namaTampil,
                    'nis'  => '-',
                    'tipe' => 'orangtua'
                ];
            }
        }

        // Kirim datanya kembali ke Javascript dalam bentuk JSON
        return $this->response->setJSON($hasil);
    }
}
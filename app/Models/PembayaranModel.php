<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'santri_id', 'kategori_id', 'bulan', 'tahun', 'jumlah_bayar',
        'status', 'metode_pembayaran', 'keterangan',
        'tanggal_bayar', 'bukti_pembayaran'
    ];

    protected $useTimestamps = true;

    public function getFull()
    {
        return $this->select('pembayaran.*, santri.nama, kategori_pembayaran.nama_kategori')
            ->join('santri', 'santri.id = pembayaran.santri_id')
            ->join('kategori_pembayaran', 'kategori_pembayaran.id = pembayaran.kategori_id', 'left')
            ->findAll();
    }

    /**
 * Ambil info pembayaran terakhir & status bayar anak tertentu
 */
public function getStatusBayarSantri($santri_id)
{
    return $this->select('pembayaran.*, kategori_pembayaran.nama_kategori')
        ->join('kategori_pembayaran', 'kategori_pembayaran.id = pembayaran.kategori_id', 'left')
        ->where('pembayaran.santri_id', $santri_id)
        ->orderBy('pembayaran.tahun', 'DESC')
        ->orderBy('pembayaran.bulan', 'DESC')
        ->first();
}

/**
 * Hitung total pembayaran sukses (Lunas)
 */
public function getTotalLunas($santri_id)
{
    return $this->where('santri_id', $santri_id)
                ->where('status', 'lunas')
                ->selectSum('jumlah_bayar')
                ->get()
                ->getRow()->jumlah_bayar ?? 0;
}
}
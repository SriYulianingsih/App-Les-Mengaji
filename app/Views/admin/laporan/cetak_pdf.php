<!DOCTYPE html>
<html>

<head>
    <title>Laporan_<?= str_replace(' ', '_', (string)$laporan['tipe_laporan']) ?>_<?= $laporan['periode_tahun'] ?>
    </title>
    <style>
    body {
        font-family: 'Helvetica', 'Arial', sans-serif;
        font-size: 11px;
        color: #333;
        line-height: 1.4;
    }

    /* HEADER PREMIUM */
    .kop-surat {
        width: 100%;
        border-bottom: 2px solid #059669;
        padding-bottom: 15px;
        margin-bottom: 20px;
        position: relative;
    }

    .logo {
        width: 65px;
        height: auto;
        position: absolute;
        left: 0;
        top: 5px;
    }

    .instansi {
        margin-left: 80px;
    }

    .instansi h1 {
        font-size: 18px;
        color: #059669;
        margin: 0;
        font-weight: bold;
        letter-spacing: 0.5px;
    }

    .instansi p {
        font-size: 10px;
        color: #4b5563;
        margin: 2px 0 0 0;
    }

    /* ISI LAPORAN */
    .judul-laporan {
        text-align: center;
        font-size: 14px;
        font-weight: bold;
        color: #111827;
        text-transform: uppercase;
        margin-top: 10px;
        margin-bottom: 5px;
    }

    .periode {
        text-align: center;
        font-size: 11px;
        color: #374151;
        margin-bottom: 25px;
        font-style: italic;
    }

    /* TABEL PREMIUM */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    th {
        background-color: #059669;
        color: #ffffff;
        font-weight: bold;
        text-align: left;
        padding: 10px 8px;
        text-transform: uppercase;
        font-size: 9px;
        border: 1px solid #059669;
    }

    td {
        padding: 9px 8px;
        border: 1px solid #e5e7eb;
        vertical-align: middle;
    }

    tr:nth-child(even) {
        background-color: #f0fdf4;
    }

    /* STATUS BADGE */
    .badge {
        display: inline-block;
        padding: 3px 8px;
        font-size: 8px;
        font-weight: bold;
        border-radius: 4px;
        text-align: center;
    }

    .bg-success {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .bg-warning {
        background-color: #fef9c3;
        color: #854d0e;
        border: 1px solid #fef08a;
    }

    .bg-danger {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* TTD / FOOTER */
    .ttd-wrapper {
        float: right;
        width: 220px;
        text-align: center;
        margin-top: 20px;
    }

    .ttd-space {
        height: 70px;
    }

    .nama-ttd {
        font-weight: bold;
        text-decoration: underline;
        color: #111827;
        margin-bottom: 2px;
    }

    .jabatan {
        color: #6b7280;
        font-size: 10px;
    }

    /* CLEARFIX */
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }
    </style>
</head>

<body>

    <div class="kop-surat">
        <?php 
            // Load Logo - Menggunakan path absolute
            $path = FCPATH . 'images/logo.png';
            if(file_exists($path)){
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $img_data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img_data);
                echo '<img src="'.$base64.'" class="logo">';
            }
        ?>
        <div class="instansi">
            <h1>SISTEM INFORMASI LES MENGAJI</h1>
            <p>Desan Sirnasari Kecamatan Samarang , Kampung Sampireun Jalan Baros.</p>
            <p>Email: cahayahidayah@gmail.com | Website: www.lesmengaji.com</p>
        </div>
    </div>

    <div class="judul-laporan">REKAPITULASI DATA <?= strtoupper((string)$laporan['tipe_laporan']) ?></div>
    <div class="periode">
        Periode: <?= $nama_bulan ?> <?= $laporan['periode_tahun'] ?>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th>Nama Lengkap Santri</th>
                <?php if ($laporan['tipe_laporan'] == 'pembayaran') : ?>
                <th style="width: 20%">Kategori Tagihan</th>
                <th style="width: 18%">Jumlah (Rp)</th>
                <th style="width: 12%; text-align: center;">Status</th>
                <th style="width: 15%; text-align: center;">Tgl Bayar</th>
                <?php else : ?>
                <th style="width: 25%">Mata Pelajaran & Kelas</th>
                <th style="width: 12%; text-align: center;">Status</th>
                <th style="width: 15%; text-align: center;">Tanggal</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($detail)) : ?>
            <tr>
                <td colspan="<?= ($laporan['tipe_laporan'] == 'pembayaran' ? 6 : 5) ?>"
                    style="text-align: center; color: #9ca3af; padding: 40px;">
                    Data rekapitulasi tidak ditemukan untuk periode ini.
                </td>
            </tr>
            <?php else : ?>
            <?php $no = 1; foreach ($detail as $row) : ?>
            <tr>
                <td style="text-align: center;"><?= $no++ ?></td>
                <td style="font-weight: bold; color: #111827;"><?= esc($row['nama_santri']) ?></td>

                <?php if ($laporan['tipe_laporan'] == 'pembayaran') : ?>
                <td><?= esc($row['nama_kategori'] ?? 'SPP Bulanan') ?></td>
                <td style="font-weight: bold; color: #059669; text-align: right;">
                    <?= number_format($row['jumlah_bayar'] ?? 0, 0, ',', '.') ?>
                </td>
                <td style="text-align: center;">
                    <?php 
                                    $st = strtolower((string)($row['status'] ?? 'belum'));
                                    if ($st == 'lunas') echo '<span class="badge bg-success">LUNAS</span>';
                                    elseif ($st == 'pending') echo '<span class="badge bg-warning">PENDING</span>';
                                    else echo '<span class="badge bg-danger">BELUM</span>';
                                ?>
                </td>
                <td style="text-align: center; font-size: 9px;">
                    <?= (!empty($row['tanggal_bayar']) && $row['tanggal_bayar'] !== '0000-00-00') ? date('d/m/Y', strtotime($row['tanggal_bayar'])) : '-' ?>
                </td>

                <?php else : ?>
                <td>
                    <div style="font-size: 10px; font-weight: bold;"><?= esc($row['nama_mapel'] ?? '-') ?></div>
                    <div style="font-size: 9px; color: #6b7280;"><?= esc($row['nama_kelas'] ?? '-') ?></div>
                </td>
                <td style="text-align: center;">
                    <?php 
                                    $st_abs = strtolower((string)($row['status'] ?? ''));
                                    if ($st_abs == 'hadir') echo '<span class="badge bg-success">HADIR</span>';
                                    elseif (in_array($st_abs, ['sakit', 'izin'])) echo '<span class="badge bg-warning">'.strtoupper($st_abs).'</span>';
                                    else echo '<span class="badge bg-danger">ALFA</span>';
                                ?>
                </td>
                <td style="text-align: center; font-size: 10px;">
                    <?= isset($row['tanggal']) ? date('d/m/Y', strtotime($row['tanggal'])) : '-' ?>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="clearfix">
        <div class="ttd-wrapper">
            <p style="margin-bottom: 5px;">Samarang, <?= date('d F Y') ?></p>
            <p style="margin: 0;">Petugas Administrasi,</p>
            <div class="ttd-space"></div>
            <p class="nama-ttd"><?= strtoupper(esc((string)($laporan['nama_admin'] ?? 'ADMINISTRATOR'))) ?></p>
            <p class="jabatan">NIP: SIP-<?= date('Ymd') ?>-<?= str_pad((string)$laporan['id'], 3, '0', STR_PAD_LEFT) ?>
            </p>
        </div>
    </div>

</body>

</html>
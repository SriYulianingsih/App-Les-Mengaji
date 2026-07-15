<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-7xl">

    <?php if (session()->getFlashdata('success')) : ?>
    <div
        class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-4 py-3.5 rounded-xl mb-6 shadow-sm flex items-start gap-3">
        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
        <div>
            <span class="text-sm font-bold">Berhasil!</span>
            <p class="text-xs text-emerald-700 mt-0.5"><?= session()->getFlashdata('success') ?></p>
        </div>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
    <div
        class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 px-4 py-3.5 rounded-xl mb-6 shadow-sm flex items-start gap-3">
        <i class="fas fa-exclamation-circle text-rose-500 mt-0.5"></i>
        <div>
            <span class="text-sm font-bold">Gagal!</span>
            <p class="text-xs text-rose-700 mt-0.5"><?= session()->getFlashdata('error') ?></p>
        </div>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')) : ?>
    <div
        class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 px-4 py-3.5 rounded-xl mb-6 shadow-sm flex items-start gap-3">
        <i class="fas fa-exclamation-circle text-rose-500 mt-0.5"></i>
        <div>
            <span class="text-sm font-bold">Terjadi Kesalahan!</span>
            <ul class="text-xs text-rose-700 mt-0.5 list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>

    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Laporan & Rekapitulasi</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola arsip pencetakan dan pantau statistik les mengaji secara berkala.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div
            class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl"><i
                    class="fas fa-user-graduate"></i></div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Santri</p>
                <p class="text-2xl font-extrabold text-slate-800">
                    <?= number_format($ringkasan['total_santri'], 0, ',', '.') ?> <span
                        class="text-sm font-medium text-slate-500">Anak</span></p>
            </div>
        </div>
        <div
            class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-xl flex items-center justify-center text-xl"><i
                    class="fas fa-money-bill-wave"></i></div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Kas Lunas</p>
                <p class="text-2xl font-extrabold text-slate-800">Rp
                    <?= number_format($ringkasan['total_kas'], 0, ',', '.') ?></p>
            </div>
        </div>
        <div
            class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-xl"><i
                    class="fas fa-clipboard-check"></i></div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Absensi Hari Ini</p>
                <p class="text-2xl font-extrabold text-slate-800"><?= $ringkasan['absensi_hari_ini'] ?> <span
                        class="text-sm font-medium text-slate-500">Record</span></p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm sticky top-6">
                <h2 class="text-lg font-bold text-slate-800 mb-1">Generate Laporan</h2>
                <p class="text-xs text-slate-500 mb-5">Pilih filter untuk mencatat riwayat laporan baru.</p>

                <form action="/admin/laporan/generate" method="POST" class="space-y-4">
                    <?= csrf_field() ?>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1 tracking-wider">TIPE
                            LAPORAN</label>
                        <select name="tipe_laporan" id="tipe_laporan" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="pembayaran">Keuangan & SPP</option>
                            <option value="absensi">Absensi Santri</option>
                        </select>
                    </div>

                    <div id="wrapper_kategori">
                        <label class="block text-xs font-semibold text-slate-600 mb-1 tracking-wider">KATEGORI
                            PEMBAYARAN</label>
                        <select name="kategori_id"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($kategori_list as $kat) : ?>
                            <option value="<?= $kat['id'] ?>"><?= esc($kat['nama_kategori']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="wrapper_jadwal" class="hidden">
                        <label class="block text-xs font-semibold text-slate-600 mb-1 tracking-wider">PILIH JADWAL /
                            KELAS</label>
                        <select name="jadwal_id"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">Semua Jadwal (Opsional)</option>
                            <?php foreach ($jadwal_list as $j) : ?>
                            <option value="<?= $j['id'] ?>"><?= esc($j['nama_mapel']) ?> - <?= esc($j['nama_kelas']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1 tracking-wider">BULAN</label>
                            <select name="periode_bulan" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all appearance-none cursor-pointer">
                                <?php foreach ($bulan_list as $key => $b) : ?>
                                <option value="<?= $key + 1 ?>" <?= date('n') == ($key + 1) ? 'selected' : '' ?>>
                                    <?= $b ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1 tracking-wider">TAHUN</label>
                            <input type="number" name="periode_tahun" value="<?= date('Y') ?>" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1 tracking-wider">KETERANGAN</label>
                        <textarea name="keterangan" rows="2"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                            placeholder="Misal: Laporan rutin bulanan..."></textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-3 rounded-xl text-sm shadow-md shadow-emerald-200 transition-all flex items-center justify-center gap-2 mt-2 group">
                        <i class="fas fa-save group-hover:scale-110 transition-transform"></i>
                        Simpan Arsip Log
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Arsip & Log Laporan</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar riwayat laporan yang sudah digenerate.</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead
                            class="text-xs text-slate-500 uppercase bg-slate-50/50 border-b border-slate-100 font-bold">
                            <tr>
                                <th class="px-6 py-4">Informasi Laporan</th>
                                <th class="px-6 py-4">Periode</th>
                                <th class="px-6 py-4">Admin</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (empty($riwayat_laporan)) : ?>
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-folder-open text-4xl mb-3 text-slate-200"></i>
                                        <p class="text-sm">Belum ada riwayat laporan.</p>
                                    </div>
                                </td>
                            </tr>
                            <?php else : ?>
                            <?php foreach ($riwayat_laporan as $l) : ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800">
                                            <?= $l['tipe_laporan'] === 'pembayaran' ? '💰 Keuangan & SPP' : '📝 Absensi Santri' ?>
                                        </span>
                                        <span class="text-[10px] text-slate-400 mt-1 uppercase tracking-tight">
                                            <?php 
                                                        if($l['tipe_laporan'] === 'pembayaran') echo esc($l['nama_kategori'] ?? 'Semua Kategori');
                                                        else echo esc(($l['nama_mapel'] ?? 'Semua Mapel')) . ' - ' . esc(($l['nama_kelas'] ?? 'Semua Kelas'));
                                                    ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-slate-700">
                                            <?php 
                                                        $bulan_idx = (int)$l['periode_bulan'];
                                                        echo $bulan_list[$bulan_idx-1] . " " . $l['periode_tahun'];
                                                    ?>
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-medium">Cetak:
                                            <?= date('d/m/Y', strtotime($l['tanggal_cetak'])) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                        <i class="fas fa-user-shield mr-1"></i>
                                        <?= strtoupper(esc((string)($l['nama_admin'] ?? 'ADMIN'))) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="/admin/laporan/cetakPdf/<?= $l['id'] ?>" target="_blank"
                                            class="w-9 h-9 rounded-xl text-rose-600 hover:text-white hover:bg-rose-600 inline-flex items-center justify-center transition-all border border-rose-100 hover:border-rose-600 shadow-sm"
                                            title="Download PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        <a href="/admin/laporan/delete/<?= $l['id'] ?>"
                                            onclick="return confirm('Hapus permanen arsip ini?')"
                                            class="w-9 h-9 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 inline-flex items-center justify-center transition-all border border-slate-100 hover:border-slate-800 shadow-sm"
                                            title="Hapus">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Handle dropdown filter visibility
    $('#tipe_laporan').on('change', function() {
        let tipe = $(this).val();
        if (tipe === 'pembayaran') {
            $('#wrapper_kategori').removeClass('hidden');
            $('#wrapper_jadwal').addClass('hidden');
        } else {
            $('#wrapper_kategori').addClass('hidden');
            $('#wrapper_jadwal').removeClass('hidden');
        }
    });
});
</script>

<?= $this->endSection() ?>
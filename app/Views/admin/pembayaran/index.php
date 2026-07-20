<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-4 lg:p-6 max-w-7xl">

    <?php if (session()->getFlashdata('success')) : ?>
    <div
        class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-4 py-2.5 rounded-xl mb-4 shadow-sm flex items-center gap-3">
        <i class="fas fa-check-circle text-emerald-500 text-xs"></i>
        <p class="text-[11px] font-bold"><?= session()->getFlashdata('success') ?></p>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
    <div
        class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 px-4 py-2.5 rounded-xl mb-4 shadow-sm flex items-center gap-3">
        <i class="fas fa-exclamation-circle text-rose-500 text-xs"></i>
        <p class="text-[11px] font-bold"><?= session()->getFlashdata('error') ?></p>
    </div>
    <?php endif; ?>

    <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-6 gap-4">
        <div class="text-left">
            <h1 class="text-2xl font-black text-slate-900 tracking-tighter leading-none">Kelola Pembayaran</h1>
            <p class="text-[11px] text-slate-500 mt-1 font-medium uppercase tracking-wider">Verifikasi & Buat
                Tagihan Otomatis</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <button onclick="document.getElementById('modalGenerate').classList.remove('hidden')"
                class="flex items-center gap-2 bg-slate-800 hover:bg-black text-white px-4 py-2 rounded-xl transition-all text-[10px] font-black uppercase tracking-widest">
                <i class="fas fa-bolt text-[9px]"></i> Buat Tagihan Otomatis
            </button>

            <a href="/admin/pembayaran/create"
                class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl shadow-md shadow-indigo-100 transition-all text-[10px] font-black uppercase tracking-widest">
                <i class="fas fa-plus-circle text-[9px]"></i> Tambah Pembayaran
            </a>

            <div class="bg-white px-3 py-1.5 rounded-xl border border-slate-100 shadow-sm text-center min-w-[80px]">
                <p class="text-[8px] font-black uppercase text-slate-400 leading-none mb-0.5">Total Data</p>
                <p class="text-sm font-black text-slate-800 leading-none"><?= count($pembayaran) ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[1.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50/50 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50">
                        <th class="px-5 py-4 text-center">No</th>
                        <th class="px-5 py-4">Santri & Kategori</th>
                        <th class="px-5 py-4 text-center">Periode</th>
                        <th class="px-5 py-4">Nominal</th>
                        <th class="px-5 py-4 text-center">Status</th>
                        <th class="px-5 py-4">Metode & Struk</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if (empty($pembayaran)) : ?>
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center">
                            <div class="flex flex-col items-center opacity-20">
                                <i class="fas fa-folder-open text-4xl mb-2 text-slate-300"></i>
                                <p class="text-xs font-bold text-slate-300 uppercase tracking-widest">Belum Ada Riwayat
                                    Pembayaran</p>
                            </div>
                        </td>
                    </tr>
                    <?php else : ?>
                    <?php 
                        $no = 1; 
                        $listBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
                        foreach ($pembayaran as $p) : ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-5 py-3 text-center text-[10px] font-bold text-slate-400"><?= $no++ ?></td>
                        <td class="px-5 py-3">
                            <div>
                                <p class="text-xs font-black text-slate-800 leading-tight mb-0.5"><?= esc($p['nama']) ?>
                                </p>
                                <span
                                    class="text-[8px] font-black px-1.5 py-0.5 bg-indigo-50 text-indigo-500 rounded uppercase tracking-tighter">
                                    <?= esc($p['nama_kategori'] ?? 'Umum') ?>
                                </span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <p class="text-[10px] font-bold text-slate-600 uppercase">
                                <?= $listBulan[(int)$p['bulan']] ?? '-' ?> <span
                                    class="text-slate-400"><?= esc($p['tahun']) ?></span>
                            </p>
                        </td>
                        <td class="px-5 py-3">
                            <p class="text-xs font-black text-slate-700">
                                Rp <?= number_format($p['jumlah_bayar'], 0, ',', '.') ?>
                            </p>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <?php $status = strtolower($p['status']); ?>
                            <span class="inline-flex items-center px-2 py-0.5 text-[8px] font-black rounded-full uppercase tracking-widest border 
                                    <?= $status == 'lunas' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 
                                        ($status == 'pending' ? 'bg-amber-50 text-amber-600 border-amber-100 animate-pulse' : 
                                        'bg-rose-50 text-rose-600 border-rose-100') ?>">
                                <?= $status ?>
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2">
                                <div class="text-left">
                                    <p class="text-[9px] font-black text-slate-700 leading-none uppercase italic">
                                        <?= esc($p['metode_pembayaran'] ?: '-') ?>
                                    </p>
                                    <p class="text-[8px] text-slate-400 mt-0.5">
                                        <?= ($p['tanggal_bayar']) ? date('d/m/Y', strtotime($p['tanggal_bayar'])) : 'Belum Bayar' ?>
                                    </p>
                                </div>
                                <?php if (!empty($p['bukti_pembayaran'])) : ?>
                                <a href="<?= base_url('uploads/pembayaran/' . $p['bukti_pembayaran']) ?>"
                                    target="_blank"
                                    class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-500 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-image text-[10px]"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-center gap-2">
                                <?php if ($status != 'lunas') : ?>
                                <a href="/admin/pembayaran/verifikasi/<?= $p['id'] ?>"
                                    onclick="return confirm('Sahkan LUNAS untuk santri ini?')"
                                    class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-500 hover:bg-emerald-500 hover:text-white flex items-center justify-center transition-all shadow-sm">
                                    <i class="fas fa-check text-[10px]"></i>
                                </a>
                                <?php endif; ?>
                                <a href="/admin/pembayaran/edit/<?= $p['id'] ?>"
                                    class="w-8 h-8 rounded-lg text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 flex items-center justify-center transition-all"
                                    title="Edit Data"><i class="fas fa-edit"></i>
                                </a>
                                <a href="/admin/pembayaran/delete/<?= $p['id'] ?>"
                                    onclick="return confirm('Hapus data transaksi ini secara permanen?')"
                                    class="w-8 h-8 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition-all"
                                    title="Hapus"><i class="fas fa-trash"></i>
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

<div id="modalGenerate"
    class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div
        class="bg-white rounded-[2rem] shadow-2xl w-full max-w-sm overflow-hidden animate__animated animate__zoomIn animate__faster">
        <div class="bg-slate-50 px-8 py-6 border-b border-slate-100 relative">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-tighter">Generate Tagihan Otomatis</h3>
            <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Ciptakan tagihan otomatis untuk santri aktif
            </p>
            <button onclick="document.getElementById('modalGenerate').classList.add('hidden')"
                class="absolute top-6 right-6 text-slate-300 hover:text-rose-500 transition-colors">
                <i class="fas fa-times-circle"></i>
            </button>
        </div>
        <form action="/admin/pembayaran/generateTagihan" method="POST" class="p-8">
            <div class="space-y-4">
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">Pilih
                        Kategori Pembayaran</label>
                    <select name="kategori_id" required
                        class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-4 py-3 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach($kategori as $k): ?>
                        <option value="<?= $k['id'] ?>"><?= $k['nama_kategori'] ?> (Rp
                            <?= number_format($k['nominal_std'], 0, ',', '.') ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label
                            class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">Bulan</label>
                        <select name="bulan" required
                            class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-4 py-3 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                            <?php foreach($listBulan as $num => $nama): ?>
                            <option value="<?= $num ?>" <?= $num == date('n') ? 'selected' : '' ?>><?= $nama ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">Tahun</label>
                        <input type="number" name="tahun" value="<?= date('Y') ?>" required
                            class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-4 py-3 text-xs font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                    </div>
                </div>

                <div class="bg-amber-50 p-4 rounded-2xl flex gap-3 items-start border border-amber-100">
                    <i class="fas fa-info-circle text-amber-500 mt-0.5"></i>
                    <p class="text-[9px] text-amber-700 font-bold leading-relaxed uppercase">Sistem akan otomatis
                        melewati (skip) santri yang sudah memiliki tagihan pada kategori dan periode yang sama.</p>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8">
                <button type="button" onclick="document.getElementById('modalGenerate').classList.add('hidden')"
                    class="flex-1 py-3 text-[10px] font-black uppercase text-slate-400 hover:text-slate-600 transition-colors">Batal</button>
                <button type="submit"
                    class="flex-1 bg-slate-900 hover:bg-black text-white py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-slate-200 transition-all transform active:scale-95">
                    Proses Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
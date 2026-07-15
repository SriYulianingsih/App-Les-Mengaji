<?= $this->extend('orangtua/layouts/main') ?>

<?= $this->section('content') ?>
<main class="p-4 lg:p-6 space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-100">
                <i class="fas fa-wallet text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight uppercase italic">Pembayaran</h2>
                <p class="text-[11px] text-slate-500 font-bold uppercase tracking-wider italic">Ananda: <?= $santri['nama'] ?></p>
            </div>
        </div>
        <div class="hidden md:block">
            <span class="px-4 py-2 bg-slate-100 text-slate-400 rounded-xl text-[9px] font-black uppercase italic border border-slate-200">Panel Pembayaran Aktif</span>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-xl text-xs font-bold animate-pulse">
            <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-[2rem] p-8 text-white shadow-xl relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-2 text-white">Total Terverifikasi</p>
                <h3 class="text-3xl font-black italic">Rp <?= number_format($totalLunas, 0, ',', '.') ?></h3>
            </div>
            <i class="fas fa-check-circle absolute -right-4 -bottom-4 text-8xl text-white/10 rotate-12"></i>
        </div>
        
        <div class="bg-white border border-slate-100 rounded-[2rem] p-8 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nama Anak</p>
                <h4 class="text-lg font-black text-slate-800 uppercase italic"><?= $santri['nama'] ?></h4>
            </div>
            <span class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-[10px] font-black uppercase italic border border-indigo-100">Data Sinkron</span>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center">
            <h3 class="font-black text-slate-800 uppercase text-xs tracking-widest italic">Riwayat Transaksi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Periode</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kategori</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Jumlah</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if (empty($pembayaran)) : ?>
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-xs font-bold uppercase italic">Belum ada data pembayaran</td>
                        </tr>
                    <?php endif; ?>
                    
                    <?php foreach ($pembayaran as $p) : ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="text-sm font-black text-slate-700 italic uppercase">
                                <?= $listBulan[(int)$p['bulan']] ?? '-' ?>
                            </span>
                            <span class="text-[10px] font-bold text-slate-400 block tracking-widest"><?= $p['tahun'] ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-600 text-sm italic uppercase"><?= $p['nama_kategori'] ?? 'Umum' ?></p>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter italic leading-none mt-1">
                                <?php if (strtolower($p['status']) == 'belum') : ?>
                                    <span class="text-rose-400">Menunggu Pembayaran</span>
                                <?php else : ?>
                                    <i class="fas fa- university mr-1 text-[8px]"></i> 
                                    <?= ($p['metode_pembayaran'] == 'transfer' || empty($p['metode_pembayaran'])) ? 'TRANSFER BANK / QRIS' : strtoupper($p['metode_pembayaran']) ?>
                                <?php endif; ?>
                            </p>
                        </td>
                        <td class="px-6 py-4 font-black text-slate-800 text-sm">
                            Rp <?= number_format($p['jumlah_bayar'], 0, ',', '.') ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php if (strtolower($p['status']) == 'lunas') : ?>
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-lg text-[9px] font-black uppercase italic">
                                    <i class="fas fa-check-circle mr-1"></i> <?= $p['status'] ?>
                                </span>
                            <?php elseif (strtolower($p['status']) == 'pending' || strtolower($p['status']) == 'dicek') : ?>
                                <span class="px-3 py-1 bg-amber-50 text-amber-600 border border-amber-100 rounded-lg text-[9px] font-black uppercase italic">
                                    <i class="fas fa-clock mr-1"></i> Dicek
                                </span>
                            <?php else : ?>
                                <span class="px-3 py-1 bg-rose-50 text-rose-600 border border-rose-100 rounded-lg text-[9px] font-black uppercase italic">
                                    <i class="fas fa-times-circle mr-1"></i> <?= $p['status'] ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <?php if (strtolower($p['status']) == 'belum') : ?>
                                <a href="<?= base_url('orangtua/pembayaran/bayar/'.$p['id']) ?>" class="inline-flex items-center bg-indigo-600 hover:bg-black text-white px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all shadow-lg shadow-indigo-100 hover:shadow-none">
                                    Bayar Sekarang
                                </a>
                            <?php else : ?>
                                <div class="flex items-center justify-end space-x-2">
                                    <span class="text-[9px] font-black text-slate-300 uppercase italic">Terarsip</span>
                                    <i class="fas fa-lock text-[10px] text-slate-200"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?= $this->endSection() ?>
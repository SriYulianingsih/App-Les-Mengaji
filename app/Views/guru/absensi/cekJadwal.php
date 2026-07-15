<?= $this->extend('guru/layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-6 sm:p-8">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pilih Jadwal Mengajar</h1>
        <p class="text-slate-500 mt-2 font-medium italic">Silakan pilih kelas untuk melakukan presensi santri hari ini.</p>
        
        <div class="mt-5 inline-flex items-center px-5 py-2.5 bg-emerald-50 rounded-2xl border border-emerald-100/50">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse mr-3"></div>
            <span class="text-emerald-700 font-bold text-xs uppercase tracking-widest">
                <?= $hari ?>, <?= date('d F Y') ?>
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($jadwal as $j): ?>
            <div class="stat-card glass-effect border-light rounded-[2.5rem] p-7 relative overflow-hidden shadow-soft group">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-100/30 rounded-full blur-3xl transition-all group-hover:bg-emerald-200/50"></div>
                
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-premium text-emerald-600 text-2xl transition-transform group-hover:scale-110 duration-300">
                            <i class="fa-solid fa-book-quran"></i>
                        </div>
                        
                        <?php if ($j['is_done']): ?>
                            <div class="flex flex-col items-end">
                                <span class="px-4 py-1.5 bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest rounded-full shadow-sm">
                                    <i class="fa-solid fa-circle-check mr-1"></i> Selesai
                                </span>
                            </div>
                        <?php else: ?>
                            <span class="px-4 py-1.5 bg-amber-50 text-amber-600 border border-amber-100 text-[10px] font-black uppercase tracking-widest rounded-full shadow-sm">
                                <i class="fa-solid fa-spinner animate-spin mr-1"></i> Ready
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-2xl font-black text-slate-800 leading-tight uppercase tracking-tight">
                            <?= $j['nama_kelas'] ?>
                        </h3>
                        <p class="text-slate-400 font-bold text-xs mt-1 uppercase tracking-[0.15em]">
                            <?= $j['nama_mapel'] ?? 'Materi Umum' ?>
                        </p>
                    </div>

                    <div class="flex items-center gap-4 py-4 border-y border-slate-50 mb-8">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Waktu</span>
                            <span class="text-sm font-extrabold text-slate-700 italic"><?= $j['jam_mulai'] ?> - <?= $j['jam_selesai'] ?></span>
                        </div>
                        <div class="w-[1px] h-8 bg-slate-100"></div>
                        <div class="flex flex-col">
                            <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Sesi</span>
                            <span class="text-sm font-extrabold text-slate-700">Halaqah</span>
                        </div>
                    </div>

                    <?php if ($j['is_done']): ?>
    <a href="<?= base_url('guru/absensi/view/' . $j['id'] . '/' . date('Y-m-d')) ?>" 
       class="block w-full text-center py-4 bg-slate-100 hover:bg-slate-200 text-slate-500 font-black text-[10px] uppercase tracking-[0.25em] rounded-2xl transition-all shadow-sm">
        Lihat Detail
    </a>
<?php else: ?>
    <a href="<?= base_url('guru/absensi/input/' . $j['id']) ?>" 
       class="block w-full text-center py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-[10px] uppercase tracking-[0.25em] rounded-2xl shadow-emerald-glow transition-all active:scale-95">
        Mulai Presensi
    </a>
<?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($jadwal)): ?>
        <div class="flex flex-col items-center justify-center py-24 glass-effect rounded-[3rem] border-2 border-dashed border-slate-200">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 text-4xl mb-6 shadow-inner">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
            <h3 class="text-xl font-black text-slate-800 tracking-tight italic uppercase">Afwan, Jadwal Kosong</h3>
            <p class="text-slate-400 font-medium text-sm mt-1">Tidak ada jadwal mengajar untuk antum hari ini.</p>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
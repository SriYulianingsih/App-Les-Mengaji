<?= $this->extend('guru/layouts/main') ?>
<?= $this->section('content') ?>

<main class="p-4 lg:p-6 space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-100 ring-4 ring-emerald-50">
                <i class="fas fa-calendar-check text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Jadwal Mengajar</h2>
                <p class="text-[11px] text-emerald-600 font-bold uppercase tracking-widest mt-0.5">Sesi Bimbingan & Validasi Absensi</p>
            </div>
        </div>
        <div class="flex items-center px-5 py-2.5 bg-white rounded-2xl border border-emerald-100 shadow-sm ring-1 ring-emerald-50">
            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse mr-3"></div>
            <span class="text-xs font-bold text-slate-400 mr-2">Sesi Aktif:</span>
            <span class="text-xs font-black text-emerald-700 uppercase"><?= $hariIni ?>, <?= date('d M Y') ?></span>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-rose-50 border border-rose-100 p-4 rounded-2xl flex items-center text-rose-600 space-x-3">
            <i class="fas fa-exclamation-circle"></i>
            <p class="text-xs font-bold uppercase tracking-tight"><?= session()->getFlashdata('error') ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (!empty($jadwal)) : ?>
            <?php foreach ($jadwal as $j) : ?>
                <div class="group bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-100/50 hover:border-emerald-200 transition-all duration-300 relative overflow-hidden">
                    
                    <div class="absolute -top-6 -right-6 w-20 h-20 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    
                    <div class="flex justify-between items-start mb-6 relative z-10">
                        <div>
                            <span class="px-4 py-1.5 <?= $j['is_today'] ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-500' ?> text-[10px] font-black rounded-full uppercase tracking-wider shadow-sm">
                                <?= $j['hari'] ?>
                            </span>
                            <h3 class="text-xl font-black text-slate-800 mt-3 tracking-tight italic group-hover:text-emerald-700 transition-colors leading-tight uppercase">
                                <?= $j['nama_kelas'] ?> 
                            </h3>
                            <p class="text-[10px] font-bold text-emerald-600 uppercase mt-1 tracking-widest">
                                <i class="fas fa-book-open mr-1"></i><?= $j['nama_mapel'] ?> 
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Mulai</p>
                            <div class="px-3 py-1 bg-slate-50 rounded-lg border border-slate-100">
                                <p class="text-sm font-black text-slate-700"><?= date('H:i', strtotime($j['jam_mulai'])) ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 relative z-10">
                        <div class="flex items-center text-slate-500 bg-slate-50/50 p-3 rounded-xl border border-dashed border-slate-200">
                            <i class="far fa-clock mr-3 text-emerald-500 text-sm"></i>
                            <span class="text-[11px] font-bold tracking-tight">
                                <?= date('H:i', strtotime($j['jam_mulai'])) ?> - <?= date('H:i', strtotime($j['jam_selesai'])) ?> WIB
                            </span>
                        </div>

                        <?php if ($j['is_today']) : ?>
                            <?php if ($j['is_done']) : ?>
                                <div class="space-y-2">
                                    <button disabled 
                                            class="w-full py-3.5 bg-slate-100 text-slate-400 border border-slate-200 rounded-2xl flex items-center justify-center font-black text-xs uppercase tracking-widest cursor-not-allowed">
                                        <i class="fas fa-check-double mr-2 text-emerald-500"></i>
                                        Selesai Absen
                                    </button>
                                    <a href="<?= base_url('guru/absensi/riwayat') ?>" class="block text-center text-[9px] font-black text-emerald-600 uppercase tracking-tighter hover:underline italic">
                                        Edit melalui Riwayat
                                    </a>
                                </div>
                            <?php else : ?>
                                <a href="<?= base_url('guru/absensi/input/' . $j['id'] . '/' . $tanggal) ?>" 
                                   class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl flex items-center justify-center font-black text-xs uppercase tracking-widest shadow-lg shadow-emerald-200 transition-all active:scale-95 animate-pulse-slow">
                                    <i class="fas fa-edit mr-2 text-sm"></i>
                                    Isi Absensi Sekarang
                                </a>
                            <?php endif; ?>
                        <?php else : ?>
                            <button disabled 
                                    class="w-full py-3.5 bg-slate-50 text-slate-300 border border-slate-100 rounded-2xl flex items-center justify-center font-black text-xs uppercase tracking-widest cursor-not-allowed">
                                <i class="fas fa-lock mr-2 text-sm"></i>
                                Belum Waktunya
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-span-full py-24 flex flex-col items-center justify-center bg-white rounded-[3rem] border-2 border-dashed border-slate-200 shadow-inner">
                <div class="w-20 h-20 bg-emerald-50 rounded-3xl flex items-center justify-center shadow-sm mb-6 ring-8 ring-emerald-50/50">
                    <i class="fas fa-calendar-day text-3xl text-emerald-300"></i>
                </div>
                <h4 class="font-black text-slate-800 uppercase tracking-widest text-base">Jadwal Kosong</h4>
                <p class="text-xs text-slate-400 mt-2 max-w-[200px] text-center leading-relaxed font-bold">Upps! Belum ada jadwal yang di-plot untuk Anda.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
    @keyframes pulse-slow {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.02); opacity: 0.95; }
    }
    .animate-pulse-slow {
        animation: pulse-slow 3s infinite ease-in-out;
    }
</style>

<?= $this->endSection() ?>
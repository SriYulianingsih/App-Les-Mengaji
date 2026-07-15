<?= $this->extend('guru/layouts/main') ?>

<?= $this->section('content') ?>
<main class="max-w-5xl mx-auto p-4 lg:p-8 space-y-8">
    
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 border-b border-slate-100 pb-8">
        <div class="flex items-center space-x-5">
            <div class="w-14 h-14 bg-slate-900 rounded-[1.5rem] flex items-center justify-center text-white shadow-2xl shadow-slate-200 rotate-3 group-hover:rotate-0 transition-transform">
                <i class="fas fa-history text-2xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight uppercase italic">Riwayat Presensi</h2>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1 flex items-center">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                    Log aktivitas & progres materi terpusat
                </p>
            </div>
        </div>

        <form action="<?= base_url('guru/absensi/riwayat') ?>" method="get" class="flex flex-wrap items-center gap-3">
            <div class="relative group/input flex items-center">
                <i class="fas fa-calendar-alt absolute left-4 text-slate-400 text-[10px] group-focus-within/input:text-emerald-500 transition-colors pointer-events-none z-10"></i>
                <input type="month" name="bulan" value="<?= $filterBulan ?? '' ?>" 
                       class="relative pl-10 pr-4 py-2.5 bg-white border border-slate-100 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-600 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm cursor-pointer min-w-[160px]">
            </div>
            
            <select name="kelas" class="px-4 py-2.5 bg-white border border-slate-100 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-600 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm cursor-pointer">
                <option value="">Semua Kelas</option>
                <?php if(!empty($listKelas)): foreach($listKelas as $lk): ?>
                    <option value="<?= $lk['id'] ?>" <?= ($filterKelas ?? '') == $lk['id'] ? 'selected' : '' ?>><?= $lk['nama_kelas'] ?></option>
                <?php endforeach; endif; ?>
            </select>

            <div class="flex items-center gap-2">
                <button type="submit" class="bg-slate-900 text-white w-10 h-10 rounded-xl hover:bg-emerald-600 transition-all shadow-lg shadow-slate-200 flex items-center justify-center group/btn">
                    <i class="fas fa-search text-xs group-hover/btn:scale-110 transition-transform"></i>
                </button>

                <?php if(!empty($filterBulan) || !empty($filterKelas)): ?>
                    <a href="<?= base_url('guru/absensi/riwayat') ?>" class="w-10 h-10 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-sm" title="Reset Filter">
                        <i class="fas fa-times text-xs"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="flex items-center justify-between">
        <div class="px-4 py-2 bg-slate-50 rounded-2xl border border-slate-100 flex items-center space-x-2">
            <i class="fas fa-info-circle text-emerald-500 text-[10px]"></i>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Ditemukan: <?= count($riwayat) ?> Sesi</p>
        </div>
    </div>

    <div class="grid gap-4">
        <?php if (!empty($riwayat)) : ?>
            <?php foreach ($riwayat as $r) : ?>
                <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-[0_10px_30px_rgba(0,0,0,0.02)] hover:shadow-xl hover:shadow-emerald-500/5 hover:border-emerald-100 transition-all group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50/50 rounded-full -mr-16 -mt-16 group-hover:bg-emerald-100/50 transition-colors"></div>

                    <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex items-center space-x-5">
                            <div class="w-16 h-16 bg-slate-50 rounded-[1.25rem] flex flex-col items-center justify-center border border-slate-100 group-hover:bg-emerald-600 transition-all duration-500 shadow-sm">
                                <span class="text-[9px] font-black text-slate-400 uppercase group-hover:text-emerald-100"><?= date('M', strtotime($r['tanggal'])) ?></span>
                                <span class="text-xl font-black text-slate-800 leading-none mt-1 group-hover:text-white"><?= date('d', strtotime($r['tanggal'])) ?></span>
                            </div>

                            <div>
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-base font-black text-slate-800 uppercase italic tracking-tight group-hover:text-emerald-700 transition-colors">
                                        Kelas <?= $r['nama_kelas'] ?>
                                    </h3>
                                    <span class="text-[8px] px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded-md font-black uppercase ring-1 ring-emerald-100">
                                        <?= $r['nama_mapel'] ?: 'Materi Umum' ?>
                                    </span>
                                </div>
                                <div class="flex items-center space-x-4 mt-2">
                                    <p class="text-[10px] text-slate-400 font-bold flex items-center">
                                        <i class="fas fa-users mr-1.5 text-emerald-500"></i> 
                                        <?= $r['total_santri'] ?> Santri
                                    </p>
                                    <p class="text-[10px] text-slate-400 font-bold flex items-center italic uppercase tracking-wider">
                                        <i class="fas fa-calendar-day mr-1.5 text-blue-500"></i> 
                                        <?= $r['hari'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between md:justify-end space-x-4 border-t md:border-t-0 pt-4 md:pt-0 border-slate-50">
                            <div class="hidden sm:block text-right mr-2">
                                <span class="block text-[8px] font-black text-slate-300 uppercase tracking-widest mb-1 text-right">Status Sesi</span>
                                <span class="inline-flex items-center text-[9px] px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full font-black ring-1 ring-emerald-100 uppercase">
                                    TERKIRIM
                                </span>
                            </div>
                            
                            <a href="<?= base_url('guru/absensi/input/' . $r['jadwal_id']) ?>?tanggal=<?= $r['tanggal'] ?>" 
                               class="flex items-center justify-center w-11 h-11 bg-white border border-slate-100 text-slate-400 rounded-xl hover:bg-amber-50 hover:text-amber-600 hover:border-amber-100 transition-all shadow-sm group/edit" 
                               title="Edit Presensi">
                                <i class="fas fa-edit text-xs"></i>
                            </a>

                            <a href="<?= base_url('guru/absensi/view/' . $r['jadwal_id'] . '/' . $r['tanggal']) ?>" 
                               class="flex items-center justify-center h-11 px-5 bg-slate-900 text-white rounded-xl hover:bg-emerald-600 hover:-translate-y-1 transition-all shadow-lg shadow-slate-200 active:scale-95 group/btn">
                                <span class="text-[10px] font-black uppercase tracking-widest mr-2">Detail</span>
                                <i class="fas fa-eye text-xs group-hover/btn:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="py-24 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-100">
                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-folder-open text-3xl text-slate-200"></i>
                </div>
                <h3 class="text-slate-800 font-black uppercase italic tracking-tight">Data Tidak Ditemukan</h3>
                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-2">Coba sesuaikan filter atau reset pencarian.</p>
                <a href="<?= base_url('guru/absensi/riwayat') ?>" class="inline-flex mt-8 px-8 py-3 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-full hover:bg-emerald-600 transition-colors shadow-xl shadow-slate-200">
                    Reset Filter
                </a>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
    /* Styling khusus agar input month gampang diakses */
    input[type="month"] {
        position: relative;
    }
    
    /* Munculkan icon picker bawaan browser agar user tahu itu bisa diklik */
    input[type="month"]::-webkit-calendar-picker-indicator {
        background: transparent;
        bottom: 0;
        color: transparent;
        cursor: pointer;
        height: auto;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: auto;
    }

    .group:hover .group-hover\:rotate-0 {
        transform: rotate(0deg);
    }
</style>
<?= $this->endSection() ?>
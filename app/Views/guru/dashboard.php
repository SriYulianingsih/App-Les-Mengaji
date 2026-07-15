<?= $this->extend('guru/layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-6xl mx-auto space-y-5">
    
    <?php 
        $jk = session()->get('jenis_kelamin');
        $panggilan = ($jk == 'P') ? 'Ustadzah' : 'Ustadz';
        $nama_guru = session()->get('nama') ?? 'Pengajar';
    ?>
    <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-[1.5rem] p-6 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-[9px] font-black uppercase tracking-wider border border-white/10">
                    Sesi Aktif
                </span>
                <h2 class="text-2xl font-black tracking-tight mt-2">
                    Ahlan, <span class="text-emerald-200"><?= $panggilan ?>.</span> <?= $nama_guru ?>
                </h2>
                <p class="text-emerald-50/80 text-[11px] font-medium mt-1 italic">
                    "Sebaik-baik kalian adalah yang belajar Al-Qur'an dan mengajarkannya."
                </p>
            </div>
            <div class="flex items-center px-4 py-2 bg-emerald-900/20 backdrop-blur-md border border-white/10 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-inner">
                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse mr-3"></div>
                <?= $hari_ini ?>, <?= $tanggal_indo ?? date('d M Y') ?>
            </div>
        </div>
        <i class="fas fa-quran absolute -right-6 -bottom-6 text-white/5 text-8xl -rotate-12"></i>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between group hover:border-emerald-200 transition-all">
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Total Santri</p>
                <h3 class="text-2xl font-black text-slate-800"><?= $total_santri ?></h3>
            </div>
            <div class="w-11 h-11 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                <i class="fas fa-user-graduate"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between group hover:border-sky-200 transition-all">
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Sesi Hari Ini</p>
                <h3 class="text-2xl font-black text-slate-800"><?= $total_jadwal ?></h3>
            </div>
            <div class="w-11 h-11 bg-sky-50 text-sky-600 rounded-xl flex items-center justify-center text-xl group-hover:bg-sky-600 group-hover:text-white transition-all duration-300">
                <i class="fas fa-clock"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between group hover:border-orange-200 transition-all">
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Total Record Absen</p>
                <h3 class="text-2xl font-black text-slate-800"><?= $absensi_count ?></h3>
            </div>
            <div class="w-11 h-11 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center text-xl group-hover:bg-orange-600 group-hover:text-white transition-all duration-300">
                <i class="fas fa-check-double"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[1.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
            <div>
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider italic">Jadwal Hari Ini</h3>
                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Sesi Aktif Terdaftar</p>
            </div>
            <a href="<?= base_url('guru/absensi/riwayat') ?>" class="text-[10px] font-black text-emerald-700 bg-emerald-50 px-4 py-2 rounded-lg hover:bg-emerald-600 hover:text-white transition-all">
                Riwayat Presensi <i class="fas fa-history ml-1"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[9px] uppercase tracking-widest text-slate-400 font-black border-b border-slate-50">
                        <th class="px-6 py-3">Jam Sesi</th>
                        <th class="px-6 py-3">Kelas & Mapel</th>
                        <th class="px-6 py-3 text-center">Status / Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if(!empty($jadwal_list)): foreach($jadwal_list as $j): ?>
                    <tr class="group hover:bg-emerald-50/30 transition-all">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-1 h-6 <?= $j['is_done'] ? 'bg-slate-300' : 'bg-emerald-500' ?> rounded-full"></div>
                                <span class="text-xs font-black <?= $j['is_done'] ? 'text-slate-400' : 'text-emerald-800' ?> italic">
                                    <?= date('H:i', strtotime($j['jam_mulai'])) ?> - <?= date('H:i', strtotime($j['jam_selesai'])) ?>
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-lg <?= $j['is_done'] ? 'bg-slate-50 text-slate-400' : 'bg-slate-100 text-slate-500' ?> flex items-center justify-center text-[10px] font-black group-hover:bg-white transition-colors border border-transparent group-hover:border-slate-100">
                                    <?= !empty($j['nama_kelas']) ? substr($j['nama_kelas'], 0, 1) : '?' ?>
                                </div>
                                <div>
                                    <p class="text-xs font-bold <?= $j['is_done'] ? 'text-slate-400 line-through' : 'text-slate-700' ?>">Kelas <?= $j['nama_kelas'] ?? '-' ?></p>
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-tighter"><?= $j['nama_mapel'] ?? 'Materi Umum' ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php if($j['is_done']): ?>
                                <a href="<?= base_url('guru/absensi/input/' . date('Y-m-d')) ?>" 
                                   class="inline-flex items-center px-4 py-1.5 bg-slate-100 text-slate-500 text-[9px] font-black uppercase tracking-widest rounded-lg transition-all border border-slate-200">
                                    <i class="fas fa-check-double mr-1.5"></i> Selesai
                                </a>
                            <?php else: ?>
                                <a href="<?= base_url('guru/absensi/input/' . $j['id']) ?>" 
                                   class="inline-flex items-center px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-[9px] font-black uppercase tracking-widest rounded-lg transition-all shadow-md shadow-emerald-100 active:scale-95">
                                    <i class="fas fa-pen-nib mr-1.5"></i> Absen
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center opacity-30">
                                <i class="fas fa-calendar-times text-2xl mb-2"></i>
                                <p class="text-[10px] font-black uppercase tracking-widest">Belum Ada Jadwal</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
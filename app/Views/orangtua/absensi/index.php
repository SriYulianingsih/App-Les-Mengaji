<?= $this->extend('orangtua/layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .shadow-premium { box-shadow: 0 20px 50px -12px rgba(0, 0, 0, 0.05); }
    .timeline-dot { left: 91px; }
    @media (max-width: 1024px) { .timeline-line { display: none; } }
</style>

<div class="max-w-6xl mx-auto space-y-12 animate-fade-in pb-20">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 border-b border-slate-100 pb-10">
        <div class="relative">
            <div class="flex items-center gap-3 mb-3">
                <span class="h-px w-8 bg-indigo-600"></span>
                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.4em]">Academic Journal</span>
            </div>
            <h2 class="text-4xl font-black text-slate-900 uppercase italic tracking-tighter italic">
                Presensi <span class="text-indigo-600">&</span> Progres
            </h2>
            <p class="text-slate-500 text-sm font-medium mt-2">Laporan komprehensif kehadiran dan capaian ananda.</p>
        </div>

        <div class="flex items-center gap-4 bg-white p-2 rounded-[2rem] shadow-sm border border-slate-50">
            <div class="bg-indigo-600 text-white px-6 py-4 rounded-[1.5rem] shadow-lg shadow-indigo-100">
                <p class="text-[9px] font-black uppercase tracking-widest opacity-80 mb-1 text-center">Total Hadir</p>
                <p class="text-2xl font-black italic leading-none text-center">
                    <?= count(array_filter($history, fn($h) => $h['status'] == 'hadir')) ?>
                </p>
            </div>
        </div>
    </div>

    <?php if (empty($history)): ?>
        <div class="bg-white rounded-[3rem] py-12 text-center border border-slate-50 shadow-premium">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200 text-3xl">
                <i class="fas fa-calendar-minus"></i>
            </div>
            <h3 class="text-lg font-black text-slate-800 uppercase italic">Belum Ada Data</h3>
            <p class="text-slate-400 text-xs mt-1">Data riwayat belajar ananda akan muncul secara otomatis di sini.</p>
        </div>
    <?php else: ?>
        <div class="relative">
            <div class="absolute left-24 top-0 h-full w-px bg-gradient-to-b from-slate-100 via-slate-100 to-transparent hidden lg:block"></div>

            <div class="space-y-10">
                <?php foreach ($history as $h): ?>
                    <div class="relative group">
                        <div class="absolute timeline-dot top-12 w-3 h-3 bg-white border-[3px] border-indigo-600 rounded-full z-10 hidden lg:block group-hover:scale-125 transition-all duration-300"></div>

                        <div class="grid grid-cols-1 lg:grid-cols-12 items-start">
                            
                            <div class="lg:col-span-2 hidden lg:flex flex-col items-end pr-20 pt-10">
                                <span class="text-3xl font-black text-slate-900 italic leading-none"><?= date('d', strtotime($h['tanggal'])) ?></span>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1"><?= date('M Y', strtotime($h['tanggal'])) ?></span>
                                <span class="text-[9px] font-bold text-indigo-500 uppercase mt-2 px-2 py-0.5 bg-indigo-50 rounded-md"><?= $h['hari'] ?></span>
                            </div>

                            <div class="lg:col-span-10">
                                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-premium group-hover:border-indigo-200 group-hover:shadow-2xl transition-all duration-500 overflow-hidden">
                                    <div class="flex flex-col lg:flex-row">
                                        
                                        <div class="lg:w-1/3 p-8 lg:p-10 border-b lg:border-b-0 lg:border-r border-slate-50 bg-slate-50/20">
                                            <div class="lg:hidden flex justify-between items-center mb-6">
                                                <span class="text-sm font-black text-slate-800 italic"><?= date('d M Y', strtotime($h['tanggal'])) ?> (<?= $h['hari'] ?>)</span>
                                            </div>

                                            <div class="mb-8">
                                                <?php 
                                                    $statusStyle = [
                                                        'hadir' => 'bg-emerald-500 shadow-emerald-100',
                                                        'izin'  => 'bg-amber-500 shadow-amber-100',
                                                        'sakit' => 'bg-blue-500 shadow-blue-100',
                                                        'alpha' => 'bg-rose-500 shadow-rose-100'
                                                    ];
                                                ?>
                                                <div class="inline-block px-5 py-2 <?= $statusStyle[$h['status']] ?? 'bg-slate-400' ?> text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg mb-4">
                                                    <?= $h['status'] ?>
                                                </div>
                                                <h4 class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Mata Pelajaran</h4>
                                                <p class="text-lg font-black text-slate-800 italic uppercase tracking-tighter leading-tight"><?= $h['nama_mapel'] ?></p>
                                            </div>

                                            <div class="pt-6 border-t border-slate-100">
                                                <p class="text-[11px] text-slate-500 font-bold italic leading-relaxed">
                                                    <i class="fas fa-info-circle text-slate-300 mr-1 italic"></i>
                                                    "<?= $h['keterangan'] ?: 'Data presensi telah tercatat di sistem.' ?>"
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex-1 p-8 lg:p-10 flex flex-col justify-center">
                                            <?php if ($h['status'] == 'hadir'): ?>
                                                <div class="flex items-center gap-3 mb-8">
                                                    <div class="w-8 h-8 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-[10px]">
                                                        <i class="fas fa-book-reader"></i>
                                                    </div>
                                                    <h4 class="text-[10px] font-black text-slate-900 uppercase tracking-widest">Progress Capaian Materi</h4>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                                                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                                                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Materi Awal</span>
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-2 h-2 rounded-full bg-slate-200"></div>
                                                            <p class="text-xs font-black text-slate-700 italic uppercase"><?= $h['materi_mulai'] ?: 'Mulai Sesi' ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm ring-4 ring-indigo-50/30">
                                                        <span class="text-[9px] font-black text-indigo-400 uppercase tracking-widest block mb-2">Capaian Akhir</span>
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                                                            <p class="text-xs font-black text-indigo-600 italic uppercase"><?= $h['materi_selesai'] ?: 'Belum Diinput' ?></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="bg-slate-900 rounded-[2rem] p-6 lg:p-8 text-white relative overflow-hidden shadow-xl">
                                                    <div class="relative z-10">
                                                        <div class="flex items-center gap-2 mb-4">
                                                            <i class="fas fa-comment-alt text-indigo-400 text-[10px]"></i>
                                                            <span class="text-[9px] font-black uppercase tracking-widest text-indigo-300">Catatan Pengajar</span>
                                                        </div>
                                                        <p class="text-xs font-medium italic leading-relaxed opacity-90 tracking-wide">
                                                            <?= $h['catatan_guru'] ?: 'Alhamdulillah, kegiatan belajar berjalan lancar.' ?>
                                                        </p>
                                                    </div>
                                                    <i class="fas fa-quote-right absolute -bottom-4 -right-2 text-6xl opacity-10 rotate-12"></i>
                                                </div>

                                            <?php else: ?>
                                                <div class="text-center py-10 px-6">
                                                    <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-6">
                                                        <i class="fas fa-mug-hot text-xl"></i>
                                                    </div>
                                                    <h4 class="text-sm font-black text-slate-800 uppercase italic tracking-widest mb-2">Tidak Ada Aktivitas Belajar</h4>
                                                    <p class="text-[11px] text-slate-400 font-medium max-w-xs mx-auto leading-relaxed uppercase tracking-tighter">
                                                        Jurnal progres hanya tersedia saat ananda berstatus <span class="text-indigo-600">Hadir</span> di kelas.
                                                    </p>
                                                    
                                                    <div class="mt-8 pt-8 border-t border-slate-50 inline-block">
                                                        <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">
                                                            <?php 
                                                                if($h['status'] == 'sakit') echo "Semoga Cepat Sembuh";
                                                                elseif($h['status'] == 'izin') echo "Sampai Jumpa di Sesi Berikutnya";
                                                                else echo "Sistem Presensi Otomatis";
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
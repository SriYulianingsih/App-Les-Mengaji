<?= $this->extend('guru/layouts/main') ?>

<?= $this->section('content') ?>
<main class="max-w-6xl mx-auto p-4 lg:p-8 space-y-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-slate-100 pb-8">
        <div class="flex items-center space-x-5">
            <a href="<?= base_url('guru/absensi/riwayat') ?>" 
               class="w-12 h-12 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:border-emerald-100 hover:shadow-xl transition-all shadow-sm group">
                <i class="fas fa-arrow-left text-sm group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight italic uppercase leading-none">
                    <?= $title ?>
                </h2>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] flex items-center mt-2">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                    Laporan Presensi: <?= date('d M Y', strtotime($tanggal)) ?>
                </p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <a href="<?= base_url('guru/absensi/input/' . $jadwal_id) ?>?tanggal=<?= $tanggal ?>" 
               class="flex items-center px-6 py-3.5 bg-slate-900 text-white rounded-2xl hover:bg-emerald-600 transition-all shadow-xl shadow-slate-200 active:scale-95 group">
                <i class="fas fa-edit text-[10px] mr-3 group-hover:rotate-12 transition-transform"></i>
                <span class="text-[10px] font-black uppercase tracking-[0.2em]">Edit Laporan</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                <i class="fa-solid fa-school"></i>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Kelas</p>
                <p class="text-sm font-black text-slate-800 uppercase italic leading-tight"><?= $absensi[0]['nama_kelas'] ?? '-' ?></p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                <i class="fa-solid fa-book-quran"></i>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Mata Pelajaran</p>
                <p class="text-sm font-black text-slate-800 uppercase italic leading-tight"><?= $absensi[0]['nama_mapel'] ?? 'Halaqah / Materi Umum' ?></p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Waktu Presensi</p>
                <p class="text-sm font-black text-slate-800 uppercase italic leading-tight"><?= $absensi[0]['jam_mulai'] ?? '00:00' ?> - Selesai</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-1/4">Data Santri</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Status</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-1/4">Capaian Progres</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Catatan / Ket</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if (!empty($absensi)) : ?>
                        <?php foreach ($absensi as $a) : ?>
                        <tr class="group hover:bg-emerald-50/5 transition-all duration-300">
                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-4">
                                    <div class="w-11 h-11 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 font-black text-xs group-hover:bg-emerald-600 group-hover:text-white transition-all shadow-sm">
                                        <?= strtoupper(substr($a['nama'] ?? 'S', 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-slate-800 uppercase italic leading-none"><?= $a['nama'] ?></p>
                                        <p class="text-[9px] text-slate-400 font-bold uppercase mt-1.5 tracking-widest"><?= $a['nis'] ?: '-' ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <?php 
                                    // SINKRONISASI DATABASE ENUM (lowercase)
                                    $st = strtolower($a['status'] ?? 'hadir');
                                    $statusConfig = [
                                        'hadir' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'ring' => 'ring-emerald-100', 'label' => 'HADIR'],
                                        'izin'  => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'ring' => 'ring-amber-100', 'label' => 'IZIN'],
                                        'sakit' => ['bg' => 'bg-sky-50', 'text' => 'text-sky-600', 'ring' => 'ring-sky-100', 'label' => 'SAKIT'],
                                        'alpha' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'ring' => 'ring-rose-100', 'label' => 'ALPHA']
                                    ];
                                    $conf = $statusConfig[$st] ?? ['bg' => 'bg-slate-50', 'text' => 'text-slate-400', 'ring' => 'ring-slate-100', 'label' => strtoupper($st)];
                                ?>
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-[9px] font-black uppercase ring-1 ring-inset <?= $conf['bg'] ?> <?= $conf['text'] ?> <?= $conf['ring'] ?>">
                                    <?= $conf['label'] ?>
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <?php 
                                    $mulai = trim($a['materi_mulai'] ?? '');
                                    $selesai = trim($a['materi_selesai'] ?? '');
                                    
                                    if($st == 'hadir' && (!empty($mulai) || !empty($selesai))): 
                                ?>
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-slate-50 border border-slate-100 px-3 py-1.5 rounded-lg text-[10px] font-black text-slate-600 min-w-[35px] text-center">
                                            <?= $mulai ?: '-' ?>
                                        </div>
                                        <i class="fas fa-arrow-right text-emerald-400 text-[8px]"></i>
                                        <div class="bg-emerald-600 px-3 py-1.5 rounded-lg text-[10px] font-black text-white shadow-lg shadow-emerald-100 min-w-[35px] text-center">
                                            <?= $selesai ?: '-' ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="flex items-center space-x-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-200"></span>
                                        <span class="text-[9px] font-black italic uppercase tracking-widest text-slate-300">Nihil Progres</span>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-6">
                                <div class="max-w-xs">
                                    <p class="text-[10px] text-slate-500 font-bold italic leading-relaxed">
                                        <?php 
                                            if ($st == 'hadir') {
                                                echo !empty($a['catatan_guru']) ? '"' . $a['catatan_guru'] . '"' : '<span class="text-slate-200">Tidak ada catatan</span>';
                                            } else {
                                                echo !empty($a['keterangan']) ? 'Ket: ' . $a['keterangan'] : '<span class="text-slate-200 italic">Tanpa keterangan</span>';
                                            }
                                        ?>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-8 py-24 text-center">
                                <i class="fas fa-folder-open text-slate-200 text-3xl mb-4 block"></i>
                                <p class="text-slate-400 font-black italic uppercase tracking-[0.3em] text-xs">Data Belum Diinput</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-emerald-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-emerald-100">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center space-x-5">
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md shadow-inner">
                    <i class="fas fa-database text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 leading-none">Database Status</p>
                    <p class="text-sm font-black italic uppercase mt-2 tracking-wide">Data Terkoneksi & Sinkron</p>
                </div>
            </div>
            <div class="text-center md:text-right hidden md:block">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80 leading-none">Smart-System v2.0</p>
                <p class="text-[10px] font-bold mt-1 italic opacity-90 tracking-wide">Data ini telah masuk ke dalam rekapitulasi nilai bulanan santri.</p>
            </div>
        </div>
    </div>
</main>

<style>
    .custom-scrollbar::-webkit-scrollbar { height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #10b981; }
</style>
<?= $this->endSection() ?>
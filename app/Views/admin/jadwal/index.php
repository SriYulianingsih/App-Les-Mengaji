<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-7xl">

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-4 py-3.5 rounded-xl mb-6 shadow-sm flex items-start gap-3">
            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
            <div>
                <span class="text-sm font-bold">Berhasil!</span>
                <p class="text-xs text-emerald-700 mt-0.5"><?= session()->getFlashdata('success') ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 px-4 py-3.5 rounded-xl mb-6 shadow-sm flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-rose-500 mt-0.5"></i>
            <div>
                <span class="text-sm font-bold">Terjadi Kesalahan:</span>
                <ul class="text-xs mt-0.5 list-disc list-inside text-rose-700">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Jadwal Pelajaran</h1>
            <p class="text-sm text-slate-500 mt-1">Atur dan pantau jam mengajar guru, mata pelajaran, serta pembagian kelas.</p>
        </div>
        
        <div>
            <a href="/admin/jadwal/create" 
               class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-medium px-5 py-2.5 rounded-xl text-sm shadow-lg shadow-indigo-100 transition-all duration-200 transform hover:-translate-y-0.5">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Jadwal</span>
            </a>
        </div>
    </div>

    <?php if (empty($jadwal)) : ?>
        <div class="bg-white rounded-2xl border border-slate-150 p-12 text-center">
            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Belum Ada Jadwal</h3>
            <p class="text-sm text-slate-500 mt-1 mb-6">Klik tombol di kanan atas untuk menambahkan jadwal pelajaran pertama.</p>
        </div>
    <?php else : ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <?php foreach ($jadwal as $j) : ?>
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-indigo-100 transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-5">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[11px] font-black uppercase tracking-wider bg-slate-100 text-slate-600">
                                <i class="far fa-calendar-alt mr-1.5"></i><?= esc($j['hari']) ?>
                            </span>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[11px] font-black uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <i class="fas fa-door-open mr-1.5"></i><?= esc($j['nama_kelas']) ?>
                            </span>
                        </div>

                        <div class="mb-5">
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Mata Pelajaran</p>
                            <h3 class="text-lg font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">
                                <?= esc($j['nama_mapel'] ?? 'Umum') ?>
                            </h3>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-sm shadow-sm">
                                    <i class="far fa-clock"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Waktu</p>
                                    <p class="text-sm font-bold text-slate-800">
                                        <?= date('H:i', strtotime($j['jam_mulai'])) ?> - <?= date('H:i', strtotime($j['jam_selesai'])) ?> WIB
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-sm shadow-sm">
                                   <?= strtoupper(substr((string)esc($j['nama_guru']), 0, 1)) ?>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Guru Pengampu</p>
                                    <p class="text-sm font-bold text-slate-800 truncate w-40"><?= esc($j['nama_guru']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50/50 px-6 py-4 border-t border-slate-100 flex items-center justify-between group-hover:bg-indigo-50/30 transition-all">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">ID: #<?= $j['id'] ?></span>
                        <div class="flex items-center gap-2">
                            <a href="/admin/jadwal/edit/<?= $j['id'] ?>" 
                               class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:shadow-sm flex items-center justify-center transition-all" 
                               title="Edit Jadwal">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <a href="/admin/jadwal/delete/<?= $j['id'] ?>" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')" 
                               class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-rose-600 hover:border-rose-200 hover:shadow-sm flex items-center justify-center transition-all" 
                               title="Hapus Jadwal">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </a>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
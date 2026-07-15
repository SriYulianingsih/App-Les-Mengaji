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
                <span class="text-sm font-bold">Gagal!</span>
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
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Data Kelas</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola pembagian kelas dan pantau populasi santri di setiap jenjang.</p>
        </div>
        
        <a href="/admin/kelas/create" 
           class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-medium px-5 py-2.5 rounded-xl text-sm shadow-lg shadow-indigo-100 transition-all duration-200 transform hover:-translate-y-0.5">
            <i class="fas fa-plus-circle"></i>
            <span>Tambah Kelas</span>
        </a>
    </div>

    <?php if (empty($kelas)) : ?>
        <div class="bg-white rounded-3xl border border-slate-150 p-16 text-center shadow-sm">
            <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-3xl flex items-center justify-center mx-auto mb-4 text-3xl">
                <i class="fas fa-school"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800">Belum Ada Kelas</h3>
            <p class="text-sm text-slate-500 mt-1 mb-8">Data kelas belum tersedia di database.</p>
            <a href="/admin/kelas/create" class="text-indigo-600 font-bold text-sm hover:underline">Mulai Tambah Kelas <i class="fas fa-arrow-right ml-1"></i></a>
        </div>
    <?php else : ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($kelas as $k) : ?>
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-indigo-100 transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-5">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <i class="fas fa-layer-group mr-1.5"></i><?= esc($k['tingkat']) ?>
                            </span>
                        </div>

                        <div class="mb-6">
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mb-1">Nama Kelas</p>
                            <h3 class="text-xl font-black text-slate-800 group-hover:text-indigo-600 transition-colors tracking-tight">
                                <?= esc($k['nama_kelas']) ?>
                            </h3>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl group-hover:bg-indigo-50 transition-colors">
                            <div class="w-10 h-10 bg-white text-slate-400 rounded-xl flex items-center justify-center text-sm shadow-sm group-hover:text-indigo-500 transition-colors">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Total Santri</p>
                                <p class="text-sm font-black <?= $k['total_santri'] > 0 ? 'text-indigo-600' : 'text-slate-400 italic' ?>">
                                    <?= $k['total_santri'] ?> <span class="text-[10px] font-medium text-slate-400 uppercase ml-0.5">Orang</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50/50 px-6 py-4 border-t border-slate-100 flex items-center justify-between group-hover:bg-indigo-50/30 transition-all">
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-tighter">System ID</span>
                            <span class="text-[10px] font-bold text-slate-500">#<?= substr($k['id'], 0, 8) ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="/admin/kelas/edit/<?= $k['id'] ?>" 
                               class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-200 hover:shadow-sm flex items-center justify-center transition-all">
                                <i class="fas fa-pen text-[10px]"></i>
                            </a>
                            <a href="/admin/kelas/delete/<?= $k['id'] ?>" 
                               onclick="return confirm('Hapus kelas ini? Pastikan tidak ada santri di dalamnya.')" 
                               class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-200 hover:shadow-sm flex items-center justify-center transition-all">
                                <i class="fas fa-trash-alt text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>/
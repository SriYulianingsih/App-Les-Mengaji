<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-4xl">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Buat Mapel Baru</h1>
        <p class="text-sm text-slate-500 mt-1">Tambahkan materi pelajaran baru ke dalam sistem kurikulum.</p>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <form action="/admin/mapel/store" method="POST" class="p-8 space-y-6">
            <?= csrf_field() ?>
            <div class="space-y-6">
                <div>
                    <label class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2">Nama Mata Pelajaran <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <i class="fas fa-book-open absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm group-focus-within:text-indigo-500 transition-colors"></i>
                        <input type="text" name="nama_mapel" placeholder="Misal: Fiqih Ibadah" required
                               class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-bold text-slate-700">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2">Keterangan Singkat</label>
                    <div class="relative group">
                        <i class="fas fa-align-left absolute left-4 top-5 text-slate-400 text-sm group-focus-within:text-indigo-500 transition-colors"></i>
                        <textarea name="keterangan" rows="3" placeholder="Jelaskan sedikit tentang mapel ini..."
                                  class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-medium text-slate-700"></textarea>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                <a href="/admin/mapel" class="px-6 py-3 border border-slate-200 rounded-2xl text-sm text-slate-600 hover:bg-slate-50 font-bold transition-all flex items-center gap-2">
                    <i class="fas fa-arrow-left text-xs"></i> Batal
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-8 py-3 rounded-2xl text-sm shadow-lg shadow-indigo-100 transition-all transform hover:-translate-y-1">
                    <i class="fas fa-save mr-2"></i> Simpan Mapel
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
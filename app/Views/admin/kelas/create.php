<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-4xl">

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

    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Tambah Kelas Baru</h1>
        <p class="text-sm text-slate-500 mt-1">Buat kelompok belajar atau ruang kelas baru untuk kegiatan belajar mengaji.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <form action="/admin/kelas/store" method="POST" class="p-6 md:p-8 space-y-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-4">
                <div>
                    <label for="nama_kelas" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2">Nama Kelas / Kelompok <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <i class="fas fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm group-focus-within:text-indigo-500 transition-colors"></i>
                        <input type="text" name="nama_kelas" id="nama_kelas" value="<?= old('nama_kelas') ?>" placeholder="Contoh: Kelas Al-Fatih / Privat A1" required
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-bold text-slate-700">
                    </div>
                </div>

                <div>
                    <label for="tingkat" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2">Jenjang Pendidikan <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <i class="fas fa-layer-group absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm group-focus-within:text-indigo-500 transition-colors"></i>
                        <select name="tingkat" id="tingkat" required
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer font-bold text-slate-700">
                            <option value="">-- Pilih Jenjang --</option>
                            <?php $selectedTingkat = old('tingkat'); ?>
                            <optgroup label="Dasar & Tahsin">
                                <option value="Iqra" <?= $selectedTingkat == 'Iqra' ? 'selected' : '' ?>>Program Iqra'</option>
                                <option value="Tahsin" <?= $selectedTingkat == 'Tahsin' ? 'selected' : '' ?>>Tahsin Tilawah</option>
                            </optgroup>
                            <optgroup label="Madrasah Diniyyah">
                                <option value="Awaliyah" <?= $selectedTingkat == 'Awaliyah' ? 'selected' : '' ?>>Diniyyah Awaliyah</option>
                                <option value="Wustha" <?= $selectedTingkat == 'Wustha' ? 'selected' : '' ?>>Diniyyah Wustha</option>
                                <option value="Ulya" <?= $selectedTingkat == 'Ulya' ? 'selected' : '' ?>>Diniyyah Ulya</option>
                            </optgroup>
                            <optgroup label="Tahfidz & Kitab">
                                <option value="Tahfidz" <?= $selectedTingkat == 'Tahfidz' ? 'selected' : '' ?>>Tahfidz Al-Qur'an</option>
                                <option value="Kitab" <?= $selectedTingkat == 'Kitab' ? 'selected' : '' ?>>Kajian Kitab Kuning</option>
                            </optgroup>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-8 border-t border-slate-100 mt-4">
                <a href="/admin/kelas" class="px-6 py-3 border border-slate-200 rounded-2xl text-sm text-slate-600 hover:bg-slate-50 font-bold transition-all flex items-center gap-2">
                    <i class="fas fa-arrow-left text-xs"></i> Batal
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold px-8 py-3 rounded-2xl text-sm shadow-lg shadow-indigo-100 transition-all duration-200 transform hover:-translate-y-1 active:scale-95">
                    <i class="fas fa-save"></i>
                    <span>Simpan Kelas</span>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
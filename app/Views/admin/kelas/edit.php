<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-4xl">

    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Data Kelas</h1>
        <p class="text-sm text-slate-500 mt-1">Perbarui informasi nama kelas atau jenjang pendidikan madrasah.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="h-1.5 w-full bg-indigo-400"></div>

        <form action="/admin/kelas/update/<?= $kelas['id'] ?>" method="POST" class="p-6 md:p-8 space-y-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-4">
                <div>
                    <label for="nama_kelas"
                        class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2 text-left">Nama
                        Kelas / Kelompok <span class="text-rose-500">*</span></label>
                    <div class="relative group text-left">
                        <i
                            class="fas fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm group-focus-within:text-indigo-500 transition-colors"></i>
                        <input type="text" name="nama_kelas" id="nama_kelas"
                            value="<?= old('nama_kelas', $kelas['nama_kelas']) ?>" required
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-bold text-slate-700">
                    </div>
                </div>

                <div>
                    <label for="tingkat"
                        class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2 text-left">Jenjang
                        Pendidikan <span class="text-rose-500">*</span></label>
                    <div class="relative group text-left">
                        <i
                            class="fas fa-layer-group absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm group-focus-within:text-indigo-500 transition-colors"></i>
                        <select name="tingkat" id="tingkat" required
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer font-bold text-slate-700">
                            <?php $currentTingkat = old('tingkat', $kelas['tingkat']); ?>
                            <optgroup label="Dasar & Tahsin">
                                <option value="Iqra" <?= $currentTingkat == 'Iqra' ? 'selected' : '' ?>>Program Iqra'
                                </option>
                                <option value="Tahsin" <?= $currentTingkat == 'Tahsin' ? 'selected' : '' ?>>Tahsin
                                    Tilawah</option>
                            </optgroup>
                            <optgroup label="Madrasah Diniyyah">
                                <option value="Awaliyah" <?= $currentTingkat == 'Awaliyah' ? 'selected' : '' ?>>Diniyyah
                                    Awaliyah</option>
                                <option value="Wustha" <?= $currentTingkat == 'Wustha' ? 'selected' : '' ?>>Diniyyah
                                    Wustha</option>
                                <option value="Ulya" <?= $currentTingkat == 'Ulya' ? 'selected' : '' ?>>Diniyyah Ulya
                                </option>
                            </optgroup>
                            <optgroup label="Tahfidz & Kitab">
                                <option value="Tahfidz" <?= $currentTingkat == 'Tahfidz' ? 'selected' : '' ?>>Tahfidz
                                    Al-Qur'an</option>
                                <option value="Kitab" <?= $currentTingkat == 'Kitab' ? 'selected' : '' ?>>Kajian Kitab
                                    Kuning</option>
                            </optgroup>
                        </select>
                        <i
                            class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-8 border-t border-slate-100 mt-4">
                <a href="/admin/kelas"
                    class="px-6 py-3 border border-slate-200 rounded-2xl text-sm text-slate-600 hover:bg-slate-50 font-bold transition-all flex items-center gap-2">
                    <i class="fas fa-times text-xs"></i> Batal
                </a>

                <button type="submit"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-bold px-8 py-3 rounded-2xl text-sm shadow-lg shadow-indigo-100 transition-all duration-200 transform hover:-translate-y-1 active:scale-95">
                    <i class="fas fa-check-circle"></i>
                    <span>Perbarui Data</span>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
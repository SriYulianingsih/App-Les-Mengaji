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
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Tambah Jadwal Baru</h1>
        <p class="text-sm text-slate-500 mt-1">Hubungkan Guru, Mata Pelajaran, dan Kelas ke dalam satu jadwal mengajar.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <form action="/admin/jadwal/store" method="POST" class="p-6 md:p-8 space-y-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="guru_id" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2">Guru Pengampu <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-user-tie absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <select name="guru_id" id="guru_id" required
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">-- Pilih Guru --</option>
                            <?php foreach ($guru as $g) : ?>
                                <option value="<?= $g['id'] ?>" <?= old('guru_id') == $g['id'] ? 'selected' : '' ?>>
                                    <?= esc($g['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
                    </div>
                </div>

                <div>
                    <label for="mapel_id" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2">Mata Pelajaran <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-book absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <select name="mapel_id" id="mapel_id" required
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            <?php foreach ($mapel as $m) : ?>
                                <option value="<?= $m['id'] ?>" <?= old('mapel_id') == $m['id'] ? 'selected' : '' ?>>
                                    <?= esc($m['nama_mapel']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="hari" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2">Hari <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <i class="far fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <select name="hari" id="hari" required
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">-- Pilih Hari --</option>
                            <?php foreach ($hari_list as $h) : ?>
                                <option value="<?= $h ?>" <?= old('hari') == $h ? 'selected' : '' ?>><?= $h ?></option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
                    </div>
                </div>

                <div>
                    <label for="kelas_id" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2">Ruang / Kelas <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-door-open absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <select name="kelas_id" id="kelas_id" required
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">-- Pilih Kelas --</option>
                            <?php foreach ($kelas as $k) : ?>
                                <option value="<?= $k['id'] ?>" <?= old('kelas_id') == $k['id'] ? 'selected' : '' ?>>
                                    Kelas <?= esc($k['nama_kelas']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-4">
                <div>
                    <label for="jam_mulai" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2">Jam Mulai <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <i class="far fa-clock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="time" name="jam_mulai" id="jam_mulai" value="<?= old('jam_mulai') ?>" required
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all cursor-pointer">
                    </div>
                </div>

                <div>
                    <label for="jam_selesai" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2">Jam Selesai <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <i class="far fa-clock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="time" name="jam_selesai" id="jam_selesai" value="<?= old('jam_selesai') ?>" required
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all cursor-pointer">
                    </div>
                    <p class="text-[10px] text-amber-600 font-bold mt-2 uppercase tracking-tight">
                        <i class="fas fa-info-circle mr-1"></i> Jam selesai harus lebih besar dari jam mulai.
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-between pt-8 border-t border-slate-100 mt-4">
                <a href="/admin/jadwal" class="px-6 py-3 border border-slate-200 rounded-2xl text-sm text-slate-600 hover:bg-slate-50 font-bold transition-all flex items-center gap-2">
                    <i class="fas fa-arrow-left text-xs"></i> Batal
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold px-8 py-3 rounded-2xl text-sm shadow-lg shadow-indigo-100 transition-all duration-200 transform hover:-translate-y-1 active:scale-95">
                    <i class="fas fa-save"></i>
                    <span>Simpan Jadwal</span>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
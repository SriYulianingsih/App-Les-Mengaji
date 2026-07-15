<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-4xl" x-data="{ role: '<?= $role ?>' }">

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
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Buat Akun Baru</h1>
        <p class="text-sm text-slate-500 mt-1">Silakan isi formulir di bawah ini untuk menambahkan hak akses baru.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <form action="/admin/akun/store" method="POST" class="p-6 md:p-8 space-y-6">
            <?= csrf_field() ?>

            <input type="hidden" name="role" :value="role">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="username" class="block text-sm font-semibold text-slate-700 mb-2">Username <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" name="username" id="username" value="<?= old('username') ?>" required
                               placeholder="Contoh: ahmad123"
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5">Minimal 4 karakter dan harus unik.</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password <span class="text-rose-500">*</span></label>
                    <div class="relative" x-data="{ show: false }">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input :type="show ? 'text' : 'password'" name="password" id="password" required
                               placeholder="••••••••"
                               class="w-full pl-11 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                            <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5">Minimal 6 karakter kombinasi huruf & angka.</p>
                </div>
            </div>

            <div x-show="role !== 'admin'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4">
                <hr class="border-slate-100 my-6">
                
                <div>
                    <label for="target_id" class="block text-sm font-semibold text-slate-700 mb-2">
                        Hubungkan ke Data <span class="capitalize" x-text="role"></span> <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fas fa-link absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <select name="target_id" id="target_id" :required="role !== 'admin'"
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">-- Pilih <span class="capitalize" x-text="role"></span> --</option>
                            
                            <?php foreach ($dataTersedia as $item) : ?>
                                <option value="<?= $item['id'] ?>">
                                    <?php if ($role === 'guru') : ?>
                                        <?= esc($item['nama']) ?>
                                    <?php elseif ($role === 'orangtua') : ?>
                                        Bpk. <?= esc($item['nama_ayah']) ?> / Ibu <?= esc($item['nama_ibu']) ?>
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5">Hanya menampilkan data yang belum memiliki akun aplikasi.</p>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-slate-100 mt-6">
                <a href="/admin/akun" class="px-5 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-600 hover:bg-slate-50 font-medium transition-all flex items-center gap-2">
                    <i class="fas fa-arrow-left text-xs"></i> Kembali
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium px-6 py-2.5 rounded-xl text-sm shadow-lg shadow-emerald-100 transition-all duration-200 transform hover:-translate-y-0.5">
                    <i class="fas fa-save"></i>
                    <span>Simpan Akun</span>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
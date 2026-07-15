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
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Akun Pengguna</h1>
        <p class="text-sm text-slate-500 mt-1">Ubah data login atau perbarui password untuk akun ini.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <form action="/admin/akun/update/<?= $user['id'] ?>" method="POST" class="p-6 md:p-8 space-y-6">
            <?= csrf_field() ?>

            <div class="bg-slate-50 p-4 rounded-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                        <?= strtoupper(substr($user['username'], 0, 1)) ?>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-medium">Role Akun</p>
                        <p class="text-sm font-bold text-slate-800 capitalize"><?= esc($user['role']) ?></p>
                    </div>
                </div>

                <?php if ($user['role'] !== 'admin') : ?>
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-slate-500">Terkoneksi ke:</span>
                    <span class="font-semibold text-slate-800 bg-white px-3 py-1.5 rounded-lg border border-slate-200 flex items-center gap-1.5">
                        <i class="fas fa-link text-emerald-500 text-xs"></i> 
                        <?= esc($nama_lengkap) ?>
                    </span>
                </div>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                <div>
                    <label for="username" class="block text-sm font-semibold text-slate-700 mb-2">Username <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" name="username" id="username" value="<?= old('username', $user['username']) ?>" required
                               placeholder="Contoh: ahmad123"
                               class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5">Minimal 4 karakter dan harus unik.</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
                    <div class="relative" x-data="{ show: false }">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input :type="show ? 'text' : 'password'" name="password" id="password"
                               placeholder="••••••••"
                               class="w-full pl-11 pr-12 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                        <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                            <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    <p class="text-xs text-amber-600 font-medium mt-1.5"><i class="fas fa-info-circle text-xs"></i> Kosongkan jika tidak ingin mengubah password.</p>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-slate-100 mt-6">
                <a href="/admin/akun" class="px-5 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-600 hover:bg-slate-50 font-medium transition-all flex items-center gap-2">
                    <i class="fas fa-arrow-left text-xs"></i> Kembali
                </a>
                
                <button type="submit" 
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium px-6 py-2.5 rounded-xl text-sm shadow-lg shadow-emerald-100 transition-all duration-200 transform hover:-translate-y-0.5">
                    <i class="fas fa-save"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
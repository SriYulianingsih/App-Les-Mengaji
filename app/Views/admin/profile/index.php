<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-5xl">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Profil Saya</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola informasi akun dan amankan kata sandi Anda.</p>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-4 py-3.5 rounded-lg mb-6 shadow-sm flex items-center">
            <svg class="w-5 h-5 text-emerald-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="text-sm font-medium"><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 px-4 py-3.5 rounded-lg mb-6 shadow-sm flex items-center">
            <svg class="w-5 h-5 text-rose-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            <span class="text-sm font-medium"><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 px-4 py-3.5 rounded-lg mb-6 shadow-sm">
            <div class="flex items-center mb-1">
                <svg class="w-5 h-5 text-rose-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                <span class="font-bold text-sm">Gagal Memperbarui Password:</span>
            </div>
            <ul class="list-disc ml-7 text-xs space-y-0.5">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-6 h-fit">
            <div class="flex flex-col items-center text-center">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white font-bold text-3xl shadow-md ring-4 ring-indigo-50">
                    <?= strtoupper(substr($user['username'], 0, 1)) ?>
                </div>
                <h2 class="mt-4 text-xl font-bold text-gray-800"><?= esc($user['username']) ?></h2>
                <span class="mt-1 px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-full uppercase"><?= esc($user['role']) ?></span>
            </div>

            <div class="border-t border-gray-100 pt-4 space-y-3">
                <div>
                    <p class="text-xs text-gray-400 font-medium">Username</p>
                    <p class="text-sm font-semibold text-gray-700 mt-0.5"><?= esc($user['username']) ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Terdaftar Sejak</p>
                    <p class="text-sm font-semibold text-gray-700 mt-0.5"><?= date('d F Y', strtotime($user['created_at'])) ?></p>
                </div>
            </div>
        </div>

        <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3">Ganti Kata Sandi</h2>

            <form action="/admin/profile/updatePassword" method="POST" class="mt-5 space-y-5">
                <?= csrf_field() ?>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Password Saat Ini <span class="text-rose-500">*</span></label>
                    <input type="password" name="password_lama" required class="mt-1.5 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm" placeholder="••••••••">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Password Baru <span class="text-rose-500">*</span></label>
                        <input type="password" name="password_baru" required class="mt-1.5 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm" placeholder="Min. 5 karakter">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Konfirmasi Password Baru <span class="text-rose-500">*</span></label>
                        <input type="password" name="konfirmasi_password" required class="mt-1.5 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm" placeholder="Ulangi password baru">
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold px-6 py-2.5 rounded-lg text-sm shadow-md shadow-indigo-100 transition-all duration-200 transform hover:-translate-y-0.5">
                        Perbarui Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
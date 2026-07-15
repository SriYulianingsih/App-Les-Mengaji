<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mx-auto p-6 max-w-7xl">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard Admin</h1>
        <p class="text-sm text-gray-500 mt-1">Selamat datang kembali! Berikut ringkasan aktivitas aplikasi les hari ini.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Santri</p>
                    <h2 class="text-3xl font-bold text-gray-900 mt-1"><?= $total_santri ?? 0 ?></h2>
                </div>
                <div class="p-2.5 bg-indigo-50 rounded-xl group-hover:bg-indigo-100 transition-colors">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs font-medium text-emerald-600">
                <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                        clip-rule="evenodd"></path>
                </svg>
                <span>Siswa aktif bimbingan</span>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Guru</p>
                    <h2 class="text-3xl font-bold text-gray-900 mt-1"><?= $total_guru ?? 0 ?></h2>
                </div>
                <div class="p-2.5 bg-sky-50 rounded-xl group-hover:bg-sky-100 transition-colors">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs font-medium text-sky-600">
                <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <span>Pengajar aktif terdaftar</span>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pembayaran</p>
                    <h2 class="text-3xl font-bold text-gray-900 mt-1"><?= $total_bayar ?? 0 ?></h2>
                </div>
                <div class="p-2.5 bg-emerald-50 rounded-xl group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 022 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs font-medium text-emerald-600">
                <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <span>Seluruh dana terkumpul</span>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Absensi</p>
                    <h2 class="text-3xl font-bold text-gray-900 mt-1"><?= $total_absensi ?? 0 ?></h2>
                </div>
                <div class="p-2.5 bg-rose-50 rounded-xl group-hover:bg-rose-100 transition-colors">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs font-medium text-gray-500">
                <span>Kehadiran terekap</span>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Santri Terbaru</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Siswa yang baru saja bergabung.</p>
                </div>
                <a href="/admin/santri"
                    class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 bg-indigo-50 px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition-colors">
                    Lihat Semua
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left bg-gray-50/80 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <th class="px-4 py-3 rounded-l-lg">Santri</th>
                            <th class="px-4 py-3">NIS</th>
                            <th class="px-4 py-3 text-center rounded-r-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php if(!empty($santri_terbaru)): ?>
                        <?php foreach($santri_terbaru as $s): ?>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-4 py-3 flex items-center gap-3">

                                <div
                                    class="flex-shrink-0 w-9 h-9 rounded-full overflow-hidden border-2 border-indigo-50 shadow-sm">
                                    <?php if(!empty($s['foto']) && file_exists(FCPATH . 'uploads/santri/' . $s['foto'])): ?>
                                    <img src="<?= base_url('uploads/santri/' . $s['foto']) ?>" alt="Foto"
                                        class="w-full h-full object-cover">
                                    <?php else: ?>
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm">
                                        <?= strtoupper(substr((string)esc($s['nama']), 0, 1)) ?>
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <span class="font-semibold text-gray-700"><?= esc($s['nama']) ?></span>
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2.5 py-0.5 rounded-md border border-indigo-100"><?= esc($s['nis'] ?? '-') ?></span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="/admin/santri/detail/<?= $s['id'] ?>"
                                    class="text-gray-400 hover:text-indigo-600 transition-colors inline-flex items-center justify-center p-2 hover:bg-indigo-50 rounded-lg"
                                    title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-gray-400">
                                <svg class="w-10 h-10 mx-auto text-gray-200 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                                <span class="text-xs font-medium">Belum ada data santri baru.</span>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="mb-5">
                <h2 class="text-lg font-bold text-gray-800">Akses Cepat</h2>
                <p class="text-xs text-gray-400 mt-0.5">Navigasi instan ke modul penting.</p>
            </div>

            <div class="space-y-3">
                <a href="/admin/santri/create"
                    class="flex items-center justify-between p-3.5 bg-gray-50/70 rounded-xl hover:bg-indigo-50/50 transition-colors border border-gray-50 group">
                    <div class="flex items-center gap-3">
                        <div
                            class="p-1.5 bg-white rounded-lg border border-gray-100 text-indigo-500 group-hover:text-indigo-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700 group-hover:text-indigo-700">Daftarkan
                            Santri</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-500 transform group-hover:translate-x-0.5 transition-all"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <a href="/admin/pembayaran"
                    class="flex items-center justify-between p-3.5 bg-gray-50/70 rounded-xl hover:bg-emerald-50/50 transition-colors border border-gray-50 group">
                    <div class="flex items-center gap-3">
                        <div
                            class="p-1.5 bg-white rounded-lg border border-gray-100 text-emerald-500 group-hover:text-emerald-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700 group-hover:text-emerald-700">Validasi
                            Pembayaran</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-500 transform group-hover:translate-x-0.5 transition-all"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
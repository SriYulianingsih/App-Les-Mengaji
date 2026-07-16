<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-7xl">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Manajemen Guru</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data tenaga pengajar aktif dan non-aktif di sini.</p>
        </div>
        <a href="/admin/guru/create"
            class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-medium px-5 py-2.5 rounded-xl text-sm flex items-center shadow-lg shadow-indigo-100 transition-all duration-200 transform hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            Tambah Guru
        </a>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
    <div
        class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-4 py-3.5 rounded-lg mb-6 shadow-sm flex items-center gap-3">
        <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="text-sm font-medium"><?= session()->getFlashdata('success') ?></span>
    </div>
    <?php endif; ?>

    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="/admin/guru" method="get" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" name="q" value="<?= esc($keyword) ?>" placeholder="Cari nama atau NIP..." P
                    class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm">
            </div>
            <div class="flex gap-2">
                <button type="submit"
                    class="bg-gray-900 text-white px-5 py-2.5 rounded-lg hover:bg-gray-800 transition-all text-sm font-medium">Cari
                    Data</button>
                <?php if ($keyword) : ?>
                <a href="/admin/guru"
                    class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg hover:bg-gray-200 transition-all text-sm font-medium flex items-center">Reset</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-50/80 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                        <th class="px-6 py-4">Foto</th>
                        <th class="px-6 py-4">Nama Guru</th>
                        <th class="px-6 py-4">NIP</th>
                        <th class="px-6 py-4">Pendidikan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    <?php if (empty($guru)) : ?>
                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-400 bg-gray-50/50">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707.293l-2.414-2.414A1 1 0 006.586 13H4">
                                </path>
                            </svg>
                            Belum ada data guru yang terdaftar.
                        </td>
                    </tr>
                    <?php else : ?>
                    <?php foreach ($guru as $g) : ?>
                    <tr class="hover:bg-indigo-50/30 transition-all duration-150">
                        <td class="px-6 py-4">
                            <div class="flex-shrink-0 w-11 h-11">
                                <?php if (!empty($g['foto'])) : ?>
                                <img class="w-full h-full rounded-xl object-cover shadow-sm ring-1 ring-gray-100"
                                    src="/uploads/guru/<?= $g['foto'] ?>" alt="Foto"
                                    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=<?= urlencode($g['nama']) ?>&color=7F9CF5&background=EBF4FF&bold=true';">
                                <?php else : ?>
                                <div
                                    class="w-full h-full rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-base shadow-sm border border-indigo-50">
                                    <?= strtoupper(substr((string)esc($g['nama']), 0, 1)) ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-900 font-semibold text-base"><?= esc($g['nama']) ?></div>
                            <div class="text-xs text-gray-500 mt-0.5 flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                <?= esc($g['no_hp'] ?? '-') ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="text-indigo-600 text-xs font-bold bg-indigo-50 px-2 py-1 rounded-md border border-indigo-100">
                                <?= esc($g['nip']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="text-gray-700 font-medium bg-gray-50 px-2.5 py-1 rounded-md text-xs border border-gray-100"><?= esc($g['pendidikan'] ?: 'Belum Diisi') ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2.5 py-1 text-xs font-bold rounded-full inline-block <?= $g['status'] == 'aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100' ?>">
                                <?= ucfirst((string)esc($g['status'])) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="/admin/guru/detail/<?= $g['id'] ?>"
                                    class="text-gray-600 hover:text-emerald-600 font-medium transition-all p-1.5 hover:bg-emerald-50 rounded-lg"
                                    title="Detail Profil">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </a>

                                <a href="/admin/guru/edit/<?= $g['id'] ?>"
                                    class="text-gray-600 hover:text-indigo-600 font-medium transition-all p-1.5 hover:bg-indigo-50 rounded-lg"
                                    title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.828 2.828 0 114 4L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </a>

                                <a href="/admin/guru/delete/<?= $g['id'] ?>"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data guru ini? Tindakan ini tidak dapat dibatalkan.')"
                                    class="text-gray-400 hover:text-rose-600 font-medium transition-all p-1.5 hover:bg-rose-50 rounded-lg"
                                    title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        <?= $pager->links('guru', 'default_full') ?>
    </div>
</div>
<?= $this->endSection() ?>
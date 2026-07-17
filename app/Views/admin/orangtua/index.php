<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-7xl">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Manajemen Orang Tua</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data wali dan orang tua santri secara profesional.</p>
        </div>
        <a href="/admin/orangtua/create" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium px-5 py-2.5 rounded-xl text-sm flex items-center shadow-lg shadow-emerald-100 transition-all duration-200 transform hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Orang Tua
        </a>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-4 py-3.5 rounded-lg mb-6 shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="text-sm font-medium"><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>

    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form action="/admin/orangtua" method="get" class="flex flex-col sm:flex-row gap-3">
            <div class="relative w-full md:w-1/3">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="q" value="<?= esc($keyword) ?>" placeholder="Cari nama ayah, ibu, atau no. hp..." class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-gray-900 text-white px-5 py-2.5 rounded-lg hover:bg-gray-800 transition-all text-sm font-medium">Cari Data</button>
                <?php if ($keyword) : ?>
                    <a href="/admin/orangtua" class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg hover:bg-gray-200 transition-all text-sm font-medium flex items-center">Reset</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-50/80 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                        <th class="px-6 py-4">Nama Orang Tua</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Domisili</th>
                        <th class="px-6 py-4">Status Akun</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    <?php if (empty($orangtua)) : ?>
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-400 bg-gray-50/50">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                Belum ada data orang tua yang terdaftar.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($orangtua as $ortu) : ?>
                            <tr class="hover:bg-emerald-50/30 transition-all duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-sm shadow-sm flex-shrink-0">
                                            <?= strtoupper(substr((string)esc($ortu['nama_ayah']), 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="text-gray-900 font-semibold text-base">Ayah: <?= esc($ortu['nama_ayah']) ?></div>
                                            <div class="text-xs text-gray-500 mt-0.5">Ibu: <?= esc($ortu['nama_ibu']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-column gap-1">
                                        <div class="text-sm text-gray-700 font-medium flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            <?= esc($ortu['no_hp']) ?>
                                        </div>
                                        <div class="text-xs text-gray-400 flex items-center mt-0.5">
                                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            <?= esc($ortu['email'] ?: '-') ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-700 font-medium bg-gray-50 px-2.5 py-1 rounded-md text-xs border border-gray-100 inline-flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <?= esc($ortu['kecamatan'] ?: 'Belum Diisi') ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if (!empty($ortu['username'])) : ?>
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-full inline-block bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            Terhubung (<?= esc($ortu['username']) ?>)
                                        </span>
                                    <?php else : ?>
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-full inline-block bg-gray-50 text-gray-500 border border-gray-100">
                                            Belum Ada Akun
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="/admin/orangtua/detail/<?= $ortu['id'] ?>" class="text-gray-600 hover:text-emerald-600 font-medium transition-all p-1.5 hover:bg-emerald-50 rounded-lg" title="Detail Profil">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        
                                        <a href="/admin/orangtua/edit/<?= $ortu['id'] ?>" class="text-gray-600 hover:text-indigo-600 font-medium transition-all p-1.5 hover:bg-indigo-50 rounded-lg" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.828 2.828 0 114 4L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        
                                        <a href="/admin/orangtua/delete/<?= $ortu['id'] ?>" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus data orang tua ini? Tindakan ini tidak dapat dibatalkan.')" 
                                           class="text-gray-400 hover:text-rose-600 font-medium transition-all p-1.5 hover:bg-rose-50 rounded-lg" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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

    <div class="mt-6 flex justify-end">
        <?= $pager->links('orangtua', 'default_full') ?>
    </div>
</div>

<style>
.pagination {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin: 0;
}

.pagination .page-item {
    list-style: none;
}

.pagination .page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 2.6rem;
    height: 2.6rem;
    padding: 0 0.8rem;
    border: 1px solid #e2e8f0;
    border-radius: 9999px;
    background: #ffffff;
    color: #475569;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 700;
    transition: all 0.2s ease;
}

.pagination .page-link:hover {
    border-color: #8b5cf6;
    color: #6d28d9;
    box-shadow: 0 8px 20px rgba(109, 40, 217, 0.12);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #7c3aed, #8b5cf6);
    border-color: #7c3aed;
    color: #ffffff;
    box-shadow: 0 10px 24px rgba(124, 58, 237, 0.25);
}

.pagination .page-item.disabled .page-link {
    opacity: 0.5;
    pointer-events: none;
    cursor: not-allowed;
    background: #f8fafc;
}

.pagination .page-item:first-child .page-link,
.pagination .page-item:last-child .page-link {
    min-width: 5rem;
    padding: 0 1rem;
}
</style>
<?= $this->endSection() ?>
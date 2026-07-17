<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-7xl">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Manajemen Santri</h1>
            <p class="text-sm text-slate-500 mt-1">Total terdaftar: <span
                    class="font-bold text-indigo-600">Terdata</span> di sistem pesantren.</p>
        </div>
        <a href="/admin/santri/create"
            class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold px-6 py-3 rounded-2xl text-sm flex items-center shadow-lg shadow-indigo-100 transition-all duration-200 transform hover:-translate-y-1 active:scale-95">
            <i class="fas fa-user-plus mr-2 text-xs"></i>
            Tambah Santri Baru
        </a>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
    <div
        class="bg-emerald-50 border border-emerald-100 text-emerald-800 px-4 py-3.5 rounded-2xl mb-6 shadow-sm flex items-center gap-3 animate-fade-in">
        <div class="bg-emerald-500 text-white p-1 rounded-full">
            <i class="fas fa-check text-[10px]"></i>
        </div>
        <span class="text-sm font-semibold"><?= session()->getFlashdata('success') ?></span>
    </div>
    <?php endif; ?>

    <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 mb-6">
        <form action="/admin/santri" method="get" class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" name="q" value="<?= esc($keyword) ?>"
                    placeholder="Cari nama, NIS, atau nama orang tua..."
                    class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm">
            </div>
            <div class="flex gap-2">
                <button type="submit"
                    class="bg-slate-900 text-white px-8 py-3 rounded-2xl hover:bg-slate-800 transition-all text-sm font-bold shadow-md">
                    Cari Data
                </button>
                <?php if ($keyword) : ?>
                <a href="/admin/santri"
                    class="bg-slate-100 text-slate-600 px-6 py-3 rounded-2xl hover:bg-slate-200 transition-all text-sm font-bold flex items-center">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr
                        class="bg-slate-50/50 border-b border-slate-100 text-left text-[11px] font-black text-slate-500 uppercase tracking-[0.1em]">
                        <th class="px-8 py-5">Profil Santri</th>
                        <th class="px-6 py-5">NIS</th>
                        <th class="px-6 py-5">Kelas & Orang Tua</th>
                        <th class="px-6 py-5 text-center">Status</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-50">
                    <?php if (empty($santri)) : ?>
                    <tr>
                        <td colspan="5" class="text-center py-20 text-slate-400">
                            <i class="fas fa-user-slash text-4xl mb-4 block opacity-20"></i>
                            <p class="text-sm">Data santri tidak ditemukan atau masih kosong.</p>
                        </td>
                    </tr>
                    <?php else : ?>
                    <?php foreach ($santri as $s) : ?>
                    <tr class="hover:bg-slate-50/80 transition-all group">
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <div class="relative flex-shrink-0 w-12 h-12">
                                    <?php if (!empty($s['foto'])) : ?>
                                    <img class="w-full h-full rounded-2xl object-cover shadow-sm ring-2 ring-white group-hover:ring-indigo-100 transition-all"
                                        src="/uploads/santri/<?= $s['foto'] ?>" alt="Foto"
                                        onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=<?= urlencode($s['nama']) ?>&color=6366f1&background=EEF2FF&bold=true';">
                                    <?php else : ?>
                                    <div
                                        class="w-full h-full rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-lg border border-indigo-100 shadow-sm">
                                        <?= strtoupper(substr((string)esc($s['nama']), 0, 1)) ?>
                                    </div>
                                    <?php endif; ?>
                                    <div
                                        class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white <?= $s['status'] == 'aktif' ? 'bg-emerald-500' : 'bg-slate-300' ?>">
                                    </div>
                                </div>
                                <div>
                                    <div
                                        class="text-slate-900 font-bold text-base group-hover:text-indigo-600 transition-colors">
                                        <?= esc($s['nama']) ?></div>
                                    <div class="text-[11px] text-slate-400 font-medium flex items-center gap-1">
                                        <i class="fas fa-phone-alt text-[9px]"></i>
                                        <?= esc($s['no_hp'] ?? 'No HP belum ada') ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="text-indigo-600 text-[11px] font-black bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100 uppercase tracking-wider">
                                <?= esc($s['nis']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-slate-700 font-bold text-xs mb-0.5">
                                <i class="fas fa-door-open text-slate-300 mr-1"></i>
                                <?= esc($s['nama_kelas'] ?: 'Belum Masuk Kelas') ?>
                            </div>
                            <div class="text-slate-400 text-[11px]">
                                Wali: <?= esc($s['nama_ayah'] ?: '-') ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span
                                class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full inline-block <?= $s['status'] == 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-500' ?>">
                                <?= esc($s['status']) ? ucfirst($s['status']) : 'Belum Aktif' ?>
                            </span>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <div
                                class="flex items-center justify-end gap-2 transition-all transform translate-x-2 group-hover:translate-x-0">
                                <a href="/admin/santri/detail/<?= $s['id'] ?>" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200
                                text-slate-600 rounded-xl hover:bg-emerald-50 hover:text-emerald-600
                                hover:border-emerald-200 transition-all shadow-sm" title="Detail">
                                    <i class="far fa-eye text-sm"></i>
                                </a>
                                <a href="/admin/santri/edit/<?= $s['id'] ?>"
                                    class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm"
                                    title="Edit">
                                    <i class="far fa-edit text-sm"></i>
                                </a>
                                <a href="/admin/santri/delete/<?= $s['id'] ?>"
                                    onclick="return confirm('Hapus data santri ini?')"
                                    class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all shadow-sm"
                                    title="Hapus">
                                    <i class="far fa-trash-alt text-sm"></i>
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
        <?= $pager->links('santri', 'default_full') ?>
    </div>
</div>

<style>
.animate-fade-in {
    animation: fadeIn 0.4s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

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
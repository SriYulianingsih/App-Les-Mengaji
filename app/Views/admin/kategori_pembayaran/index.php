<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-7xl">

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-4 py-3.5 rounded-xl mb-6 shadow-sm flex items-start gap-3">
            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
            <div class="text-xs font-bold"><?= session()->getFlashdata('success') ?></div>
        </div>
    <?php endif; ?>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4 text-left">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kategori Pembayaran</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola jenis tagihan dan iuran standar santri.</p>
        </div>
        <a href="/admin/kategori-pembayaran/create" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded-2xl text-sm shadow-lg shadow-indigo-100 transition-all transform hover:-translate-y-0.5">
            <i class="fas fa-plus-circle"></i> Tambah Kategori
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">
                    <th class="px-8 py-6">Jenis Pembayaran</th>
                    <th class="px-8 py-6">Nominal Standar</th>
                    <th class="px-8 py-6 text-right">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php foreach ($kategori as $k) : ?>
                <tr class="hover:bg-slate-50/30 transition-colors group">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fas fa-wallet text-xs"></i>
                            </div>
                            <span class="text-sm font-black text-slate-800"><?= esc($k['nama_kategori']) ?></span>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-sm font-bold text-slate-700">Rp <?= number_format($k['nominal_std'], 0, ',', '.') ?></span>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="/admin/kategori-pembayaran/edit/<?= $k['id'] ?>" class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-200 flex items-center justify-center transition-all">
                                <i class="fas fa-pen text-[10px]"></i>
                            </a>
                            <a href="/admin/kategori-pembayaran/delete/<?= $k['id'] ?>" onclick="return confirm('Hapus kategori ini?')" class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-200 flex items-center justify-center transition-all">
                                <i class="fas fa-trash-alt text-[10px]"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
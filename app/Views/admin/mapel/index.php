<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-7xl">

    <?php if (session()->getFlashdata('success')) : ?>
    <div
        class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-4 py-3.5 rounded-xl mb-6 shadow-sm flex items-start gap-3">
        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
        <div class="text-xs font-bold"><?= session()->getFlashdata('success') ?></div>
    </div>
    <?php endif; ?>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Mata Pelajaran</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar materi pembelajaran yang tersedia di madrasah.</p>
        </div>
        <a href="/admin/mapel/create"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-xl text-sm shadow-lg shadow-indigo-100 transition-all transform hover:-translate-y-0.5">
            <i class="fas fa-plus-circle"></i> Tambah Mapel
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Nama Mata
                            Pelajaran</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">
                            Keterangan</th>
                        <th
                            class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach ($mapel as $m) : ?>
                    <tr class="hover:bg-slate-50/30 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-black shadow-sm group-hover:scale-110 transition-transform">
                                    <?= strtoupper(substr($m['nama_mapel'], 0, 1)) ?>
                                </div>
                                <span
                                    class="text-sm font-black text-slate-800 tracking-tight"><?= esc($m['nama_mapel']) ?></span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-xs text-slate-500 font-medium leading-relaxed italic opacity-80">
                                <?= $m['keterangan'] ?: 'Belum ada deskripsi...' ?>
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="/admin/mapel/edit/<?= $m['id'] ?>"
                                    class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-200 flex items-center justify-center transition-all">
                                    <i class="fas fa-pen text-[10px]"></i>
                                </a>
                                <a href="/admin/mapel/delete/<?= $m['id'] ?>"
                                    onclick="return confirm('Hapus mapel ini?')"
                                    class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-200 flex items-center justify-center transition-all">
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
</div>
<?= $this->endSection() ?>
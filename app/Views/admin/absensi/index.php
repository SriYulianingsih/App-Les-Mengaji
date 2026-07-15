<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-7xl">

    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-6 text-left">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Rekap Presensi & Progres</h1>
            <p class="text-sm text-slate-500 mt-1">Pantau kehadiran santri beserta capaian materi belajarnya secara real-time.</p>
        </div>

        <form action="/admin/absensi" method="GET" class="flex flex-wrap items-end gap-3 bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex flex-col">
                <label class="text-[10px] font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">Tanggal</label>
                <div class="relative group">
                    <i class="far fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors text-xs"></i>
                    <input type="date" name="tanggal" value="<?= $filter_tgl ?>" onchange="this.form.submit()"
                           class="pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold shadow-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                </div>
            </div>
            
            <div class="flex flex-col">
                <label class="text-[10px] font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">Pilih Kelas</label>
                <div class="relative group">
                    <i class="fas fa-door-open absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors text-xs"></i>
                    <select name="kelas" onchange="this.form.submit()"
                            class="pl-10 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold shadow-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none appearance-none transition-all">
                        <option value="">Semua Kelas</option>
                        <?php foreach ($list_kelas as $k) : ?>
                            <option value="<?= $k['id'] ?>" <?= $filter_kls == $k['id'] ? 'selected' : '' ?>><?= $k['nama_kelas'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 text-[9px] pointer-events-none"></i>
                </div>
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2 rounded-xl text-xs shadow-lg shadow-indigo-100 transition-all flex items-center gap-2 active:scale-95">
                <i class="fas fa-sync-alt text-[10px]"></i> Refresh
            </button>
        </form>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden text-left">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/50 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50">
                        <th class="px-8 py-6">Santri & Kelas</th>
                        <th class="px-8 py-6">Status Kehadiran</th>
                        <th class="px-8 py-6">Materi / Mapel</th>
                        <th class="px-8 py-6">Capaian Progres</th>
                        <th class="px-8 py-6">Catatan Pengajar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if (empty($absensi)) : ?>
                        <tr>
                            <td colspan="5" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-calendar-day text-slate-200 text-3xl"></i>
                                    </div>
                                    <p class="text-sm font-bold text-slate-400">Belum ada data presensi ditemukan</p>
                                    <p class="text-[10px] text-slate-300 uppercase tracking-widest mt-1">Coba sesuaikan tanggal atau filter kelas</p>
                                </div>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($absensi as $a) : ?>
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 font-black text-xs group-hover:bg-indigo-50 group-hover:text-indigo-500 transition-colors uppercase">
                                        <?= substr($a['nama_santri'], 0, 2) ?>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800 leading-none mb-1.5"><?= esc($a['nama_santri']) ?></p>
                                        <span class="text-[9px] px-2 py-0.5 bg-slate-100 text-slate-500 rounded-md font-black uppercase tracking-wider"><?= esc($a['nama_kelas']) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <?php 
                                    $statusStyle = [
                                        'Hadir' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'Izin'  => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'Sakit' => 'bg-sky-50 text-sky-600 border-sky-100',
                                        'Alpa'  => 'bg-rose-50 text-rose-600 border-rose-100',
                                        'Alfa'  => 'bg-rose-50 text-rose-600 border-rose-100',
                                    ];
                                    $curStatus = ucfirst(strtolower($a['status']));
                                    $style = $statusStyle[$curStatus] ?? 'bg-slate-50 text-slate-400 border-slate-100';
                                ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-black rounded-full border <?= $style ?> uppercase tracking-widest">
                                    <span class="w-1 h-1 rounded-full bg-current"></span>
                                    <?= $curStatus ?>
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-indigo-400"></div>
                                    <p class="text-xs font-bold text-slate-700"><?= esc($a['nama_mapel'] ?? 'Pelajaran Umum') ?></p>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <?php if ($a['materi_selesai']) : ?>
                                    <div class="bg-indigo-50/50 p-3 rounded-2xl border border-indigo-100/50">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex justify-between items-center text-[9px] uppercase font-black text-slate-400 tracking-tighter">
                                                <span>Mulai</span>
                                                <i class="fas fa-arrow-right text-[7px] text-indigo-300"></i>
                                                <span class="text-indigo-600">Selesai</span>
                                            </div>
                                            <div class="flex justify-between items-center text-[11px] font-black text-slate-700 leading-none mt-1">
                                                <span><?= esc($a['materi_mulai']) ?></span>
                                                <span><?= esc($a['materi_selesai']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <span class="text-[10px] text-slate-300 italic font-medium tracking-tight">Tidak ada input materi</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-6">
                                <div class="max-w-[180px]">
                                    <p class="text-[11px] text-slate-500 leading-relaxed font-medium italic line-clamp-2">
                                        <?= $a['catatan_guru'] ? '"'.esc($a['catatan_guru']).'"' : '<span class="text-slate-200">Tidak ada catatan</span>' ?>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
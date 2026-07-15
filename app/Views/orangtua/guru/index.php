<?= $this->extend('orangtua/layouts/main') ?>
<?= $this->section('content') ?>

<div class="p-6">
    <div class="mb-8">
        <div class="flex items-center space-x-3 mb-2">
            <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-100">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Guru Pengajar</h1>
        </div>
        <p class="text-sm text-slate-500">Daftar ustadz/ustadzah yang mengajar <span class="font-bold text-slate-700 italic"><?= session()->get('active_santri_nama') ?></span></p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (!empty($guru)) : ?>
            <?php foreach ($guru as $row) : ?>
                <?php 
                    // Bersihkan & Format Nomor WA
                    $phone = preg_replace('/[^0-9]/', '', $row['no_hp']);
                    if (str_starts_with($phone, '0')) {
                        $wa_formatted = '62' . substr($phone, 1);
                    } else {
                        $wa_formatted = $phone;
                    }
                    
                    $pesan_wa = urlencode("Assalamu'alaikum Ustadz/ah " . $row['nama'] . ", saya wali santri dari " . session()->get('active_santri_nama') . "...");
                ?>
                
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group p-6">
                    <div class="flex flex-col items-center text-center">
                        <div class="relative mb-4">
                            <div class="w-24 h-24 rounded-[2rem] overflow-hidden ring-4 ring-slate-50 group-hover:ring-indigo-50 transition-all">
                                <?php if (!empty($row['foto'])) : ?>
                                    <img src="<?= base_url('uploads/guru/' . $row['foto']) ?>" class="w-full h-full object-cover">
                                <?php else : ?>
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($row['nama']) ?>&background=6366f1&color=fff&size=128" class="w-full h-full object-cover">
                                <?php endif; ?>
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-green-500 border-4 border-white rounded-full flex items-center justify-center">
                                <i class="fab fa-whatsapp text-white text-[10px]"></i>
                            </div>
                        </div>

                        <h3 class="font-bold text-slate-800 mb-1 group-hover:text-indigo-600 transition-colors"><?= $row['nama'] ?></h3>
                        <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase tracking-wider mb-4">
                            <?= $row['nama_mapel'] ?? 'Pengajar' ?>
                        </span>
                        
                        <div class="w-full grid grid-cols-2 gap-2 mb-6">
                            <div class="bg-slate-50 p-2 rounded-2xl">
                                <p class="text-[9px] text-slate-400 uppercase font-bold">Kelas</p>
                                <p class="text-xs font-semibold text-slate-700"><?= $row['nama_kelas'] ?></p>
                            </div>
                            <div class="bg-slate-50 p-2 rounded-2xl">
                                <p class="text-[9px] text-slate-400 uppercase font-bold">Pendidikan</p>
                                <p class="text-xs font-semibold text-slate-700 truncate"><?= $row['pendidikan'] ?: '-' ?></p>
                            </div>
                        </div>

                        <a href="https://wa.me/<?= $wa_formatted ?>?text=<?= $pesan_wa ?>" 
                           target="_blank"
                           class="w-full py-3 bg-slate-900 group-hover:bg-green-500 text-white rounded-2xl font-bold text-sm transition-all duration-300 flex items-center justify-center space-x-2">
                            <i class="fab fa-whatsapp"></i>
                            <span>Hubungi Guru</span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-span-full bg-white rounded-[3rem] p-12 text-center border-2 border-dashed border-slate-100">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-tie text-3xl text-slate-300"></i>
                </div>
                <h2 class="text-lg font-bold text-slate-700">Belum Ada Data Guru</h2>
                <p class="text-sm text-slate-400">Jadwal pengajar untuk Ananda belum tersedia.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
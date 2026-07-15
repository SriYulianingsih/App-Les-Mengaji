<?= $this->extend('guru/layouts/main') ?>

<?= $this->section('content') ?>
<main class="max-w-6xl mx-auto p-4 lg:p-8 space-y-8">
    
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-slate-100 pb-8">
        <div>
            <div class="flex items-center space-x-2 mb-2">
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[9px] font-black uppercase tracking-[0.2em] rounded-lg">
                    <?= $jadwal['nama_mapel'] ?? 'Materi Umum' ?>
                </span>
            </div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight flex items-center italic uppercase">
                <span class="w-2.5 h-10 bg-emerald-500 rounded-full mr-4 shadow-lg shadow-emerald-200"></span>
                Presensi Kelas <?= $jadwal['nama_kelas'] ?>
            </h2>
            <p class="text-slate-400 text-[10px] font-black mt-2 flex items-center uppercase tracking-[0.2em]">
                <i class="fas fa-fingerprint text-emerald-500 mr-2 text-xs"></i>
                Pembaruan data otomatis sinkron ke riwayat & progres materi
            </p>
        </div>
        
        <div class="flex items-center space-x-4 bg-white border border-slate-100 px-6 py-3 rounded-[1.5rem] shadow-sm hover:shadow-md transition-shadow">
            <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-sm shadow-inner">
                <i class="fas fa-calendar-alt italic"></i>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none">Sesi Aktif</p>
                <p class="text-xs font-black text-slate-700 mt-1 uppercase"><?= $hari_ini ?>, <?= date('d M Y', strtotime($tanggal)) ?></p>
            </div>
        </div>
    </div>

    <form action="<?= base_url('guru/absensi/simpan') ?>" method="POST" class="pb-24">
        <?= csrf_field() ?>
        <input type="hidden" name="jadwal_id" value="<?= $jadwal['id'] ?>">
        <input type="hidden" name="tanggal" value="<?= $tanggal ?>">

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden mb-10">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse min-w-[1000px]">
                    <thead class="bg-slate-50/50 border-b border-slate-100">
                        <tr>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-1/4">Data Santri</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Kehadiran</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-1/3">Progres Hafalan / Materi</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php foreach ($santri as $s) : 
                            // AMBIL DATA LAMA (Mode Edit)
                            $exist = $existing_absensi[$s['id']] ?? null;
                            $status_skrg = $exist['status'] ?? 'Hadir'; 
                        ?>
                        <input type="hidden" name="santri_ids[]" value="<?= $s['id'] ?>">

                        <tr class="group hover:bg-emerald-50/10 transition-all duration-300">
                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-4">
                                    <div class="w-11 h-11 rounded-2xl bg-slate-50 border-2 border-white shadow-sm flex items-center justify-center text-slate-400 font-black text-xs group-hover:bg-emerald-600 group-hover:text-white group-hover:border-emerald-600 transition-all group-hover:rotate-6">
                                        <?= strtoupper(substr($s['nama'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-slate-800 uppercase italic tracking-wide"><?= $s['nama'] ?></p>
                                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5"><?= $s['nis'] ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-center space-x-2 bg-slate-50/50 p-1.5 rounded-2xl border border-slate-100/50">
                                    <?php 
                                    $options = [
                                        ['val' => 'hadir', 'label' => 'H', 'color' => 'peer-checked:bg-emerald-500 peer-checked:shadow-emerald-200'],
                                        ['val' => 'izin', 'label' => 'I', 'color' => 'peer-checked:bg-amber-500 peer-checked:shadow-amber-200'],
                                        ['val' => 'sakit', 'label' => 'S', 'color' => 'peer-checked:bg-sky-500 peer-checked:shadow-sky-200'],
                                        ['val' => 'alpha', 'label' => 'A', 'color' => 'peer-checked:bg-rose-500 peer-checked:shadow-rose-200'],
                                    ];
                                    foreach ($options as $opt) : 
                                        // Cek apakah status ini yang sedang aktif
                                        $isChecked = (strtolower($status_skrg) == strtolower($opt['val']));
                                    ?>
                                    <label class="cursor-pointer flex-1">
                                        <input type="radio" 
                                               name="status[<?= $s['id'] ?>]" 
                                               value="<?= $opt['val'] ?>" 
                                               <?= $isChecked ? 'checked' : '' ?> 
                                               onchange="toggleMateri(<?= $s['id'] ?>, this.value)"
                                               class="hidden peer">
                                        <div class="w-full h-10 rounded-xl border-2 border-transparent bg-white text-[10px] font-black text-slate-400 flex items-center justify-center transition-all active:scale-90 peer-checked:text-white peer-checked:shadow-lg <?= $opt['color'] ?>">
                                            <?= $opt['label'] ?>
                                        </div>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                            
                            <td class="px-8 py-6">
                                <div id="materi_container_<?= $s['id'] ?>" class="<?= strtolower($status_skrg) == 'hadir' ? '' : 'opacity-30 pointer-events-none' ?> transition-all duration-500">
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="text" 
                                               name="materi_mulai[<?= $s['id'] ?>]" 
                                               value="<?= $exist['materi_mulai'] ?? '' ?>"
                                               placeholder="Mulai (Hlm/Ayat)" 
                                               class="bg-slate-50 border border-slate-100 rounded-xl px-3 py-2.5 text-[10px] font-bold text-slate-600 focus:bg-white focus:border-emerald-500 outline-none transition-all placeholder:text-slate-300">
                                        <input type="text" 
                                               name="materi_selesai[<?= $s['id'] ?>]" 
                                               value="<?= $exist['materi_selesai'] ?? '' ?>"
                                               placeholder="Sampai..." 
                                               class="bg-slate-50 border border-slate-100 rounded-xl px-3 py-2.5 text-[10px] font-bold text-slate-600 focus:bg-white focus:border-emerald-500 outline-none transition-all placeholder:text-slate-300">
                                    </div>
                                    <input type="text" 
                                           name="catatan_guru[<?= $s['id'] ?>]" 
                                           value="<?= $exist['catatan_guru'] ?? '' ?>"
                                           placeholder="Catatan progres hafalan..." 
                                           class="w-full mt-2 bg-slate-50 border border-slate-100 rounded-xl px-3 py-2.5 text-[10px] font-bold text-emerald-700 focus:bg-white focus:border-emerald-500 outline-none transition-all placeholder:text-slate-300 italic">
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <input type="text" 
                                       name="keterangan[<?= $s['id'] ?>]" 
                                       value="<?= $exist['keterangan'] ?? '' ?>"
                                       placeholder="Ket. absen..." 
                                       class="w-full bg-slate-50/50 border border-slate-100 rounded-xl px-4 py-2.5 text-[10px] font-bold text-slate-500 focus:bg-white focus:border-slate-300 transition-all outline-none">
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="fixed bottom-8 left-1/2 -translate-x-1/2 w-[90%] max-w-4xl z-50">
            <div class="bg-white/80 backdrop-blur-xl border border-white shadow-[0_20px_50px_rgba(0,0,0,0.15)] p-4 rounded-[2.5rem] flex items-center justify-between px-8 ring-1 ring-slate-100">
                <div class="hidden md:block pl-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Data Realtime</p>
                    </div>
                    <p class="text-[11px] font-black text-emerald-600 italic mt-0.5">Siap simpan progres & kehadiran</p>
                </div>
                
                <button type="submit" class="w-full md:w-auto px-10 py-4 bg-emerald-600 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-full shadow-xl shadow-emerald-200 hover:bg-emerald-700 hover:-translate-y-1 transition-all active:scale-95 flex items-center justify-center group">
                    <i class="fas fa-save mr-3 group-hover:rotate-12 transition-transform"></i>
                    Simpan Laporan Hari Ini
                </button>
            </div>
        </div>
    </form>
</main>

<script>
    function toggleMateri(santriId, status) {
        const container = document.getElementById('materi_container_' + santriId);
        // Pastikan case-insensitive
        if (status.toLowerCase() === 'hadir') {
            container.classList.remove('opacity-30', 'pointer-events-none');
        } else {
            container.classList.add('opacity-30', 'pointer-events-none');
        }
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #10b981; }
    
    input[type="radio"] + div {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
<?= $this->endSection() ?>
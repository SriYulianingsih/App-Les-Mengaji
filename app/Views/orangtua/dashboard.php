<?= $this->extend ('orangtua/layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-8 animate-fade-in">

    <?php if ($santri): ?>
    <div class="relative overflow-hidden bg-slate-900 rounded-[3rem] p-8 lg:p-12 shadow-2xl shadow-indigo-200">
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/10 rounded-full -mr-48 -mt-48 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-500/10 rounded-full -ml-32 -mb-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div>
                <span
                    class="inline-block px-4 py-1.5 bg-indigo-500/20 border border-indigo-500/30 rounded-full text-indigo-300 text-[10px] font-black uppercase tracking-[0.2em] mb-4">
                    Portal Wali Santri
                </span>
                <h2 class="text-3xl lg:text-4xl font-black text-white tracking-tight italic uppercase leading-tight">
                    Assalamu'alaikum, <br>
                    <span class="text-indigo-400">Wali <?= $santri['nama'] ?></span>
                </h2>
                <p class="text-slate-400 text-sm mt-4 max-w-md leading-relaxed">
                    Pantau perkembangan tahfidz dan administrasi ananda secara real-time melalui sistem Cahaya Hidayah
                    Qurani.
                </p>
            </div>

            <div class="flex items-center gap-4 bg-white/5 p-4 rounded-[2rem] border border-white/10 backdrop-blur-md">
                <div
                    class="w-16 h-16 bg-indigo-600 rounded-[1.5rem] flex items-center justify-center text-white text-2xl shadow-lg">
                    <i class="fas fa-heart animate-pulse"></i>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Status Belajar</p>
                    <p class="text-white font-bold italic uppercase">
                        <?= (isset($santri['status']) && $santri['status'] == 'aktif') ? 'Ananda Aktif' : 'Status: ' . ($santri['status'] ?? 'Aktif') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
            class="stat-card bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-premium group transition-all hover:-translate-y-2">
            <div
                class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                <i class="fas fa-user-check text-xl"></i>
            </div>
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Kehadiran</h4>
            <div class="flex items-end gap-2 mt-2">
                <span class="text-4xl font-black text-slate-800 tracking-tighter"><?= $hadir ?? '0' ?></span>
                <span class="text-slate-400 text-xs font-bold mb-1.5 uppercase italic">Pertemuan</span>
            </div>
        </div>

        <a href="<?= base_url('orangtua/guru') ?>"
            class="stat-card bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-premium group transition-all hover:-translate-y-2">
            <div
                class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                <i class="fas fa-chalkboard-teacher text-xl"></i>
            </div>
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Guru Pengajar</h4>
            <div class="flex items-end gap-2 mt-2">
                <span class="text-4xl font-black text-slate-800 tracking-tighter"><?= $total_guru ?? '0' ?></span>
                <span class="text-slate-400 text-xs font-bold mb-1.5 uppercase italic">Orang</span>
            </div>
            <p class="text-[9px] text-emerald-600 font-bold uppercase mt-2 italic flex items-center">
                Hubungi Guru <i class="fas fa-arrow-right ml-1 text-[7px]"></i>
            </p>
        </a>

        <div
            class="stat-card bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-premium group transition-all hover:-translate-y-2">
            <div
                class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
                <i class="fas fa-book-open text-xl"></i>
            </div>
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Materi Terakhir</h4>
            <div class="mt-2">
                <p class="text-lg font-black text-slate-800 italic uppercase truncate leading-tight">
                    <?= isset($progres->materi_selesai) ? $progres->materi_selesai : 'Belum Ada Data' ?>
                </p>
                <p class="text-[10px] text-amber-600 tracking-normal font-medium mt-1">
                    <?= isset($progres->tanggal) ? 'Update: ' . date('d/m/Y', strtotime($progres->tanggal)) : 'Silahkan hubungi ustadz/ustadzah' ?>
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-premium">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest italic flex items-center">
                    <i class="fas fa-info-circle mr-3 text-indigo-500"></i> Informasi Ananda
                </h3>
                <a href="<?= base_url('orangtua/santri') ?>"
                    class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline">Selengkapnya</a>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between p-4 bg-slate-50 rounded-2xl transition-colors hover:bg-slate-100">
                    <span class="text-xs font-bold text-slate-400 uppercase">Nama Lengkap</span>
                    <span class="text-xs font-black text-slate-700 italic uppercase"><?= $santri['nama'] ?></span>
                </div>
                <div class="flex justify-between p-4 bg-slate-50 rounded-2xl transition-colors hover:bg-slate-100">
                    <span class="text-xs font-bold text-slate-400 uppercase">Nomor Induk (NIS)</span>
                    <span class="text-xs font-black text-slate-700 italic uppercase"><?= $santri['nis'] ?? '-' ?></span>
                </div>
                <div class="flex justify-between p-4 bg-slate-50 rounded-2xl transition-colors hover:bg-slate-100">
                    <span class="text-xs font-bold text-slate-400 uppercase">Terdaftar Sejak</span>
                    <span class="text-xs font-black text-slate-700 italic uppercase">
                        <?= isset($santri['created_at']) ? date('d M Y', strtotime($santri['created_at'])) : '-' ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <a href="<?= base_url('orangtua/pembayaran') ?>"
                class="p-8 bg-indigo-600 rounded-[2.5rem] flex flex-col justify-between hover:bg-indigo-700 transition-all group shadow-xl shadow-indigo-100 transform hover:-rotate-2">
                <i class="fas fa-wallet text-white/50 text-2xl group-hover:scale-110 transition-transform"></i>
                <div>
                    <p class="text-white font-black italic uppercase tracking-tighter leading-tight">
                        Lakukan<br>Pembayaran</p>
                    <i class="fas fa-arrow-right text-white/30 mt-4 text-xs"></i>
                </div>
            </a>
            <a href="<?= base_url('orangtua/absensi') ?>"
                class="p-8 bg-slate-800 rounded-[2.5rem] flex flex-col justify-between hover:bg-slate-900 transition-all group shadow-xl shadow-slate-100 transform hover:rotate-2">
                <i class="fas fa-calendar-alt text-white/50 text-2xl group-hover:scale-110 transition-transform"></i>
                <div>
                    <p class="text-white font-black italic uppercase tracking-tighter leading-tight">Lihat
                        Riwayat<br>Presensi</p>
                    <i class="fas fa-arrow-right text-white/30 mt-4 text-xs"></i>
                </div>
            </a>
        </div>
    </div>

    <?php else: ?>
    <div class="min-h-[60vh] flex flex-col items-center justify-center text-center p-8">
        <div class="w-24 h-24 bg-slate-100 rounded-[2.5rem] flex items-center justify-center mb-6">
            <i class="fas fa-user-graduate text-3xl text-slate-300"></i>
        </div>
        <h2 class="text-2xl font-black text-slate-800 uppercase italic">Data Belum Terhubung</h2>
        <p class="text-slate-500 text-sm max-w-xs mt-2">
            Akun Bapak/Ibu belum terhubung dengan data santri. Silahkan hubungi admin untuk proses sinkronisasi.
        </p>
        <a href="https://wa.me/628123456789"
            class="mt-8 px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase italic text-xs tracking-widest shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all">
            Hubungi Admin
        </a>
    </div>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>
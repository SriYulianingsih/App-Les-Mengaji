<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-6xl">
    
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <a href="/admin/guru" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center mb-2 gap-1 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Guru
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Detail Profil Guru</h1>
            <p class="text-sm text-gray-500 mt-1">Informasi lengkap biodata dan profil tenaga pengajar.</p>
        </div>
        
        <div class="flex gap-2">
            <a href="/admin/guru/edit/<?= $guru['id'] ?>" class="bg-white text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all text-sm font-medium flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.828 2.828 0 114 4L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Profil
            </a>
            <a href="/admin/guru/delete/<?= $guru['id'] ?>" 
               onclick="return confirm('Apakah Anda yakin ingin menghapus data guru ini? Tindakan ini tidak dapat dibatalkan.')" 
               class="bg-rose-50 text-rose-600 px-5 py-2.5 rounded-xl hover:bg-rose-100 border border-rose-100 transition-all text-sm font-medium flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Hapus
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
                <div class="w-32 h-32 mx-auto mb-4">
                    <?php if (!empty($guru['foto'])) : ?>
                        <img class="w-full h-full rounded-2xl object-cover shadow-md ring-4 ring-gray-50" src="/uploads/guru/<?= $guru['foto'] ?>" alt="Foto Guru">
                    <?php else : ?>
                        <div class="w-full h-full rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 font-extrabold text-3xl shadow-sm">
                            <?= strtoupper(substr((string)esc($guru['nama']), 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <h2 class="text-xl font-bold text-gray-900"><?= esc($guru['nama']) ?></h2>
                <p class="text-sm font-medium text-emerald-600 mt-0.5"><?= esc($guru['nip'] ?: 'NIP Kosong') ?></p>
                
                <div class="mt-3 flex justify-center gap-2">
                    <span class="px-3 py-1 text-xs font-bold rounded-full inline-block <?= $guru['status'] == 'aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100' ?>">
                        <?= ucfirst((string)esc($guru['status'] ?: 'Tidak Aktif')) ?>
                    </span>

                    <?php if (!empty($guru['username'])) : ?>
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">
                            Akun Terhubung
                        </span>
                    <?php else : ?>
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-gray-50 text-gray-400 border border-gray-100">
                            Belum Ada Akun
                        </span>
                    <?php endif; ?>
                </div>

                <div class="border-t border-gray-100 mt-5 pt-5 grid grid-cols-2 gap-2 text-sm">
                    <div class="p-3 bg-gray-50/70 rounded-lg">
                        <p class="text-xs text-gray-400 font-medium">Pendidikan</p>
                        <p class="text-gray-800 font-bold mt-0.5 truncate"><?= esc($guru['pendidikan'] ?: '-') ?></p>
                    </div>
                    <div class="p-3 bg-gray-50/70 rounded-lg">
                        <p class="text-xs text-gray-400 font-medium">Gender</p>
                        <p class="text-gray-800 font-bold mt-0.5"><?= $guru['jenis_kelamin'] == 'L' ? 'Laki-laki' : ($guru['jenis_kelamin'] == 'P' ? 'Perempuan' : '-') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Biodata Lengkap
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">NIP (Nomor Induk Pegawai)</p>
                        <p class="text-gray-800 font-bold"><?= esc($guru['nip'] ?: 'Belum Diisi') ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">No. Handphone / WhatsApp</p>
                        <?php if (!empty($guru['no_hp'])) : ?>
                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $guru['no_hp']) ?>" target="_blank" class="text-emerald-600 font-bold hover:text-emerald-700 transition-all flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <?= esc($guru['no_hp']) ?>
                            </a>
                        <?php else : ?>
                            <p class="text-gray-800 font-bold">-</p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Pendidikan Terakhir</p>
                        <p class="text-gray-800 font-bold"><?= esc($guru['pendidikan'] ?: '-') ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Jenis Kelamin</p>
                        <p class="text-gray-800 font-bold"><?= $guru['jenis_kelamin'] == 'L' ? 'Laki-laki' : ($guru['jenis_kelamin'] == 'P' ? 'Perempuan' : '-') ?></p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Alamat Rumah</p>
                        <p class="text-gray-800 font-bold leading-relaxed"><?= esc($guru['alamat'] ?: 'Belum Diisi') ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Informasi Akun Aplikasi</h3>
                <?php if (!empty($guru['username'])) : ?>
                    <div class="flex items-center gap-4">
                        <span class="p-3 bg-gray-50 text-emerald-600 rounded-lg border border-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </span>
                        <div>
                            <p class="text-sm font-bold text-gray-800"><?= esc($guru['username']) ?></p>
                            <p class="text-xs text-emerald-600 font-medium">Akun terhubung untuk mengisi absensi dan rekap nilai.</p>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="text-center py-4 bg-gray-50 rounded-lg border border-gray-100 border-dashed">
                        <p class="text-xs text-gray-500">Guru ini belum memiliki akun aplikasi.</p>
                        <a href="/admin/akun/create/guru" class="text-xs text-emerald-600 font-bold hover:text-emerald-700 mt-1 inline-block">Buat Akun Sekarang &rarr;</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>
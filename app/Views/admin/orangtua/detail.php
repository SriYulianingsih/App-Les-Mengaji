<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-width-6xl">
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <a href="/admin/orangtua" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center mb-2 gap-1 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Orang Tua
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Detail Data Orang Tua</h1>
            <p class="text-sm text-gray-500 mt-1">Informasi lengkap mengenai wali dan orang tua santri.</p>
        </div>
        
        <div class="flex gap-2">
            <a href="/admin/orangtua/edit/<?= $orangtua['id'] ?>" class="bg-white text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all text-sm font-medium flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.828 2.828 0 114 4L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Data
            </a>
            <a href="/admin/orangtua/delete/<?= $orangtua['id'] ?>" 
               onclick="return confirm('Apakah Anda yakin ingin menghapus data orang tua ini? Tindakan ini tidak dapat dibatalkan.')" 
               class="bg-rose-50 text-rose-600 px-5 py-2.5 rounded-xl hover:bg-rose-100 border border-rose-100 transition-all text-sm font-medium flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Hapus
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
                <div class="w-24 h-24 mx-auto rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 font-extrabold text-3xl shadow-sm mb-4">
                    <?= strtoupper(substr((string)esc($orangtua['nama_ayah']), 0, 1)) ?>
                </div>
                <h2 class="text-xl font-bold text-gray-900"><?= esc($orangtua['nama_ayah']) ?></h2>
                <p class="text-sm text-gray-500 mb-4">Kepala Keluarga / Ayah</p>
                
                <div class="flex justify-center gap-2">
                    <?php if (!empty($orangtua['username'])) : ?>
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">
                            Akun Terhubung
                        </span>
                    <?php else : ?>
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-gray-50 text-gray-400 border border-gray-100">
                            Belum Ada Akun
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider">Informasi Kontak</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <span class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </span>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">No. Handphone / WhatsApp</p>
                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $orangtua['no_hp']) ?>" target="_blank" class="text-sm font-bold text-gray-800 hover:text-emerald-600 transition-all"><?= esc($orangtua['no_hp']) ?></a>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </span>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Alamat Email</p>
                            <p class="text-sm font-bold text-gray-800"><?= esc($orangtua['email'] ?: '-') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Biodata Orang Tua</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Nama Lengkap Ayah</p>
                        <p class="text-sm font-bold text-gray-800"><?= esc($orangtua['nama_ayah']) ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Pekerjaan Ayah</p>
                        <p class="text-sm font-bold text-gray-800"><?= esc($orangtua['pekerjaan_ayah'] ?: 'Belum Diisi') ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Nama Lengkap Ibu</p>
                        <p class="text-sm font-bold text-gray-800"><?= esc($orangtua['nama_ibu']) ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Pekerjaan Ibu</p>
                        <p class="text-sm font-bold text-gray-800"><?= esc($orangtua['pekerjaan_ibu'] ?: 'Belum Diisi') ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Domisili & Alamat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Provinsi</p>
                        <p class="text-sm font-bold text-gray-800"><?= esc($orangtua['provinsi'] ?: 'Belum Diisi') ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Kabupaten / Kota</p>
                        <p class="text-sm font-bold text-gray-800"><?= esc($orangtua['kabupaten'] ?: 'Belum Diisi') ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Kecamatan</p>
                        <p class="text-sm font-bold text-gray-800"><?= esc($orangtua['kecamatan'] ?: 'Belum Diisi') ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Kelurahan / Desa</p>
                        <p class="text-sm font-bold text-gray-800"><?= esc($orangtua['kelurahan'] ?: 'Belum Diisi') ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">RT / RW</p>
                        <p class="text-sm font-bold text-gray-800"><?= esc($orangtua['rt'] ?: '00') ?> / <?= esc($orangtua['rw'] ?: '00') ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Kode Pos</p>
                        <p class="text-sm font-bold text-gray-800"><?= esc($orangtua['kode_pos'] ?: '-') ?></p>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium mb-0.5">Alamat Lengkap (Jalan / Gg)</p>
                    <p class="text-sm font-bold text-gray-800"><?= esc($orangtua['alamat'] ?: 'Belum Diisi') ?></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Informasi Akun</h3>
                <?php if (!empty($orangtua['username'])) : ?>
                    <div class="flex items-center gap-4">
                        <span class="p-3 bg-gray-50 text-emerald-600 rounded-lg border border-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </span>
                        <div>
                            <p class="text-sm font-bold text-gray-800"><?= esc($orangtua['username']) ?></p>
                            <p class="text-xs text-emerald-600 font-medium">Akun terhubung untuk memantau data santri.</p>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="text-center py-4 bg-gray-50 rounded-lg border border-gray-100 border-dashed">
                        <p class="text-xs text-gray-500">Orang tua ini belum memiliki akun aplikasi.</p>
                        <a href="/admin/user/create" class="text-xs text-emerald-600 font-bold hover:text-emerald-700 mt-1 inline-block">Buat Akun Sekarang &rarr;</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
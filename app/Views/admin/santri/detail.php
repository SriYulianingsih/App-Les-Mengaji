<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-6xl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Profil Lengkap</h1>
            <p class="text-sm text-slate-500 mt-1">Manajemen data informasi personal dan wali santri.</p>
        </div>
        <div class="flex gap-3">
            <a href="/admin/santri/edit/<?= $santri['id'] ?>" class="group bg-indigo-600 hover:bg-indigo-700 text-white flex items-center text-sm font-bold px-5 py-2.5 rounded-2xl transition-all shadow-lg shadow-indigo-100 hover:-translate-y-0.5">
                <i class="fas fa-edit mr-2 text-indigo-200 group-hover:text-white transition-colors"></i>
                Edit Profil
            </a>
            <a href="/admin/santri" class="bg-white text-slate-600 hover:text-slate-900 flex items-center text-sm font-bold px-5 py-2.5 rounded-2xl border border-slate-200 shadow-sm transition-all hover:bg-slate-50">
                <i class="fas fa-chevron-left mr-2 text-xs"></i>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-br from-indigo-500 to-purple-600 opacity-[0.03]"></div>
                
                <div class="relative inline-block mt-4">
                    <div class="w-40 h-40 mx-auto relative z-10">
                        <?php if (!empty($santri['foto'])) : ?>
                            <img class="w-full h-full rounded-[2rem] object-cover shadow-2xl ring-8 ring-white" src="/uploads/santri/<?= $santri['foto'] ?>" alt="Foto Santri">
                        <?php else : ?>
                            <div class="w-full h-full rounded-[2rem] bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-400 font-bold text-5xl shadow-inner border-4 border-white">
                                <?= strtoupper(substr((string)esc($santri['nama']), 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="absolute -bottom-2 -right-2 z-20">
                         <span class="flex h-10 w-10 items-center justify-center rounded-2xl border-4 border-white shadow-lg <?= $santri['status'] == 'aktif' ? 'bg-emerald-500' : 'bg-rose-500' ?>">
                            <i class="fas <?= $santri['status'] == 'aktif' ? 'fa-check' : 'fa-times' ?> text-white text-xs"></i>
                         </span>
                    </div>
                </div>
                
                <div class="mt-8">
                    <h2 class="text-2xl font-black text-slate-900 leading-tight"><?= esc($santri['nama']) ?></h2>
                    <p class="text-indigo-600 font-black tracking-widest text-xs mt-2 uppercase bg-indigo-50 inline-block px-3 py-1 rounded-lg italic">
                        ID: <?= esc($santri['nis']) ?>
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-8 pt-8 border-t border-slate-50">
                    <div class="text-left p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-wider">Kelas</p>
                        <p class="text-slate-800 font-bold text-lg leading-none mt-1"><?= esc($santri['nama_kelas'] ?? '-') ?></p>
                    </div>
                    <div class="text-left p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-wider">Gender</p>
                        <p class="text-slate-800 font-bold text-lg leading-none mt-1">
                            <?= $santri['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 p-6 rounded-[2rem] shadow-xl text-white">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-sm font-bold text-slate-400">Statistik Santri</h4>
                    <i class="fas fa-chart-line text-indigo-400"></i>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-400">Usia Saat Ini</span>
                        <span class="text-sm font-bold">
                            <?php 
                                if($santri['tanggal_lahir']){
                                    $birth = new DateTime($santri['tanggal_lahir']);
                                    $today = new DateTime();
                                    echo $today->diff($birth)->y . " Tahun";
                                } else { echo "-"; }
                            ?>
                        </span>
                    </div>
                    <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-indigo-500 h-full w-2/3"></div>
                    </div>
                    <div class="flex items-center justify-between pt-2">
                        <span class="text-xs font-medium text-slate-400">Lama Bergabung</span>
                        <span class="text-sm font-bold text-indigo-400">
                            <?php 
                                if($santri['tanggal_daftar']){
                                    $joined = new DateTime($santri['tanggal_daftar']);
                                    $today = new DateTime();
                                    $diff = $today->diff($joined);
                                    echo $diff->y . "th " . $diff->m . "bln";
                                } else { echo "-"; }
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-8">
            
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <div class="flex items-center gap-4 mb-8 border-b border-slate-50 pb-6">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shadow-sm">
                        <i class="fas fa-address-card text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">Biodata Personal</h3>
                        <p class="text-xs text-slate-400 font-medium">Informasi kelahiran dan domisili santri.</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-12">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tempat, Tanggal Lahir</label>
                        <p class="text-slate-800 font-bold flex items-center gap-2">
                            <i class="fas fa-calendar-day text-indigo-300"></i>
                            <?= esc($santri['tempat_lahir'] ?: '-') ?>, <?= $santri['tanggal_lahir'] ? date('d F Y', strtotime($santri['tanggal_lahir'])) : '-' ?>
                        </p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pendidikan Terakhir</label>
                        <p class="text-slate-800 font-bold flex items-center gap-2">
                            <i class="fas fa-graduation-cap text-indigo-300"></i>
                            <?= esc($santri['pendidikan_terakhir'] ?: '-') ?>
                        </p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tanggal Registrasi</label>
                        <p class="text-slate-800 font-bold flex items-center gap-2">
                            <i class="fas fa-sign-in-alt text-indigo-300"></i>
                            <?= $santri['tanggal_daftar'] ? date('d F Y', strtotime($santri['tanggal_daftar'])) : '-' ?>
                        </p>
                    </div>
                    <div class="sm:col-span-2 space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Alamat Domisili</label>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-slate-700 font-medium leading-relaxed italic">
                            "<?= esc($santri['alamat'] ?: 'Alamat belum dilengkapi.') ?>"
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-full -mr-16 -mt-16 opacity-50"></div>
                
                <div class="flex items-center gap-4 mb-8 border-b border-slate-50 pb-6 relative z-10">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shadow-sm">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">Keluarga & Wali</h3>
                        <p class="text-xs text-slate-400 font-medium">Data orang tua yang dapat dihubungi.</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-12 relative z-10">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Nama Ayah</label>
                        <p class="text-slate-800 font-bold"><?= esc($santri['nama_ayah'] ?? '-') ?></p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Nama Ibu</label>
                        <p class="text-slate-800 font-bold"><?= esc($santri['nama_ibu'] ?? '-') ?></p>
                    </div>
                    <div class="sm:col-span-2 space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kontak Darurat (WhatsApp)</label>
                        <?php if(!empty($santri['no_hp'])): ?>
                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $santri['no_hp']) ?>" target="_blank" 
                               class="flex items-center gap-3 bg-emerald-50 text-emerald-700 p-4 rounded-2xl border border-emerald-100 hover:bg-emerald-100 transition-colors group w-fit">
                                <i class="fab fa-whatsapp text-2xl"></i>
                                <div>
                                    <p class="text-sm font-black"><?= esc($santri['no_hp']) ?></p>
                                    <p class="text-[10px] font-bold opacity-60">Klik untuk hubungi wali</p>
                                </div>
                                <i class="fas fa-external-link-alt text-[10px] ml-2 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                            </a>
                        <?php else: ?>
                            <p class="text-slate-400 font-bold italic">- Tidak ada nomor kontak -</p>
                        <?php endif; ?>
                    </div>
                    <div class="sm:col-span-2 space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Alamat Orang Tua</label>
                        <p class="text-slate-700 font-medium leading-relaxed italic"><?= esc($santri['alamat_ortu'] ?? '-') ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>
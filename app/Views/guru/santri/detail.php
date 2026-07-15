<?= $this->extend('guru/layouts/main') ?> 
<?= $this->section('content') ?>

<main class="p-4 lg:p-6 space-y-6">
    
    <div class="flex items-center space-x-3 mb-4">
        <a href="<?= base_url('guru/santri') ?>" class="w-10 h-10 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-slate-400 hover:text-indigo-600 transition-all shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h2 class="text-xl font-black text-slate-800 tracking-tight">Profil Santri</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="space-y-6">
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 text-center">
                <div class="w-32 h-32 mx-auto rounded-[2rem] overflow-hidden bg-slate-50 border-4 border-white shadow-xl mb-6">
                    <?php if(!empty($santri['foto'])): ?>
                        <img src="<?= base_url('uploads/santri/' . $santri['foto']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-200">
                            <i class="fas fa-user text-5xl"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <h3 class="text-xl font-black text-slate-800 italic"><?= $santri['nama'] ?></h3>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1"><?= $santri['nis'] ?></p>
                
                <div class="mt-6 flex justify-center gap-2">
                    <span class="px-4 py-1.5 bg-indigo-50 text-indigo-600 text-[10px] font-black rounded-full uppercase italic">
                        Kelas <?= $santri['nama_kelas'] ?? '-' ?>
                    </span>
                    <span class="px-4 py-1.5 <?= $santri['status'] == 'Aktif' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' ?> text-[10px] font-black rounded-full uppercase">
                        <?= $santri['status'] ?>
                    </span>
                </div>
            </div>

            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-xl shadow-slate-200">
                <i class="fas fa-users absolute -right-4 -bottom-4 text-8xl text-white/5"></i>
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Info Orang Tua</h4>
                <p class="text-[10px] font-bold text-slate-400">Nama Ayah/Wali</p>
                <p class="font-bold text-sm mb-4"><?= $santri['nama_ayah'] ?? '-' ?></p>
                
                <?php if(!empty($santri['no_hp_ortu'])): ?>
                    <a href="https://wa.me/<?= str_replace(['+', '-', ' '], '', $santri['no_hp_ortu']) ?>" target="_blank" class="flex items-center justify-center w-full py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-black transition-all">
                        <i class="fab fa-whatsapp mr-2 text-base"></i> HUBUNGI WALI
                    </a>
                <?php else: ?>
                    <button disabled class="flex items-center justify-center w-full py-3 bg-slate-800 text-slate-500 rounded-xl text-xs font-black cursor-not-allowed">
                        <i class="fas fa-phone-slash mr-2 text-base"></i> NO. HP TIDAK ADA
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 h-full">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-8 flex items-center">
                    <span class="w-2 h-6 bg-indigo-600 rounded-full mr-3"></span> Informasi Akademik & Pribadi
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tempat, Tanggal Lahir</p>
                        <p class="text-sm font-bold text-slate-700">
                            <?= $santri['tempat_lahir'] ?? '-' ?>, <?= !empty($santri['tanggal_lahir']) ? date('d F Y', strtotime($santri['tanggal_lahir'])) : '-' ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Jenis Kelamin</p>
                        <p class="text-sm font-bold text-slate-700"><?= $santri['jenis_kelamin'] ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Pendidikan Terakhir</p>
                        <p class="text-sm font-bold text-slate-700"><?= $santri['pendidikan_terakhir'] ?? '-' ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggal Daftar</p>
                        <p class="text-sm font-bold text-slate-700">
                            <?= !empty($santri['tanggal_daftar']) ? date('d M Y', strtotime($santri['tanggal_daftar'])) : '-' ?>
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Alamat Tinggal</p>
                        <p class="text-sm font-bold text-slate-700 italic leading-relaxed">
                            "<?= $santri['alamat'] ?? 'Alamat belum diisi.' ?>"
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>
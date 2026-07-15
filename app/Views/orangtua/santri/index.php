<?= $this->extend('orangtua/layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-8 animate-fade-in">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase italic tracking-tight">Profil Lengkap Ananda</h2>
            <p class="text-sm text-slate-500">Informasi detail mengenai data akademik dan personal ananda.</p>
        </div>
        <div class="flex items-center gap-3 bg-white px-6 py-3 rounded-2xl shadow-sm border border-slate-100">
            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></div>
            <span class="text-xs font-bold text-slate-600 uppercase tracking-widest">Data Terverifikasi</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-premium text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-24 bg-slate-900"></div>
                
                <div class="relative z-10">
                    <div class="inline-block p-1.5 bg-white rounded-[2rem] shadow-xl mb-4 relative group">
                        <div id="imagePreviewContainer">
                            <?php if (!empty($santri['foto']) && file_exists('uploads/santri/' . $santri['foto'])): ?>
                                <img src="<?= base_url('uploads/santri/' . $santri['foto']) ?>" 
                                     id="imgShow" class="w-32 h-32 rounded-[1.8rem] object-cover" alt="Foto Santri">
                            <?php else: ?>
                                <div id="initialShow" class="w-32 h-32 rounded-[1.8rem] bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                                    <span class="text-4xl font-black text-white italic uppercase">
                                        <?php 
                                            $words = explode(" ", $santri['nama']);
                                            $initials = "";
                                            foreach ($words as $w) { $initials .= $w[0]; }
                                            echo substr($initials, 0, 2); 
                                        ?>
                                    </span>
                                </div>
                                <img id="imgShow" class="w-32 h-32 rounded-[1.8rem] object-cover hidden" alt="Preview">
                            <?php endif; ?>
                        </div>

                        <form action="<?= base_url('orangtua/santri/upload-foto/' . $santri['id']) ?>" method="POST" enctype="multipart/form-data" id="formUpload">
                            <?= csrf_field() ?>
                            <label for="fileInput" class="absolute bottom-2 right-2 w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center cursor-pointer border-4 border-white hover:bg-indigo-700 transition-all shadow-lg">
                                <i class="fas fa-camera text-xs"></i>
                            </label>
                            <input type="file" name="foto" id="fileInput" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </form>
                    </div>
                    
                    <h3 class="text-xl font-black text-slate-800 uppercase italic leading-tight"><?= $santri['nama'] ?></h3>
                    <p class="text-indigo-600 text-xs font-bold uppercase tracking-[0.2em] mt-2"><?= $santri['nama_kelas'] ?? 'Belum Ada Kelas' ?></p>
                    
                    <button type="submit" form="formUpload" id="btnSaveFoto" class="hidden mt-6 w-full py-4 bg-emerald-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-100">
                        Simpan Foto Baru
                    </button>

                    <div class="mt-8 pt-8 border-t border-slate-50 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black text-slate-400 uppercase">NIS</span>
                            <span class="text-sm font-black text-slate-700 italic"><?= $santri['nis'] ?? '-' ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black text-slate-400 uppercase">Status</span>
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase">
                                <?= $santri['status'] ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-indigo-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-indigo-100">
                <h4 class="text-xs font-black uppercase tracking-widest opacity-60 mb-4">Kontak Darurat</h4>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <p class="text-[10px] opacity-60 uppercase font-bold">WhatsApp Ayah</p>
                        <p class="font-bold tracking-wider"><?= $santri['no_hp_ortu'] ?? '-' ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-premium overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex items-center gap-3">
                    <i class="fas fa-id-card text-indigo-500"></i>
                    <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Informasi Biodata</h4>
                </div>
                
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tempat, Tanggal Lahir</label>
                        <p class="text-slate-700 font-bold italic uppercase">
                            <?= $santri['tempat_lahir'] ?>, <?= isset($santri['tanggal_lahir']) ? date('d F Y', strtotime($santri['tanggal_lahir'])) : '-' ?>
                        </p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Jenis Kelamin</label>
                        <p class="text-slate-700 font-bold italic uppercase"><?= ($santri['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan' ?></p>
                    </div>

                    <div class="space-y-1 md:col-span-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Alamat Lengkap</label>
                        <p class="text-slate-700 font-bold italic uppercase leading-relaxed"><?= $santri['alamat'] ?? '-' ?></p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pendidikan Terakhir</label>
                        <p class="text-slate-700 font-bold italic uppercase"><?= $santri['pendidikan_terakhir'] ?? '-' ?></p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Bergabung</label>
                        <p class="text-slate-700 font-bold italic uppercase">
                            <?= isset($santri['tanggal_daftar']) ? date('d M Y', strtotime($santri['tanggal_daftar'])) : '-' ?>
                        </p>
                    </div>
                </div>
                
                <div class="p-8 bg-slate-50/50 border-t border-slate-50 mt-4">
                    <div class="flex items-center gap-4 text-slate-500">
                        <i class="fas fa-info-circle"></i>
                        <p class="text-[10px] font-medium leading-relaxed uppercase">Jika terdapat kekeliruan data, mohon segera hubungi pihak administrasi sekolah untuk melakukan pengkinian data.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const file = input.files[0];
    const imgShow = document.querySelector('#imgShow');
    const initialShow = document.querySelector('#initialShow');
    const btnSave = document.querySelector('#btnSaveFoto');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imgShow.src = e.target.result;
            imgShow.classList.remove('hidden');
            if (initialShow) initialShow.classList.add('hidden');
            btnSave.classList.remove('hidden'); // Tampilkan tombol simpan
        }
        reader.readAsDataURL(file);
    }
}
</script>
<?= $this->endSection() ?>
<?= $this->extend('guru/layouts/main') ?> <?= $this->section('content') ?>
<main class="p-4 lg:p-6 space-y-5">
    
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-sky-500 rounded-xl flex items-center justify-center text-white shadow-md shadow-sky-100">
                <i class="fas fa-user-edit text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight">Profil Pengajar</h2>
                <p class="text-[11px] text-slate-500 font-bold uppercase tracking-wider">Update informasi & keamanan</p>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-4 py-3 rounded-xl text-xs font-bold shadow-sm">
            <i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 px-4 py-3 rounded-xl text-xs font-bold shadow-sm">
            <ul class="list-disc ml-4">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <div class="lg:col-span-8">
            <form action="/guru/profile/update" method="POST" enctype="multipart/form-data" class="bg-white rounded-[2rem] p-6 lg:p-8 shadow-sm border border-slate-100">
                <?= csrf_field() ?>
                <input type="hidden" name="id_guru" value="<?= $guru['id'] ?>">
                
                <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-8 mb-10 pb-10 border-b border-slate-50">
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-[2.5rem] overflow-hidden border-4 border-white shadow-2xl rotate-3 group-hover:rotate-0 transition-all duration-500">
                            <img id="img-preview" 
                                 src="<?= $guru['foto'] ? base_url('uploads/guru/' . $guru['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($guru['nama']) . '&background=0ea5e9&color=fff&size=128' ?>" 
                                 class="w-full h-full object-cover">
                        </div>
                        <label for="foto" class="absolute -bottom-2 -right-2 w-10 h-10 bg-slate-900 text-white rounded-2xl flex items-center justify-center cursor-pointer hover:bg-sky-600 transition-all shadow-lg border-2 border-white">
                            <i class="fas fa-camera text-sm"></i>
                            <input type="file" name="foto" id="foto" class="hidden" onchange="previewImage()">
                        </label>
                    </div>
                    <div class="text-center md:text-left">
                        <h4 class="text-sm font-black text-slate-800 uppercase italic">Foto Profil</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-1">Saran: 1:1 (Max 2MB)</p>
                        <p class="text-[9px] text-sky-500 font-black mt-2 bg-sky-50 px-3 py-1 rounded-full inline-block uppercase">Klik icon kamera untuk ganti</p>
                    </div>
                </div>

                <div class="flex items-center mb-6">
                    <span class="w-2 h-6 bg-sky-500 rounded-full mr-3"></span>
                    <h3 class="font-black text-slate-800 uppercase text-sm tracking-widest">Informasi Umum</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" value="<?= $guru['nama'] ?>" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-sky-500 focus:bg-white transition-all outline-none text-sm font-bold text-slate-700 shadow-sm shadow-slate-100/50">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">NIP / ID Pengajar</label>
                        <input type="text" value="<?= $guru['nip'] ?>" readonly class="w-full px-5 py-3.5 bg-slate-100 border border-slate-200 rounded-2xl text-sm font-bold text-slate-400 cursor-not-allowed italic">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">No. WhatsApp</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">+62</span>
                            <input type="text" name="no_hp" value="<?= $guru['no_hp'] ?>" class="w-full pl-12 pr-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-sky-500 transition-all outline-none text-sm font-bold text-slate-700">
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan" value="<?= $guru['pendidikan'] ?>" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-sky-500 transition-all outline-none text-sm font-bold text-slate-700">
                    </div>
                    <div class="md:col-span-2 space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat Tinggal</label>
                        <textarea name="alamat" rows="3" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-sky-500 transition-all outline-none text-sm font-bold text-slate-700 resize-none"><?= $guru['alamat'] ?></textarea>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-slate-50 flex justify-end">
                    <button type="submit" class="w-full md:w-auto px-10 py-4 bg-sky-600 hover:bg-slate-900 text-white text-xs font-black rounded-2xl shadow-xl shadow-sky-100 transition-all active:scale-95 flex items-center justify-center space-x-2">
                        <i class="fas fa-save mr-2"></i>
                        <span>SIMPAN PERUBAHAN</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                <div class="flex items-center mb-6">
                    <span class="w-2 h-6 bg-rose-500 rounded-full mr-3"></span>
                    <h3 class="font-black text-slate-800 uppercase text-sm tracking-widest">Keamanan Akun</h3>
                </div>

                <form action="/guru/profile/update-password" method="POST" class="space-y-4">
                    <?= csrf_field() ?>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Password Saat Ini</label>
                        <input type="password" name="old_password" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm outline-none focus:border-rose-300 transition-all font-bold text-slate-700">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Password Baru</label>
                        <input type="password" name="new_password" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm outline-none focus:border-sky-300 transition-all font-bold text-slate-700">
                    </div>
                    <button type="submit" class="w-full py-4 bg-slate-800 text-white text-xs font-black rounded-2xl hover:bg-black transition-all shadow-lg active:scale-95">
                        GANTI PASSWORD
                    </button>
                </form>
            </div>

            <div class="bg-slate-900 rounded-[2rem] p-8 text-white relative overflow-hidden group">
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center mb-4">
                        <i class="fas fa-shield-alt text-xl text-sky-400"></i>
                    </div>
                    <h4 class="font-black text-sm mb-2 italic uppercase tracking-wider text-sky-400">Tips Keamanan</h4>
                    <p class="text-slate-400 text-[11px] leading-relaxed font-medium">Gunakan kombinasi huruf, angka, dan simbol untuk password yang lebih kuat. Jangan pernah memberikan password Anda kepada siapapun.</p>
                </div>
                <i class="fas fa-fingerprint absolute -right-4 -bottom-4 text-7xl text-white/5 rotate-12 group-hover:scale-110 transition-transform duration-700"></i>
            </div>
        </div>

    </div>
</main>

<script>
function previewImage() {
    const foto = document.querySelector('#foto');
    const imgPreview = document.querySelector('#img-preview');

    const fileFoto = new FileReader();
    fileFoto.readAsDataURL(foto.files[0]);

    fileFoto.onload = function(e) {
        imgPreview.src = e.target.result;
    }
}
</script>

<?= $this->endSection() ?>
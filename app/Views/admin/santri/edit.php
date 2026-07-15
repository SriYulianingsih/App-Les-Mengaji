<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-5xl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Santri</h1>
            <p class="text-sm text-slate-500 mt-1">Lakukan pembaruan data pada profil santri <strong><?= esc($santri['nama']) ?></strong>.</p>
        </div>
        <a href="/admin/santri" class="text-slate-600 hover:text-slate-900 flex items-center text-sm font-bold bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-sm transition-all hover:bg-slate-50">
            <i class="fas fa-arrow-left mr-2 text-xs"></i>
            Kembali ke List
        </a>
    </div>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="bg-rose-50 border border-rose-100 text-rose-800 px-5 py-4 rounded-2xl mb-8 animate-shake">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle text-rose-500 mr-2"></i>
                <span class="font-bold text-sm">Gagal Memperbarui Data:</span>
            </div>
            <ul class="list-disc ml-8 text-xs space-y-1 font-medium">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/admin/santri/update/<?= $santri['id'] ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-50 pb-5">
                        <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <h2 class="text-xl font-bold text-slate-800">Identitas Santri</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">NIS <span class="text-rose-500">*</span></label>
                            <input type="text" name="nis" value="<?= old('nis', $santri['nis']) ?>" required 
                                   class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <input type="text" name="nama" value="<?= old('nama', $santri['nama']) ?>" required 
                                   class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="<?= old('tempat_lahir', $santri['tempat_lahir']) ?>" 
                                   class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="<?= old('tanggal_lahir', $santri['tanggal_lahir']) ?>" 
                                   class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1 text-block">Jenis Kelamin</label>
                            <div class="flex gap-4 p-1 bg-slate-50 rounded-2xl border border-slate-200">
                                <label class="flex-1 flex items-center justify-center px-4 py-2.5 rounded-xl cursor-pointer transition-all has-[:checked]:bg-white has-[:checked]:text-indigo-600 has-[:checked]:shadow-sm group">
                                    <input type="radio" name="jenis_kelamin" value="L" <?= old('jenis_kelamin', $santri['jenis_kelamin']) == 'L' ? 'checked' : '' ?> class="sr-only"> 
                                    <span class="text-sm font-bold opacity-60 group-hover:opacity-100">Laki-laki</span>
                                </label>
                                <label class="flex-1 flex items-center justify-center px-4 py-2.5 rounded-xl cursor-pointer transition-all has-[:checked]:bg-white has-[:checked]:text-indigo-600 has-[:checked]:shadow-sm group">
                                    <input type="radio" name="jenis_kelamin" value="P" <?= old('jenis_kelamin', $santri['jenis_kelamin']) == 'P' ? 'checked' : '' ?> class="sr-only"> 
                                    <span class="text-sm font-bold opacity-60 group-hover:opacity-100">Perempuan</span>
                                </label>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">Pendidikan Terakhir</label>
                            <input type="text" name="pendidikan_terakhir" value="<?= old('pendidikan_terakhir', $santri['pendidikan_terakhir']) ?>" 
                                   class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                        </div>
                    </div>

                    <div class="mt-6 space-y-2">
                        <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">Alamat Domisili</label>
                        <textarea name="alamat" rows="3" 
                                  class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium"><?= old('alamat', $santri['alamat']) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-50 pb-5">
                        <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800">Status & Kelas</h2>
                    </div>

                    <div class="space-y-5">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">Status Keaktifan</label>
                            <select name="status" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-bold <?= $santri['status'] == 'aktif' ? 'text-emerald-600' : 'text-rose-600' ?>">
                                <option value="aktif" <?= old('status', $santri['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="non-aktif" <?= old('status', $santri['status']) == 'non-aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">Orang Tua/Wali</label>
                            <select name="orangtua_id" required class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                                <?php foreach ($orangtua as $ortu) : ?>
                                    <option value="<?= $ortu['id'] ?>" <?= old('orangtua_id', $santri['orangtua_id']) == $ortu['id'] ? 'selected' : '' ?>>
                                        <?= esc($ortu['nama_ayah']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">Kelas</label>
                            <select name="kelas_id" required class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                                <?php foreach ($kelas as $k) : ?>
                                    <option value="<?= $k['id'] ?>" <?= old('kelas_id', $santri['kelas_id']) == $k['id'] ? 'selected' : '' ?>>
                                        <?= esc($k['nama_kelas']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-3">
                         <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-image"></i>
                        </div>
                        Foto Profil
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="relative group aspect-[3/4] rounded-2xl overflow-hidden border-4 border-slate-50 shadow-inner bg-slate-100">
                            <?php if (!empty($santri['foto'])) : ?>
                                <img id="preview-img" src="/uploads/santri/<?= $santri['foto'] ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Foto">
                            <?php else : ?>
                                <div id="no-photo" class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                    <i class="fas fa-user-circle text-5xl mb-2"></i>
                                    <span class="text-[10px] font-bold uppercase tracking-widest">Tanpa Foto</span>
                                </div>
                                <img id="preview-img" class="hidden w-full h-full object-cover" src="#" alt="Preview">
                            <?php endif; ?>
                            
                            <label for="file-upload" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
                                <div class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-xl border border-white/30 text-white text-xs font-bold">
                                    GANTI FOTO
                                </div>
                            </label>
                        </div>
                        
                        <input id="file-upload" name="foto" type="file" class="sr-only" accept="image/*" onchange="bacaGambar(this)">
                        <p class="text-[10px] text-center text-slate-400 font-medium">Klik pada gambar untuk mengunggah foto baru</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-indigo-600 text-white font-bold px-10 py-4 rounded-2xl shadow-xl shadow-indigo-100 hover:bg-slate-900 transition-all transform hover:-translate-y-1 active:scale-95">
                <i class="fas fa-sync-alt mr-2"></i> Update Profil Santri
            </button>
        </div>
    </form>
</div>

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    .animate-shake { animation: shake 0.3s ease-in-out; }
</style>

<script>
function bacaGambar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview-img');
            const noPhoto = document.getElementById('no-photo');
            
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if(noPhoto) noPhoto.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?= $this->endSection() ?>
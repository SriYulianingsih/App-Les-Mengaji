<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-5xl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Tambah Santri</h1>
            <p class="text-sm text-slate-500 mt-1">Daftarkan santri baru ke dalam sistem manajemen pesantren.</p>
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
                <span class="font-bold text-sm">Ada kesalahan input:</span>
            </div>
            <ul class="list-disc ml-8 text-xs space-y-1 font-medium">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/admin/santri/store" method="POST" enctype="multipart/form-data" class="space-y-8">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-50 pb-5">
                        <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <h2 class="text-xl font-bold text-slate-800">Identitas Santri</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">NIS <span class="text-rose-500">*</span></label>
                            <input type="text" name="nis" value="<?= old('nis') ?>" required 
                                   placeholder="Contoh: 2024001"
                                   class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <input type="text" name="nama" value="<?= old('nama') ?>" required 
                                   placeholder="Nama lengkap santri"
                                   class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="<?= old('tempat_lahir') ?>" 
                                   class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="<?= old('tanggal_lahir') ?>" 
                                   class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1 text-block">Jenis Kelamin</label>
                            <div class="flex gap-4 p-1 bg-slate-50 rounded-2xl border border-slate-200">
                                <label class="flex-1 flex items-center justify-center px-4 py-2.5 rounded-xl cursor-pointer transition-all has-[:checked]:bg-white has-[:checked]:text-indigo-600 has-[:checked]:shadow-sm group">
                                    <input type="radio" name="jenis_kelamin" value="L" <?= old('jenis_kelamin') == 'L' ? 'checked' : '' ?> class="sr-only"> 
                                    <span class="text-sm font-bold opacity-60 group-hover:opacity-100">Laki-laki</span>
                                </label>
                                <label class="flex-1 flex items-center justify-center px-4 py-2.5 rounded-xl cursor-pointer transition-all has-[:checked]:bg-white has-[:checked]:text-indigo-600 has-[:checked]:shadow-sm group">
                                    <input type="radio" name="jenis_kelamin" value="P" <?= old('jenis_kelamin') == 'P' ? 'checked' : '' ?> class="sr-only"> 
                                    <span class="text-sm font-bold opacity-60 group-hover:opacity-100">Perempuan</span>
                                </label>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">Pendidikan Terakhir</label>
                            <input type="text" name="pendidikan_terakhir" value="<?= old('pendidikan_terakhir') ?>" 
                                   placeholder="Misal: TK / Belum Sekolah"
                                   class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                        </div>
                    </div>

                    <div class="mt-6 space-y-2">
                        <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">Alamat Domisili</label>
                        <textarea name="alamat" rows="3" 
                                  placeholder="Alamat lengkap santri saat ini..."
                                  class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium"><?= old('alamat') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <div class="flex items-center gap-3 mb-6 border-b border-slate-50 pb-5">
                        <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800">Penempatan</h2>
                    </div>

                    <div class="space-y-5">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">Orang Tua/Wali <span class="text-rose-500">*</span></label>
                            <select name="orangtua_id" required class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                                <option value="">-- Pilih Orang Tua --</option>
                                <?php foreach ($orangtua as $ortu) : ?>
                                    <option value="<?= $ortu['id'] ?>" <?= old('orangtua_id') == $ortu['id'] ? 'selected' : '' ?>>
                                        <?= esc($ortu['nama_ayah']) ?> (<?= esc($ortu['no_hp']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">Kelas <span class="text-rose-500">*</span></label>
                            <select name="kelas_id" required class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                                <option value="">-- Pilih Kelas --</option>
                                <?php foreach ($kelas as $k) : ?>
                                    <option value="<?= $k['id'] ?>" <?= old('kelas_id') == $k['id'] ? 'selected' : '' ?>>
                                        <?= esc($k['nama_kelas']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-slate-500 uppercase tracking-wider ml-1">Tanggal Daftar</label>
                            <input type="date" name="tanggal_daftar" value="<?= old('tanggal_daftar') ?: date('Y-m-d') ?>" 
                                   class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                    <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-3">
                         <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-camera"></i>
                        </div>
                        Foto Santri
                    </h2>
                    
                    <div class="relative group">
                        <div id="wrapper-preview" class="hidden mb-4 overflow-hidden rounded-2xl border-4 border-slate-50 shadow-inner aspect-[3/4] relative">
                            <img id="preview-img" class="w-full h-full object-cover" src="#" alt="Preview">
                            <button type="button" onclick="resetGambar()" class="absolute top-3 right-3 bg-white/90 p-2 rounded-xl text-rose-600 hover:bg-white hover:scale-110 shadow-lg transition-all">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <label id="kotak-upload" for="file-upload" class="flex flex-col items-center justify-center w-full aspect-[3/4] border-2 border-dashed border-slate-200 rounded-2xl hover:border-indigo-400 hover:bg-indigo-50/30 transition-all cursor-pointer group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-slate-400 group-hover:text-indigo-500"></i>
                                </div>
                                <p class="text-xs font-bold text-slate-500 group-hover:text-indigo-600">KLIK UNTUK UPLOAD</p>
                                <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-tighter">JPG, PNG (Max. 2MB)</p>
                            </div>
                            <input id="file-upload" name="foto" type="file" class="sr-only" accept="image/*" onchange="bacaGambar(this)">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-slate-900 text-white font-bold px-10 py-4 rounded-2xl shadow-xl shadow-slate-200 hover:bg-indigo-600 hover:shadow-indigo-100 transition-all transform hover:-translate-y-1 active:scale-95">
                <i class="fas fa-save mr-2"></i> Simpan Data Santri
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
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('wrapper-preview').classList.remove('hidden');
            document.getElementById('kotak-upload').classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function resetGambar() {
    document.getElementById('file-upload').value = '';
    document.getElementById('wrapper-preview').classList.add('hidden');
    document.getElementById('kotak-upload').classList.remove('hidden');
}
</script>

<?= $this->endSection() ?>
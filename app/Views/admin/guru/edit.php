<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-5xl">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Guru</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui data profil tenaga pengajar yang bersangkutan.</p>
        </div>
        <a href="/admin/guru" class="text-gray-600 hover:text-gray-900 flex items-center text-sm font-medium bg-gray-50 px-4 py-2 rounded-lg hover:bg-gray-100 transition-all border border-gray-100">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke List
        </a>
    </div>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 px-4 py-3.5 rounded-lg mb-6 shadow-sm">
            <div class="flex items-center mb-1">
                <svg class="w-5 h-5 text-rose-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                <span class="font-bold text-sm">Gagal Mengupdate Data:</span>
            </div>
            <ul class="list-disc ml-7 text-xs space-y-0.5">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/admin/guru/update/<?= $guru['id'] ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-5">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h2 class="text-lg font-bold text-gray-800">Identitas Guru</h2>
                    <div>
                        <label class="text-xs text-gray-400 font-medium block text-right">Status Keaktifan</label>
                        <select name="status" class="mt-0.5 text-xs font-bold border-0 bg-gray-50 rounded-lg focus:ring-0 cursor-pointer">
                            <option value="aktif" <?= old('status', $guru['status']) == 'aktif' ? 'selected' : '' ?>>🟢 Aktif</option>
                            <option value="non-aktif" <?= old('status', $guru['status']) == 'non-aktif' ? 'selected' : '' ?>>🔴 Non-Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">NIP <span class="text-rose-500">*</span></label>
                        <input type="text" name="nip" value="<?= old('nip', $guru['nip']) ?>" required class="mt-1.5 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama" value="<?= old('nama', $guru['nama']) ?>" required class="mt-1.5 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">No. HP / WhatsApp</label>
                        <input type="text" name="no_hp" value="<?= old('no_hp', $guru['no_hp']) ?>" placeholder="Misal: 081234567890" class="mt-1.5 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan" value="<?= old('pendidikan', $guru['pendidikan']) ?>" placeholder="Misal: S1 Pendidikan" class="mt-1.5 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Jenis Kelamin</label>
                    <div class="mt-2.5 flex space-x-6">
                        <label class="flex items-center text-sm cursor-pointer group">
                            <input type="radio" name="jenis_kelamin" value="L" <?= old('jenis_kelamin', $guru['jenis_kelamin']) == 'L' ? 'checked' : '' ?> class="text-indigo-600 focus:ring-indigo-500 mr-2 border-gray-300"> 
                            <span class="group-hover:text-indigo-600 font-medium">Laki-laki</span>
                        </label>
                        <label class="flex items-center text-sm cursor-pointer group">
                            <input type="radio" name="jenis_kelamin" value="P" <?= old('jenis_kelamin', $guru['jenis_kelamin']) == 'P' ? 'checked' : '' ?> class="text-indigo-600 focus:ring-indigo-500 mr-2 border-gray-300"> 
                            <span class="group-hover:text-indigo-600 font-medium">Perempuan</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" class="mt-1.5 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm"><?= old('alamat', $guru['alamat']) ?></textarea>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 self-start">
                    <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3">Perbarui Foto</h2>
                    
                    <div class="flex items-center space-x-4 mb-2">
                        <div class="flex-shrink-0">
                            <?php if (!empty($guru['foto'])) : ?>
                                <img id="preview-foto" src="/uploads/guru/<?= $guru['foto'] ?>" alt="Preview" class="w-16 h-16 rounded-xl object-cover shadow-sm ring-1 ring-gray-100">
                            <?php else : ?>
                                <div id="default-avatar" class="w-16 h-16 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xl shadow-sm border border-indigo-50">
                                    G
                                </div>
                                <img id="preview-foto" class="hidden w-16 h-16 rounded-xl object-cover shadow-sm ring-1 ring-gray-100" src="#" alt="Preview">
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex-1">
                            <input type="file" name="foto" accept="image/*" onchange="bacaGambar(this)" class="text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 file:cursor-pointer transition-colors">
                            <p class="text-xs text-gray-400 mt-1">Biarkan kosong jika tidak diganti.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold px-6 py-2.5 rounded-lg text-sm shadow-md shadow-indigo-100 transition-all duration-200 transform hover:-translate-y-0.5">
                Update Data Guru
            </button>
        </div>
    </form>
</div>

<script>
function bacaGambar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            let previewImg = document.getElementById('preview-foto');
            let defaultAvatar = document.getElementById('default-avatar');

            previewImg.src = e.target.result;
            previewImg.classList.remove('hidden');
            
            if (defaultAvatar) {
                defaultAvatar.classList.add('hidden');
            }
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?= $this->endSection() ?>
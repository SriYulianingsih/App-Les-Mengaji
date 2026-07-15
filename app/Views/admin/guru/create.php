<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-5xl">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Guru</h1>
            <p class="text-sm text-gray-500 mt-1">Daftarkan tenaga pengajar baru ke dalam sistem aplikasi les.</p>
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
                <span class="font-bold text-sm">Gagal Menyimpan Data:</span>
            </div>
            <ul class="list-disc ml-7 text-xs space-y-0.5">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/admin/guru/store" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-5">
                <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3">Identitas Guru</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">NIP <span class="text-rose-500">*</span></label>
                        <input type="text" name="nip" value="<?= old('nip') ?>" required class="mt-1.5 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama" value="<?= old('nama') ?>" required class="mt-1.5 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">No. HP / WhatsApp</label>
                        <input type="text" name="no_hp" value="<?= old('no_hp') ?>" placeholder="Misal: 081234567890" class="mt-1.5 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan" value="<?= old('pendidikan') ?>" placeholder="Misal: S1 Pendidikan" class="mt-1.5 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Jenis Kelamin</label>
                    <div class="mt-2.5 flex space-x-6">
                        <label class="flex items-center text-sm cursor-pointer group">
                            <input type="radio" name="jenis_kelamin" value="L" <?= old('jenis_kelamin') == 'L' ? 'checked' : '' ?> class="text-indigo-600 focus:ring-indigo-500 mr-2 border-gray-300"> 
                            <span class="group-hover:text-indigo-600 font-medium">Laki-laki</span>
                        </label>
                        <label class="flex items-center text-sm cursor-pointer group">
                            <input type="radio" name="jenis_kelamin" value="P" <?= old('jenis_kelamin') == 'P' ? 'checked' : '' ?> class="text-indigo-600 focus:ring-indigo-500 mr-2 border-gray-300"> 
                            <span class="group-hover:text-indigo-600 font-medium">Perempuan</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" class="mt-1.5 w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm"><?= old('alamat') ?></textarea>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 self-start">
                    <h2 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3">Unggah Foto</h2>
                    
                    <div>
                        <div id="wrapper-preview" class="hidden mb-3">
                            <div class="relative w-full h-40">
                                <img id="preview-img" class="w-full h-full object-cover rounded-lg border border-gray-200 shadow-sm" src="#" alt="Preview Foto">
                                <button type="button" onclick="resetGambar()" class="absolute top-2 right-2 bg-white/90 p-1.5 rounded-full text-rose-600 hover:bg-white hover:text-rose-700 shadow-sm transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div id="kotak-upload" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-lg hover:border-indigo-300 transition-all cursor-pointer">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Upload file foto</span>
                                        <input id="file-upload" name="foto" type="file" class="sr-only" accept="image/*" onchange="bacaGambar(this)">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold px-6 py-2.5 rounded-lg text-sm shadow-md shadow-indigo-100 transition-all duration-200 transform hover:-translate-y-0.5">
                Simpan Data Guru
            </button>
        </div>
    </form>
</div>

<script>
function bacaGambar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            let previewImg = document.getElementById('preview-img');
            let wrapperPreview = document.getElementById('wrapper-preview');
            let kotakUpload = document.getElementById('kotak-upload');

            previewImg.src = e.target.result;
            wrapperPreview.classList.remove('hidden');
            kotakUpload.classList.add('hidden');
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function resetGambar() {
    let inputFoto = document.getElementById('file-upload');
    let wrapperPreview = document.getElementById('wrapper-preview');
    let kotakUpload = document.getElementById('kotak-upload');
    
    inputFoto.value = '';
    wrapperPreview.classList.add('hidden');
    kotakUpload.classList.remove('hidden');
}
</script>

<?= $this->endSection() ?>
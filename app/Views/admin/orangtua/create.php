<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-5xl">
    <div class="mb-8">
        <a href="/admin/orangtua" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center mb-2 gap-1 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Orang Tua
        </a>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Data Orang Tua</h1>
        <p class="text-sm text-gray-500 mt-1">Silakan lengkapi formulir di bawah untuk mendaftarkan wali santri baru.</p>
    </div>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 px-4 py-3.5 rounded-lg mb-6 shadow-sm flex items-start gap-3">
            <svg class="w-5 h-5 text-rose-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <div>
                <span class="text-sm font-bold">Terjadi Kesalahan:</span>
                <ul class="text-xs mt-1 list-disc list-inside">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <form action="/admin/orangtua/store" method="POST" class="space-y-6">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4">
                    <h2 class="text-lg font-bold text-gray-800 border-b pb-2">Biodata Orang Tua</h2>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_ayah" value="<?= old('nama_ayah') ?>" placeholder="Nama lengkap ayah" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" value="<?= old('pekerjaan_ayah') ?>" placeholder="Contoh: Karyawan Swasta" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                    </div>

                    <div class="pt-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_ibu" value="<?= old('nama_ibu') ?>" placeholder="Nama lengkap ibu" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" value="<?= old('pekerjaan_ibu') ?>" placeholder="Contoh: Ibu Rumah Tangga" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4">
                    <h2 class="text-lg font-bold text-gray-800 border-b pb-2">Kontak</h2>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Handphone / WA <span class="text-rose-500">*</span></label>
                        <input type="text" name="no_hp" value="<?= old('no_hp') ?>" placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="<?= old('email') ?>" placeholder="orangtua@email.com" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 h-fit">
                <h2 class="text-lg font-bold text-gray-800 border-b pb-2">Domisili & Alamat</h2>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                    <select id="provinsi" name="provinsi" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm bg-gray-50 cursor-pointer">
                        <option value="">-- Pilih Provinsi --</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kabupaten / Kota</label>
                    <select id="kabupaten" name="kabupaten" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm bg-gray-50 cursor-not-allowed" disabled>
                        <option value="">-- Pilih Kabupaten --</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                    <select id="kecamatan" name="kecamatan" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm bg-gray-50 cursor-not-allowed" disabled>
                        <option value="">-- Pilih Kecamatan --</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelurahan / Desa</label>
                    <select id="kelurahan" name="kelurahan" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm bg-gray-50 cursor-not-allowed" disabled>
                        <option value="">-- Pilih Kelurahan --</option>
                    </select>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">RT</label>
                        <input type="text" name="rt" value="<?= old('rt') ?>" placeholder="001" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">RW</label>
                        <input type="text" name="rw" value="<?= old('rw') ?>" placeholder="002" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                        <input type="text" name="kode_pos" value="<?= old('kode_pos') ?>" placeholder="xxxxx" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap (Jalan / Gg)</label>
                    <textarea name="alamat" rows="2" placeholder="Tulis nama jalan, nomor rumah, atau patokan..." class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm"><?= old('alamat') ?></textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="/admin/orangtua" class="bg-white text-gray-700 px-6 py-2.5 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all text-sm font-medium">Batal</a>
            <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium px-8 py-2.5 rounded-xl text-sm shadow-lg shadow-emerald-100 transition-all duration-200 transform hover:-translate-y-0.5">Simpan Data</button>
        </div>
    </form>
</div>

<script>
    const provSelect = document.getElementById('provinsi');
    const kabSelect  = document.getElementById('kabupaten');
    const kecSelect  = document.getElementById('kecamatan');
    const kelSelect  = document.getElementById('kelurahan');

    // Fungsi reset dropdown
    function resetSelect(select, text, disable = true) {
        select.innerHTML = `<option value="">-- ${text} --</option>`;
        if (disable) {
            select.classList.add('cursor-not-allowed', 'bg-gray-50');
            select.classList.remove('bg-white');
            select.disabled = true;
        } else {
            select.classList.remove('cursor-not-allowed', 'bg-gray-50');
            select.classList.add('bg-white');
            select.disabled = false;
        }
    }

    // 1. Ambil Data Provinsi (MENGGUNAKAN SERVER BARU)
    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json`)
        .then(response => response.json())
        .then(provinces => {
            provSelect.classList.remove('bg-gray-50');
            provSelect.classList.add('bg-white');
            provinces.forEach(prov => {
                let option = document.createElement('option');
                option.value = prov.name; // Simpan Nama Provinsinya
                option.setAttribute('data-id', prov.id); // Simpan ID untuk fetch berikutnya
                option.text = prov.name;
                provSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error Prov:', error));

    // 2. Event Provinsi Berubah -> Ambil Kabupaten
    provSelect.addEventListener('change', function() {
        resetSelect(kabSelect, 'Pilih Kabupaten', true);
        resetSelect(kecSelect, 'Pilih Kecamatan', true);
        resetSelect(kelSelect, 'Pilih Kelurahan', true);

        const selectedOption = this.options[this.selectedIndex];
        const provId = selectedOption.getAttribute('data-id');

        if (!provId) return;

        resetSelect(kabSelect, 'Pilih Kabupaten', false);
        
        // SUDAH DIUPDATE KE SERVER BARU
        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`)
            .then(response => response.json())
            .then(regencies => {
                regencies.forEach(reg => {
                    let option = document.createElement('option');
                    option.value = reg.name;
                    option.setAttribute('data-id', reg.id);
                    option.text = reg.name;
                    kabSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error Kab:', error));
    });

    // 3. Event Kabupaten Berubah -> Ambil Kecamatan
    kabSelect.addEventListener('change', function() {
        resetSelect(kecSelect, 'Pilih Kecamatan', true);
        resetSelect(kelSelect, 'Pilih Kelurahan', true);

        const selectedOption = this.options[this.selectedIndex];
        const kabId = selectedOption.getAttribute('data-id');

        if (!kabId) return;

        resetSelect(kecSelect, 'Pilih Kecamatan', false);
        
        // SUDAH DIUPDATE KE SERVER BARU
        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabId}.json`)
            .then(response => response.json())
            .then(districts => {
                districts.forEach(dist => {
                    let option = document.createElement('option');
                    option.value = dist.name;
                    option.setAttribute('data-id', dist.id);
                    option.text = dist.name;
                    kecSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error Kec:', error));
    });

    // 4. Event Kecamatan Berubah -> Ambil Kelurahan
    kecSelect.addEventListener('change', function() {
        resetSelect(kelSelect, 'Pilih Kelurahan', true);

        const selectedOption = this.options[this.selectedIndex];
        const kecId = selectedOption.getAttribute('data-id');

        if (!kecId) return;

        resetSelect(kelSelect, 'Pilih Kelurahan', false);
        
        // SUDAH DIUPDATE KE SERVER BARU
        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecId}.json`)
            .then(response => response.json())
            .then(villages => {
                villages.forEach(vill => {
                    let option = document.createElement('option');
                    option.value = vill.name;
                    option.text = vill.name;
                    kelSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error Kel:', error));
    });
</script>
<?= $this->endSection() ?>
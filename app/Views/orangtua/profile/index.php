<?= $this->extend('orangtua/layouts/main') ?>

<?= $this->section('content') ?>
<main class="p-4 lg:p-6 space-y-5">
    
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-md shadow-indigo-100">
                <i class="fas fa-user-shield text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight uppercase italic">Profil Orang Tua</h2>
                <p class="text-[11px] text-slate-500 font-bold uppercase tracking-wider">Update informasi wali & keamanan akun</p>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-4 py-3 rounded-xl text-xs font-bold shadow-sm animate-bounce-short">
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
            <form action="/orangtua/profile/update" method="POST" class="bg-white rounded-[2rem] p-6 lg:p-8 shadow-sm border border-slate-100">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= $orangtua['id'] ?>">
                
                <div class="flex items-center mb-8">
                    <span class="w-2 h-6 bg-indigo-500 rounded-full mr-3"></span>
                    <h3 class="font-black text-slate-800 uppercase text-sm tracking-widest">Identitas Wali Santri</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Ayah</label>
                        <input type="text" name="nama_ayah" value="<?= old('nama_ayah', $orangtua['nama_ayah']) ?>" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-indigo-500 focus:bg-white transition-all outline-none text-sm font-bold text-slate-700 shadow-sm shadow-slate-100/50">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" value="<?= old('pekerjaan_ayah', $orangtua['pekerjaan_ayah']) ?>" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-indigo-500 transition-all outline-none text-sm font-bold text-slate-700">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Ibu</label>
                        <input type="text" name="nama_ibu" value="<?= old('nama_ibu', $orangtua['nama_ibu']) ?>" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-indigo-500 focus:bg-white transition-all outline-none text-sm font-bold text-slate-700 shadow-sm shadow-slate-100/50">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" value="<?= old('pekerjaan_ibu', $orangtua['pekerjaan_ibu']) ?>" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-indigo-500 transition-all outline-none text-sm font-bold text-slate-700">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">No. WhatsApp Aktif</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">+62</span>
                            <input type="text" name="no_hp" value="<?= old('no_hp', $orangtua['no_hp']) ?>" class="w-full pl-12 pr-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-indigo-500 transition-all outline-none text-sm font-bold text-slate-700">
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email</label>
                        <input type="email" name="email" value="<?= old('email', $orangtua['email']) ?>" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-indigo-500 transition-all outline-none text-sm font-bold text-slate-700">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:col-span-2 pt-4 border-t border-slate-50">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Provinsi</label>
                            <select id="provinsi" name="provinsi" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-indigo-500 outline-none text-sm font-bold text-slate-700 cursor-pointer">
                                <option value="<?= $orangtua['provinsi'] ?>"><?= $orangtua['provinsi'] ?: '-- Pilih Provinsi --' ?></option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kabupaten / Kota</label>
                            <select id="kabupaten" name="kabupaten" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-indigo-500 outline-none text-sm font-bold text-slate-700 cursor-pointer">
                                <option value="<?= $orangtua['kabupaten'] ?>"><?= $orangtua['kabupaten'] ?: '-- Pilih Kabupaten --' ?></option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kecamatan</label>
                            <select id="kecamatan" name="kecamatan" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-indigo-500 outline-none text-sm font-bold text-slate-700 cursor-pointer">
                                <option value="<?= $orangtua['kecamatan'] ?>"><?= $orangtua['kecamatan'] ?: '-- Pilih Kecamatan --' ?></option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kelurahan / Desa</label>
                            <select id="kelurahan" name="kelurahan" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-indigo-500 outline-none text-sm font-bold text-slate-700 cursor-pointer">
                                <option value="<?= $orangtua['kelurahan'] ?>"><?= $orangtua['kelurahan'] ?: '-- Pilih Kelurahan --' ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="md:col-span-2 space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat Lengkap (Jalan / Gg / No. Rumah)</label>
                        <textarea name="alamat" rows="2" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:border-indigo-500 transition-all outline-none text-sm font-bold text-slate-700 resize-none"><?= $orangtua['alamat'] ?></textarea>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:col-span-2">
                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">RT / RW</label>
                            <div class="flex items-center space-x-2">
                                <input type="text" name="rt" placeholder="RT" value="<?= $orangtua['rt'] ?>" class="w-full px-3 py-3 bg-slate-50 border border-slate-100 rounded-xl text-xs font-bold text-slate-700">
                                <input type="text" name="rw" placeholder="RW" value="<?= $orangtua['rw'] ?>" class="w-full px-3 py-3 bg-slate-50 border border-slate-100 rounded-xl text-xs font-bold text-slate-700">
                            </div>
                        </div>
                        <div class="space-y-1 md:col-span-1">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Kode Pos</label>
                            <input type="text" name="kode_pos" value="<?= $orangtua['kode_pos'] ?>" class="w-full px-3 py-3 bg-slate-50 border border-slate-100 rounded-xl text-xs font-bold text-slate-700">
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-slate-50 flex justify-end">
                    <button type="submit" class="w-full md:w-auto px-10 py-4 bg-indigo-600 hover:bg-slate-900 text-white text-xs font-black rounded-2xl shadow-xl shadow-indigo-100 transition-all active:scale-95 flex items-center justify-center space-x-2">
                        <i class="fas fa-save mr-2"></i>
                        <span>SIMPAN DATA PROFILE</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                <div class="flex items-center mb-6">
                    <span class="w-2 h-6 bg-rose-500 rounded-full mr-3"></span>
                    <h3 class="font-black text-slate-800 uppercase text-sm tracking-widest">Ganti Password</h3>
                </div>

                <form action="/orangtua/profile/update-password" method="POST" class="space-y-4">
                    <?= csrf_field() ?>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Password Lama</label>
                        <input type="password" name="old_password" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm outline-none focus:border-rose-300 transition-all font-bold text-slate-700">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Password Baru</label>
                        <input type="password" name="new_password" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm outline-none focus:border-indigo-300 transition-all font-bold text-slate-700">
                    </div>
                    <button type="submit" class="w-full py-4 bg-slate-800 text-white text-xs font-black rounded-2xl hover:bg-black transition-all shadow-lg active:scale-95">
                        UPDATE KEAMANAN
                    </button>
                </form>
            </div>

            <div class="bg-indigo-900 rounded-[2rem] p-8 text-white relative overflow-hidden group">
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center mb-4">
                        <i class="fas fa-info-circle text-xl text-indigo-300"></i>
                    </div>
                    <h4 class="font-black text-sm mb-2 italic uppercase tracking-wider text-indigo-300">Informasi Penting</h4>
                    <p class="text-indigo-100 text-[11px] leading-relaxed font-medium">Mohon pastikan nomor WhatsApp yang Anda masukkan aktif untuk menerima notifikasi perkembangan belajar ananda secara real-time.</p>
                </div>
                <i class="fas fa-whatsapp absolute -right-4 -bottom-4 text-7xl text-white/5 rotate-12 group-hover:rotate-0 transition-all duration-700"></i>
            </div>
        </div>

    </div>
</main>

<script>
    const provSelect = document.getElementById('provinsi');
    const kabSelect  = document.getElementById('kabupaten');
    const kecSelect  = document.getElementById('kecamatan');
    const kelSelect  = document.getElementById('kelurahan');

    // Data dari Database (PHP)
    const savedProv = "<?= $orangtua['provinsi'] ?>";
    const savedKab  = "<?= $orangtua['kabupaten'] ?>";
    const savedKec  = "<?= $orangtua['kecamatan'] ?>";
    const savedKel  = "<?= $orangtua['kelurahan'] ?>";

    function resetSelect(select, text, disable = true) {
        select.innerHTML = `<option value="">-- Pilih ${text} --</option>`;
        select.disabled = disable;
        disable ? select.classList.add('opacity-50') : select.classList.remove('opacity-50');
    }

    // 1. Init & Load Provinsi
    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json`)
        .then(res => res.json())
        .then(data => {
            data.forEach(prov => {
                let opt = document.createElement('option');
                opt.value = prov.name;
                opt.setAttribute('data-id', prov.id);
                opt.text = prov.name;
                if (prov.name === savedProv) opt.selected = true;
                provSelect.appendChild(opt);
            });
            // Jika ada data provinsi, trigger load kabupaten
            if (savedProv) provSelect.dispatchEvent(new Event('change'));
        });

    // 2. Event Provinsi -> Kabupaten
    provSelect.addEventListener('change', function() {
        const id = this.options[this.selectedIndex]?.getAttribute('data-id');
        if (!id) return;

        resetSelect(kabSelect, 'Kabupaten', false);
        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${id}.json`)
            .then(res => res.json())
            .then(data => {
                data.forEach(reg => {
                    let opt = document.createElement('option');
                    opt.value = reg.name;
                    opt.setAttribute('data-id', reg.id);
                    opt.text = reg.name;
                    if (reg.name === savedKab) opt.selected = true;
                    kabSelect.appendChild(opt);
                });
                if (savedKab) kabSelect.dispatchEvent(new Event('change'));
            });
    });

    // 3. Event Kabupaten -> Kecamatan
    kabSelect.addEventListener('change', function() {
        const id = this.options[this.selectedIndex]?.getAttribute('data-id');
        if (!id) return;

        resetSelect(kecSelect, 'Kecamatan', false);
        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${id}.json`)
            .then(res => res.json())
            .then(data => {
                data.forEach(dist => {
                    let opt = document.createElement('option');
                    opt.value = dist.name;
                    opt.setAttribute('data-id', dist.id);
                    opt.text = dist.name;
                    if (dist.name === savedKec) opt.selected = true;
                    kecSelect.appendChild(opt);
                });
                if (savedKec) kecSelect.dispatchEvent(new Event('change'));
            });
    });

    // 4. Event Kecamatan -> Kelurahan
    kecSelect.addEventListener('change', function() {
        const id = this.options[this.selectedIndex]?.getAttribute('data-id');
        if (!id) return;

        resetSelect(kelSelect, 'Kelurahan', false);
        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${id}.json`)
            .then(res => res.json())
            .then(data => {
                data.forEach(vill => {
                    let opt = document.createElement('option');
                    opt.value = vill.name;
                    opt.text = vill.name;
                    if (vill.name === savedKel) opt.selected = true;
                    kelSelect.appendChild(opt);
                });
            });
    });
</script>

<?= $this->endSection() ?>
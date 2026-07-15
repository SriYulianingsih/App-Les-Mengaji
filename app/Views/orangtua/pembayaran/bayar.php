<?= $this->extend('orangtua/layouts/main') ?>

<?= $this->section('content') ?>
<main class="p-4 lg:p-8 max-w-5xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase italic tracking-tighter leading-none">
                Konfirmasi Bayar: <span class="text-indigo-600"><?= $santri['nama'] ?></span>
            </h2>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] italic mt-1">Scan QRIS atau Transfer lalu unggah bukti transaksi</p>
        </div>
        
        <a href="<?= base_url('orangtua/pembayaran') ?>" class="inline-flex items-center space-x-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all w-fit border border-slate-200">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <form action="<?= base_url('orangtua/pembayaran/simpan') ?>" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <?= csrf_field() ?>
        
        <input type="hidden" name="santri_id" value="<?= $santri['id'] ?>">
        <input type="hidden" name="id" value="<?= $tagihan['id'] ?? '' ?>"> 
        <input type="hidden" name="metode_pembayaran" value="transfer">

        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white rounded-[2rem] p-6 lg:p-8 shadow-xl shadow-slate-100 border border-slate-100 space-y-6">
                
                <div class="space-y-1.5">
                    <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-[0.15em]">Kategori Pembayaran</label>
                    <select name="kategori_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl font-bold text-slate-700 outline-none focus:border-indigo-500 focus:bg-white transition-all text-sm">
                        <?php foreach($kategori as $k): ?>
                            <option value="<?= $k['id'] ?>" <?= (isset($tagihan) && $tagihan['kategori_id'] == $k['id']) ? 'selected' : '' ?>>
                                <?= $k['nama_kategori'] ?> — (Rp <?= number_format($k['nominal_std'], 0, ',', '.') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-[0.15em]">Bulan</label>
                        <select name="bulan" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl font-bold text-slate-700 outline-none focus:border-indigo-500 focus:bg-white text-sm text-center">
                            <?php 
                            $listBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
                            foreach($listBulan as $num => $nama): 
                            ?>
                                <option value="<?= $num ?>" <?= (isset($tagihan) ? $tagihan['bulan'] == $num : date('n') == $num) ? 'selected' : '' ?>>
                                    <?= $nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-[0.15em]">Tahun</label>
                        <input type="number" name="tahun" value="<?= $tagihan['tahun'] ?? date('Y') ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl font-bold text-slate-700 outline-none focus:border-indigo-500 focus:bg-white text-sm text-center">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] font-black text-indigo-500 uppercase ml-1 tracking-[0.15em]">Nominal Yang Dibayar (Rp)</label>
                    <input type="text" id="rupiah" name="jumlah_bayar" required placeholder="0" value="<?= isset($tagihan) ? number_format($tagihan['jumlah_bayar'], 0, ',', '.') : '' ?>" class="w-full px-4 py-3 bg-indigo-50 border border-indigo-100 rounded-xl font-black text-indigo-600 outline-none focus:border-indigo-500 focus:bg-white text-xl italic">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-[0.15em]">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="2" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl font-bold text-slate-700 outline-none focus:border-indigo-500 focus:bg-white text-sm" placeholder="Contoh: Pembayaran SPP bulan Mei..."><?= $tagihan['keterangan'] ?? '' ?></textarea>
                </div>

                <div class="pt-4 border-t border-slate-50">
                    <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-[0.15em] mb-3 block">Unggah Bukti Transaksi</label>
                    <div class="relative min-h-[150px]">
                        <input type="file" name="bukti_pembayaran" id="bukti" class="hidden" accept="image/*" onchange="previewImg()" required>
                        <label for="bukti" class="cursor-pointer border-2 border-dashed border-slate-200 rounded-2xl h-[150px] flex items-center justify-center hover:bg-slate-50 hover:border-indigo-300 transition-all overflow-hidden group">
                            <img id="img-preview" class="hidden w-full h-full object-cover">
                            <div id="placeholder" class="text-center">
                                <i class="fas fa-cloud-upload-alt text-2xl text-slate-300 group-hover:text-indigo-500 mb-2"></i>
                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest leading-relaxed text-xs">Pilih Foto Bukti</p>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-slate-900 hover:bg-black text-white rounded-2xl font-black uppercase italic tracking-[0.2em] shadow-lg transition-all flex items-center justify-center space-x-3 group">
                    <span class="text-xs">Kirim Konfirmasi Pembayaran</span>
                    <i class="fas fa-paper-plane text-[10px] group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>
        </div>

        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-[2rem] p-6 shadow-xl shadow-slate-100 border border-slate-100 text-center">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 italic">Scan untuk bayar otomatis</p>
                <div class="bg-slate-50 p-4 rounded-3xl border border-slate-100 inline-block mb-4">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=CAHAYAHIDAYAHQURANI_PAYMENT" alt="QRIS" class="w-48 h-48 mx-auto rounded-xl shadow-sm">
                </div>
                <div class="flex items-center justify-center space-x-2">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" class="h-4 opacity-70" alt="Logo QRIS">
                </div>
                <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-tighter italic">Mendukung semua dompet digital & M-Banking</p>
            </div>

            <div class="bg-gradient-to-br from-indigo-600 to-violet-700 rounded-[2rem] p-6 text-white shadow-lg relative overflow-hidden">
                <i class="fas fa-university absolute -right-4 -bottom-4 text-7xl text-white/10 rotate-12"></i>
                <h5 class="text-[10px] font-black uppercase tracking-widest opacity-70 mb-4 italic">Alternatif Transfer Bank</h5>
                <div class="space-y-4 relative z-10">
                    <div>
                        <p class="text-[10px] font-bold opacity-60 uppercase">Nama Bank</p>
                        <p class="text-lg font-black tracking-wider leading-tight"><?= $rekening['nama_bank'] ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold opacity-60 uppercase">Nomor Rekening</p>
                        <p class="text-xl font-black tracking-widest leading-tight text-amber-300"><?= $rekening['nomor_rekening'] ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold opacity-60 uppercase">Atas Nama</p>
                        <p class="text-sm font-black uppercase italic"><?= $rekening['atas_nama'] ?></p>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-amber-50 border border-amber-100 rounded-2xl">
                <p class="text-[9px] font-bold text-amber-700 leading-relaxed uppercase italic">
                    <i class="fas fa-info-circle mr-1"></i> Pastikan nominal yang dimasukkan sesuai dengan tagihan agar proses verifikasi lebih cepat.
                </p>
            </div>
        </div>
    </form>
</main>

<script>
    // Script format rupiah dan preview tetap sama bang...
    const rupiah = document.getElementById('rupiah');
    rupiah.addEventListener('keyup', function(e) {
        this.value = formatRupiah(this.value);
    });

    function formatRupiah(angka) {
        if (!angka) return '';
        let number_string = angka.toString().replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    }

    function previewImg() {
        const file = document.querySelector('#bukti');
        const imgPreview = document.querySelector('#img-preview');
        const placeholder = document.querySelector('#placeholder');
        const fileReader = new FileReader();
        if(file.files[0]) {
            fileReader.readAsDataURL(file.files[0]);
            fileReader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
        }
    }
</script>
<?= $this->endSection() ?>
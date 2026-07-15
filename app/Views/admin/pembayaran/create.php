<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-4xl">
    <div class="mb-8">
        <a href="/admin/pembayaran" class="text-xs font-bold text-indigo-600 uppercase tracking-widest flex items-center gap-2 mb-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Catat Pembayaran Manual</h1>
        <p class="text-sm text-slate-500 mt-1">Gunakan form ini untuk input pembayaran langsung atau cash.</p>
    </div>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 px-4 py-3 rounded-xl mb-6 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-widest mb-1">Ada Kesalahan:</p>
            <ul class="list-disc list-inside text-xs">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        <form action="/admin/pembayaran/store" method="post">
            <?= csrf_field() ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Pilih Santri</label>
                    <select name="santri_id" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-700" required>
                        <option value="">-- Cari Nama Santri --</option>
                        <?php foreach($santri as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= old('santri_id') == $s['id'] ? 'selected' : '' ?>>
                                <?= $s['nis'] ?> - <?= $s['nama'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Kategori Biaya</label>
                    <select name="kategori_id" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-700" required>
                        <?php foreach($kategori as $k): ?>
                            <option value="<?= $k['id'] ?>" <?= old('kategori_id') == $k['id'] ? 'selected' : '' ?>>
                                <?= $k['nama_kategori'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Jumlah Bayar (Rp)</label>
                    <input type="text" id="jumlah_bayar" name="jumlah_bayar" value="<?= old('jumlah_bayar') ?>" placeholder="Rp 0" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-700" required>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Untuk Bulan</label>
                    <select name="bulan" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-700">
                        <?php 
                        $bulanIndo = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        $blnNow = date('n');
                        foreach($bulanIndo as $num => $nama): ?>
                            <option value="<?= $num ?>" <?= (old('bulan') == $num || (!old('bulan') && $num == $blnNow)) ? 'selected' : '' ?>>
                                <?= $nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Tahun</label>
                    <input type="number" name="tahun" value="<?= old('tahun') ?? date('Y') ?>" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-700" required>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-700">
                        <option value="cash" <?= old('metode_pembayaran') == 'cash' ? 'selected' : '' ?>>Cash / Tunai</option>
                        <option value="transfer" <?= old('metode_pembayaran') == 'transfer' ? 'selected' : '' ?>>Transfer Bank</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Status Transaksi</label>
                    <select name="status" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-700">
                        <option value="lunas" <?= old('status') == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                        <option value="belum" <?= old('status') == 'belum' ? 'selected' : '' ?>>Belum Lunas</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Tanggal Bayar</label>
                    <input type="date" name="tanggal_bayar" value="<?= old('tanggal_bayar') ?? date('Y-m-d') ?>" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-700" required>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Keterangan</label>
                    <input type="text" name="keterangan" value="<?= old('keterangan') ?>" placeholder="Misal: Lunas didepan" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-700">
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3.5 rounded-2xl shadow-lg shadow-indigo-100 transition-all text-sm font-black uppercase tracking-widest">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const jumlahBayar = document.getElementById('jumlah_bayar');
    
    // Auto format rupiah saat mengetik
    jumlahBayar.addEventListener('keyup', function(e) {
        this.value = formatRupiah(this.value, 'Rp ');
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
    }
</script>
<?= $this->endSection() ?>
<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-4xl">
    <div class="mb-8 text-left">
        <a href="/admin/pembayaran" class="text-xs font-bold text-indigo-600 uppercase tracking-widest flex items-center gap-2 mb-2">
            <i class="fas fa-arrow-left"></i> Batal Edit
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Transaksi</h1>
        <p class="text-sm text-slate-500 mt-1">Perbarui detail pembayaran santri secara teliti.</p>
    </div>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 px-4 py-3 rounded-xl mb-6 shadow-sm">
            <ul class="list-disc list-inside text-xs font-bold uppercase tracking-tight">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
        <form action="/admin/pembayaran/update/<?= $pembayaran['id'] ?>" method="post">
            <?= csrf_field() ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Nama Santri</label>
                    <select name="santri_id" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all">
                        <?php foreach($santri as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= $s['id'] == $pembayaran['santri_id'] ? 'selected' : '' ?>>
                                <?= $s['nis'] ?> - <?= $s['nama'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Kategori Biaya</label>
                    <select name="kategori_id" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all">
                        <?php foreach($kategori as $k): ?>
                            <option value="<?= $k['id'] ?>" <?= $k['id'] == $pembayaran['kategori_id'] ? 'selected' : '' ?>>
                                <?= $k['nama_kategori'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Jumlah Bayar (Rp)</label>
                    <input type="text" id="jumlah_bayar" name="jumlah_bayar" value="Rp <?= number_format($pembayaran['jumlah_bayar'], 0, ',', '.') ?>" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Untuk Bulan</label>
                    <select name="bulan" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all">
                        <?php 
                        $bulanIndo = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        foreach($bulanIndo as $num => $nama): ?>
                            <option value="<?= $num ?>" <?= $num == $pembayaran['bulan'] ? 'selected' : '' ?>><?= $nama ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Tahun</label>
                    <input type="number" name="tahun" value="<?= $pembayaran['tahun'] ?>" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="cash" <?= $pembayaran['metode_pembayaran'] == 'cash' ? 'selected' : '' ?>>Cash / Tunai </option>
                        <option value="Transfer" <?= $pembayaran['metode_pembayaran'] == 'Transfer' ? 'selected' : '' ?>>Transfer</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Status Pembayaran</label>
                    <select name="status" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="lunas" <?= strtolower($pembayaran['status']) == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                        <option value="belum" <?= in_array(strtolower($pembayaran['status']), ['belum', 'pending']) ? 'selected' : '' ?>>Belum Lunas</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Keterangan</label>
                    <input type="text" name="keterangan" value="<?= esc($pembayaran['keterangan']) ?>" placeholder="Catatan tambahan..." class="w-full bg-slate-50 border-none rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3.5 rounded-2xl shadow-lg shadow-indigo-100 transition-all text-sm font-black uppercase tracking-widest">
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const jumlahBayar = document.getElementById('jumlah_bayar');
    
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
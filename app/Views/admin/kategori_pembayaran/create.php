<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-4xl">
    <div class="mb-8 text-left">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Tambah Kategori</h1>
        <p class="text-sm text-slate-500 mt-1">Tentukan nama tagihan dan nominal dasar.</p>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">
        <form action="/admin/kategori-pembayaran/store" method="POST" class="space-y-6 text-left">
            <?= csrf_field() ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2">Nama Kategori</label>
                    <input type="text" name="nama_kategori" placeholder="Contoh: SPP Bulanan" required
                           class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none font-bold text-slate-700 transition-all">
                </div>
                <div>
                    <label class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2">Nominal Standar (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-black text-slate-400">Rp</span>
                        <input type="text" id="rupiah" name="nominal_std" placeholder="0" required
                               class="w-full pl-12 pr-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none font-black text-slate-700 transition-all">
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                <a href="/admin/kategori-pembayaran" class="text-sm font-bold text-slate-400 hover:text-slate-600">Batal</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-8 py-3.5 rounded-2xl text-sm shadow-lg shadow-indigo-100 transition-all transform hover:-translate-y-1">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const rupiah = document.getElementById('rupiah');
    rupiah.addEventListener('keyup', function(e) {
        this.value = formatRupiah(this.value);
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
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>
<?= $this->endSection() ?>
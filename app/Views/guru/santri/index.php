<?= $this->extend('guru/layouts/main') ?> 
<?= $this->section('content') ?>

<main class="p-4 lg:p-6 space-y-6">
    
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-100">
                <i class="fas fa-user-graduate text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight">Data Santri</h2>
                <p class="text-[11px] text-slate-500 font-bold uppercase tracking-wider">Daftar santri aktif di kelas Anda</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center group focus-within:border-indigo-300 transition-all">
        <i class="fas fa-search text-slate-300 ml-2 group-focus-within:text-indigo-400"></i>
        <input type="text" id="searchSantri" placeholder="Cari nama santri..." class="w-full px-4 bg-transparent outline-none text-sm font-semibold text-slate-600">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="santriGrid">
        <?php if (!empty($santri)) : ?>
            <?php foreach ($santri as $s) : ?>
                <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-sm hover:shadow-xl hover:border-indigo-200 transition-all group">
                    <div class="flex flex-col items-center text-center">
                        
                        <div class="relative mb-4">
                            <div class="w-20 h-20 rounded-[1.5rem] overflow-hidden bg-slate-100 border-4 border-white shadow-md group-hover:scale-105 transition-transform">
                                <?php if(!empty($s['foto'])): ?>
                                    <img src="<?= base_url('uploads/santri/' . $s['foto']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300">
                                        <i class="fas fa-user text-3xl"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <span class="absolute -bottom-1 -right-1 w-6 h-6 <?= $s['status'] == 'Aktif' ? 'bg-emerald-500' : 'bg-slate-300' ?> border-4 border-white rounded-full"></span>
                        </div>

                        <h3 class="font-black text-slate-800 leading-tight mb-1 truncate w-full px-2"><?= $s['nama'] ?></h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-3"><?= $s['nis'] ?></p>
                        
                        <div class="px-4 py-1.5 bg-slate-50 rounded-full text-[10px] font-black text-slate-500 mb-5 border border-slate-100">
                            <?= !empty($s['nama_kelas']) ? 'KELAS ' . strtoupper($s['nama_kelas']) : 'TANPA KELAS' ?>
                        </div>

                        <div class="grid grid-cols-2 gap-2 w-full">
                            <?php if(!empty($s['no_hp'])): ?>
                                <a href="https://wa.me/<?= str_replace(['+', '-', ' '], '', $s['no_hp']) ?>" target="_blank" class="flex items-center justify-center p-3 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-500 hover:text-white transition-all shadow-sm">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            <?php else: ?>
                                <button onclick="Swal.fire('Afwan', 'Nomor HP Wali belum terdaftar.', 'info')" class="flex items-center justify-center p-3 bg-slate-50 text-slate-300 rounded-xl cursor-not-allowed">
                                    <i class="fab fa-whatsapp"></i>
                                </button>
                            <?php endif; ?>

                            <a href="<?= base_url('guru/santri/detail/' . $s['id']) ?>" class="flex items-center justify-center p-3 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-span-full py-20 text-center bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-slate-200 mx-auto mb-4 shadow-sm">
                    <i class="fas fa-user-slash text-2xl"></i>
                </div>
                <p class="font-bold text-slate-400 italic">Afwan, belum ada santri terdaftar di kelas binaan Anda.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
    // Live Search Logic
    document.getElementById('searchSantri').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        let cards = document.querySelectorAll('#santriGrid > div:not(.col-span-full)');
        
        cards.forEach(card => {
            let name = card.querySelector('h3').innerText.toLowerCase();
            let nis = card.querySelector('p').innerText.toLowerCase();
            if(name.includes(val) || nis.includes(val)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>

<?= $this->endSection() ?>
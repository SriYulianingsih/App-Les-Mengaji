<header class="sticky top-0 z-[100] border-b border-emerald-100 bg-slate-50 shadow-sm">
    <div class="px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <button @click="sidebarOpen = true" class="text-slate-600 hover:text-emerald-600 focus:outline-none lg:hidden mr-1">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <div class="w-10 h-10 rounded-xl overflow-hidden shadow-md hidden sm:block bg-white p-1">
                <img src="<?= base_url('images/logo.png') ?>" alt="Logo" class="w-full h-full object-contain">
            </div>

            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight leading-none">App Les Privat Mengaji</h1>
                <p class="text-[10px] text-emerald-600 font-black uppercase tracking-widest mt-1">Cahaya Hidayah Qurani</p>
            </div>
        </div>

        <div class="hidden md:flex items-center w-1/3" x-data="{ 
                searchQuery: '', 
                results: [], 
                showDropdown: false,
                loading: false,
                fetchSearch() {
    let q = this.searchQuery.trim();
    if (q.length < 2) {
        this.results = [];
        this.showDropdown = false;
        return;
    }
    this.loading = true;
    this.showDropdown = true;
    
    // Pastikan base_url bersih dari slash di akhir, lalu tambah route guru/search_ajax
    // Pakai window.location.origin jika base_url dirasa bermasalah
    let base = '<?= rtrim(base_url(), "/") ?>';
    let targetUrl = base + '/guru/search_ajax';
    
    fetch(`${targetUrl}?q=${encodeURIComponent(q)}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest' // Penting untuk request AJAX di CI4
        }
    })
    .then(res => {
        if (!res.ok) {
            // Kalau error, kita lihat statusnya di console
            console.error('Server balikkin status:', res.status);
            throw new Error('Network response was not ok');
        }
        return res.json();
    })
    .then(data => {
        this.results = data;
        this.loading = false;
    })
    .catch(err => {
        this.loading = false;
        console.error('AJAX Error:', err);
    });
}
             }">
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="fas fa-search" x-show="!loading"></i>
                    <i class="fas fa-spinner fa-spin text-emerald-500" x-show="loading" x-cloak></i>
                </span>
                <input 
                    type="text" 
                    x-model="searchQuery"
                    @input.debounce.300ms="fetchSearch()"
                    @focus="if(searchQuery.trim().length >= 2) showDropdown = true"
                    @click.outside="showDropdown = false"
                    placeholder="Cari nama santri..." 
                    class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-400 focus:outline-none text-sm shadow-sm transition-all bg-white">

                <div x-show="showDropdown" x-transition x-cloak
                     class="absolute left-0 mt-2 w-full bg-white rounded-xl shadow-lg border border-slate-100 z-[110] overflow-hidden max-h-64 overflow-y-auto">
                    
                    <template x-for="item in results" :key="item.id">
    <a :href="'<?= rtrim(base_url(), '/') ?>/guru/santri/detail/' + item.id" 
       class="flex items-center px-4 py-3 hover:bg-emerald-50 border-b border-slate-50 last:border-0 transition-colors">
        
        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 font-bold text-xs mr-3">
            <span x-text="item.nama ? item.nama.substring(0, 1).toUpperCase() : '?'"></span>
        </div>

        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-slate-700 truncate" x-text="item.nama"></p>
            <p class="text-[10px] text-slate-400 capitalize" x-text="item.tipe"></p>
        </div>
        
        <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
    </a>
</template>

                    <div x-show="results.length === 0 && searchQuery.trim().length >= 2 && !loading" class="px-4 py-6 text-center">
                        <p class="text-xs text-slate-400 italic">Data santri tidak ditemukan...</p>
                    </div>
                </div>
            </div>
        </div>

        <div x-data="{ open: false }" class="relative">
            <div @click="open = !open" class="flex items-center space-x-3 cursor-pointer group">
                <div class="relative">
                    <?php 
                        $foto = session('foto');
                        $nama = session('nama') ?? session('username');
                        $jk = session('jenis_kelamin');
                    ?>
                    <?php if (!empty($foto) && $foto != 'default.jpg' && file_exists(FCPATH . 'uploads/guru/' . $foto)): ?>
                        <img src="<?= base_url('uploads/guru/' . $foto) ?>" class="w-10 h-10 rounded-xl object-cover border-2 border-white shadow-md">
                    <?php else: ?>
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-black text-xs border-2 border-white">
                            <?= strtoupper(substr($nama, 0, 2)) ?>
                        </div>
                    <?php endif; ?>
                    <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-emerald-500 rounded-full border-2 border-white"></div>
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-sm font-bold text-slate-800 leading-none"><?= $nama ?></p>
                    <p class="text-[10px] text-emerald-600 font-black uppercase mt-1 tracking-tighter"><?= ($jk == 'P') ? 'Ustadzah' : 'Ustadz' ?></p>
                </div>
                <i class="fas fa-chevron-down text-xs text-slate-400 group-hover:text-emerald-500"></i>
            </div>

            <div x-show="open" @click.outside="open = false" x-transition x-cloak
                 class="absolute right-0 mt-3 w-52 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-[150]">
                <div class="px-4 py-3 bg-emerald-50/50 border-b border-emerald-100">
                    <p class="text-[10px] text-emerald-700 font-black uppercase">Menu Pengajar</p>
                </div>
                <div class="p-1">
                    <a href="<?= base_url('guru/profile') ?>" class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-xl">
                        <i class="fas fa-user-circle mr-3 opacity-50"></i> Profil Saya
                    </a>
                    <hr class="my-1 border-slate-50">
                    <a href="<?= base_url('/logout') ?>" class="flex items-center px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 rounded-xl font-bold">
                        <i class="fas fa-sign-out-alt mr-3"></i> Keluar Sistem
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<header class="sticky top-0 z-[100] border-b border-indigo-100 bg-slate-50 shadow-sm">
    <div class="px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <button @click="sidebarOpen = true" class="text-slate-600 hover:text-indigo-600 focus:outline-none lg:hidden mr-1">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <div class="w-10 h-10 rounded-xl overflow-hidden shadow-md hidden sm:block bg-white p-1 border border-indigo-50">
                <img src="<?= base_url('images/logo.png') ?>" alt="Logo" class="w-full h-full object-contain">
            </div>

            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight leading-none italic">App Les Privat Mengaji</h1>
                <p class="text-[10px] text-indigo-600 font-black uppercase tracking-widest mt-1">Cahaya Hidayah Qurani</p>
            </div>
        </div>

        <div class="hidden md:flex items-center space-x-4 w-1/2 justify-center">
            <div class="relative w-full max-w-xs" x-data="{ 
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
                    let base = '<?= rtrim(base_url(), "/") ?>';
                    fetch(`${base}/orangtua/search_ajax?q=${encodeURIComponent(q)}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(res => res.json())
                    .then(data => { 
                        this.results = data; 
                        this.loading = false; 
                        if(data.length === 0) this.showDropdown = false;
                    })
                    .catch(() => { 
                        this.loading = false; 
                        this.showDropdown = false;
                    });
                }
            }">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <i class="fas fa-search text-[10px]" x-show="!loading"></i>
                    <i class="fas fa-circle-notch fa-spin text-indigo-500 text-[10px]" x-show="loading" x-cloak></i>
                </span>

                <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchSearch()"
                    placeholder="Cari guru atau anak..." 
                    class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400 focus:outline-none text-[11px] font-medium transition-all bg-white shadow-sm"
                    @focus="if(results.length > 0) showDropdown = true">
                
                <div x-show="showDropdown" x-transition x-cloak @click.outside="showDropdown = false"
                     class="absolute left-0 mt-2 w-full bg-white rounded-2xl shadow-2xl border border-slate-100 z-[110] overflow-hidden max-h-72 overflow-y-auto p-1">
                    
                    <template x-for="(item, index) in results" :key="index">
                        <a :href="item.url" 
                            class="flex items-center px-4 py-3 hover:bg-indigo-50 rounded-xl transition-all border-b border-slate-50 last:border-0 group">
                            
                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center mr-3 group-hover:bg-white transition-colors">
                                <i :class="item.tipe === 'Guru Privat' ? 'fas fa-chalkboard-teacher text-indigo-500' : 'fas fa-user-graduate text-emerald-500'" class="text-[10px]"></i>
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-[11px] font-bold text-slate-700 truncate" x-text="item.nama"></p>
                                <span class="text-[8px] font-black uppercase tracking-widest italic" 
                                      :class="item.tipe === 'Guru Privat' ? 'text-indigo-600' : 'text-emerald-600'"
                                      x-text="item.tipe"></span>
                            </div>
                            
                            <i class="fas fa-chevron-right text-[8px] text-slate-300 group-hover:translate-x-1 group-hover:text-indigo-500 transition-all"></i>
                        </a>
                    </template>

                    <div x-show="results.length === 0 && searchQuery.length >= 2 && !loading" class="p-4 text-center">
                        <p class="text-[10px] text-slate-400 font-bold italic">Data tidak ditemukan...</p>
                    </div>
                </div>
            </div>

            <div class="h-8 w-[1px] bg-slate-200"></div>

            <div x-data="{ open: false }" class="relative min-w-[180px]">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-2 bg-indigo-50 border border-indigo-100 rounded-xl hover:bg-indigo-100 transition-all focus:outline-none shadow-sm">
                    <div class="flex items-center space-x-3">
                        <div class="w-7 h-7 rounded-lg bg-indigo-600 flex items-center justify-center text-white shadow-sm">
                            <i class="fas fa-child text-[10px]"></i>
                        </div>
                        <div class="text-left">
                            <p class="text-[10px] text-indigo-600 font-black uppercase leading-none mb-0.5">Santri Aktif</p>
                            <p class="text-[11px] font-bold text-slate-700 truncate max-w-[80px]">
                                <?= session()->get('active_santri_nama') ?? 'Pilih Anak' ?>
                            </p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-down text-[10px] text-indigo-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" @click.outside="open = false" x-transition x-cloak
                     class="absolute right-0 mt-2 w-full bg-white rounded-xl shadow-xl border border-slate-100 z-[150] overflow-hidden p-1">
                    <?php 
                    $listAnak = session()->get('list_anak') ?? [];
                    foreach($listAnak as $anak): 
                        $isActive = (session()->get('active_santri_id') == $anak['id_santri']);
                    ?>
                    <a href="<?= base_url('orangtua/switch-anak/' . $anak['id_santri']) ?>" 
                       class="flex items-center justify-between px-3 py-2 rounded-lg transition-all <?= $isActive ? 'bg-indigo-600 text-white' : 'text-slate-600 hover:bg-indigo-50' ?>">
                        <span class="text-xs font-semibold"><?= $anak['nama_santri'] ?></span>
                        <?php if($isActive): ?>
                            <i class="fas fa-check-circle text-[10px]"></i>
                        <?php endif; ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div x-data="{ open: false }" class="relative">
            <div @click="open = !open" class="flex items-center space-x-3 cursor-pointer group">
                <div class="md:hidden w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 border border-indigo-100">
                    <i class="fas fa-users-cog"></i>
                </div>

                <div class="relative hidden md:block">
                    <?php 
                        $rawNamaIbu = session('nama_ibu') ?? 'Wali';
                        $namaTampilan = "Ibu " . $rawNamaIbu;
                    ?>
                    <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-white font-black text-xs border-2 border-white shadow-md group-hover:shadow-indigo-100 transition-all">
                        <?= strtoupper(substr($rawNamaIbu, 0, 2)) ?>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white"></div>
                </div>

                <div class="hidden lg:block text-left">
                    <p class="text-xs font-bold text-slate-800 leading-none"><?= $namaTampilan ?></p>
                    <p class="text-[9px] text-slate-400 font-bold uppercase mt-1">Wali Ibu</p>
                </div>
                <i class="fas fa-chevron-down text-[10px] text-slate-400 group-hover:text-indigo-500 hidden md:block"></i>
            </div>

            <div x-show="open" @click.outside="open = false" x-transition x-cloak
                 class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden z-[150]">
                
                <div class="md:hidden p-3 bg-indigo-50 border-b border-indigo-100">
                    <p class="text-[9px] text-indigo-700 font-black uppercase mb-2 px-1 text-center">Ganti Santri Aktif</p>
                    <div class="space-y-1">
                        <?php foreach($listAnak as $anak): ?>
                        <a href="<?= base_url('orangtua/switch-anak/' . $anak['id_santri']) ?>" 
                           class="flex items-center justify-between px-3 py-2 bg-white rounded-lg border border-indigo-100 text-[10px] font-bold text-slate-700 shadow-sm">
                            <?= $anak['nama_santri'] ?>
                            <?php if(session()->get('active_santri_id') == $anak['id_santri']): ?>
                                <i class="fas fa-check-circle text-green-500 text-[10px]"></i>
                            <?php endif; ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="p-1">
                    <a href="<?= base_url('orangtua/profile') ?>" 
                       class="flex items-center px-4 py-2.5 text-xs rounded-xl transition-all 
                       <?= url_is('orangtua/profile*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' ?>">
                        <i class="fas fa-user-circle mr-3 <?= url_is('orangtua/profile*') ? 'opacity-100' : 'opacity-40' ?>"></i> 
                        Profil Saya
                    </a>
                    <hr class="my-1 border-slate-50">
                    <a href="<?= base_url('/logout') ?>" class="flex items-center px-4 py-2.5 text-xs text-red-500 hover:bg-red-50 rounded-xl font-bold transition-all">
                        <i class="fas fa-power-off mr-3"></i> Keluar Sistem
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
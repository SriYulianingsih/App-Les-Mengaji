<header
    class="sticky top-0 z-[100] bg-white/70 backdrop-blur-md border-b border-slate-200/50 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)]">
    <div class="px-6 py-3 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <button @click="sidebarOpen = true"
                class="p-2 rounded-lg text-slate-500 hover:bg-sky-50 hover:text-sky-600 focus:outline-none lg:hidden transition-all duration-300">
                <i class="fas fa-bars-staggered text-xl"></i> </button>

            <div class="flex items-center space-x-3 group cursor-pointer">
                <div
                    class="w-10 h-10 rounded-xl overflow-hidden shadow-indigo-100 shadow-lg ring-2 ring-white transition-transform group-hover:scale-105 duration-500">
                    <img src="<?= base_url('images/logo.png') ?>" alt="Logo" class="w-full h-full object-cover">
                </div>

                <div class="leading-tight">
                    <h1 class="text-lg font-black text-slate-800 tracking-tight leading-none italic">
                        App Les Privat <span class="text-sky-600 non-italic">Mengaji</span>
                    </h1>
                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-[0.15em] mt-1">
                        Cahaya Hidayah Qurani
                    </p>
                </div>
            </div>
        </div>

        <!-- <div class="hidden md:flex items-center w-1/3" x-data="{ 
                searchQuery: '', 
                results: [], 
                showDropdown: false,
                loading: false,
                fetchSearch() {
                    if (this.searchQuery.length < 2) {
                        this.results = [];
                        this.showDropdown = false;
                        return;
                    }
                    this.loading = true;
                    this.showDropdown = true;
                    
                    fetch(`<?= base_url('admin/search_ajax') ?>?q=${this.searchQuery}`)
                        .then(res => res.json())
                        .then(data => {
                            this.results = data;
                            this.loading = false;
                        })
                        .catch(err => {
                            this.results = [];
                            this.loading = false;
                        });
                }
             }">
            <div class="relative w-full group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 transition-colors group-focus-within:text-sky-500">
                    <i class="fas fa-search text-sm" x-show="!loading"></i>
                    <i class="fas fa-circle-notch fa-spin text-sky-500" x-show="loading" x-cloak></i>
                </span>
                <input 
                    type="text" 
                    x-model="searchQuery"
                    @input.debounce.300ms="fetchSearch()"
                    @focus="if(searchQuery.length >= 2) showDropdown = true"
                    @click.outside="showDropdown = false"
                    placeholder="Cari santri, guru, atau wali..." 
                    class="w-full pl-11 pr-4 py-2.5 bg-slate-100/50 border-transparent focus:bg-white focus:border-sky-400 focus:ring-4 focus:ring-sky-500/10 rounded-2xl text-sm transition-all duration-500 outline-none placeholder:text-slate-400 font-medium shadow-inner">

                <div x-show="showDropdown" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-cloak
                     class="absolute left-0 mt-3 w-full bg-white/95 backdrop-blur-xl rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-slate-100 z-[110] overflow-hidden max-h-80 overflow-y-auto ring-1 ring-black/5">
                    
                    <div class="p-2">
                        <template x-for="item in results" :key="item.id">
                            <a :href="`<?= base_url('admin/') ?>${item.tipe}/detail/${item.id}`" 
                               class="group flex items-center px-4 py-3 hover:bg-sky-50 rounded-xl transition-all duration-300 border-b border-slate-50 last:border-0">
                                
                                <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-xs mr-3 group-hover:bg-sky-600 group-hover:text-white transition-colors shadow-sm">
                                    <span x-text="item.nama ? item.nama.substring(0, 1).toUpperCase() : '?'"></span>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-slate-700 truncate group-hover:text-sky-700 transition-colors" x-text="item.nama"></p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">
                                        <span x-text="item.tipe"></span>
                                        <span x-show="item.tipe !== 'orangtua'" x-text="` • ${item.tipe === 'guru' ? 'NIP' : 'NIS'}: ${item.nis}`"></span>
                                    </p>
                                </div>

                                <i class="fas fa-arrow-right text-[10px] text-slate-300 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all"></i>
                            </a>
                        </template>
                    </div>

                    <div x-show="results.length === 0 && !loading" class="px-4 py-8 text-sm text-slate-400 text-center bg-slate-50/50">
                        <i class="fas fa-search-minus mb-2 block text-2xl text-slate-300"></i>
                        <span class="font-medium">Wah, datanya nggak ada bg...</span>
                    </div>
                </div>
            </div>
        </div> -->

        <div x-data="{ open: false }" class="relative">
            <div @click="open = !open"
                class="flex items-center space-x-3 p-1.5 pr-4 rounded-2xl hover:bg-slate-100 transition-all duration-300 cursor-pointer border border-transparent hover:border-slate-200 group">
                <div class="relative">
                    <img src="<?= base_url('images/admin.png') ?>" alt="Admin"
                        class="w-10 h-10 rounded-xl object-cover ring-2 ring-white shadow-md group-hover:shadow-sky-200 transition-all">
                    <div
                        class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white animate-pulse">
                    </div>
                </div>

                <div class="hidden md:block text-left">
                    <p class="text-[13px] font-black text-slate-800 leading-none"><?= session('username') ?></p>
                    <p class="text-[10px] font-bold text-sky-500 uppercase tracking-widest mt-1">Super Admin</p>
                </div>

                <i class="fas fa-chevron-down text-[10px] text-slate-400 transition-transform duration-300"
                    :class="open ? 'rotate-180' : ''"></i>
            </div>

            <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-4"
                class="absolute right-0 mt-4 w-56 bg-white/95 backdrop-blur-xl rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.2)] border border-slate-100 p-2 z-50 ring-1 ring-black/5">

                <div class="px-4 py-2 mb-2 border-b border-slate-50">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Akses Cepat</p>
                </div>

                <a href="/admin/profile"
                    class="flex items-center px-4 py-3 text-sm font-bold text-slate-600 hover:bg-sky-50 hover:text-sky-600 rounded-xl transition-all group">
                    <div
                        class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center mr-3 group-hover:bg-sky-100">
                        <i class="fas fa-user-gear text-xs text-slate-400 group-hover:text-sky-600"></i>
                    </div>
                    Pengaturan Profil
                </a>

                <div class="my-2 border-t border-slate-50"></div>

                <a href="<?= base_url('/logout') ?>"
                    class="flex items-center px-4 py-3 text-sm font-bold text-red-500 hover:bg-red-50 rounded-xl transition-all group">
                    <div
                        class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center mr-3 group-hover:bg-red-100">
                        <i class="fas fa-power-off text-xs text-red-400 group-hover:text-red-600"></i>
                    </div>
                    Keluar Sistem
                </a>
            </div>
        </div>
    </div>
</header>
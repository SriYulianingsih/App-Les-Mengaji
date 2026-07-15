<?php 
$uri = service('uri');
$currentSegment2 = $uri->getSegment(2); // orangtua/[segment2]
$currentSegment3 = $uri->getTotalSegments() >= 3 ? $uri->getSegment(3) : ''; 

// --- LOGIKA ACTIVE MENU ORANG TUA ---
$isDashboardActive = ($currentSegment2 == 'dashboard');
$isSantriActive    = ($currentSegment2 == 'santri');
$isAbsensiActive   = ($currentSegment2 == 'absensi');
$isGuruActive      = ($currentSegment2 == 'guru');
$isBayarActive     = ($currentSegment2 == 'pembayaran'); 
?>

<div x-show="sidebarOpen" 
      @click="sidebarOpen = false" 
      class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[110] lg:hidden"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"></div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
        class="fixed inset-y-0 left-0 w-72 bg-white border-r border-slate-100 transform transition-transform duration-300 ease-in-out z-[120] lg:translate-x-0 lg:static lg:h-screen lg:z-0 flex flex-col shadow-xl lg:shadow-none">

    <div class="flex items-center justify-between p-6 border-b border-slate-50 lg:hidden">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white shadow-lg">
                <i class="fas fa-user-graduate text-sm"></i>
            </div>
            <span class="font-bold text-slate-800 tracking-tight italic text-sm uppercase">Menu Wali Santri</span>
        </div>
        <button @click="sidebarOpen = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:text-red-500 transition-colors">
            <i class="fas fa-times text-sm"></i>
        </button>
    </div>

    <nav class="flex-1 p-6 space-y-1.5 overflow-y-auto">
        
        <a href="<?= base_url('orangtua/dashboard') ?>"
           class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group
           <?= $isDashboardActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200 font-semibold' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' ?>">
            <div class="flex items-center justify-center w-5 h-5 transition-transform group-hover:scale-110">
                <i class="fas fa-th-large text-base"></i>
            </div>
            <span class="text-sm tracking-wide">Beranda</span>
        </a>

        <div class="pt-6 pb-2 px-4">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Pantauan Belajar</p>
        </div>

        <a href="<?= base_url('orangtua/santri') ?>"
           class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group
           <?= $isSantriActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200 font-semibold' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' ?>">
            <div class="flex items-center justify-center w-5 h-5 transition-transform group-hover:scale-110">
                <i class="fas fa-child text-base"></i>
            </div>
            <span class="text-sm tracking-wide">Data Anak</span>
        </a>

        <a href="<?= base_url('orangtua/absensi') ?>"
           class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group
           <?= $isAbsensiActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200 font-semibold' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' ?>">
            <div class="flex items-center justify-center w-5 h-5 transition-transform group-hover:scale-110">
                <i class="fas fa-calendar-check text-base"></i>
            </div>
            <span class="text-sm tracking-wide">Presensi Anak</span>
        </a>

        <a href="<?= base_url('orangtua/guru') ?>"
           class="flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 group
           <?= $isGuruActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200 font-semibold' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' ?>">
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-5 h-5 transition-transform group-hover:scale-110">
                    <i class="fas fa-chalkboard-teacher text-base"></i>
                </div>
                <span class="text-sm tracking-wide">Data Guru</span>
            </div>
            <i class="fab fa-whatsapp text-sm <?= $isGuruActive ? 'text-indigo-200' : 'text-green-500 opacity-0 group-hover:opacity-100' ?> transition-opacity"></i>
        </a>

        <div class="pt-6 pb-2 px-4">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Administrasi</p>
        </div>

        <a href="<?= base_url('orangtua/pembayaran') ?>"
           class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group
           <?= $isBayarActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200 font-semibold' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' ?>">
            <div class="flex items-center justify-center w-5 h-5 transition-transform group-hover:scale-110">
                <i class="fas fa-wallet text-base"></i>
            </div>
            <span class="text-sm tracking-wide">Pembayaran</span>
        </a>

        <div class="pt-6 pb-2">
            <div class="px-4 py-4 rounded-2xl bg-slate-50 border border-slate-100 relative group overflow-hidden">
                <div class="relative z-10 flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-indigo-600 border border-indigo-100 shadow-sm">
                        <i class="fas fa-fingerprint text-xs"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest leading-none mb-1">Ananda Terpilih</p>
                        <p class="text-[11px] font-bold text-slate-700 truncate italic">
                            <?= session()->get('active_santri_nama') ?? 'Pilih Santri...' ?>
                        </p>
                    </div>
                </div>
                <div class="absolute -right-2 -bottom-2 w-12 h-12 bg-indigo-500/5 rounded-full"></div>
            </div>
        </div>
    </nav>

</aside>
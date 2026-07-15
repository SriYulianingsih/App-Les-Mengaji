<?php 
$uri = service('uri');
$currentSegment2 = $uri->getSegment(2); // guru/[segment2]
$currentSegment3 = $uri->getTotalSegments() >= 3 ? $uri->getSegment(3) : ''; // guru/absensi/[segment3]

// --- LOGIKA ACTIVE MENU YANG LEBIH PRESISI ---
$isDashboardActive = ($currentSegment2 == 'dashboard');
$isJadwalActive    = ($currentSegment2 == 'jadwal');
$isSantriActive    = ($currentSegment2 == 'santri');

/** * Absensi Santri Active jika:
 * Sedang di cekJadwal, input, atau view detail (halaman operasional hari ini)
 */
$isAbsensiActive = ($currentSegment2 == 'absensi' && in_array($currentSegment3, ['cekJadwal', 'input', 'view', 'view_detail']));

/** * Riwayat Active jika:
 * Segment 3-nya eksplisit 'riwayat'
 */
$isRiwayatActive = ($currentSegment2 == 'absensi' && $currentSegment3 == 'riwayat');
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
       class="fixed inset-y-0 left-0 w-72 bg-white border-r border-slate-100 transform transition-transform duration-300 ease-in-out z-[120] lg:translate-x-0 lg:static lg:h-screen lg:z-0 overflow-y-auto shadow-xl lg:shadow-none">

    <div class="flex items-center justify-between p-6 border-b border-slate-50 lg:hidden">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center text-white shadow-lg">
                <i class="fas fa-book-open text-sm"></i>
            </div>
            <span class="font-bold text-slate-800 tracking-tight">Menu Pengajar</span>
        </div>
        <button @click="sidebarOpen = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:text-red-500 transition-colors">
            <i class="fas fa-times text-sm"></i>
        </button>
    </div>

    <nav class="p-6 space-y-1.5">
        
        <a href="<?= base_url('guru/dashboard') ?>"
           class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group
           <?= $isDashboardActive ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200 font-semibold' : 'text-slate-500 hover:bg-emerald-50 hover:text-emerald-600' ?>">
            <div class="flex items-center justify-center w-5 h-5 transition-transform group-hover:scale-110">
                <i class="fas fa-th-large text-base"></i>
            </div>
            <span class="text-sm tracking-wide">Beranda</span>
        </a>

        <div class="pt-6 pb-2 px-4">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Aktivitas Mengajar</p>
        </div>

        <a href="<?= base_url('guru/jadwal') ?>"
           class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group
           <?= $isJadwalActive ? 'bg-emerald-50 text-emerald-700 font-bold border border-emerald-100' : 'text-slate-500 hover:bg-emerald-50 hover:text-emerald-600' ?>">
            <div class="<?= $isJadwalActive ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-500' ?> flex items-center justify-center w-5 h-5">
                <i class="fas fa-calendar-alt text-base"></i>
            </div>
            <span class="text-sm tracking-wide">Jadwal Saya</span>
        </a>

        <a href="<?= base_url('guru/absensi/cekJadwal') ?>"
           class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group
           <?= $isAbsensiActive ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200 font-semibold' : 'text-slate-500 hover:bg-emerald-50 hover:text-emerald-600' ?>">
            <div class="flex items-center justify-center w-5 h-5 transition-transform group-hover:scale-110">
                <i class="fas fa-user-check text-base"></i>
            </div>
            <span class="text-sm tracking-wide">Absensi Santri</span>
        </a>

        <div class="pt-6 pb-2 px-4">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Data & Laporan</p>
        </div>

        <a href="<?= base_url('guru/santri') ?>"
           class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group
           <?= $isSantriActive ? 'bg-emerald-50 text-emerald-700 font-bold border border-emerald-100' : 'text-slate-500 hover:bg-emerald-50 hover:text-emerald-600' ?>">
            <div class="<?= $isSantriActive ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-500' ?> flex items-center justify-center w-5 h-5">
                <i class="fas fa-user-graduate text-base"></i>
            </div>
            <span class="text-sm tracking-wide">Data Santri</span>
        </a>

        <a href="<?= base_url('guru/absensi/riwayat') ?>"
           class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 group
           <?= $isRiwayatActive ? 'bg-emerald-50 text-emerald-700 font-bold border border-emerald-100' : 'text-slate-500 hover:bg-emerald-50 hover:text-emerald-600' ?>">
            <div class="<?= $isRiwayatActive ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-500' ?> flex items-center justify-center w-5 h-5">
                <i class="fas fa-history text-base"></i>
            </div>
            <span class="text-sm tracking-wide">Riwayat Absensi</span>
        </a>
    </nav>

    <div class="px-6 pb-8 mt-4">
        <div class="p-4 rounded-2xl bg-slate-900 text-white overflow-hidden relative group">
            <div class="relative z-10">
                <p class="text-[10px] text-emerald-400 font-bold uppercase tracking-widest mb-1">Butuh Bantuan?</p>
                <p class="text-xs text-slate-300 leading-relaxed">Hubungi admin jika ada kendala sistem.</p>
            </div>
            <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-emerald-600 rounded-full blur-2xl opacity-20 group-hover:opacity-40 transition-opacity"></div>
        </div>
    </div>
</aside>
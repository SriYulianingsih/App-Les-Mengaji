<?php 
$uri = service('uri');
$currentSegment2 = $uri->getSegment(2);
$currentSegment3 = $uri->getSegment(3);

// Otomatis buka dropdown sesuai halaman aktif
$isSantriActive = ($currentSegment2 == 'santri');
$isGuruActive = ($currentSegment2 == 'guru');
$isOrangtuaActive = ($currentSegment2 == 'orangtua');
$isJadwalActive = ($currentSegment2 == 'jadwal');
$isMasterActive = in_array($currentSegment2, ['kelas', 'mapel', 'kategori-pembayaran']);
$isLaporanActive = ($currentSegment2 == 'laporan');
?>

<div x-show="sidebarOpen" @click="sidebarOpen = false"
    class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[80] lg:hidden transition-opacity duration-300"></div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 w-72 bg-white border-r border-slate-100 shadow-2xl lg:shadow-none transform transition-all duration-500 ease-in-out z-[110] lg:sticky lg:top-16 lg:h-[calc(100vh-4rem)] lg:translate-x-0 lg:z-[50] overflow-y-auto overflow-x-hidden custom-scrollbar">

    <div class="flex items-center justify-between p-6 border-b border-slate-50 lg:hidden bg-slate-50/50">
        <div class="flex items-center space-x-2">
            <div
                class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                <i class="fas fa-th-large text-[10px]"></i>
            </div>
            <span class="font-black text-slate-800 tracking-tight text-sm">NAVIGASI</span>
        </div>
        <button @click="sidebarOpen = false"
            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white shadow-sm text-slate-400 hover:text-rose-500 transition-all border border-slate-100">
            <i class="fas fa-times text-sm"></i>
        </button>
    </div>

    <nav class="p-6 space-y-2" x-data="{ 
        openSantri: <?= $isSantriActive ? 'true' : 'false' ?>, 
        openGuru: <?= $isGuruActive ? 'true' : 'false' ?>,
        openOrangtua: <?= $isOrangtuaActive ? 'true' : 'false' ?>,
        openJadwal: <?= $isJadwalActive ? 'true' : 'false' ?>,
        openMaster: <?= $isMasterActive ? 'true' : 'false' ?>,
        openLaporan: <?= $isLaporanActive ? 'true' : 'false' ?>
    }">

        <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.25em] px-4 mb-4">Main Navigation</p>

        <a href="/admin/dashboard"
            class="flex items-center space-x-3 p-3 rounded-2xl transition-all duration-300 group
           <?= $currentSegment2 == 'dashboard' ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-100 font-bold scale-[1.02]' : 'text-slate-500 hover:bg-slate-50 hover:pl-5' ?>">
            <div
                class="w-9 h-9 flex items-center justify-center rounded-xl transition-all duration-300 <?= $currentSegment2 == 'dashboard' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-400 group-hover:bg-indigo-100 group-hover:text-indigo-600' ?>">
                <i class="fas fa-columns text-sm"></i>
            </div>
            <span class="flex-1 text-sm tracking-tight">Dashboard</span>
        </a>

        <div class="space-y-1">
            <button @click="openMaster = !openMaster"
                class="w-full flex items-center space-x-3 p-3 rounded-2xl transition-all duration-300 group <?= $isMasterActive ? 'bg-indigo-50/50 text-indigo-700 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:pl-5' ?>">
                <div
                    class="w-9 h-9 flex items-center justify-center rounded-xl transition-all duration-300 <?= $isMasterActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'bg-slate-100 text-slate-400 group-hover:bg-indigo-100 group-hover:text-indigo-600' ?>">
                    <i class="fas fa-database text-sm"></i>
                </div>
                <span class="flex-1 text-left text-sm tracking-tight">Master Data</span>
                <i class="fas fa-chevron-right text-[9px] transition-transform duration-500"
                    :class="{ 'rotate-90 text-indigo-600': openMaster }"></i>
            </button>
            <div x-show="openMaster" x-collapse class="ml-7 border-l-2 border-slate-100 pl-4 space-y-1 my-2">
                <a href="/admin/kelas"
                    class="flex items-center gap-3 p-2.5 text-[13px] rounded-xl transition-all duration-300 <?= ($currentSegment2 == 'kelas') ? 'text-indigo-600 font-bold bg-indigo-50/50' : 'text-slate-400 hover:text-indigo-600 hover:pl-2' ?>">
                    <i class="fas fa-school text-[10px]"></i> Data Kelas
                </a>
                <a href="/admin/mapel"
                    class="flex items-center gap-3 p-2.5 text-[13px] rounded-xl transition-all duration-300 <?= ($currentSegment2 == 'mapel') ? 'text-indigo-600 font-bold bg-indigo-50/50' : 'text-slate-400 hover:text-indigo-600 hover:pl-2' ?>">
                    <i class="fas fa-book-open text-[10px]"></i> Mata Pelajaran
                </a>
                <a href="/admin/kategori-pembayaran"
                    class="flex items-center gap-3 p-2.5 text-[13px] rounded-xl transition-all duration-300 <?= ($currentSegment2 == 'kategori-pembayaran') ? 'text-indigo-600 font-bold bg-indigo-50/50' : 'text-slate-400 hover:text-indigo-600 hover:pl-2' ?>">
                    <i class="fas fa-tags text-[10px]"></i> Kategori Biaya
                </a>
            </div>
        </div>

        <div class="py-2"></div>
        <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.25em] px-4 mb-2">Users Management</p>

        <div class="space-y-1">
            <button @click="openSantri = !openSantri"
                class="w-full flex items-center space-x-3 p-3 rounded-2xl transition-all duration-300 group <?= $isSantriActive ? 'bg-indigo-50/50 text-indigo-700 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:pl-5' ?>">
                <div
                    class="w-9 h-9 flex items-center justify-center rounded-xl transition-all duration-300 <?= $isSantriActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'bg-slate-100 text-slate-400 group-hover:bg-indigo-100 group-hover:text-indigo-600' ?>">
                    <i class="fas fa-user-graduate text-sm"></i>
                </div>
                <span class="flex-1 text-left text-sm tracking-tight">Data Santri</span>
                <i class="fas fa-chevron-right text-[9px] transition-transform duration-500"
                    :class="{ 'rotate-90 text-indigo-600': openSantri }"></i>
            </button>
            <div x-show="openSantri" x-collapse class="ml-7 border-l-2 border-slate-100 pl-4 space-y-1 my-2">
                <a href="/admin/santri"
                    class="flex items-center gap-3 p-2.5 text-[13px] rounded-xl transition-all duration-300 <?= ($isSantriActive && !$currentSegment3) ? 'text-indigo-600 font-bold bg-indigo-50/50' : 'text-slate-400 hover:text-indigo-600 hover:pl-2' ?>">
                    <i class="fas fa-list-ul text-[10px]"></i> List Santri
                </a>
                <a href="/admin/santri/create"
                    class="flex items-center gap-3 p-2.5 text-[13px] rounded-xl transition-all duration-300 <?= ($isSantriActive && $currentSegment3 == 'create') ? 'text-indigo-600 font-bold bg-indigo-50/50' : 'text-slate-400 hover:text-indigo-600 hover:pl-2' ?>">
                    <i class="fas fa-plus-circle text-[10px]"></i> Tambah Baru
                </a>
            </div>
        </div>

        <div class="space-y-1">
            <button @click="openGuru = !openGuru"
                class="w-full flex items-center space-x-3 p-3 rounded-2xl transition-all duration-300 group <?= $isGuruActive ? 'bg-indigo-50/50 text-indigo-700 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:pl-5' ?>">
                <div
                    class="w-9 h-9 flex items-center justify-center rounded-xl transition-all duration-300 <?= $isGuruActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'bg-slate-100 text-slate-400 group-hover:bg-indigo-100 group-hover:text-indigo-600' ?>">
                    <i class="fas fa-chalkboard-teacher text-sm"></i>
                </div>
                <span class="flex-1 text-left text-sm tracking-tight">Data Guru</span>
                <i class="fas fa-chevron-right text-[9px] transition-transform duration-500"
                    :class="{ 'rotate-90 text-indigo-600': openGuru }"></i>
            </button>
            <div x-show="openGuru" x-collapse class="ml-7 border-l-2 border-slate-100 pl-4 space-y-1 my-2">
                <a href="/admin/guru"
                    class="flex items-center gap-3 p-2.5 text-[13px] rounded-xl transition-all duration-300 <?= ($isGuruActive && !$currentSegment3) ? 'text-indigo-600 font-bold bg-indigo-50/50' : 'text-slate-400 hover:text-indigo-600 hover:pl-2' ?>">
                    <i class="fas fa-address-book text-[10px]"></i> Direktori Guru
                </a>
                <a href="/admin/guru/create"
                    class="flex items-center gap-3 p-2.5 text-[13px] rounded-xl transition-all duration-300 <?= ($isGuruActive && $currentSegment3 == 'create') ? 'text-indigo-600 font-bold bg-indigo-50/50' : 'text-slate-400 hover:text-indigo-600 hover:pl-2' ?>">
                    <i class="fas fa-user-plus text-[10px]"></i> Registrasi Guru
                </a>
            </div>
        </div>

        <div class="space-y-1">
            <button @click="openOrangtua = !openOrangtua"
                class="w-full flex items-center space-x-3 p-3 rounded-2xl transition-all duration-300 group <?= $isOrangtuaActive ? 'bg-indigo-50/50 text-indigo-700 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:pl-5' ?>">
                <div
                    class="w-9 h-9 flex items-center justify-center rounded-xl transition-all duration-300 <?= $isOrangtuaActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'bg-slate-100 text-slate-400 group-hover:bg-indigo-100 group-hover:text-indigo-600' ?>">
                    <i class="fas fa-users text-sm"></i>
                </div>
                <span class="flex-1 text-left text-sm tracking-tight">Wali Santri</span>
                <i class="fas fa-chevron-right text-[9px] transition-transform duration-500"
                    :class="{ 'rotate-90 text-indigo-600': openOrangtua }"></i>
            </button>
            <div x-show="openOrangtua" x-collapse class="ml-7 border-l-2 border-slate-100 pl-4 space-y-1 my-2">
                <a href="/admin/orangtua"
                    class="flex items-center gap-3 p-2.5 text-[13px] rounded-xl transition-all duration-300 <?= ($isOrangtuaActive && !$currentSegment3) ? 'text-indigo-600 font-bold bg-indigo-50/50' : 'text-slate-400 hover:text-indigo-600 hover:pl-2' ?>">
                    <i class="fas fa-id-card text-[10px]"></i> Database Wali
                </a>
                <a href="/admin/orangtua/create"
                    class="flex items-center gap-3 p-2.5 text-[13px] rounded-xl transition-all duration-300 <?= ($isOrangtuaActive && $currentSegment3 == 'create') ? 'text-indigo-600 font-bold bg-indigo-50/50' : 'text-slate-400 hover:text-indigo-600 hover:pl-2' ?>">
                    <i class="fas fa-user-plus text-[10px]"></i> Tambah Wali
                </a>
            </div>
        </div>

        <div class="py-2 border-b border-slate-50 mx-4"></div>
        <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.25em] px-4 my-2">Academic & Finance</p>

        <div class="space-y-1">
            <button @click="openJadwal = !openJadwal"
                class="w-full flex items-center space-x-3 p-3 rounded-2xl transition-all duration-300 group <?= $isJadwalActive ? 'bg-indigo-50/50 text-indigo-700 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:pl-5' ?>">
                <div
                    class="w-9 h-9 flex items-center justify-center rounded-xl transition-all duration-300 <?= $isJadwalActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'bg-slate-100 text-slate-400 group-hover:bg-indigo-100 group-hover:text-indigo-600' ?>">
                    <i class="fas fa-calendar-alt text-sm"></i>
                </div>
                <span class="flex-1 text-left text-sm tracking-tight">Penjadwalan</span>
                <i class="fas fa-chevron-right text-[9px] transition-transform duration-500"
                    :class="{ 'rotate-90 text-indigo-600': openJadwal }"></i>
            </button>
            <div x-show="openJadwal" x-collapse class="ml-7 border-l-2 border-slate-100 pl-4 space-y-1 my-2">
                <a href="/admin/jadwal"
                    class="flex items-center gap-3 p-2.5 text-[13px] rounded-xl transition-all duration-300 <?= ($isJadwalActive && !$currentSegment3) ? 'text-indigo-600 font-bold bg-indigo-50/50' : 'text-slate-400 hover:text-indigo-600 hover:pl-2' ?>">
                    <i class="fas fa-clock text-[10px]"></i> List Jadwal
                </a>
                <a href="/admin/jadwal/create"
                    class="flex items-center gap-3 p-2.5 text-[13px] rounded-xl transition-all duration-300 <?= ($isJadwalActive && $currentSegment3 == 'create') ? 'text-indigo-600 font-bold bg-indigo-50/50' : 'text-slate-400 hover:text-indigo-600 hover:pl-2' ?>">
                    <i class="fas fa-plus text-[10px]"></i> Buat Sesi Baru
                </a>
            </div>
        </div>

        <a href="/admin/absensi"
            class="flex items-center space-x-3 p-3 rounded-2xl transition-all duration-300 group <?= $currentSegment2 == 'absensi' ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-100 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:pl-5' ?>">
            <div
                class="w-9 h-9 flex items-center justify-center rounded-xl transition-all duration-300 <?= $currentSegment2 == 'absensi' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-400 group-hover:bg-indigo-100 group-hover:text-indigo-600' ?>">
                <i class="fas fa-tasks text-sm"></i>
            </div>
            <span class="flex-1 text-sm tracking-tight">Presensi</span>
        </a>

        <a href="/admin/pembayaran"
            class="flex items-center space-x-3 p-3 rounded-2xl transition-all duration-300 group <?= $currentSegment2 == 'pembayaran' ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-100 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:pl-5' ?>">
            <div
                class="w-9 h-9 flex items-center justify-center rounded-xl transition-all duration-300 <?= $currentSegment2 == 'pembayaran' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-400 group-hover:bg-indigo-100 group-hover:text-indigo-600' ?>">
                <i class="fas fa-file-invoice-dollar text-sm"></i>
            </div>
            <span class="flex-1 text-sm tracking-tight">Pembayaran</span>
        </a>

        <a href="/admin/laporan"
            class="flex items-center space-x-3 p-3 rounded-2xl transition-all duration-300 group <?= $currentSegment2 == 'laporan' ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-100 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:pl-5' ?>">
            <div
                class="w-9 h-9 flex items-center justify-center rounded-xl transition-all duration-300 <?= $currentSegment2 == 'laporan' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-400 group-hover:bg-indigo-100 group-hover:text-indigo-600' ?>">
                <i class="fas fa-file-signature text-sm"></i>
            </div>
            <span class="flex-1 text-sm tracking-tight">Laporan</span>
        </a>

        <div class="py-4 border-t border-slate-50 mx-4"></div>

        <a href="/admin/akun"
            class="flex items-center space-x-3 p-3 rounded-2xl transition-all duration-300 group <?= $currentSegment2 == 'akun' ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-100 font-bold' : 'text-slate-500 hover:bg-slate-100 hover:pl-5' ?>">
            <div
                class="w-9 h-9 flex items-center justify-center rounded-xl transition-all duration-300 <?= $currentSegment2 == 'akun' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-400 group-hover:bg-indigo-100 group-hover:text-indigo-600' ?>">
                <i class="fas fa-shield-alt text-sm"></i>
            </div>
            <span class="flex-1 text-sm tracking-tight">Kelola Akun</span>
        </a>

    </nav>
</aside>
<?php 

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// DEFAULT
$routes->get('/', function() {
    return redirect()->to('/login');
});

// AUTH
$routes->get('/login', 'Auth::login');
$routes->post('/login/process', 'Auth::processLogin');
$routes->get('/logout', 'Auth::logout');

// LUPA PASSWORD/FORGOT PASSWORD
$routes->get('/forgot-password', 'Auth::forgotPassword');
$routes->post('/forgot-password/process', 'Auth::processForgotPassword');


// ====================
// DASHBOARD ADMIN
// ====================
$routes->group('admin', ['filter' => 'auth:admin', 'namespace' => 'App\Controllers\Admin'], function($routes){

    // DASHBOARD
    $routes->get('dashboard', 'Dashboard::index');

    // SANTRI
    $routes->get('santri', 'Santri::index');
    $routes->get('santri/create', 'Santri::create');
    $routes->post('santri/store', 'Santri::store');
    $routes->get('santri/edit/(:num)', 'Santri::edit/$1');
    $routes->post('santri/update/(:num)', 'Santri::update/$1');
    $routes->get('santri/delete/(:num)', 'Santri::delete/$1');
    $routes->get('santri/detail/(:num)', 'Santri::detail/$1'); 

    // Profile
    $routes->get('profile', 'Profile::index');
    $routes->post('profile/updatePassword', 'Profile::updatePassword');

    // GURU
    $routes->get('guru', 'Guru::index');
    $routes->get('guru/create', 'Guru::create');
    $routes->post('guru/store', 'Guru::store');
    $routes->get('guru/edit/(:num)', 'Guru::edit/$1');
    $routes->post('guru/update/(:num)', 'Guru::update/$1');
    $routes->get('guru/delete/(:num)', 'Guru::delete/$1');
    $routes->get('guru/detail/(:num)', 'Guru::detail/$1');

    // ORANG TUA
    $routes->get('orangtua', 'Orangtua::index');
    $routes->get('orangtua/create', 'Orangtua::create');
    $routes->post('orangtua/store', 'Orangtua::store');
    $routes->get('orangtua/edit/(:num)', 'Orangtua::edit/$1');
    $routes->post('orangtua/update/(:num)', 'Orangtua::update/$1');
    $routes->get('orangtua/delete/(:num)', 'Orangtua::delete/$1');
    $routes->get('orangtua/detail/(:num)', 'Orangtua::detail/$1');

    // Jadwal
    $routes->group('jadwal', function($routes) {
        $routes->get('/', 'JadwalController::index');
        $routes->get('create', 'JadwalController::create');
        $routes->post('store', 'JadwalController::store');
        $routes->get('edit/(:num)', 'JadwalController::edit/$1');
        $routes->post('update/(:num)', 'JadwalController::update/$1');
        $routes->get('delete/(:num)', 'JadwalController::delete/$1');
    });

    // ABSENSI (ADMIN SIDE)
    $routes->group('absensi', function($routes) {
        $routes->get('/', 'AbsensiController::index');
    });

    // PEMBAYARAN
$routes->group('pembayaran', function($routes) {
    $routes->get('/', 'PembayaranController::index');
    $routes->get('create', 'PembayaranController::create');
    $routes->post('store', 'PembayaranController::store');
    $routes->post('generateTagihan', 'PembayaranController::generateTagihan');
    
    // Perbaikan di sini: Pastikan urutannya benar
    $routes->get('edit/(:num)', 'PembayaranController::edit/$1'); 
    $routes->post('update/(:num)', 'PembayaranController::update/$1');
    
    $routes->get('verifikasi/(:num)', 'PembayaranController::verifikasi/$1');
    $routes->get('delete/(:num)', 'PembayaranController::delete/$1');
    
    // AJAX nominal
    $routes->get('getNominalKategori/(:num)', 'PembayaranController::getNominalKategori/$1');
});

   // LAPORAN
$routes->group('laporan', function($routes) {
    $routes->get('/', 'LaporanController::index');
    $routes->post('generate', 'LaporanController::generate');
    $routes->get('delete/(:num)', 'LaporanController::delete/$1');
    
    // Kita arahkan segment 'cetakPdf' ke fungsi cetakPdf di Controller
    $routes->get('cetakPdf/(:num)', 'LaporanController::cetakPdf/$1');
});

    // DATA KELAS
    $routes->group('kelas', function($routes) {
    $routes->get('/', 'Kelas::index');
    $routes->get('create', 'Kelas::create');
    $routes->post('store', 'Kelas::store');
    $routes->get('edit/(:num)', 'Kelas::edit/$1');
    $routes->post('update/(:num)', 'Kelas::update/$1');
    $routes->get('delete/(:num)', 'Kelas::delete/$1');
    });

   // DATA MAPEL
$routes->group('mapel', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('/', 'Mapel::index');
    $routes->get('create', 'Mapel::create');
    $routes->post('store', 'Mapel::store');
    $routes->get('edit/(:num)', 'Mapel::edit/$1');
    $routes->post('update/(:num)', 'Mapel::update/$1');
    $routes->get('delete/(:num)', 'Mapel::delete/$1');
});

// DATA KATEGORI PEMBAYARAN
$routes->group('kategori-pembayaran', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('/', 'KategoriPembayaran::index');
    $routes->get('create', 'KategoriPembayaran::create');
    $routes->post('store', 'KategoriPembayaran::store');
    $routes->get('edit/(:num)', 'KategoriPembayaran::edit/$1');
    $routes->post('update/(:num)', 'KategoriPembayaran::update/$1');
    $routes->get('delete/(:num)', 'KategoriPembayaran::delete/$1');
});

    // MANAJEMEN AKUN
    $routes->group('akun', function($routes) {
        $routes->get('/', 'AkunController::index');
        $routes->get('create/(:segment)', 'AkunController::create/$1');
        $routes->post('store', 'AkunController::store');
        $routes->get('edit/(:num)', 'AkunController::edit/$1');
        $routes->post('update/(:num)', 'AkunController::update/$1');
        $routes->get('delete/(:num)', 'AkunController::delete/$1');
    });

    // SEARCH NAVBAR
    $routes->get('search_ajax', 'SearchController::index');

});


// =============================================================================
// DASHBOARD GURU
// =============================================================================
$routes->group('guru', ['filter' => 'auth:guru', 'namespace' => 'App\Controllers\Guru'], function($routes) {
    
    // Dashboard Utama
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('search_ajax', 'Dashboard::searchAjax');

    // Profile Management
    $routes->get('profile', 'Profile::index');
    $routes->post('profile/update', 'Profile::update');
    $routes->post('profile/update-password', 'Profile::updatePassword');

    // Modul Jadwal
    $routes->get('jadwal', 'Jadwal::index');

    // Modul Absensi & Progres Materi
    $routes->get('absensi/cekJadwal', 'Absensi::cekJadwal');
    
    // (:any) menampung ID Jadwal (Input baru) atau Tanggal (Mode Edit lama)
    $routes->get('absensi/input/(:any)', 'Absensi::input/$1'); 
    $routes->post('absensi/simpan', 'Absensi::simpan');

    // Riwayat & Monitoring
    $routes->get('absensi/riwayat', 'Absensi::riwayat');
    
    /**
     * Detail Riwayat (viewByDate)
     * Parameter 1: (:num) -> ID Jadwal
     * Parameter 2: (:any) -> Tanggal (YYYY-MM-DD)
     */
    $routes->get('absensi/view/(:num)/(:any)', 'Absensi::viewByDate/$1/$2');

    // Data Santri (Manajemen Data)
    $routes->get('santri', 'Santri::index');
    $routes->get('santri/detail/(:num)', 'Santri::detail/$1');

});


// ====================
// DASHBOARD ORANGTUA
// ====================
$routes->group('orangtua', ['filter' => 'auth:orangtua', 'namespace' => 'App\Controllers\Orangtua'], function($routes){
    
    // Dashboard & Search
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('search_ajax', 'Dashboard::searchAjax');

    // --- FITUR SWITCH ANAK ---
    $routes->get('switch-anak/(:num)', 'Dashboard::switchAnak/$1');

    // Data Anak (Santri)
    $routes->get('santri', 'Santri::index');
    $routes->get('santri/detail/(:num)', 'Santri::detail/$1');
    $routes->post('santri/upload-foto/(:num)', 'Santri::uploadFoto/$1');

    // Profile Management
    $routes->get('profile', 'Profile::index');
    $routes->post('profile/update', 'Profile::update');
    $routes->post('profile/update-password', 'Profile::updatePassword');

    // Absensi
    $routes->get('absensi', 'Absensi::index');

    // Guru
    $routes->get('guru', 'Guru::index');

    // --- MODUL PEMBAYARAN ---
    $routes->get('pembayaran', 'Pembayaran::index'); 
    
    // Update ini: Tambahkan parameter (:any) agar bisa menerima ID tagihan atau kosong
    $routes->get('pembayaran/bayar/(:any)', 'Pembayaran::formBayar/$1'); 
    $routes->get('pembayaran/bayar', 'Pembayaran::formBayar'); // Fallback jika tanpa ID
    
    $routes->post('pembayaran/simpan', 'Pembayaran::simpan');
});
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('admin/dashboard', 'Admin::dashboard');
$routes->get('admin', 'Admin::dashboard');
$routes->get('admin/kegiatan', 'Admin::kegiatan');
$routes->get('admin/kegiatan/tambah', 'Admin::tambah_kegiatan');
$routes->post('admin/kegiatan/simpan', 'Admin::simpan_kegiatan');
$routes->get('admin/kegiatan/edit/(:num)', 'Admin::edit_kegiatan/$1');
$routes->post('admin/kegiatan/update/(:num)', 'Admin::update_kegiatan/$1');
$routes->get('admin/kegiatan/hapus/(:num)', 'Admin::hapus_kegiatan/$1');
$routes->get('admin/pengaturan', 'Admin::pengaturan');
$routes->post('admin/pengaturan/update', 'Admin::update_pengaturan');
$routes->get('kegiatan/(:segment)', 'Home::detail_kegiatan/$1');
$routes->get('admin/pendaftaran', 'Admin::pendaftaran');
$routes->post('admin/pendaftaran/update', 'Admin::update_pendaftaran');
$routes->group('admin', function ($routes) {
    $routes->get('akses-cepat', 'Admin::akses_cepat');
    $routes->post('akses-cepat/tambah', 'Admin::akses_cepat_tambah');
    $routes->get('akses-cepat/hapus/(:num)', 'Admin::akses_cepat_hapus/$1');
    $routes->get('beranda', 'Admin::beranda');
    $routes->post('beranda/tambah', 'Admin::beranda_tambah');
    $routes->get('beranda/hapus/(:num)', 'Admin::beranda_hapus/$1');
    $routes->get('beranda/edit/(:num)', 'Admin::beranda_edit/$1');
    $routes->post('beranda/update/(:num)', 'Admin::beranda_update/$1');
    $routes->get('testimoni', 'AdminTestimoniController::index');
    $routes->get('testimoni/approve/(:num)', 'AdminTestimoniController::approve/$1');
    $routes->get('testimoni/reject/(:num)', 'AdminTestimoniController::reject/$1');
    $routes->get('testimoni/delete/(:num)', 'AdminTestimoniController::delete/$1');
    $routes->get('profil', 'Admin\ProfilController::index');
    $routes->post('profil/update-umum', 'Admin\ProfilController::updateUmum');
    $routes->post('profil/fasilitas/simpan', 'Admin\ProfilController::simpanFasilitas');
    $routes->post('profil/fasilitas/update/(:num)', 'Admin\ProfilController::updateFasilitas/$1');
    $routes->get('profil/fasilitas/hapus/(:num)', 'Admin\ProfilController::hapusFasilitas/$1');
    $routes->get('profil/fasilitas/galeri/(:num)', 'Admin\ProfilController::galeriFasilitas/$1');
    $routes->post('profil/fasilitas/galeri/simpan', 'Admin\ProfilController::simpanGaleri');
    $routes->get('profil/fasilitas/galeri/hapus/(:num)', 'Admin\ProfilController::hapusGaleri/$1');
    $routes->get('bakat-minat', 'Admin\BakatMinat::index');
    $routes->get('bakat-minat/create', 'Admin\BakatMinat::create');
    $routes->post('bakat-minat/store', 'Admin\BakatMinat::store');
    $routes->get('bakat-minat/edit/(:num)', 'Admin\BakatMinat::edit/$1');
    $routes->post('bakat-minat/update/(:num)', 'Admin\BakatMinat::update/$1');
    $routes->get('bakat-minat/delete/(:num)', 'Admin\BakatMinat::delete/$1');
    // --- ROUTES KATEGORI BERITA ---
    $routes->group('kategori-berita', function ($routes) {
        $routes->get('/', 'Admin\BeritaController::kategori');
        $routes->post('simpan', 'Admin\BeritaController::simpanKategori');
        $routes->get('hapus/(:num)', 'Admin\BeritaController::hapusKategori/$1');
    });

    // --- ROUTES BERITA ---
    $routes->group('berita', function ($routes) {
        $routes->get('/', 'Admin\BeritaController::index');
        $routes->get('tambah', 'Admin\BeritaController::tambah');
        $routes->post('simpan', 'Admin\BeritaController::simpan');
        $routes->get('edit/(:num)', 'Admin\BeritaController::edit/$1');
        $routes->post('update/(:num)', 'Admin\BeritaController::update/$1');
        $routes->get('hapus/(:num)', 'Admin\BeritaController::hapus/$1');

        // Route khusus untuk upload gambar dari editor teks Quill.js (AJAX)
        $routes->post('upload-gambar-quill', 'Admin\BeritaController::uploadGambarQuill');
    });
});
// --- ROUTES PROFIL ---
$routes->group('profil', function ($routes) {
    $routes->get('madrasah', 'Profil::madrasah');
    $routes->get('struktur', 'Profil::struktur');
    $routes->get('testimoni', 'TestimoniController::index');
    $routes->post('testimoni/simpan', 'TestimoniController::simpan');
});
$routes->group('admin/guru', function ($routes) {
    $routes->get('/', 'AdminGuru::index');
    $routes->get('tambah', 'AdminGuru::tambah');
    $routes->post('simpan', 'AdminGuru::simpan');
    $routes->get('edit/(:num)', 'AdminGuru::edit/$1');
    $routes->post('update/(:num)', 'AdminGuru::update/$1');
    $routes->get('hapus/(:num)', 'AdminGuru::hapus/$1');
});

$routes->get('/profil/bakat-minat', 'Profil::bakatMinat');

$routes->get('/berita', 'Berita::index');
$routes->get('/berita/(:segment)', 'Berita::detail/$1');
$routes->get('berita/baca/(:any)', 'Home::detail_berita/$1');
$routes->get('berita/baca/(:segment)', 'Berita::baca/$1');

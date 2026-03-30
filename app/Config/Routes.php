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
        $routes->get('tags', 'Admin\BeritaController::tags');
        $routes->post('simpanTag', 'Admin\BeritaController::simpanTag');
        $routes->get('hapusTag/(:num)', 'Admin\BeritaController::hapusTag/$1');

        // Route khusus untuk upload gambar dari editor teks Quill.js (AJAX)
        $routes->post('upload-gambar-quill', 'Admin\BeritaController::uploadGambarQuill');
    });

    $routes->group('prestasi', function ($routes) {
        $routes->get('/', 'Admin\Prestasi::index');
        $routes->get('create', 'Admin\Prestasi::create');
        $routes->post('store', 'Admin\Prestasi::store');
        $routes->get('edit/(:num)', 'Admin\Prestasi::edit/$1');
        $routes->post('update/(:num)', 'Admin\Prestasi::update/$1');
        // Route hapus mendukung _method="DELETE" dari form
        $routes->delete('delete/(:num)', 'Admin\Prestasi::delete/$1');
    });

    $routes->group('kalender', function ($routes) {
        $routes->get('/', 'Admin\KalenderAkademikController::index');
        $routes->get('create', 'Admin\KalenderAkademikController::create');
        $routes->post('store', 'Admin\KalenderAkademikController::store');
        $routes->get('edit/(:num)', 'Admin\KalenderAkademikController::edit/$1');
        $routes->post('update/(:num)', 'Admin\KalenderAkademikController::update/$1');
        $routes->get('delete/(:num)', 'Admin\KalenderAkademikController::delete/$1');
    });

    $routes->group('pengumuman', function ($routes) {
        $routes->get('/', 'Admin\PengumumanController::index');
        $routes->get('create', 'Admin\PengumumanController::create');
        $routes->post('store', 'Admin\PengumumanController::store');
        $routes->get('edit/(:num)', 'Admin\PengumumanController::edit/$1');
        $routes->post('update/(:num)', 'Admin\PengumumanController::update/$1');
        $routes->get('delete/(:num)', 'Admin\PengumumanController::delete/$1');
    });

    $routes->group('galeri', function ($routes) {
        $routes->get('/', 'Admin\GaleriController::index');
        $routes->get('create', 'Admin\GaleriController::create');
        $routes->post('store', 'Admin\GaleriController::store');
        $routes->get('edit/(:num)', 'Admin\GaleriController::edit/$1');
        $routes->post('update/(:num)', 'Admin\GaleriController::update/$1');
        $routes->get('delete/(:num)', 'Admin\GaleriController::delete/$1');

        // Rute khusus untuk mengupload foto-foto dalam album
        $routes->post('uploadPhotos/(:num)', 'Admin\GaleriController::uploadPhotos/$1');
        // Rute khusus untuk menghapus foto tertentu dalam album
        $routes->post('deletePhoto/(:num)', 'Admin\GaleriController::deletePhoto/$1');
    });

    $routes->group('galeri-video', function ($routes) {
        $routes->get('/', 'Admin\GaleriVideoController::index');
        $routes->get('create', 'Admin\GaleriVideoController::create');
        $routes->post('store', 'Admin\GaleriVideoController::store');
        $routes->get('edit/(:num)', 'Admin\GaleriVideoController::edit/$1');
        $routes->post('update/(:num)', 'Admin\GaleriVideoController::update/$1');
        $routes->get('delete/(:num)', 'Admin\GaleriVideoController::delete/$1');
    });

    $routes->group('unduhan', function ($routes) {
        $routes->get('/', 'Admin\UnduhanController::index');
        $routes->get('create', 'Admin\UnduhanController::create');
        $routes->post('store', 'Admin\UnduhanController::store');
        $routes->get('edit/(:num)', 'Admin\UnduhanController::edit/$1');
        $routes->post('update/(:num)', 'Admin\UnduhanController::update/$1');
        $routes->get('delete/(:num)', 'Admin\UnduhanController::delete/$1');
    });
    $routes->group('kontak', function ($routes) {
        $routes->get('/', 'Admin\KontakController::index');
        $routes->get('show/(:num)', 'Admin\KontakController::show/$1');
        $routes->get('delete/(:num)', 'Admin\KontakController::delete/$1');
    });
    $routes->group('universitas', function ($routes) {
        $routes->get('/', 'Admin\Universitas::index');
        $routes->post('simpan', 'Admin\Universitas::store');
        $routes->post('update/(:num)', 'Admin\Universitas::update/$1');
        $routes->get('edit/(:num)', 'Admin\Universitas::edit/$1');
        $routes->get('hapus/(:num)', 'Admin\Universitas::delete/$1');
    });
    $routes->group('alumni', function ($routes) {
        $routes->get('/', 'Admin\Alumni::index');
        $routes->get('create', 'Admin\Alumni::create');
        $routes->post('simpan', 'Admin\Alumni::store');
        $routes->get('edit/(:num)', 'Admin\Alumni::edit/$1');
        $routes->post('update/(:num)', 'Admin\Alumni::update/$1');
        $routes->get('hapus/(:num)', 'Admin\Alumni::delete/$1');

        // Rute Khusus Approval & Slider
        $routes->get('approve/(:num)', 'Admin\Alumni::approve/$1');
        $routes->get('reject/(:num)', 'Admin\Alumni::reject/$1');
        $routes->get('toggle-featured/(:num)', 'Admin\Alumni::toggleFeatured/$1');
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

$routes->get('berita', 'Berita::index');
$routes->get('berita/baca/(:segment)', 'Berita::detail/$1');

$routes->get('prestasi', 'PrestasiController::index');
$routes->get('prestasi/detail/(:segment)', 'PrestasiController::detail/$1');

$routes->get('kalender', 'KalenderController::index');

$routes->get('pengumuman', 'PengumumanController::index');
$routes->get('pengumuman/(:segment)', 'PengumumanController::detail/$1');

$routes->get('galeri', 'GaleriController::index');
$routes->get('galeri/(:segment)', 'GaleriController::detail/$1');
$routes->get('galeri-video', 'GaleriController::video');

$routes->get('/pusat-unduhan', 'Unduhan::index');

$routes->get('/hubungi-kami', 'Kontak::index');
$routes->post('/hubungi-kami/kirim', 'Kontak::kirim');

// Halaman Publik Direktori Alumni
$routes->get('/alumni', 'AlumniPublic::index');
$routes->get('/alumni/kampus/(:num)', 'AlumniPublic::kampus/$1'); // Untuk lihat detail kampus
$routes->get('/alumni/daftar', 'AlumniPublic::daftar');
$routes->post('/alumni/simpan-mandiri', 'AlumniPublic::simpanMandiri');

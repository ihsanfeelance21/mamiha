<?php
// Mengambil data pengaturan dari database untuk Header & Footer
$pengaturan = (new \App\Models\PengaturanModel())->first();
$ppdbModel = new \App\Models\PendaftaranModel();
$ppdb = $ppdbModel->first();
// Ambil data Akses Cepat
$aksesCepatModel = new \App\Models\AksesCepatModel();
$listAksesCepat = $aksesCepatModel->findAll();

// --- LOGIKA STATUS TOMBOL PENDAFTARAN ---
$isBuka = ($ppdb && $ppdb['status_ppdb'] == 'buka');
$linkDaftar = '#';
$targetDaftar = '';
$onclickDaftar = '';

if ($isBuka) {
    // Jika BUKA: arahkan ke link
    $linkDaftar = ($ppdb['tipe_daftar'] == 'eksternal' && !empty($ppdb['link_daftar'])) ? $ppdb['link_daftar'] : base_url('daftar');
    $targetDaftar = ($ppdb['tipe_daftar'] == 'eksternal') ? 'target="_blank"' : '';
} else {
    // Jika TUTUP: cegah aksi klik (preventDefault) dan tampilkan pop-up
    $onclickDaftar = 'onclick="event.preventDefault(); document.getElementById(\'modalTutup\').classList.remove(\'hidden\'); document.getElementById(\'modalTutup\').classList.add(\'flex\');"';
}

// --- LOGIKA DETEKSI MENU AKTIF ---
$currentUri = uri_string(); // Mengambil url saat ini (misal: 'profil/madrasah')
$isBeranda = ($currentUri == '' || $currentUri == '/');
$isProfil  = (strpos($currentUri, 'profil') === 0);
$isBerita  = (strpos($currentUri, 'kegiatan') === 0);

// ==============================================================
// ðŸš€ LOGIKA SETUP META SEO & SHARE SOSMED
// ==============================================================
$metaTitle = $title ?? $pengaturan['nama_sekolah'] ?? 'MA Mabadi\'ul Ihsan';
$metaDesc = $pengaturan['meta_deskripsi'] ?? $pengaturan['deskripsi_footer'] ?? 'Madrasah Aliyah berbasis pesantren Islam yang menggabungkan pendidikan agama dan umum modern.';
$metaKeywords = $pengaturan['meta_keywords'] ?? 'madrasah aliyah, ma mabadiul ihsan, pesantren banyuwangi, sekolah tegalsari, pendaftaran siswa baru';
$metaAuthor = $pengaturan['nama_sekolah'] ?? 'MA Mabadi\'ul Ihsan';
$currentUrl = current_url();

// Penentuan Gambar untuk Share (Penting!)
if (isset($meta_image)) {
    // 1. Jika dikirim dari Controller (misal halaman detail berita), pakai gambar berita
    $ogImage = base_url($meta_image);
} elseif (!empty($pengaturan['logo'])) {
    // 2. Jika tidak ada gambar khusus, pakai Logo dari tabel pengaturan
    $ogImage = base_url('uploads/pengaturan/' . $pengaturan['logo']);
} else {
    // 3. Fallback terakhir jika semua kosong
    $ogImage = base_url('uploads/default-share.jpg');
}
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($metaTitle) ?></title>
    <meta name="description" content="<?= esc($metaDesc) ?>">
    <meta name="keywords" content="<?= esc($metaKeywords) ?>">
    <meta name="author" content="<?= esc($metaAuthor) ?>">
    <link rel="canonical" href="<?= esc($currentUrl) ?>">

    <meta property="og:site_name" content="<?= esc($metaAuthor) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= esc($currentUrl) ?>">
    <meta property="og:title" content="<?= esc($metaTitle) ?>">
    <meta property="og:description" content="<?= esc($metaDesc) ?>">
    <meta property="og:image" content="<?= esc($ogImage) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= esc($currentUrl) ?>">
    <meta name="twitter:title" content="<?= esc($metaTitle) ?>">
    <meta name="twitter:description" content="<?= esc($metaDesc) ?>">
    <meta name="twitter:image" content="<?= esc($ogImage) ?>">

    <?php if (!empty($pengaturan['favicon'])) : ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/pengaturan/' . $pengaturan['favicon']) ?>">
    <?php endif; ?>

    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <?= $this->renderSection('meta') ?>
    <?= $this->renderSection('styles') ?>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased flex flex-col min-h-screen">

    <div class="bg-[#0B4A2D] text-green-50 text-xs py-2 hidden md:block border-b border-green-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center gap-2 truncate pr-4">
                <i class="fa-solid fa-location-dot text-green-400"></i>
                <a href="<?= $pengaturan['link_maps'] ?? '#' ?>" target="_blank" class="hover:text-white transition truncate">
                    <?= esc($pengaturan['alamat']) ?>
                </a>
            </div>
            <div class="flex items-center gap-6 shrink-0">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-phone text-green-400"></i>
                    <a href="<?= $pengaturan['link_whatsapp'] ?? '#' ?>" target="_blank" class="hover:text-white transition font-medium">
                        <?= esc($pengaturan['telepon']) ?>
                    </a>
                </div>
                <div class="flex items-center gap-3 border-l border-green-700 pl-4">
                    <?php if ($pengaturan['youtube']): ?>
                        <a href="<?= esc($pengaturan['youtube']) ?>" target="_blank" class="hover:text-white transition"><i class="fa-brands fa-youtube text-sm"></i></a>
                    <?php endif; ?>
                    <?php if ($pengaturan['facebook']): ?>
                        <a href="<?= esc($pengaturan['facebook']) ?>" target="_blank" class="hover:text-white transition"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                    <?php endif; ?>
                    <?php if ($pengaturan['instagram']): ?>
                        <a href="<?= esc($pengaturan['instagram']) ?>" target="_blank" class="hover:text-white transition"><i class="fa-brands fa-instagram text-sm"></i></a>
                    <?php endif; ?>
                    <?php if ($pengaturan['tiktok']): ?>
                        <a href="<?= esc($pengaturan['tiktok']) ?>" target="_blank" class="hover:text-white transition"><i class="fa-brands fa-tiktok text-sm"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <nav class="bg-white shadow-md sticky top-0 z-40 transition-all duration-300" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20 md:h-24">

                <a href="<?= base_url() ?>" class="flex items-center gap-2 md:gap-4 hover:opacity-90 transition w-[70%] md:w-auto">
                    <?php if (!empty($pengaturan['logo'])) : ?>
                        <img src="<?= base_url('uploads/pengaturan/' . $pengaturan['logo']) ?>" alt="Logo <?= esc($pengaturan['nama_sekolah']) ?>" class="w-12 h-12 md:w-15 md:h-15 object-contain shrink-0">
                    <?php else : ?>
                        <div class="w-10 h-10 md:w-14 md:h-14 bg-[#0B4A2D] text-white rounded-full flex items-center justify-center font-bold text-lg md:text-2xl shrink-0">
                            <?= substr($pengaturan['nama_sekolah'], 0, 1) ?>
                        </div>
                    <?php endif; ?>

                    <div class="flex flex-col justify-center overflow-hidden">
                        <h1 class="font-extrabold text-lg md:text-lg lg:text-xl text-[#0B4A2D] leading-tight md:leading-none tracking-tight uppercase truncate">
                            <?= esc($pengaturan['nama_sekolah']) ?>
                        </h1>
                        <?php if (!empty($pengaturan['slogan'])): ?>
                            <p class="text-sm md:text-base text-[#00A859] font-medium leading-tight mt-0.5 truncate sm:block">
                                <?= esc($pengaturan['slogan']) ?>
                            </p>
                        <?php endif; ?>
                        <?php if (!empty($pengaturan['alamat_singkat'])): ?>
                            <p class="text-[0.70rem] md:text-xs text-gray-600 font-medium leading-tight mt-0.5 truncate sm:block">
                                <?= esc($pengaturan['alamat_singkat']) ?></p>
                        <?php endif; ?>
                    </div>
                </a>

                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-[#0B4A2D] hover:text-[#00A859] focus:outline-none p-2 transition-colors">
                        <i class="fa-solid fa-bars text-2xl" x-show="!mobileMenuOpen"></i>
                        <i class="fa-solid fa-xmark text-2xl" x-show="mobileMenuOpen" x-cloak></i>
                    </button>
                </div>

                <div class="hidden md:flex items-center gap-5 lg:gap-7">

                    <a href="<?= base_url() ?>" class="text-sm lg:text-[15px] font-medium transition-colors <?= isset($isBeranda) && $isBeranda ? 'text-[#0B4A2D] border-b-2 border-[#00A859] pb-1' : 'text-gray-600 hover:text-[#00A859]' ?>">Beranda</a>

                    <div class="relative group">
                        <button class="flex items-center gap-1.5 text-sm lg:text-[15px] font-medium transition-colors py-2 <?= isset($isProfil) && $isProfil ? 'text-[#0B4A2D] border-b-2 border-[#00A859] pb-1' : 'text-gray-600 hover:text-[#00A859]' ?>">
                            Profil <i class="fa-solid fa-chevron-down text-[10px] mt-0.5 group-hover:rotate-180 transition-transform duration-300"></i>
                        </button>
                        <div class="absolute left-0 mt-2 w-56 bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-left scale-95 group-hover:scale-100 z-50 overflow-hidden">
                            <a href="<?= base_url('profil/madrasah') ?>" class="block px-5 py-3 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-[#00A859] border-b border-gray-50 transition-colors">
                                <i class="fa-solid fa-school w-5 text-center mr-1.5 text-gray-400"></i> Profil Madrasah
                            </a>
                            <a href="<?= base_url('profil/struktur') ?>" class="block px-5 py-3 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-[#00A859] border-b border-gray-50 transition-colors">
                                <i class="fa-solid fa-sitemap w-5 text-center mr-1.5 text-gray-400"></i> Struktur Organisasi
                            </a>
                            <a href="<?= base_url('profil/bakat-minat') ?>" class="block px-5 py-3 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-[#00A859] border-b border-gray-50 transition-colors">
                                <i class="fa-solid fa-volleyball w-5 text-center mr-1.5 text-gray-400"></i> Bakat Minat
                            </a>
                            <a href="<?= base_url('/alumni') ?>" class="block px-5 py-3 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-[#00A859] border-b border-gray-50 transition-colors">
                                <i class="fa-solid fa-graduation-cap w-5 text-center mr-1.5 text-gray-400"></i> Where Are They Now?
                            </a>
                            <a href="<?= base_url('profil/testimoni') ?>" class="block px-5 py-3 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-[#00A859] transition-colors">
                                <i class="fa-solid fa-comments w-5 text-center mr-1.5 text-gray-400"></i> Testimoni
                            </a>
                        </div>
                    </div>

                    <div class="relative group">
                        <button class="flex items-center gap-1.5 text-sm lg:text-[15px] font-medium transition-colors py-2 <?= isset($isBerita) && $isBerita ? 'text-[#0B4A2D] border-b-2 border-[#00A859] pb-1' : 'text-gray-600 hover:text-[#00A859]' ?>">
                            Berita <i class="fa-solid fa-chevron-down text-[10px] mt-0.5 group-hover:rotate-180 transition-transform duration-300"></i>
                        </button>
                        <div class="absolute left-0 mt-2 w-56 bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-left scale-95 group-hover:scale-100 z-50 overflow-hidden">
                            <a href="<?= base_url('berita') ?>" class="block px-5 py-3 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-[#00A859] border-b border-gray-50 transition-colors">
                                <i class="fa-solid fa-newspaper w-5 text-center mr-1.5 text-gray-400"></i> Berita
                            </a>
                            <a href="<?= base_url('prestasi') ?>" class="block px-5 py-3 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-[#00A859] border-b border-gray-50 transition-colors">
                                <i class="fa-solid fa-medal w-5 text-center mr-1.5 text-gray-400"></i> Prestasi
                            </a>
                            <a href="<?= base_url('pengumuman') ?>" class="block px-5 py-3 text-sm font-medium text-gray-700 hover:bg-green-50 hover:text-[#00A859] border-b border-gray-50 transition-colors">
                                <i class="fa-solid fa-scroll w-5 text-center mr-1.5 text-gray-400"></i> Pengumuman
                            </a>
                        </div>
                    </div>

                    <a href="<?= base_url('kalender') ?>" class="text-sm lg:text-[15px] font-medium transition-colors <?= isset($isKalender) && $isKalender ? 'text-[#0B4A2D] border-b-2 border-[#00A859] pb-1' : 'text-gray-600 hover:text-[#00A859]' ?>">Agenda Madrasah</a>

                    <a href="<?= base_url('galeri') ?>" class="text-sm lg:text-[15px] font-medium transition-colors <?= isset($isGaleri) && $isGaleri ? 'text-[#0B4A2D] border-b-2 border-[#00A859] pb-1' : 'text-gray-600 hover:text-[#00A859]' ?>">Galeri</a>

                    <a href="<?= base_url('pusat-unduhan') ?>" class="text-sm lg:text-[15px] font-medium transition-colors <?= isset($isUnduhan) && $isUnduhan ? 'text-[#0B4A2D] border-b-2 border-[#00A859] pb-1' : 'text-gray-600 hover:text-[#00A859]' ?>">Unduhan</a>

                    <a href="<?= base_url('hubungi-kami') ?>" class="text-sm lg:text-[15px] font-medium transition-colors <?= isset($isKontak) && $isKontak ? 'text-[#0B4A2D] border-b-2 border-[#00A859] pb-1' : 'text-gray-600 hover:text-[#00A859]' ?>">Kontak</a>

                    <a href="<?= $linkDaftar ?>" <?= $targetDaftar ?> <?= $onclickDaftar ?> class="bg-[#00A859] hover:bg-green-600 text-white px-5 lg:px-6 py-2.5 rounded-lg font-bold text-sm shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 ml-2">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>

        <div x-show="mobileMenuOpen"
            x-collapse
            x-cloak
            class="md:hidden bg-white border-t border-gray-100 shadow-inner absolute w-full left-0 z-50">

            <div class="px-4 pt-2 pb-6 space-y-1.5 max-h-[80vh] overflow-y-auto">
                <a href="<?= base_url() ?>" class="block px-3 py-3 rounded-md text-base transition-colors <?= isset($isBeranda) && $isBeranda ? 'font-bold text-[#0B4A2D] bg-green-50' : 'font-semibold hover:bg-gray-50 hover:text-[#00A859]' ?>">Beranda</a>

                <div x-data="{ openProfil: <?= (isset($isProfil) && $isProfil) ? 'true' : 'false' ?> }">
                    <button @click="openProfil = !openProfil" class="w-full flex justify-between items-center px-3 py-3 rounded-md text-base transition-colors <?= isset($isProfil) && $isProfil ? 'font-bold text-[#0B4A2D] bg-green-50' : 'font-semibold hover:bg-gray-50 hover:text-[#00A859]' ?>">
                        Profil
                        <i class="fa-solid fa-chevron-down text-sm transition-transform duration-300" :class="openProfil ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openProfil" x-collapse class="pl-4 pr-2 py-2 space-y-1 bg-gray-50/50 rounded-b-md border-l-2 border-green-200 ml-2">
                        <a href="<?= base_url('profil/madrasah') ?>" class="block px-3 py-2.5 text-sm font-medium text-gray-600 hover:text-[#00A859]">Profil Madrasah</a>
                        <a href="<?= base_url('profil/struktur') ?>" class="block px-3 py-2.5 text-sm font-medium text-gray-600 hover:text-[#00A859]">Struktur Organisasi</a>
                        <a href="<?= base_url('profil/bakat-minat') ?>" class="block px-3 py-2.5 text-sm font-medium text-gray-600 hover:text-[#00A859]">Bakat Minat</a>
                        <a href="<?= base_url('/alumni') ?>" class="block px-3 py-2.5 text-sm font-medium text-gray-600 hover:text-[#00A859]">Where Are They Now?</a>
                        <a href="<?= base_url('profil/testimoni') ?>" class="block px-3 py-2.5 text-sm font-medium text-gray-600 hover:text-[#00A859]">Testimoni</a>
                    </div>
                </div>

                <div x-data="{ openBerita: <?= (isset($isBerita) && $isBerita) ? 'true' : 'false' ?> }">
                    <button @click="openBerita = !openBerita" class="w-full flex justify-between items-center px-3 py-3 rounded-md text-base transition-colors <?= isset($isBerita) && $isBerita ? 'font-bold text-[#0B4A2D] bg-green-50' : 'font-semibold hover:bg-gray-50 hover:text-[#00A859]' ?>">
                        Berita
                        <i class="fa-solid fa-chevron-down text-sm transition-transform duration-300" :class="openBerita ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openBerita" x-collapse class="pl-4 pr-2 py-2 space-y-1 bg-gray-50/50 rounded-b-md border-l-2 border-green-200 ml-2">
                        <a href="<?= base_url('berita') ?>" class="block px-3 py-2.5 text-sm font-medium text-gray-600 hover:text-[#00A859]">Berita</a>
                        <a href="<?= base_url('prestasi') ?>" class="block px-3 py-2.5 text-sm font-medium text-gray-600 hover:text-[#00A859]">Prestasi</a>
                        <a href="<?= base_url('pengumuman') ?>" class="block px-3 py-2.5 text-sm font-medium text-gray-600 hover:text-[#00A859]">Pengumuman</a>
                    </div>
                </div>

                <a href="<?= base_url('kalender') ?>" class="block px-3 py-3 rounded-md text-base transition-colors <?= isset($isKalender) && $isKalender ? 'font-bold text-[#0B4A2D] bg-green-50' : 'font-semibold hover:bg-gray-50 hover:text-[#00A859]' ?>">Kalender Akademik</a>

                <a href="<?= base_url('galeri') ?>" class="block px-3 py-3 rounded-md text-base transition-colors <?= isset($isGaleri) && $isGaleri ? 'font-bold text-[#0B4A2D] bg-green-50' : 'font-semibold hover:bg-gray-50 hover:text-[#00A859]' ?>">Galeri</a>

                <a href="<?= base_url('pusat-unduhan') ?>" class="block px-3 py-3 rounded-md text-base transition-colors <?= isset($isUnduhan) && $isUnduhan ? 'font-bold text-[#0B4A2D] bg-green-50' : 'font-semibold hover:bg-gray-50 hover:text-[#00A859]' ?>">Unduhan</a>

                <a href="<?= base_url('hubungi-kami') ?>" class="block px-3 py-3 rounded-md text-base transition-colors <?= isset($isKontak) && $isKontak ? 'font-bold text-[#0B4A2D] bg-green-50' : 'font-semibold hover:bg-gray-50 hover:text-[#00A859]' ?>">Kontak</a>

                <div class="pt-6 pb-2 px-3">
                    <a href="<?= $linkDaftar ?>" <?= $targetDaftar ?> <?= $onclickDaftar ?> class="block w-full text-center bg-[#00A859] hover:bg-[#088a4c] text-white px-5 py-3.5 rounded-xl font-bold text-base shadow-md transition-colors">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="grow">
        <?= $this->renderSection('content') ?>
    </main>
    <section class="py-16 md:py-24 bg-white relative overflow-hidden border-t border-gray-100">
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-green-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-green-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-gray-50 rounded-3xl p-8 md:p-16 border border-gray-100 shadow-xl text-center relative overflow-hidden">

                <i class="fa-solid fa-bullhorn absolute top-4 right-8 text-9xl text-[#00A859] opacity-5 -rotate-12 pointer-events-none"></i>

                <h2 class="text-3xl md:text-5xl font-extrabold text-[#0B4A2D] mb-6 leading-tight relative z-10">
                    Siap Mewujudkan Masa Depan <span class="text-[#00A859]">Gemilang?</span>
                </h2>

                <p class="text-gray-600 text-lg md:text-xl mb-10 max-w-2xl mx-auto leading-relaxed relative z-10">
                    Pendaftaran Peserta Didik Baru (PPDB) tahun ajaran ini telah dibuka. Kuota terbatas! Segera daftarkan putra-putri Anda atau konsultasikan program pendidikan kami sekarang juga.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6 relative z-10">

                    <a href="<?= $linkDaftar ?>" <?= $targetDaftar ?> <?= $onclickDaftar ?> class="w-full sm:w-auto inline-flex justify-center items-center gap-3 px-8 py-4 bg-[#00A859] text-white font-bold text-lg rounded-full shadow-lg hover:shadow-xl hover:bg-[#0B4A2D] hover:-translate-y-1 transition-all duration-300 group">
                        <i class="fa-solid fa-user-plus group-hover:scale-110 transition-transform"></i>
                        Daftar Sekarang
                    </a>

                    <a href="<?= $pengaturan['link_whatsapp'] ?? '#' ?>" target="_blank" class="w-full sm:w-auto inline-flex justify-center items-center gap-3 px-8 py-4 bg-white border-2 border-gray-200 text-[#0B4A2D] font-bold text-lg rounded-full shadow-sm hover:border-[#00A859] hover:text-[#00A859] hover:-translate-y-1 transition-all duration-300 group">
                        <i class="fa-brands fa-whatsapp text-2xl text-[#00A859] group-hover:scale-110 transition-transform"></i>
                        Konsultasi Program
                    </a>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-[#0B4A2D] text-white pt-16 pb-8 mt-auto border-t-8 border-[#00A859]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12 mb-12">

                <div>
                    <a href="<?= base_url() ?>" class="flex items-center gap-3 mb-6 hover:opacity-90 transition">
                        <?php if (!empty($pengaturan['logo'])) : ?>
                            <img src="<?= base_url('uploads/pengaturan/' . $pengaturan['logo']) ?>" alt="Logo <?= esc($pengaturan['nama_sekolah']) ?>" class="w-20 h-20 object-contain">
                        <?php else : ?>
                            <div class="w-14 h-14 bg-white text-[#0B4A2D] rounded-full flex items-center justify-center font-bold text-2xl">
                                <?= substr($pengaturan['nama_sekolah'], 0, 1) ?>
                            </div>
                        <?php endif; ?>

                        <div class="flex flex-col justify-center gap-1">
                            <h2 class="font-extrabold text-xl md:text-lg leading-none uppercase text-white mb-1 tracking-tight">
                                <?= esc($pengaturan['nama_sekolah']) ?>
                            </h2>
                            <?php if (!empty($pengaturan['slogan'])): ?>
                                <p class="text-base md:text-sm text-green-400 font-medium leading-none mb-1"><?= esc($pengaturan['slogan']) ?></p>
                            <?php endif; ?>

                            <?php if (!empty($pengaturan['alamat_singkat'])): ?>
                                <p class="text-xs md:text-[0.70rem] text-green-100 font-medium opacity-80 leading-none"><?= esc($pengaturan['alamat_singkat']) ?></p>
                            <?php endif; ?>
                        </div>
                    </a>

                    <p class="text-green-50/90 text-sm leading-relaxed mb-6">
                        <?= esc($pengaturan['deskripsi_footer']) ?>
                    </p>

                    <div class="flex items-center gap-3">
                        <?php if (!empty($pengaturan['facebook'] ?? '')): ?>
                            <a href="<?= esc($pengaturan['facebook']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#00A859] hover:-translate-y-1 transition-all duration-300 border border-white/20">
                                <i class="fa-brands fa-facebook-f text-white text-sm"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($pengaturan['instagram'] ?? '')): ?>
                            <a href="<?= esc($pengaturan['instagram']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#00A859] hover:-translate-y-1 transition-all duration-300 border border-white/20">
                                <i class="fa-brands fa-instagram text-white text-sm"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($pengaturan['youtube'] ?? '')): ?>
                            <a href="<?= esc($pengaturan['youtube']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#00A859] hover:-translate-y-1 transition-all duration-300 border border-white/20">
                                <i class="fa-brands fa-youtube text-white text-sm"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($pengaturan['tiktok'] ?? '')): ?>
                            <a href="<?= esc($pengaturan['tiktok']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#00A859] hover:-translate-y-1 transition-all duration-300 border border-white/20">
                                <i class="fa-brands fa-tiktok text-white text-sm"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <h3 class="text-base font-bold mb-6 uppercase tracking-widest text-[#00A859]">Akses Cepat</h3>
                    <ul class="space-y-3.5 text-green-50/90 text-sm font-medium">
                        <?php if (empty($listAksesCepat)): ?>
                            <li class="italic text-green-300/50">Belum ada link tautan.</li>
                        <?php else: ?>
                            <?php foreach ($listAksesCepat as $ac): ?>
                                <li>
                                    <a href="<?= esc($ac['url_link']) ?>" target="_blank" class="hover:text-white flex items-center gap-2 group transition-colors">
                                        <i class="fa-solid fa-chevron-right text-[10px] text-[#00A859] group-hover:translate-x-1 transition-transform"></i>
                                        <?= esc($ac['nama_link']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <div>
                    <h3 class="text-base font-bold mb-6 uppercase tracking-widest text-[#00A859]">Hubungi Kami</h3>
                    <ul class="space-y-4 text-green-50/90 text-sm font-medium">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot mt-1 text-[#00A859] text-base w-4 text-center shrink-0"></i>
                            <a href="<?= $pengaturan['link_maps'] ?? '#' ?>" target="_blank" class="hover:text-white transition leading-relaxed">
                                <?= esc($pengaturan['alamat']) ?>
                            </a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-[#00A859] text-base w-4 text-center shrink-0"></i>
                            <a href="<?= $pengaturan['link_whatsapp'] ?? '#' ?>" target="_blank" class="hover:text-white transition">
                                <?= esc($pengaturan['telepon']) ?>
                            </a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-[#00A859] text-base w-4 text-center shrink-0"></i>
                            <a href="mailto:<?= esc($pengaturan['email']) ?>" class="hover:text-white transition break-all">
                                <?= esc($pengaturan['email']) ?>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="bg-black/20 rounded-xl p-5 border border-white/10 shadow-inner">
                    <h3 class="text-base font-bold mb-5 uppercase tracking-widest text-center md:text-left text-white flex items-center gap-2 justify-center">
                        <i class="fa-solid fa-bullhorn text-[#00A859]"></i> Info Pendaftaran
                    </h3>

                    <?php if (!empty($ppdb['poster'])): ?>
                        <div class="mb-4 overflow-hidden rounded-lg border-2 border-[#00A859]/50 group cursor-pointer relative" onclick="document.getElementById('modalPoster').classList.remove('hidden'); document.getElementById('modalPoster').classList.add('flex');">
                            <img src="<?= base_url('uploads/ppdb/' . $ppdb['poster']) ?>" alt="Preview Poster PPDB" class="w-full h-32 object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i class="fa-solid fa-magnifying-glass-plus text-white text-2xl"></i>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="space-y-3 mt-4">
                        <a href="<?= $linkDaftar ?>" <?= $targetDaftar ?> <?= $onclickDaftar ?> class="flex items-center justify-center gap-2 w-full bg-[#00A859] hover:bg-green-500 text-white py-2.5 rounded-lg font-bold text-sm shadow-md hover:-translate-y-0.5 transition-all">
                            <i class="fa-solid fa-user-pen"></i> Daftar Sekarang
                        </a>

                        <?php if (!empty($ppdb['brosur'])): ?>
                            <a href="<?= base_url('uploads/ppdb/' . $ppdb['brosur']) ?>" download class="flex items-center justify-center gap-2 w-full bg-transparent border-2 border-white/20 hover:border-white text-white py-2 rounded-lg font-semibold text-sm hover:bg-white/10 transition-all">
                                <i class="fa-solid fa-file-pdf text-[#00A859]"></i> Unduh Brosur
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-medium text-green-200">
                <p>&copy; <?= date('Y') ?> <?= esc($pengaturan['nama_sekolah']) ?>. Hak Cipta Dilindungi.</p>
                <p>Website dikembangkan dengan <i class="fa-solid fa-heart text-red-500 mx-1"></i></p>
            </div>
        </div>
    </footer>

    <?php if ($ppdb && !empty($ppdb['poster'])): ?>
        <div id="modalPoster" class="fixed inset-0 z-50 hidden bg-black/80 items-center justify-center p-4" style="z-index: 9999;">
            <div class="relative inline-block max-w-[90vw] max-h-[90vh] animate__animated animate__zoomIn">
                <img src="<?= base_url('uploads/ppdb/' . $ppdb['poster']) ?>" alt="Poster PPDB" class="max-w-full max-h-[90vh] block rounded-lg shadow-2xl object-contain">
                <button onclick="closePoster()" class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center bg-black/50 hover:bg-black/80 text-white rounded-full text-xl transition duration-300 focus:outline-none shadow-md">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>

        <script>
            // Munculkan poster otomatis saat halaman selesai dimuat
            window.onload = function() {
                // Pop-up otomatis HANYA muncul jika pendaftaran BUKA
                <?php if ($isBuka): ?>
                    if (!sessionStorage.getItem('posterShown')) {
                        const poster = document.getElementById('modalPoster');
                        poster.classList.remove('hidden');
                        poster.classList.add('flex');
                    }
                <?php endif; ?>
            };

            function closePoster() {
                const poster = document.getElementById('modalPoster');
                poster.classList.add('hidden');
                poster.classList.remove('flex');
                sessionStorage.setItem('posterShown', 'true');
            }
        </script>
    <?php endif; ?>

    <?php if (!$isBuka): ?>
        <div id="modalTutup" class="fixed inset-0 z-50 hidden bg-black/70 items-center justify-center p-4" style="z-index: 9999;">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-8 text-center animate__animated animate__zoomIn">

                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <i class="fa-solid fa-lock text-red-500 text-4xl"></i>
                </div>

                <?php
                // Logika default jika kosong
                $pesanTutup = !empty($ppdb['pesan_tutup']) ? $ppdb['pesan_tutup'] : 'Mohon maaf, pendaftaran siswa baru saat ini belum dibuka / telah ditutup. Untuk informasi lebih lanjut, silakan hubungi admin kami.';

                // Prioritaskan WA PPDB, jika kosong pakai WA Utama
                $linkAdminPPDB = !empty($ppdb['link_admin_ppdb']) ? $ppdb['link_admin_ppdb'] : ($pengaturan['link_whatsapp'] ?? '#');
                ?>

                <h3 class="text-2xl font-bold text-gray-800 mb-2">Pendaftaran Ditutup</h3>
                <p class="text-gray-600 mb-8 leading-relaxed text-sm"><?= esc($pesanTutup) ?></p>

                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="<?= esc($linkAdminPPDB) ?>" target="_blank" class="bg-[#00A859] hover:bg-green-600 text-white px-5 py-2.5 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                        <i class="fa-brands fa-whatsapp text-lg"></i> Hubungi Admin
                    </a>

                    <button onclick="document.getElementById('modalTutup').classList.add('hidden'); document.getElementById('modalTutup').classList.remove('flex');" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-5 py-2.5 rounded-lg font-semibold transition">
                        Kembali
                    </button>
                </div>

            </div>
        </div>
    <?php endif; ?>

    <button id="btnBackToTop" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-6 right-6 md:bottom-10 md:right-10 bg-[#00A859] text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center opacity-0 invisible transition-all duration-300 z-50 hover:bg-green-600 hover:-translate-y-1 hover:shadow-xl focus:outline-none">
        <i class="fa-solid fa-arrow-up text-lg"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btnBackToTop = document.getElementById('btnBackToTop');

            window.addEventListener('scroll', () => {
                // Tombol muncul setelah scroll ke bawah 300px
                if (window.scrollY > 300) {
                    btnBackToTop.classList.remove('opacity-0', 'invisible');
                    btnBackToTop.classList.add('opacity-100', 'visible');
                } else {
                    btnBackToTop.classList.remove('opacity-100', 'visible');
                    btnBackToTop.classList.add('opacity-0', 'invisible');
                }
            });
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>
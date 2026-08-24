<?php
$pengaturan = (new \App\Models\PengaturanModel())->first();

// Menggunakan Session untuk mengecek hak akses (Sangat Ringan & Cepat)
if (!function_exists('hasAccess')) {
    function hasAccess($slug)
    {
        if (session()->get('role') === 'superadmin') return true;
        $perms = session()->get('permissions') ?? [];
        return in_array($slug, $perms);
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= $title ?? 'Admin Panel' ?> - <?= esc($pengaturan['nama_sekolah'] ?? 'Admin') ?></title>

    <?php if (!empty($pengaturan['favicon'])) : ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/pengaturan/' . $pengaturan['favicon']) ?>">
    <?php endif; ?>

    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <meta name="csrf-token" content="<?= csrf_hash() ?>">

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.4);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans h-screen flex overflow-hidden selection:bg-[#00A859] selection:text-white" x-data="{ isSidebarOpen: false }">

    <div x-show="isSidebarOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100 backdrop-blur-sm"
        x-transition:leave="transition ease-in duration-200"
        @click="isSidebarOpen = false"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden" x-cloak>
    </div>

    <aside class="fixed inset-y-0 left-0 z-50 w-65 bg-[#0B4A2D] text-white flex flex-col shadow-2xl transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0 shrink-0"
        :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        <div class="h-16 flex items-center justify-between px-6 border-b border-white/10 shrink-0 bg-[#083a23]">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shadow-sm">
                    <i class="fa-solid fa-gauge-high text-[#0B4A2D]"></i>
                </div>
                <h1 class="text-sm font-bold tracking-tight uppercase">Admin Panel</h1>
            </div>
            <button @click="isSidebarOpen = false" class="lg:hidden w-8 h-8 flex items-center justify-center rounded-lg text-white/70 hover:text-white hover:bg-white/10 transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <?php
        // Accordion init: hanya 1 parent terbuka, sesuai URL aktif
        $activeMenuInit = '';
        if (url_is('admin/kegiatan*') || url_is('admin/berita*') || url_is('admin/kategori-berita*') || url_is('admin/prestasi*') || url_is('admin/pengumuman*') || url_is('admin/kalender*') || url_is('admin/galeri*') || url_is('admin/unduhan*')) $activeMenuInit = 'konten';
        elseif (url_is('admin/beranda*') || url_is('admin/profil*') || url_is('admin/bakat-minat*') || url_is('admin/testimoni*') || url_is('admin/guru*')) $activeMenuInit = 'profil';
        elseif (url_is('admin/pendaftaran*') || url_is('admin/alumni*') || url_is('admin/universitas*')) $activeMenuInit = 'ppdb';
        elseif (url_is('admin/pengaturan*') || url_is('admin/akses-cepat*') || url_is('admin/users*')) $activeMenuInit = 'pengaturan';
        ?>
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto sidebar-scroll pb-24 lg:pb-4" x-data="{ activeMenu: '<?= $activeMenuInit ?>' }">

            <a href="<?= base_url('admin/dashboard') ?>"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?= (url_is('admin') || url_is('admin/dashboard')) ? 'bg-[#00A859] text-white shadow-md font-semibold' : 'text-green-100 hover:bg-white/10 hover:text-white' ?>">
                <i class="fa-solid fa-house w-5 text-center text-sm"></i>
                <span class="text-sm">Dashboard</span>
            </a>

            <?php
            // =====================================================
            // GRUP KONTEN SEKOLAH
            // =====================================================
            $adaKonten = hasAccess('kegiatan') || hasAccess('berita') || hasAccess('prestasi')
                || hasAccess('pengumuman') || hasAccess('kalender') || hasAccess('galeri') || hasAccess('unduhan');
            $kontenAktif = url_is('admin/kegiatan*') || url_is('admin/berita*') || url_is('admin/kategori-berita*')
                || url_is('admin/prestasi*') || url_is('admin/pengumuman*') || url_is('admin/kalender*')
                || url_is('admin/galeri*') || url_is('admin/unduhan*');
            ?>
            <?php if ($adaKonten) : ?>
                <div>
                    <button @click="activeMenu = activeMenu === 'konten' ? '' : 'konten'" class="w-full flex justify-between items-center text-green-100 hover:bg-white/10 hover:text-white px-4 py-3 rounded-xl transition-all duration-200 focus:outline-none" :class="activeMenu === 'konten' ? 'bg-white/5' : ''">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-newspaper w-5 text-center text-sm"></i>
                            <span class="text-sm font-medium">Konten Sekolah</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" :class="activeMenu === 'konten' ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="activeMenu === 'konten'" x-collapse x-cloak class="mt-1 space-y-1">
                        <?php if (hasAccess('kegiatan')): ?>
                            <a href="<?= base_url('admin/kegiatan') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/kegiatan*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-chalkboard text-xs w-5 text-center mr-1 opacity-70"></i> Kegiatan
                            </a>
                        <?php endif; ?>

                        <?php if (hasAccess('berita')): ?>
                            <a href="<?= base_url('admin/berita/tambah') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/berita/tambah') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-pen-to-square text-xs w-5 text-center mr-1 opacity-70"></i> Tulis Berita
                            </a>
                            <a href="<?= base_url('admin/berita') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= (url_is('admin/berita*') && !url_is('admin/berita/tambah') && !url_is('admin/berita/tags*')) ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-list-ul text-xs w-5 text-center mr-1 opacity-70"></i> Daftar Berita
                            </a>
                            <a href="<?= base_url('admin/kategori-berita') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/kategori-berita*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-tags text-xs w-5 text-center mr-1 opacity-70"></i> Kategori &amp; Tags
                            </a>
                        <?php endif; ?>

                        <?php if (hasAccess('prestasi')): ?>
                            <a href="<?= base_url('admin/prestasi') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/prestasi*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-medal text-xs w-5 text-center mr-1 opacity-70"></i> Prestasi
                            </a>
                        <?php endif; ?>

                        <?php if (hasAccess('pengumuman')): ?>
                            <a href="<?= base_url('admin/pengumuman') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/pengumuman*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-bullhorn text-xs w-5 text-center mr-1 opacity-70"></i> Pengumuman
                            </a>
                        <?php endif; ?>

                        <?php if (hasAccess('kalender')): ?>
                            <a href="<?= base_url('admin/kalender') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/kalender*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-calendar-days text-xs w-5 text-center mr-1 opacity-70"></i> Kalender Akademik
                            </a>
                        <?php endif; ?>

                        <?php if (hasAccess('galeri')): ?>
                            <a href="<?= base_url('admin/galeri') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= (url_is('admin/galeri*') && !url_is('admin/galeri-video*')) ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-images text-xs w-5 text-center mr-1 opacity-70"></i> Galeri Foto
                            </a>
                            <a href="<?= base_url('admin/galeri-video') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/galeri-video*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-clapperboard text-xs w-5 text-center mr-1 opacity-70"></i> Galeri Video
                            </a>
                        <?php endif; ?>

                        <?php if (hasAccess('unduhan')): ?>
                            <a href="<?= base_url('admin/unduhan') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/unduhan*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-download text-xs w-5 text-center mr-1 opacity-70"></i> Pusat Unduhan
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            // =====================================================
            // GRUP PROFIL SEKOLAH
            // =====================================================
            $adaProfil = hasAccess('beranda') || hasAccess('profil') || hasAccess('bakat_minat')
                || hasAccess('testimoni') || hasAccess('guru');
            $profilAktif = url_is('admin/beranda*') || url_is('admin/profil*') || url_is('admin/bakat-minat*')
                || url_is('admin/testimoni*') || url_is('admin/guru*');
            ?>
            <?php if ($adaProfil) : ?>
                <div>
                    <button @click="activeMenu = activeMenu === 'profil' ? '' : 'profil'" class="w-full flex justify-between items-center text-green-100 hover:bg-white/10 hover:text-white px-4 py-3 rounded-xl transition-all duration-200 focus:outline-none" :class="activeMenu === 'profil' ? 'bg-white/5' : ''">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-school w-5 text-center text-sm"></i>
                            <span class="text-sm font-medium">Profil Sekolah</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" :class="activeMenu === 'profil' ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="activeMenu === 'profil'" x-collapse x-cloak class="mt-1 space-y-1">
                        <?php if (hasAccess('beranda')): ?>
                            <a href="<?= base_url('admin/beranda') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/beranda*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-sliders text-xs w-5 text-center mr-1 opacity-70"></i> Slider Beranda
                            </a>
                        <?php endif; ?>

                        <?php if (hasAccess('profil')): ?>
                            <a href="<?= base_url('admin/profil') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/profil*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-building-columns text-xs w-5 text-center mr-1 opacity-70"></i> Profil Madrasah
                            </a>
                        <?php endif; ?>

                        <?php if (hasAccess('bakat_minat')): ?>
                            <a href="<?= base_url('admin/bakat-minat') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/bakat-minat*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-futbol text-xs w-5 text-center mr-1 opacity-70"></i> Bakat Minat
                            </a>
                        <?php endif; ?>

                        <?php if (hasAccess('testimoni')): ?>
                            <a href="<?= base_url('admin/testimoni') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/testimoni*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-comment-dots text-xs w-5 text-center mr-1 opacity-70"></i> Testimoni
                            </a>
                        <?php endif; ?>

                        <?php if (hasAccess('guru')): ?>
                            <a href="<?= base_url('admin/guru') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/guru*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-chalkboard-user text-xs w-5 text-center mr-1 opacity-70"></i> Guru &amp; Staff
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            // =====================================================
            // GRUP PPDB & ALUMNI
            // =====================================================
            $adaPpdb = hasAccess('pendaftaran') || hasAccess('alumni') || hasAccess('universitas');
            $ppdbAktif = url_is('admin/pendaftaran*') || url_is('admin/alumni*') || url_is('admin/universitas*');
            ?>
            <?php if ($adaPpdb) : ?>
                <div>
                    <button @click="activeMenu = activeMenu === 'ppdb' ? '' : 'ppdb'" class="w-full flex justify-between items-center text-green-100 hover:bg-white/10 hover:text-white px-4 py-3 rounded-xl transition-all duration-200 focus:outline-none" :class="activeMenu === 'ppdb' ? 'bg-white/5' : ''">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-graduation-cap w-5 text-center text-sm"></i>
                            <span class="text-sm font-medium">PPDB &amp; Alumni</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" :class="activeMenu === 'ppdb' ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="activeMenu === 'ppdb'" x-collapse x-cloak class="mt-1 space-y-1">
                        <?php if (hasAccess('pendaftaran')): ?>
                            <a href="<?= base_url('admin/pendaftaran') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/pendaftaran*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-user-plus text-xs w-5 text-center mr-1 opacity-70"></i> Manajemen PPDB
                            </a>
                        <?php endif; ?>

                        <?php if (hasAccess('alumni')): ?>
                            <a href="<?= base_url('admin/alumni') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/alumni*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-user-graduate text-xs w-5 text-center mr-1 opacity-70"></i> Daftar Alumni
                            </a>
                        <?php endif; ?>

                        <?php if (hasAccess('universitas')): ?>
                            <a href="<?= base_url('admin/universitas') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/universitas*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-building-columns text-xs w-5 text-center mr-1 opacity-70"></i> Kelola Universitas
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (hasAccess('kontak')) : ?>
                <a href="<?= base_url('admin/kontak') ?>"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?= url_is('admin/kontak*') ? 'bg-[#00A859] text-white shadow-md font-semibold' : 'text-green-100 hover:bg-white/10 hover:text-white' ?>">
                    <i class="fa-solid fa-envelope-open-text w-5 text-center text-sm"></i>
                    <span class="text-sm">Kotak Masuk</span>
                </a>
            <?php endif; ?>

            <?php
            // =====================================================
            // GRUP PENGATURAN
            // =====================================================
            $adaPengaturan = hasAccess('pengaturan') || hasAccess('akses_cepat')
                || session()->get('role') === 'superadmin';
            $pengaturanAktif = url_is('admin/pengaturan*') || url_is('admin/akses-cepat*') || url_is('admin/users*');
            ?>
            <?php if ($adaPengaturan) : ?>
                <div>
                    <button @click="activeMenu = activeMenu === 'pengaturan' ? '' : 'pengaturan'" class="w-full flex justify-between items-center text-green-100 hover:bg-white/10 hover:text-white px-4 py-3 rounded-xl transition-all duration-200 focus:outline-none" :class="activeMenu === 'pengaturan' ? 'bg-white/5' : ''">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-gear w-5 text-center text-sm"></i>
                            <span class="text-sm font-medium">Pengaturan</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" :class="activeMenu === 'pengaturan' ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="activeMenu === 'pengaturan'" x-collapse x-cloak class="mt-1 space-y-1">
                        <?php if (hasAccess('pengaturan')): ?>
                            <a href="<?= base_url('admin/pengaturan') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/pengaturan*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-sliders text-xs w-5 text-center mr-1 opacity-70"></i> Profil Web
                            </a>
                        <?php endif; ?>

                        <?php if (hasAccess('akses_cepat')): ?>
                            <a href="<?= base_url('admin/akses-cepat') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors <?= url_is('admin/akses-cepat*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                                <i class="fa-solid fa-link text-xs w-5 text-center mr-1 opacity-70"></i> Menu Akses Cepat
                            </a>
                        <?php endif; ?>

                        <?php if (session()->get('role') === 'superadmin'): ?>
                            <a href="<?= base_url('admin/users') ?>" class="flex items-center py-2.5 px-6 text-sm rounded-lg transition-colors text-red-200 hover:bg-red-500/20 <?= url_is('admin/users*') ? 'bg-red-500/20 font-bold' : 'hover:text-white' ?>">
                                <i class="fa-solid fa-user-shield text-xs w-5 text-center mr-1"></i> Manajemen User
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        </nav>

        <div class="p-4 border-t border-white/10 bg-[#083a23] shrink-0">
            <a href="<?= base_url('logout') ?>" class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-green-100 hover:text-white bg-green-500/10 hover:bg-green-500 transition-colors w-full font-bold text-sm">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar
            </a>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden bg-gray-50/50">

        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-4 lg:px-8 shrink-0 shadow-sm z-10 relative">
            <div class="flex items-center gap-3 lg:gap-4 overflow-hidden">
                <button @click="isSidebarOpen = true" class="lg:hidden p-2 text-gray-500 hover:bg-gray-100 rounded-lg shrink-0">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <h2 class="text-base lg:text-lg font-bold text-gray-800 truncate leading-tight"><?= $title ?? 'Dashboard' ?></h2>
            </div>

            <div class="flex items-center gap-3 lg:gap-5 shrink-0">
                <a href="<?= base_url() ?>" target="_blank" class="hidden sm:flex items-center gap-2 px-4 py-2 text-[11px] font-bold text-gray-600 hover:text-white border border-gray-200 hover:bg-[#0B4A2D] hover:border-[#0B4A2D] rounded-xl transition-all shadow-sm">
                    <i class="fa-solid fa-globe"></i> Kunjungi Web
                </a>

                <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>

                <div class="flex items-center gap-3">
                    <div class="text-right hidden md:block">
                        <p class="text-xs font-bold text-gray-900 leading-none"><?= esc(session()->get('nama_lengkap') ?? 'Admin') ?></p>
                        <p class="text-[10px] text-[#00A859] mt-1 font-semibold uppercase tracking-widest"><?= esc(session()->get('role') ?? 'Administrator') ?></p>
                    </div>
                    <div class="w-9 h-9 lg:w-10 lg:h-10 bg-linear-to-br from-[#0B4A2D] to-[#00A859] rounded-full flex items-center justify-center text-white shadow-md border-2 border-green-100">
                        <i class="fa-solid fa-user-shield text-sm"></i>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 lg:p-8 bg-gray-50">
            <div class="max-w-7xl mx-auto pb-10">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>

    <script>
        (function() {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!token) return;
            const origFetch = window.fetch;
            window.fetch = function(url, opts) {
                opts = opts || {};
                opts.headers = opts.headers || {};
                opts.headers['X-CSRF-TOKEN'] = token;
                return origFetch(url, opts);
            };
            const origOpen = XMLHttpRequest.prototype.open;
            const origSend = XMLHttpRequest.prototype.send;
            XMLHttpRequest.prototype.open = function(method, url, async, user, pass) {
                this._csrfMethod = method;
                return origOpen.call(this, method, url, async, user, pass);
            };
            XMLHttpRequest.prototype.send = function(body) {
                if (this._csrfMethod && String(this._csrfMethod).toUpperCase() !== 'GET') {
                    this.setRequestHeader('X-CSRF-TOKEN', token);
                }
                return origSend.call(this, body);
            };
        })();
    </script>

</body>

</html>
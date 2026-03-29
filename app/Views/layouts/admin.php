<?php
// Mengambil data pengaturan untuk Favicon dan Title di Admin
$pengaturan = (new \App\Models\PengaturanModel())->first();
$currentUri = uri_string();
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

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Custom scrollbar untuk sidebar agar rapi di desktop & mobile */
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

    <aside class="fixed inset-y-0 left-0 z-50 w-[260px] bg-[#0B4A2D] text-white flex flex-col shadow-2xl transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0 shrink-0"
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

        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto sidebar-scroll pb-24 lg:pb-4">

            <a href="<?= base_url('admin/dashboard') ?>"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?= (url_is('admin') || url_is('admin/dashboard')) ? 'bg-[#00A859] text-white shadow-md font-semibold' : 'text-green-100 hover:bg-white/10 hover:text-white' ?>">
                <i class="fa-solid fa-house w-5 text-center text-sm"></i>
                <span class="text-sm">Dashboard</span>
            </a>

            <div x-data="{ open: <?= (strpos($currentUri, 'admin/beranda') !== false || strpos($currentUri, 'admin/profil') !== false || strpos($currentUri, 'admin/guru') !== false || strpos($currentUri, 'admin/testimoni') !== false || strpos($currentUri, 'admin/berita') !== false || strpos($currentUri, 'admin/kategori-berita') !== false || strpos($currentUri, 'admin/prestasi') !== false || strpos($currentUri, 'admin/pengumuman') !== false || strpos($currentUri, 'admin/kalender') !== false) ? 'true' : 'false' ?> }">

                <button @click="open = !open" class="w-full flex justify-between items-center text-green-100 hover:bg-white/10 hover:text-white px-4 py-3 rounded-xl transition-all duration-200 focus:outline-none <?= (strpos($currentUri, 'admin/beranda') !== false || strpos($currentUri, 'admin/profil') !== false || strpos($currentUri, 'admin/guru') !== false || strpos($currentUri, 'admin/testimoni') !== false || strpos($currentUri, 'admin/berita') !== false || strpos($currentUri, 'admin/kategori-berita') !== false || strpos($currentUri, 'admin/prestasi') !== false || strpos($currentUri, 'admin/pengumuman') !== false || strpos($currentUri, 'admin/kalender') !== false) ? 'bg-white/5' : '' ?>">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-layer-group w-5 text-center text-sm"></i>
                        <span class="text-sm font-medium">Manajemen Halaman</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1">
                    <a href="<?= base_url('admin/beranda') ?>" class="flex items-center py-2.5 px-10 text-sm rounded-lg transition-colors <?= url_is('admin/beranda*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                        <i class="fa-solid fa-minus text-[10px] mr-2 opacity-50"></i> Slider Beranda
                    </a>
                    <a href="<?= base_url('admin/profil') ?>" class="flex items-center py-2.5 px-10 text-sm rounded-lg transition-colors <?= url_is('admin/profil*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                        <i class="fa-solid fa-minus text-[10px] mr-2 opacity-50"></i> Profil Madrasah
                    </a>
                    <a href="<?= base_url('admin/guru') ?>" class="flex items-center py-2.5 px-10 text-sm rounded-lg transition-colors <?= url_is('admin/guru*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                        <i class="fa-solid fa-minus text-[10px] mr-2 opacity-50"></i> Data Guru & Staff
                    </a>
                    <a href="<?= base_url('admin/testimoni') ?>" class="flex items-center py-2.5 px-10 text-sm rounded-lg transition-colors <?= url_is('admin/testimoni*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                        <i class="fa-solid fa-minus text-[10px] mr-2 opacity-50"></i> Testimoni
                    </a>

                    <div x-data="{ openBerita: <?= (url_is('admin/berita*') || url_is('admin/kategori-berita*') || url_is('admin/prestasi*') || url_is('admin/pengumuman*')) ? 'true' : 'false' ?> }">
                        <button @click="openBerita = !openBerita" class="w-full flex items-center justify-between py-2.5 px-10 text-sm rounded-lg transition-colors <?= (url_is('admin/berita*') || url_is('admin/kategori-berita*') || url_is('admin/prestasi*') || url_is('admin/pengumuman*')) ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                            <div class="flex items-center">
                                <i class="fa-solid fa-newspaper text-xs mr-2 opacity-70"></i> Portal Berita
                            </div>
                            <i class="fa-solid fa-angle-down text-[10px] transition-transform duration-300" :class="openBerita ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="openBerita" x-collapse x-cloak class="pl-14 pr-4 py-1.5 space-y-1 bg-black/15 rounded-lg mx-4 mt-1 mb-2">
                            <a href="<?= base_url('admin/berita/tambah') ?>" class="block py-2 text-[13px] transition-colors <?= url_is('admin/berita/tambah') ? 'text-[#00A859] font-bold' : 'text-green-200/70 hover:text-white' ?>">Tulis Berita Baru</a>
                            <a href="<?= base_url('admin/berita') ?>" class="block py-2 text-[13px] transition-colors <?= (url_is('admin/berita*') && !url_is('admin/berita/tambah') && !url_is('admin/berita/tags*')) ? 'text-[#00A859] font-bold' : 'text-green-200/70 hover:text-white' ?>">Daftar Berita</a>
                            <a href="<?= base_url('admin/kategori-berita') ?>" class="block py-2 text-[13px] transition-colors <?= url_is('admin/kategori-berita*') ? 'text-[#00A859] font-bold' : 'text-green-200/70 hover:text-white' ?>">Kategori Berita</a>
                            <a href="<?= base_url('admin/berita/tags') ?>" class="block py-2 text-[13px] transition-colors <?= url_is('admin/berita/tags*') ? 'text-[#00A859] font-bold' : 'text-green-200/70 hover:text-white' ?>">Kelola Tags</a>
                            <a href="<?= base_url('admin/prestasi') ?>" class="block py-2 text-[13px] transition-colors <?= url_is('admin/prestasi*') ? 'text-[#00A859] font-bold' : 'text-green-200/70 hover:text-white' ?>">Data Prestasi</a>
                            <a href="<?= base_url('admin/pengumuman') ?>" class="block py-2 text-[13px] transition-colors <?= url_is('admin/pengumuman*') ? 'text-[#00A859] font-bold' : 'text-green-200/70 hover:text-white' ?>">Pengumuman</a>
                        </div>
                    </div>

                    <a href="<?= base_url('admin/kalender') ?>" class="flex items-center py-2.5 px-10 text-sm rounded-lg transition-colors <?= url_is('admin/kalender*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                        <i class="fa-solid fa-minus text-[10px] mr-2 opacity-50"></i> Kalender Akademik
                    </a>
                </div>
            </div>

            <div x-data="{ open: <?= url_is('admin/galeri*') ? 'true' : 'false' ?> }">

                <button @click="open = !open" class="w-full flex justify-between items-center text-green-100 hover:bg-white/10 hover:text-white px-4 py-3 rounded-xl transition-all duration-200 focus:outline-none <?= url_is('admin/galeri*') ? 'bg-white/5' : '' ?>">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-images w-5 text-center text-sm"></i>
                        <span class="text-sm font-medium">Kelola Galeri</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1">
                    <a href="<?= base_url('admin/galeri') ?>" class="flex items-center py-2.5 px-10 text-sm rounded-lg transition-colors <?= (url_is('admin/galeri*') && !url_is('admin/galeri-video*')) ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                        <i class="fa-solid fa-minus text-[10px] mr-2 opacity-50"></i> Galeri Foto
                    </a>
                    <a href="<?= base_url('admin/galeri-video') ?>" class="flex items-center py-2.5 px-10 text-sm rounded-lg transition-colors <?= url_is('admin/galeri-video*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                        <i class="fa-solid fa-minus text-[10px] mr-2 opacity-50"></i> Galeri Video
                    </a>
                </div>
            </div>

            <a href="<?= base_url('admin/pendaftaran') ?>"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?= url_is('admin/pendaftaran*') ? 'bg-[#00A859] text-white shadow-md font-semibold' : 'text-green-100 hover:bg-white/10 hover:text-white' ?>">
                <i class="fa-solid fa-user-plus w-5 text-center text-sm"></i>
                <span class="text-sm">Manajemen PPDB</span>
            </a>

            <a href="<?= base_url('admin/kontak') ?>"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?= url_is('admin/kontak*') ? 'bg-[#00A859] text-white shadow-md font-semibold' : 'text-green-100 hover:bg-white/10 hover:text-white' ?>">
                <i class="fa-solid fa-envelope-open-text w-5 text-center text-sm"></i>
                <span class="text-sm">Kotak Masuk</span>
            </a>

            <div x-data="{ open: <?= (strpos($currentUri, 'admin/pengaturan') !== false || strpos($currentUri, 'admin/akses-cepat') !== false || strpos($currentUri, 'admin/unduhan') !== false) ? 'true' : 'false' ?> }">

                <button @click="open = !open" class="w-full flex justify-between items-center text-green-100 hover:bg-white/10 hover:text-white px-4 py-3 rounded-xl transition-all duration-200 focus:outline-none <?= (strpos($currentUri, 'admin/pengaturan') !== false || strpos($currentUri, 'admin/akses-cepat') !== false || strpos($currentUri, 'admin/unduhan') !== false) ? 'bg-white/5' : '' ?>">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-gear w-5 text-center text-sm"></i>
                        <span class="text-sm font-medium">Pengaturan Sistem</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1">
                    <a href="<?= base_url('admin/pengaturan') ?>" class="flex items-center py-2.5 px-10 text-sm rounded-lg transition-colors <?= url_is('admin/pengaturan*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                        <i class="fa-solid fa-minus text-[10px] mr-2 opacity-50"></i> Profil Web
                    </a>
                    <a href="<?= base_url('admin/akses-cepat') ?>" class="flex items-center py-2.5 px-10 text-sm rounded-lg transition-colors <?= url_is('admin/akses-cepat*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                        <i class="fa-solid fa-minus text-[10px] mr-2 opacity-50"></i> Menu Akses Cepat
                    </a>
                    <a href="<?= base_url('admin/unduhan') ?>" class="flex items-center py-2.5 px-10 text-sm rounded-lg transition-colors <?= url_is('admin/unduhan*') ? 'text-white font-bold bg-white/10' : 'text-green-200/80 hover:text-white hover:bg-white/5' ?>">
                        <i class="fa-solid fa-minus text-[10px] mr-2 opacity-50"></i> Pusat Unduhan
                    </a>
                </div>
            </div>

        </nav>

        <div class="p-4 border-t border-white/10 bg-[#083a23] shrink-0">
            <a href="<?= base_url('logout') ?>" class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-red-100 hover:text-white bg-red-500/10 hover:bg-red-500 transition-colors w-full font-bold text-sm">
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
                        <p class="text-xs font-bold text-gray-900 leading-none">Admin Madrasah</p>
                        <p class="text-[10px] text-[#00A859] mt-1 font-semibold uppercase tracking-widest">Administrator</p>
                    </div>
                    <div class="w-9 h-9 lg:w-10 lg:h-10 bg-gradient-to-br from-[#0B4A2D] to-[#00A859] rounded-full flex items-center justify-center text-white shadow-md border-2 border-green-100">
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

</body>

</html>
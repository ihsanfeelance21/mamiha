<?php
// Mengambil data pengaturan untuk Favicon dan Title di Admin
$pengaturan = (new \App\Models\PengaturanModel())->first();
$currentUri = uri_string();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?> - <?= esc($pengaturan['nama_sekolah'] ?? 'Admin') ?></title>

    <?php if (!empty($pengaturan['favicon'])) : ?>
        <link rel="icon" type="image/png" href="<?= base_url('uploads/pengaturan/' . $pengaturan['favicon']) ?>">
    <?php endif; ?>

    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Custom scrollbar untuk sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #065f46;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-white text-gray-800 font-sans h-screen flex overflow-hidden" x-data="{ isSidebarOpen: false }">

    <div x-show="isSidebarOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        @click="isSidebarOpen = false"
        class="fixed inset-0 bg-black/60 z-40 lg:hidden" x-cloak>
    </div>

    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0B4A2D] text-white flex flex-col shadow-xl transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0 shrink-0"
        :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        <div class="h-16 flex items-center justify-between px-6 border-b border-white/10 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white rounded flex items-center justify-center">
                    <i class="fa-solid fa-gauge-high text-[#0B4A2D]"></i>
                </div>
                <h1 class="text-sm font-bold tracking-tight uppercase">Admin Panel</h1>
            </div>
            <button @click="isSidebarOpen = false" class="lg:hidden text-white/70 hover:text-white">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto sidebar-scroll">

            <a href="<?= base_url('admin/dashboard') ?>"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 <?= (url_is('admin') || url_is('admin/dashboard')) ? 'bg-[#00A859] text-white shadow-md' : 'text-green-100 hover:bg-white/10' ?>">
                <i class="fa-solid fa-house w-5 text-center text-sm"></i>
                <span class="font-medium text-sm">Dashboard</span>
            </a>

            <div x-data="{ open: <?= (strpos($currentUri, 'admin/beranda') !== false || strpos($currentUri, 'admin/profil') !== false || strpos($currentUri, 'admin/guru') !== false || strpos($currentUri, 'admin/kegiatan') !== false || strpos($currentUri, 'admin/testimoni') !== false) ? 'true' : 'false' ?> }">
                <button @click="open = !open"
                    class="w-full flex justify-between items-center text-green-100 hover:bg-white/10 px-4 py-3 rounded-lg transition-all duration-200 focus:outline-none">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-layer-group w-5 text-center text-sm"></i>
                        <span class="font-medium text-sm">Manajemen Halaman</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" x-cloak x-collapse class="mt-1 space-y-1 pl-4">
                    <a href="<?= base_url('admin/beranda') ?>" class="flex items-center py-2 px-8 text-xs rounded-lg transition-colors <?= url_is('admin/beranda*') ? 'text-white font-bold' : 'text-green-200/70 hover:text-white' ?>">
                        Slider Beranda
                    </a>
                    <a href="<?= base_url('admin/profil') ?>" class="flex items-center py-2 px-8 text-xs rounded-lg transition-colors <?= url_is('admin/profil*') ? 'text-white font-bold' : 'text-green-200/70 hover:text-white' ?>">
                        Profil Madrasah
                    </a>
                    <a href="<?= base_url('admin/guru') ?>" class="flex items-center py-2 px-8 text-xs rounded-lg transition-colors <?= url_is('admin/guru*') ? 'text-white font-bold' : 'text-green-200/70 hover:text-white' ?>">
                        Data Guru & Staff
                    </a>

                    <a href="<?= base_url('admin/testimoni') ?>" class="flex items-center py-2 px-8 text-xs rounded-lg transition-colors <?= url_is('admin/testimoni*') ? 'text-white font-bold' : 'text-green-200/70 hover:text-white' ?>">
                        Testimoni
                    </a>
                    <div class="mt-4">
                        <button onclick="document.getElementById('submenu-berita').classList.toggle('hidden')"
                            class="w-full flex items-center justify-between px-4 py-2 text-text-main hover:bg-gray-100 rounded-lg transition <?= url_is('admin/berita*') || url_is('admin/kategori-berita*') || url_is('admin/prestasi*') ? 'bg-blue-50 font-semibold' : '' ?>">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H14"></path>
                                </svg>
                                Berita
                            </div>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div id="submenu-berita" class="flex-col pl-11 pr-4 py-2 space-y-1 <?= url_is('admin/berita*') || url_is('admin/kategori-berita*') || url_is('admin/prestasi*') ? 'flex' : 'hidden' ?>">

                            <a href="<?= base_url('admin/berita/tambah') ?>" class="block py-1.5 text-sm text-gray-500 hover:text-primary transition <?= url_is('admin/berita/tambah') ? 'text-primary font-medium' : '' ?>">
                                + Tulis Berita
                            </a>

                            <a href="<?= base_url('admin/berita') ?>" class="block py-1.5 text-sm text-gray-500 hover:text-primary transition <?= (url_is('admin/berita*') && !url_is('admin/berita/tambah')) ? 'text-primary font-medium' : '' ?>">
                                Daftar Berita
                            </a>

                            <a href="<?= base_url('admin/kategori-berita') ?>" class="block py-1.5 text-sm text-gray-500 hover:text-primary transition <?= url_is('admin/kategori-berita*') ? 'text-primary font-medium' : '' ?>">
                                Kategori Berita
                            </a>

                            <a href="<?= base_url('admin/berita/tags') ?>" class="block py-1.5 text-sm text-gray-500 hover:text-primary transition <?= url_is('admin/berita/tags*') ? 'text-primary font-medium' : '' ?>">
                                Kelola Tags
                            </a>

                            <a href="<?= base_url('admin/prestasi') ?>" class="block py-1.5 text-sm text-gray-500 hover:text-primary transition <?= url_is('admin/prestasi*') ? 'text-primary font-medium' : '' ?>">
                                Data Prestasi
                            </a>
                        </div>
                    </div>

                    <a href="<?= base_url('admin/kalender') ?>" class="flex items-center py-2 px-8 text-xs rounded-lg transition-colors <?= url_is('admin/kalender') ? 'text-white font-bold' : 'text-green-200/70 hover:text-white' ?>">
                        Kelola Kalender
                    </a>
                </div>
            </div>

            <a href="<?= base_url('admin/pendaftaran') ?>"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 <?= url_is('admin/pendaftaran*') ? 'bg-[#00A859] text-white shadow-md' : 'text-green-100 hover:bg-white/10' ?>">
                <i class="fa-solid fa-user-plus w-5 text-center text-sm"></i>
                <span class="font-medium text-sm">Manajemen PPDB</span>
            </a>

            <div x-data="{ open: <?= (strpos($currentUri, 'admin/pengaturan') !== false || strpos($currentUri, 'admin/akses-cepat') !== false) ? 'true' : 'false' ?> }">
                <button @click="open = !open"
                    class="w-full flex justify-between items-center text-green-100 hover:bg-white/10 px-4 py-3 rounded-lg transition-all duration-200 focus:outline-none">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-gear w-5 text-center text-sm"></i>
                        <span class="font-medium text-sm">Pengaturan</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" x-cloak x-collapse class="mt-1 space-y-1 pl-4">
                    <a href="<?= base_url('admin/pengaturan') ?>" class="flex items-center py-2 px-8 text-xs rounded-lg transition-colors <?= url_is('admin/pengaturan*') ? 'text-white font-bold' : 'text-green-200/70 hover:text-white' ?>">
                        Profil Web
                    </a>
                    <a href="<?= base_url('admin/akses-cepat') ?>" class="flex items-center py-2 px-8 text-xs rounded-lg transition-colors <?= url_is('admin/akses-cepat*') ? 'text-white font-bold' : 'text-green-200/70 hover:text-white' ?>">
                        Akses Cepat
                    </a>
                </div>
            </div>

        </nav>

        <div class="p-4 border-t border-white/10">
            <a href="<?= base_url('logout') ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg text-red-300 hover:bg-red-500/10 transition-colors">
                <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                <span class="font-medium text-sm">Keluar</span>
            </a>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden bg-white">

        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-4 lg:px-8 shrink-0">
            <div class="flex items-center gap-4">
                <button @click="isSidebarOpen = true" class="lg:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                <h2 class="text-base lg:text-lg font-bold text-gray-800 truncate"><?= $title ?? 'Dashboard' ?></h2>
            </div>

            <div class="flex items-center gap-3 lg:gap-4">
                <a href="<?= base_url() ?>" target="_blank" class="hidden md:flex items-center gap-2 px-3 py-1.5 text-[11px] font-semibold text-gray-500 hover:text-[#00A859] border border-gray-200 rounded-lg transition-all">
                    <i class="fa-solid fa-globe"></i> Lihat Web
                </a>

                <div class="h-8 w-px bg-gray-200 mx-1"></div>

                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-gray-900 leading-none">Admin</p>
                        <p class="text-[10px] text-gray-500 mt-1 uppercase tracking-widest">Administrator</p>
                    </div>
                    <div class="w-8 h-8 lg:w-9 lg:h-9 bg-[#0B4A2D] rounded-full flex items-center justify-center text-white shadow-md">
                        <i class="fa-solid fa-user text-sm"></i>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 lg:p-10 bg-white">
            <div class="max-w-7xl mx-auto">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>

</body>

</html>
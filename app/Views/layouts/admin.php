<?php
// Mengambil data pengaturan untuk Favicon dan Title di Admin
$pengaturan = (new \App\Models\PengaturanModel())->first();
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
</head>

<body class="bg-surface text-text-main font-sans flex h-screen overflow-hidden">

    <aside class="w-64 bg-white shadow-md flex flex-col">
        <div class="h-16 flex items-center justify-center border-b border-gray-200">
            <h1 class="text-xl font-bold text-primary">Admin MAMIHA</h1>
        </div>
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <a href="<?= base_url('admin/dashboard') ?>"
                class="block px-4 py-2 rounded transition <?= url_is('admin') || url_is('admin/dashboard') ? 'bg-[var(--color-primary)] text-white' : 'text-[var(--color-text-muted)] hover:bg-gray-100' ?>">
                Dashboard
            </a>

            <div class="mb-2">
                <button onclick="document.getElementById('menuHalaman').classList.toggle('hidden')" class="w-full flex justify-between items-center text-gray-300 hover:text-white hover:bg-green-800 px-4 py-3 rounded-lg transition focus:outline-none">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-layer-group w-5 text-center"></i>
                        <span>Manajemen Halaman</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>

                <div id="menuHalaman" class="hidden flex-col gap-1 pl-11 pr-4 mt-1 transition-all duration-300">
                    <a href="<?= base_url('admin/beranda') ?>" class="text-sm text-gray-400 hover:text-white py-2 block transition">
                        <i class="fa-regular fa-image mr-2 text-xs"></i> Slider Beranda
                    </a>
                    <a href="<?= base_url('admin/profil') ?>" class="text-sm text-gray-400 hover:text-white py-2 block transition">
                        <i class="fa-regular fa-newspaper mr-2 text-xs"></i> Profil Madrasah
                    </a>
                    <a href="<?= base_url('admin/guru') ?>" class="text-sm text-gray-400 hover:text-white py-2 block transition">
                        <i class="fa-regular fa-newspaper mr-2 text-xs"></i> Data Guru & Staff
                    </a>
                    <a href="<?= base_url('admin/kegiatan') ?>" class="text-sm text-gray-400 hover:text-white py-2 block transition">
                        <i class="fa-regular fa-newspaper mr-2 text-xs"></i> Kegiatan Sekolah
                    </a>
                    <a href="<?= base_url('admin/testimoni') ?>" class="text-sm text-gray-400 hover:text-white py-2 block transition">
                        <i class="fa-regular fa-newspaper mr-2 text-xs"></i> Testimoni
                    </a>
                </div>
            </div>

            <a href="<?= base_url('admin/pendaftaran') ?>" class="flex items-center gap-3 text-gray-300 hover:text-white hover:bg-green-800 px-4 py-3 rounded-lg transition">
                <i class="fa-solid fa-user-plus w-5 text-center"></i>
                <span>Manajemen PPDB</span>
            </a>

            <div class="mb-2">
                <button onclick="document.getElementById('menuPengaturan').classList.toggle('hidden')" class="w-full flex justify-between items-center text-gray-300 hover:text-white hover:bg-green-800 px-4 py-3 rounded-lg transition focus:outline-none">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-gear w-5 text-center"></i>
                        <span>Pengaturan</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>

                <div id="menuPengaturan" class="hidden flex-col gap-1 pl-11 pr-4 mt-1 transition-all duration-300">
                    <a href="<?= base_url('admin/pengaturan') ?>" class="text-sm text-gray-400 hover:text-white py-2 block transition">
                        <i class="fa-solid fa-globe mr-2 text-xs"></i> Profil Web
                    </a>
                    <a href="<?= base_url('admin/akses-cepat') ?>" class="text-sm text-gray-400 hover:text-white py-2 block transition">
                        <i class="fa-solid fa-link mr-2 text-xs"></i> Akses Cepat
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6">
            <h2 class="text-lg font-semibold"><?= $title ?? 'Dashboard' ?></h2>
            <div>
                <span class="text-sm font-medium">Halo, Admin</span>
            </div>
        </header>

        <main class="flex-1 p-6 overflow-y-auto">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

</body>

</html>
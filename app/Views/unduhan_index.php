<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="pt-32 pb-12 bg-[#0B4A2D] text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Pusat Unduhan</h1>
        <p class="text-lg text-green-100 max-w-2xl mx-auto">Temukan dan unduh berbagai dokumen resmi, formulir, modul, dan aplikasi madrasah di sini.</p>
    </div>
</section>

<section class="py-16 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <?php if (!empty($unduhan)) : ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <ul class="divide-y divide-gray-100">
                    <?php foreach ($unduhan as $item) : ?>

                        <?php
                        // Tentukan Ikon berdasarkan kategori
                        $icon = 'fa-file-lines';
                        $iconColor = 'text-gray-400';
                        $kategori = strtolower($item['kategori']);

                        if (strpos($kategori, 'surat') !== false) {
                            $icon = 'fa-envelope-open-text';
                            $iconColor = 'text-blue-500';
                        } elseif (strpos($kategori, 'aplikasi') !== false || strpos($kategori, 'software') !== false) {
                            $icon = 'fa-mobile-screen-button';
                            $iconColor = 'text-purple-500';
                        } elseif (strpos($kategori, 'modul') !== false || strpos($kategori, 'akademik') !== false) {
                            $icon = 'fa-book-open';
                            $iconColor = 'text-orange-500';
                        }
                        ?>

                        <li class="p-5 md:p-6 hover:bg-gray-50 transition-colors group flex flex-col md:flex-row md:items-center gap-4 md:gap-6">

                            <div class="hidden md:flex shrink-0 w-14 h-14 rounded-xl bg-gray-50 border border-gray-100 items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fa-solid <?= $icon ?> text-2xl <?= $iconColor ?>"></i>
                            </div>

                            <div class="grow">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-600 border border-gray-200">
                                        <?= esc($item['kategori']) ?>
                                    </span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800 group-hover:text-[#00A859] transition-colors leading-snug">
                                    <?= esc($item['judul']) ?>
                                </h3>
                                <?php if (!empty($item['keterangan'])): ?>
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2"><?= esc($item['keterangan']) ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="shrink-0 mt-2 md:mt-0">
                                <?php
                                // Logika prioritas: Jika ada link eksternal, gunakan itu. Jika tidak, gunakan file lokal.
                                $urlUnduh = '#';
                                $target = '_blank';
                                $iconClass = 'fa-solid fa-cloud-arrow-down'; // Default pakai fa-solid

                                if (!empty($item['link_eksternal'])) {
                                    $urlUnduh = esc($item['link_eksternal']);
                                    $iconClass = 'fa-brands fa-google-drive'; // Google Drive pakai fa-brands
                                } elseif (!empty($item['file_unduhan'])) {
                                    $urlUnduh = base_url('uploads/unduhan/' . $item['file_unduhan']);
                                }
                                ?>

                                <a href="<?= $urlUnduh ?>" target="<?= $target ?>" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg text-sm font-bold text-white bg-[#00A859] hover:bg-green-700 shadow-sm hover:shadow-md transition-all group-hover:-translate-y-1 w-full md:w-auto">
                                    <i class="<?= $iconClass ?> text-lg"></i> Unduh File
                                </a>
                            </div>

                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else : ?>
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm max-w-2xl mx-auto">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-folder-open text-4xl text-gray-300"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada File</h3>
                <p class="text-gray-500">Saat ini belum ada dokumen atau aplikasi yang tersedia untuk diunduh.</p>
            </div>
        <?php endif; ?>

    </div>
</section>

<?= $this->endSection() ?>
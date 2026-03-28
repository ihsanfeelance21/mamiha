<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="pt-32 pb-12 bg-[#0B4A2D] text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/20 shadow-sm rounded-full mb-4 backdrop-blur-sm">
            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
            <span class="text-sm font-bold text-green-400 tracking-widest uppercase">Generasi Juara</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Galeri Prestasi</h1>
        <p class="text-lg text-green-100 max-w-2xl mx-auto">
            Jejak langkah kebanggaan dan deretan penghargaan yang diraih oleh siswa, guru, dan institusi MA Mabadi'ul Ihsan.
        </p>
    </div>
</section>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-10 relative z-20">
            <form action="<?= base_url('prestasi') ?>" method="get" class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">

                <div class="lg:col-span-4">
                    <label for="cari" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Cari Prestasi</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </span>
                        <input type="text" name="cari" id="cari" value="<?= esc($keyword ?? '') ?>"
                            placeholder="Cari nama lomba atau pemenang..."
                            class="w-full pl-9 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all text-sm text-gray-700">
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <label for="kategori" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Kategori</label>
                    <select name="kategori" id="kategori" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all cursor-pointer text-sm text-gray-700">
                        <option value="">Semua Kategori</option>
                        <option value="Prestasi Siswa" <?= (($kategoriAktif ?? '') == 'Siswa') ? 'selected' : '' ?>>Prestasi Siswa</option>
                        <option value="Prestasi Guru" <?= (($kategoriAktif ?? '') == 'Guru') ? 'selected' : '' ?>>Prestasi Guru</option>
                        <option value="Prestasi Madrasah" <?= (($kategoriAktif ?? '') == 'Madrasah') ? 'selected' : '' ?>>Prestasi Madrasah</option>
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <label for="tahun" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Tahun</label>
                    <select name="tahun" id="tahun" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all cursor-pointer text-sm text-gray-700">
                        <option value="">Semua Tahun</option>
                        <?php
                        $currentYear = date('Y');
                        for ($y = $currentYear; $y >= $currentYear - 5; $y--) : ?>
                            <option value="<?= $y ?>" <?= (($tahunAktif ?? '') == $y) ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <label for="urutan" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Urutkan</label>
                    <select name="urutan" id="urutan" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all cursor-pointer text-sm text-gray-700">
                        <option value="terbaru" <?= (($urutanAktif ?? 'terbaru') == 'terbaru') ? 'selected' : '' ?>>Terbaru</option>
                        <option value="terlama" <?= (($urutanAktif ?? '') == 'terlama') ? 'selected' : '' ?>>Terlama</option>
                    </select>
                </div>

                <div class="lg:col-span-1 flex gap-2 w-full">
                    <button type="submit" class="grow px-0 py-2.5 bg-[#00A859] hover:bg-[#0B4A2D] text-white font-bold rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2 h-10.5" title="Terapkan Filter">
                        <i class="fa-solid fa-filter"></i> <span class="lg:hidden">Filter</span>
                    </button>

                    <?php if (!empty($keyword) || !empty($kategoriAktif) || !empty($tahunAktif) || ($urutanAktif ?? 'terbaru') != 'terbaru'): ?>
                        <a href="<?= base_url('prestasi') ?>" class="w-10.5 py-2.5 bg-red-50 hover:bg-red-100 text-red-500 border border-red-100 font-bold rounded-xl transition-colors flex items-center justify-center shrink-0 h-10.5" title="Reset Filter">
                            <i class="fa-solid fa-rotate-right"></i>
                        </a>
                    <?php endif; ?>
                </div>

            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mb-12">

            <?php if (!empty($prestasi)) : ?>
                <?php foreach ($prestasi as $item) : ?>
                    <div class="group relative bg-gray-200 rounded-4xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 h-120 md:h-130">

                        <?php if ($item['gambar']) : ?>
                            <img src="<?= base_url('uploads/prestasi/' . $item['gambar']) ?>" alt="<?= esc($item['judul']) ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <?php else : ?>
                            <div class="absolute inset-0 w-full h-full flex flex-col items-center justify-center bg-gray-100 text-gray-400">
                                <i class="fa-solid fa-medal text-5xl mb-2"></i>
                                <span class="text-sm">Tanpa Poster</span>
                            </div>
                        <?php endif; ?>

                        <div class="absolute top-5 left-5 bg-white px-3.5 py-1.5 rounded-full text-[11px] font-extrabold text-gray-800 shadow-md flex items-center gap-2 z-10">
                            <span class="w-2 h-2 rounded-full bg-green-700"></span>
                            <?= esc(strtoupper($item['juara'])) ?>
                        </div>

                        <div class="absolute bottom-4 left-4 right-4 bg-white rounded-2xl p-5 shadow-xl z-10 flex flex-col">

                            <div class="mb-1.5">
                                <span class="text-gray-400 font-bold text-[10px] uppercase tracking-widest">
                                    Prestasi <?= esc($item['kategori_prestasi']) ?>
                                </span>
                            </div>

                            <a href="<?= base_url('prestasi/detail/' . $item['slug']) ?>" class="block">
                                <h3 class="text-lg font-extrabold text-gray-800 leading-tight mb-2 line-clamp-2 group-hover:text-[#00A859] transition-colors" title="<?= esc($item['judul']) ?>">
                                    <?= esc($item['judul']) ?>
                                </h3>
                            </a>

                            <p class="text-gray-500 text-xs leading-relaxed mb-4 line-clamp-2">
                                <?= esc(mb_substr(strip_tags($item['konten']), 0, 100)) ?>...
                            </p>

                            <div class="pt-4 border-t border-gray-100 flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2 truncate">
                                    <div class="w-6 h-6 rounded-full bg-gray-50 text-gray-400 border border-gray-100 flex items-center justify-center shrink-0">
                                        <?php if ($item['kategori_prestasi'] == 'Madrasah'): ?>
                                            <i class="fa-solid fa-school text-[10px]"></i>
                                        <?php elseif ($item['kategori_prestasi'] == 'Guru'): ?>
                                            <i class="fa-solid fa-chalkboard-user text-[10px]"></i>
                                        <?php else: ?>
                                            <i class="fa-regular fa-user text-[10px]"></i>
                                        <?php endif; ?>
                                    </div>
                                    <span class="font-bold text-gray-600 text-xs truncate">
                                        <?php
                                        if ($item['kategori_prestasi'] == 'Guru') {
                                            echo esc($item['nama_guru']);
                                        } elseif ($item['kategori_prestasi'] == 'Madrasah') {
                                            echo "MA Mabadi'ul Ihsan";
                                        } else {
                                            echo esc($item['nama_pemenang']);
                                        }
                                        ?>
                                    </span>
                                </div>
                                <div class="bg-green-50 text-green-600 px-2.5 py-1 rounded text-[11px] font-bold shrink-0">
                                    <?= esc($item['tahun_perolehan']) ?>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm">
                    <i class="fa-solid fa-medal text-4xl text-gray-300 mb-4 block"></i>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Data Prestasi</h3>
                    <p class="text-gray-500">Maaf, data prestasi belum tersedia atau tidak ditemukan sesuai filter pencarian.</p>
                    <a href="<?= base_url('prestasi') ?>" class="inline-block mt-4 text-[#00A859] font-bold hover:underline">Reset Pencarian</a>
                </div>
            <?php endif; ?>

        </div>

        <?php if (isset($pager)) : ?>
            <div class="flex justify-center mt-8">
                <div class="[&>ul]:flex [&>ul]:gap-2 [&>ul>li>a]:px-4 [&>ul>li>a]:py-2 [&>ul>li>a]:bg-white [&>ul>li>a]:border [&>ul>li>a]:border-gray-200 [&>ul>li>a]:rounded-lg [&>ul>li>a:hover]:bg-gray-50 [&>ul>li.active>a]:bg-[#00A859] [&>ul>li.active>a]:text-white [&>ul>li.active>a]:border-[#00A859] [&>ul>li>span]:px-4 [&>ul>li>span]:py-2 [&>ul>li>span]:bg-[#00A859] [&>ul>li>span]:text-white [&>ul>li>span]:rounded-lg">
                    <?= $pager->links('prestasi') ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>

<?= $this->endSection() ?>
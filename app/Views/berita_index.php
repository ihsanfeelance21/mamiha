<?= $this->extend('layouts/main') ?> <?= $this->section('content') ?>

<section class="pt-32 pb-12 bg-[#0B4A2D] text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Pusat Informasi & Berita</h1>
        <p class="text-lg text-green-100 max-w-2xl mx-auto">
            Temukan kabar terbaru, pengumuman, dan berbagai informasi seputar kegiatan di MA Mabadi'ul Ihsan.
        </p>
    </div>
</section>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-10 relative z-20">
            <form action="<?= base_url('berita') ?>" method="get" class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">

                <div class="lg:col-span-4">
                    <label for="cari" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Cari Berita</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </span>
                        <input type="text" name="cari" id="cari" value="<?= esc($keyword ?? '') ?>"
                            placeholder="Ketik kata kunci..."
                            class="w-full pl-9 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all text-sm text-gray-700">
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <label for="kategori" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Kategori</label>
                    <select name="kategori" id="kategori" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all cursor-pointer text-sm text-gray-700">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($kategoriList as $kat) : ?>
                            <option value="<?= esc($kat['slug_kategori']) ?>" <?= ($kategoriAktif == $kat['slug_kategori']) ? 'selected' : '' ?>>
                                <?= esc($kat['nama_kategori']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <label for="tahun" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Tahun</label>
                    <select name="tahun" id="tahun" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all cursor-pointer text-sm text-gray-700">
                        <option value="">Semua Tahun</option>
                        <?php
                        $currentYear = date('Y');
                        for ($y = $currentYear; $y >= $currentYear - 3; $y--) : ?>
                            <option value="<?= $y ?>" <?= ($tahunAktif == $y) ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <label for="urutan" class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Urutkan</label>
                    <select name="urutan" id="urutan" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all cursor-pointer text-sm text-gray-700">
                        <option value="terbaru" <?= ($urutanAktif == 'terbaru') ? 'selected' : '' ?>>Terbaru</option>
                        <option value="terlama" <?= ($urutanAktif == 'terlama') ? 'selected' : '' ?>>Terlama</option>
                    </select>
                </div>

                <div class="lg:col-span-1 flex gap-2 w-full">
                    <button type="submit" class="grow px-0 py-2.5 bg-[#00A859] hover:bg-[#0B4A2D] text-white font-bold rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2 h-10.5" title="Terapkan Filter">
                        <i class="fa-solid fa-filter"></i> <span class="lg:hidden">Filter</span>
                    </button>

                    <?php if (!empty($keyword) || !empty($kategoriAktif) || !empty($tahunAktif) || $urutanAktif != 'terbaru'): ?>
                        <a href="<?= base_url('berita') ?>" class="w-10.5 py-2.5 bg-red-50 hover:bg-red-100 text-red-500 border border-red-100 font-bold rounded-xl transition-colors flex items-center justify-center shrink-0 h-10.5" title="Reset Filter">
                            <i class="fa-solid fa-rotate-right"></i>
                        </a>
                    <?php endif; ?>
                </div>

            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">

            <?php if (!empty($berita)) : ?>
                <?php foreach ($berita as $item) : ?>
                    <div class="group bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <div class="relative h-60 overflow-hidden bg-gray-100">
                            <?php if ($item['gambar']) : ?>
                                <img src="<?= base_url('uploads/berita/' . $item['gambar']) ?>" alt="<?= esc($item['judul']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                            <?php else : ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm"><i class="fa-regular fa-image text-3xl mb-2 block text-center"></i> Tanpa Gambar</div>
                            <?php endif; ?>

                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-bold text-[#0B4A2D] shadow-sm">
                                <?= esc($item['nama_kategori'] ?? 'Umum') ?>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col grow">
                            <div class="flex items-center gap-4 text-xs text-gray-500 mb-3 font-medium">
                                <span class="flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar text-[#00A859]"></i>
                                    <?= date('d M Y', strtotime($item['waktu_tayang'] ?? $item['created_at'])) ?>
                                </span>
                                <span class="flex items-center gap-1.5"><i class="fa-regular fa-user text-[#00A859]"></i> Admin</span>
                            </div>

                            <a href="<?= base_url('berita/baca/' . $item['slug']) ?>" class="block mb-3">
                                <h3 class="text-xl font-bold text-gray-800 leading-snug group-hover:text-[#00A859] transition-colors line-clamp-2" title="<?= esc($item['judul']) ?>">
                                    <?= esc($item['judul']) ?>
                                </h3>
                            </a>

                            <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-3">
                                <?= esc(mb_substr(strip_tags($item['konten']), 0, 150)) ?>...
                            </p>

                            <div class="mt-auto pt-4 border-t border-gray-100">
                                <a href="<?= base_url('berita/baca/' . $item['slug']) ?>" class="inline-flex items-center gap-2 text-sm font-bold text-[#0B4A2D] group-hover:text-[#00A859] transition-colors">
                                    Baca Selengkapnya <i class="fa-solid fa-arrow-right-long group-hover:translate-x-2 transition-transform duration-300"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 bg-white rounded-3xl border border-gray-100">
                    <i class="fa-solid fa-magnifying-glass text-4xl text-gray-300 mb-4 block"></i>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Pencarian Tidak Ditemukan</h3>
                    <p class="text-gray-500">Maaf, kami tidak dapat menemukan berita yang sesuai dengan filter atau kata kunci Anda.</p>
                    <a href="<?= base_url('berita') ?>" class="inline-block mt-4 text-[#00A859] font-bold hover:underline">Reset Pencarian</a>
                </div>
            <?php endif; ?>

        </div>

        <?php if ($pager) : ?>
            <div class="flex justify-center mt-8">
                <div class="[&>ul]:flex [&>ul]:gap-2 [&>ul>li>a]:px-4 [&>ul>li>a]:py-2 [&>ul>li>a]:bg-white [&>ul>li>a]:border [&>ul>li>a]:border-gray-200 [&>ul>li>a]:rounded-lg [&>ul>li>a:hover]:bg-gray-50 [&>ul>li.active>a]:bg-[#00A859] [&>ul>li.active>a]:text-white [&>ul>li.active>a]:border-[#00A859] [&>ul>li>span]:px-4 [&>ul>li>span]:py-2 [&>ul>li>span]:bg-[#00A859] [&>ul>li>span]:text-white [&>ul>li>span]:rounded-lg">
                    <?= $pager->links('berita') ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>

<?= $this->endSection() ?>
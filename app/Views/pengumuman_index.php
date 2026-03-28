<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="pt-32 pb-12 bg-[#0B4A2D] text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/20 shadow-sm rounded-full mb-4 backdrop-blur-sm">
            <i class="fa-solid fa-bullhorn text-green-400"></i>
            <span class="text-sm font-bold text-green-400 tracking-widest uppercase">Pusat Informasi</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Pengumuman Madrasah</h1>
        <p class="text-lg text-green-100 max-w-2xl mx-auto">Dapatkan informasi terbaru seputar agenda, kebijakan, dan pengumuman penting lainnya.</p>
    </div>
</section>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-wrap justify-center gap-3 mb-12">
            <a href="<?= base_url('/pengumuman') ?>" class="px-5 py-2.5 rounded-full font-semibold transition-all shadow-sm <?= empty($kategori_aktif) ? 'bg-[#00A859] text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' ?>">
                Semua
            </a>
            <?php
            $kategoris = ['Akademik', 'Kesiswaan', 'Keuangan', 'Sarpras', 'Umum'];
            foreach ($kategoris as $kat): ?>
                <a href="<?= base_url('/pengumuman?kategori=' . $kat) ?>" class="px-5 py-2.5 rounded-full font-semibold transition-all shadow-sm <?= ($kategori_aktif == $kat) ? 'bg-[#00A859] text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' ?>">
                    <?= $kat ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($pengumuman)) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($pengumuman as $item) : ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full relative">
                        <div class="absolute top-4 right-4 z-10 bg-green-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-md uppercase tracking-wider">
                            <?= esc($item['kategori']) ?>
                        </div>

                        <div class="h-56 overflow-hidden bg-gray-100 relative">
                            <?php if ($item['gambar']) : ?>
                                <img src="<?= base_url('uploads/pengumuman/' . $item['gambar']) ?>" alt="<?= esc($item['judul']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <?php else : ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fa-solid fa-bullhorn text-6xl text-gray-300"></i>
                                </div>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent opacity-60"></div>
                        </div>

                        <div class="p-6 flex flex-col grow">
                            <div class="flex items-center gap-2 text-sm text-gray-500 mb-3 font-medium">
                                <i class="fa-regular fa-calendar-check text-[#00A859]"></i>
                                <?= date('d M Y', strtotime($item['tanggal_publish'])) ?>
                            </div>

                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 leading-snug group-hover:text-[#00A859] transition-colors">
                                <?= esc($item['judul']) ?>
                            </h3>

                            <p class="text-gray-600 mb-6 line-clamp-3 text-sm grow">
                                <?= strip_tags($item['konten']) ?>
                            </p>

                            <a href="<?= base_url('pengumuman/' . $item['slug']) ?>" class="inline-flex items-center gap-2 text-[#00A859] font-bold hover:text-[#0B4A2D] transition-colors mt-auto">
                                Baca Selengkapnya <i class="fa-solid fa-arrow-right-long transition-transform group-hover:translate-x-2"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm max-w-2xl mx-auto">
                <i class="fa-regular fa-folder-open text-6xl text-gray-300 mb-4 block"></i>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Pengumuman</h3>
                <p class="text-gray-500">Saat ini belum ada informasi pengumuman <?= $kategori_aktif ? 'untuk kategori ' . $kategori_aktif : '' ?>.</p>
            </div>
        <?php endif; ?>

    </div>
</section>

<?= $this->endSection() ?>
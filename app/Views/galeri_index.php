<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="pt-32 pb-12 bg-green-800 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Galeri Kegiatan</h1>
        <p class="text-lg text-green-100 max-w-2xl mx-auto">Dokumentasi momen-momen terbaik dan kegiatan seru di madrasah kami.</p>
    </div>
</section>

<section class="py-16 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <?php if (!empty($galeri)) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($galeri as $item) : ?>
                    <a href="<?= base_url('galeri/' . $item['slug']) ?>" class="relative block h-72 md:h-80 rounded-2xl overflow-hidden group shadow-sm hover:shadow-2xl transition-all duration-300">

                        <?php if (!empty($item['sampul'])) : ?>
                            <img src="<?= base_url('uploads/galeri/' . $item['sampul']) ?>" alt="<?= esc($item['judul']) ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <?php else : ?>
                            <div class="absolute inset-0 w-full h-full flex items-center justify-center bg-gray-200">
                                <i class="fa-solid fa-camera text-5xl text-gray-400"></i>
                            </div>
                        <?php endif; ?>

                        <div class="absolute inset-0 bg-linear-to-t from-black/70 via-black/10 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <div class="absolute bottom-4 left-4 right-4 bg-white/80 backdrop-blur-md border border-white/50 p-4 rounded-xl transform transition-transform duration-300 group-hover:-translate-y-2 shadow-lg">

                            <h3 class="font-bold text-gray-900 text-lg mb-1 line-clamp-2 group-hover:text-green-700 transition-colors leading-snug">
                                <?= esc($item['judul']) ?>
                            </h3>

                            <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-300/50">
                                <div class="text-xs font-bold text-gray-600 flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar-days text-green-600"></i>
                                    <?= date('d M Y', strtotime($item['tanggal'])) ?>
                                </div>
                                <div class="bg-white/60 px-2.5 py-1 rounded-lg text-xs font-bold text-gray-800 flex items-center gap-1.5 border border-white/60 shadow-sm">
                                    <i class="fa-regular fa-images text-green-700"></i>
                                    <?= $item['jumlah_foto'] ?? 0 ?> Foto
                                </div>
                            </div>

                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm max-w-2xl mx-auto">
                <i class="fa-regular fa-folder-open text-6xl text-gray-300 mb-4 block"></i>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Album</h3>
                <p class="text-gray-500">Saat ini belum ada dokumentasi kegiatan yang diunggah.</p>
            </div>
        <?php endif; ?>

    </div>
</section>

<?= $this->endSection() ?>
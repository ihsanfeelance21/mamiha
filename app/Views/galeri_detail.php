<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
<style>
    .fancybox__container {
        z-index: 99999 !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-green-800 pt-24 pb-16 md:pt-32 md:pb-24 text-white relative">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative -mt-8 md:-mt-16 mb-12 md:mb-20 z-10">

    <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl border border-gray-100 p-5 sm:p-8 md:p-10 mb-8">

        <a href="<?= base_url('/galeri') ?>" class="inline-flex items-center gap-2 text-gray-500 hover:text-green-600 font-semibold transition-colors mb-4 md:mb-6 bg-gray-50 px-3 md:px-4 py-2 rounded-xl text-sm md:text-base w-fit">
            <i class="fa-solid fa-arrow-left"></i> Kembali <span class="hidden sm:inline">ke Galeri</span>
        </a>

        <div class="flex flex-col md:flex-row gap-5 md:gap-8 items-start">

            <?php if (!empty($galeri['sampul'])) : ?>
                <div class="w-full md:w-1/3 shrink-0 rounded-xl md:rounded-2xl overflow-hidden border-4 border-gray-50 shadow-sm aspect-video md:aspect-auto">
                    <img src="<?= base_url('uploads/galeri/' . $galeri['sampul']) ?>" alt="Cover" class="w-full h-full md:h-auto object-cover">
                </div>
            <?php endif; ?>

            <div class="grow w-full">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-green-50 text-green-600 rounded-lg text-xs md:text-sm font-bold border border-green-100 mb-3 uppercase tracking-wide">
                    <i class="fa-solid fa-folder"></i> Album Kegiatan
                </div>

                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-800 leading-tight mb-3 md:mb-4">
                    <?= esc($galeri['judul']) ?>
                </h1>

                <p class="text-gray-600 text-sm sm:text-base md:text-lg mb-4 md:mb-6 leading-relaxed">
                    <?= !empty($galeri['deskripsi']) ? esc($galeri['deskripsi']) : 'Tidak ada deskripsi' ?>
                </p>

                <div class="flex flex-wrap items-center gap-4 md:gap-6 text-xs md:text-sm font-bold text-gray-500 bg-gray-50/80 p-3 md:p-0 md:bg-transparent rounded-xl md:rounded-none border border-gray-100 md:border-none w-fit md:w-auto">
                    <span class="flex items-center gap-2"><i class="fa-regular fa-calendar-check text-green-600"></i> <?= date('d M Y', strtotime($galeri['tanggal'])) ?></span>
                    <span class="flex items-center gap-2"><i class="fa-regular fa-image text-blue-500"></i> <?= count($fotos) ?> Foto</span>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-4 md:mb-6 flex items-center gap-2">
            <i class="fa-solid fa-images text-green-600"></i> Jelajahi Foto
        </h3>

        <?php if (!empty($fotos)) : ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6">
                <?php foreach ($fotos as $foto) : ?>
                    <a href="<?= base_url('uploads/galeri/fotos/' . $foto['nama_file']) ?>" data-fancybox="gallery" data-caption="<?= esc($galeri['judul']) ?>" class="block relative group rounded-xl md:rounded-2xl overflow-hidden shadow-sm bg-gray-100 aspect-square">
                        <img src="<?= base_url('uploads/galeri/fotos/' . $foto['nama_file']) ?>" alt="Foto Kegiatan" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                            <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/20 flex items-center justify-center text-white border border-white/50">
                                <i class="fa-solid fa-magnifying-glass-plus text-lg md:text-xl"></i>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="bg-gray-50 rounded-2xl p-8 md:p-10 text-center border border-dashed border-gray-300">
                <i class="fa-regular fa-image text-4xl md:text-5xl text-gray-300 mb-3 block"></i>
                <p class="text-gray-500 text-sm md:text-base font-medium">Belum ada foto yang diunggah ke dalam album ini.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Fancybox.bind('[data-fancybox="gallery"]', {
            Images: {
                zoom: false,
            },
            Toolbar: {
                display: {
                    left: ["infobar"],
                    middle: [
                        "zoomIn",
                        "zoomOut",
                        "toggle1to1",
                        "rotateCCW",
                        "rotateCW",
                        "flipX",
                        "flipY",
                    ],
                    right: ["slideshow", "download", "thumbs", "close"],
                },
            },
            Thumbs: {
                type: "classic"
            }
        });
    });
</script>
<?= $this->endSection() ?>
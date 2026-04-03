<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="relative bg-[#0B4A2D] py-16 md:py-24 overflow-hidden border-b-8 border-[#00A859]">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 2px, transparent 2px); background-size: 30px 30px;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 drop-shadow-md">Profil Madrasah</h1>

        <nav class="flex justify-center text-green-100 text-sm font-medium">
            <ol class="inline-flex items-center space-x-2">
                <li><a href="<?= base_url() ?>" class="hover:text-white transition"><i class="fa-solid fa-house mr-1"></i> Beranda</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-1 opacity-70"></i></li>
                <li class="text-white opacity-80">Profil</li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-1 opacity-70"></i></li>
                <li class="text-white font-bold">Madrasah</li>
            </ol>
        </nav>
    </div>
</section>
<!-- Sambutan Kepala -->
<section class="py-20 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <?php if (!empty($pimpinan)): ?>
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-20 items-start justify-between">

                <div class="relative w-full mx-auto lg:mx-0 shrink-0" style="max-width: 300px;">
                    <div class="absolute -top-10 -left-10 w-48 h-48 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 z-0"></div>
                    <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 z-0"></div>

                    <div class="relative z-10 rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-gray-200">
                        <?php $fotoPimpinan = !empty($pimpinan['foto']) ? base_url('uploads/guru/' . $pimpinan['foto']) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600'; ?>
                        <img
                            src="<?= $fotoPimpinan ?>"
                            alt="<?= esc($pimpinan['nama']) ?>"
                            class="w-full object-cover hover:scale-105 transition-transform duration-700 ease-out"
                            style="aspect-ratio: 3/4;" />
                    </div>
                </div>

                <div class="w-full lg:w-7/12 relative z-20">

                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 rounded-full mb-4">
                        <span class="w-2 h-2 rounded-full bg-[#00A859] animate-pulse"></span>
                        <span class="text-xs font-bold text-[#00A859] tracking-widest uppercase">Sambutan <?= esc($pimpinan['jabatan']) ?></span>
                    </div>

                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-gray-900 leading-snug mb-5">
                        Mencetak Generasi Unggul Berwawasan <span class="text-[#00A859]">Global</span>
                    </h2>

                    <p class="text-gray-600 text-base md:text-lg leading-relaxed mb-5 italic border-l-4 border-[#00A859] pl-4">
                        "<?= esc($pimpinan['sambutan'] ?? 'Pendidikan bukan sekadar mengisi pikiran, tetapi menyalakan api keingintahuan dan membentuk akhlak yang mulia.') ?>"
                    </p>

                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between border-t border-gray-200 pt-6 mt-2 gap-4">
                        <div>
                            <h4 class="text-lg md:text-2xl font-bold text-gray-800">
                                <?= esc($pimpinan['nama']) ?>
                            </h4>
                            <p class="text-[#00A859] font-medium text-xl"><?= esc($pimpinan['jabatan']) ?></p>
                        </div>
                    </div>

                </div>

            </div>
        <?php else: ?>
            <p class="text-center text-gray-400">Data pimpinan belum ditambahkan.</p>
        <?php endif; ?>

    </div>
</section>
<!-- Kilas Balik -->
<section class="py-16 md:py-24 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">

            <div class="w-full lg:w-7/12 order-2 lg:order-1">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 border border-green-100 rounded-full mb-4">
                    <i class="fa-solid fa-clock-rotate-left text-[#00A859]"></i>
                    <span class="text-xs font-bold text-[#0B4A2D] tracking-widest uppercase">Kilas Balik</span>
                </div>

                <h2 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] mb-6 leading-tight">
                    Sejarah Singkat Madrasah
                </h2>

                <div class="prose prose-base md:prose-lg text-gray-600">
                    <p><?= nl2br(esc($profil['kilas_balik_deskripsi'])) ?></p>
                </div>
            </div>

            <div class="w-full lg:w-5/12 relative order-1 lg:order-2">
                <div class="absolute -inset-4 bg-green-50 rounded-3xl transform rotate-3 -z-10"></div>
                <div class="absolute -inset-4 bg-[#0B4A2D] rounded-3xl transform -rotate-2 -z-20 opacity-10"></div>

                <img src="<?= base_url('uploads/profil/' . $profil['kilas_balik_foto']) ?>" alt="Kilas Balik" class="w-full h-80 md:h-88 object-cover rounded-2xl shadow-lg border-4 border-white">

                <div class="absolute -bottom-6 -left-6 bg-green-100 text-[#0B4A2D] p-5 rounded-full shadow-xl border-4 border-white flex flex-col items-center justify-center w-28 h-28 transform hover:scale-105 transition-transform">
                    <span class="text-xs font-bold uppercase tracking-wider mb-1">Sejak</span>
                    <span class="text-2xl font-extrabold">2020</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Visi & misi -->
<section class="py-16 md:py-24 bg-gray-50 border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] mb-4">Visi & Misi</h2>
            <div class="w-20 h-1.5 bg-[#00A859] mx-auto rounded-full mb-4"></div>
            <p class="text-gray-500 text-sm md:text-base">Arah dan tujuan utama yang menjadi komitmen kami dalam menyelenggarakan pendidikan yang berkualitas.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10">
            <div class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-gray-100 hover:shadow-xl transition-shadow relative overflow-hidden group">
                <i class="fa-solid fa-eye absolute -top-4 -right-4 text-9xl text-green-50 opacity-50 group-hover:scale-110 transition-transform duration-500"></i>
                <div class="w-14 h-14 bg-green-100 text-[#00A859] rounded-2xl flex items-center justify-center text-2xl mb-6 relative z-10 shadow-inner">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>
                <h3 class="text-2xl font-bold text-[#0B4A2D] mb-4 relative z-10">Visi Madrasah</h3>
                <p class="text-lg md:text-xl text-gray-600 font-medium leading-relaxed relative z-10 italic">
                    "<?= nl2br(esc($profil['visi'])) ?>"
                </p>
            </div>

            <div class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-gray-100 hover:shadow-xl transition-shadow relative overflow-hidden group">
                <i class="fa-solid fa-bullseye absolute -top-4 -right-4 text-9xl text-yellow-50 opacity-50 group-hover:scale-110 transition-transform duration-500"></i>
                <div class="w-14 h-14 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center text-2xl mb-6 relative z-10 shadow-inner">
                    <i class="fa-solid fa-rocket"></i>
                </div>
                <h3 class="text-2xl font-bold text-[#0B4A2D] mb-5 relative z-10">Misi Madrasah</h3>
                <ul class="space-y-3 relative z-10 text-sm md:text-base">
                    <?php
                    // Memecah teks Misi berdasarkan baris baru (enter)
                    $listMisi = explode("\n", $profil['misi']);
                    foreach ($listMisi as $misiItem) :
                        $misiItem = trim($misiItem);
                        // Hanya tampilkan jika barisnya tidak kosong
                        if (!empty($misiItem)) :
                    ?>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-[#00A859] mt-1 text-base shrink-0"></i>
                                <span class="text-gray-600"><?= esc($misiItem) ?></span>
                            </li>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<section class="py-16 md:py-24 bg-white" x-data="lightbox()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">

        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] mb-4">Fasilitas Madrasah</h2>
            <div class="w-20 h-1.5 bg-[#00A859] mx-auto rounded-full mb-4"></div>
            <p class="text-gray-500 text-sm md:text-base">Sarana dan prasarana pendukung yang memadai untuk menciptakan lingkungan belajar yang optimal dan menyenangkan.</p>
        </div>

        <div class="hidden md:flex absolute top-1/2 -left-4 z-10 -translate-y-1/2 w-12 h-12 bg-white text-[#0B4A2D] rounded-full shadow-lg items-center justify-center cursor-pointer hover:bg-[#00A859] hover:text-white transition-colors swiper-button-prev-fasilitas">
            <i class="fa-solid fa-chevron-left"></i>
        </div>
        <div class="hidden md:flex absolute top-1/2 -right-4 z-10 -translate-y-1/2 w-12 h-12 bg-white text-[#0B4A2D] rounded-full shadow-lg items-center justify-center cursor-pointer hover:bg-[#00A859] hover:text-white transition-colors swiper-button-next-fasilitas">
            <i class="fa-solid fa-chevron-right"></i>
        </div>

        <div class="swiper fasilitasSwiper pb-12!">
            <div class="swiper-wrapper">

                <?php foreach ($fasilitas as $f) : ?>
                    <?php
                    // Siapkan array foto untuk dikirim ke Javascript
                    $fotoGaleri = [];
                    if (!empty($f['galeri'])) {
                        foreach ($f['galeri'] as $g) {
                            $fotoGaleri[] = base_url('uploads/fasilitas/galeri/' . $g['foto']);
                        }
                    } else {
                        // Jika galeri kosong, pakai foto cover saja
                        $cover = $f['foto_cover'] ? base_url('uploads/fasilitas/' . $f['foto_cover']) : 'https://placehold.co/800x600?text=No+Image';
                        $fotoGaleri[] = $cover;
                    }
                    ?>

                    <div class="swiper-slide h-auto">

                        <div class="relative overflow-hidden rounded-2xl group min-h-64 md:min-h-80 shadow-md hover:shadow-xl transition-all duration-300 cursor-pointer">

                            <img src="<?= $fotoGaleri[0] ?>" alt="<?= esc($f['judul']) ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                            <div class="absolute inset-0 bg-linear-to-t from-[#0B4A2D]/95 via-[#0B4A2D]/60 to-transparent opacity-90 transition-opacity group-hover:opacity-100"></div>

                            <div class="absolute inset-0 z-10 p-6 flex flex-col justify-end pointer-events-none">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 shrink-0 bg-white/20 backdrop-blur-sm border border-white/30 text-white rounded-xl flex items-center justify-center text-xl group-hover:bg-[#00A859] group-hover:border-[#00A859] transition-colors duration-300">
                                        <i class="<?= esc($f['icon']) ?>"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-white mb-1"><?= esc($f['judul']) ?></h4>
                                        <p class="text-sm text-gray-200 leading-snug line-clamp-2"><?= esc($f['deskripsi']) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div @click="bukaLightbox(<?= htmlspecialchars(json_encode($fotoGaleri)) ?>)" class="absolute inset-0 z-20"></div>

                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <div class="swiper-pagination"></div>
        </div>
    </div>

    <div x-show="isOpen"
        style="display: none;"
        class="fixed inset-0 z-100 bg-black/95 backdrop-blur-sm flex items-center justify-center"
        @keydown.escape.window="tutupLightbox()"
        @keydown.right.window="nextFoto()"
        @keydown.left.window="prevFoto()">

        <button @click="tutupLightbox()" class="absolute top-4 right-4 md:top-6 md:right-6 text-white/70 hover:text-white transition-colors p-2 z-50">
            <i class="fa-solid fa-xmark text-4xl"></i>
        </button>

        <button x-show="kumpulanFoto.length > 1" @click.stop="prevFoto()" class="absolute left-2 md:left-8 text-white/50 hover:text-white transition-colors p-4 z-50">
            <i class="fa-solid fa-chevron-left text-3xl md:text-5xl"></i>
        </button>

        <div class="relative max-w-5xl max-h-screen p-4 flex flex-col items-center justify-center" @click.outside="tutupLightbox()">
            <img :src="kumpulanFoto[indexAktif]" class="max-h-[80vh] max-w-full object-contain rounded-lg shadow-2xl transition-all duration-300">

            <div x-show="kumpulanFoto.length > 1" class="text-white/70 mt-4 font-medium text-sm bg-black/50 px-4 py-1 rounded-full">
                <span x-text="indexAktif + 1"></span> / <span x-text="kumpulanFoto.length"></span>
            </div>
        </div>

        <button x-show="kumpulanFoto.length > 1" @click.stop="nextFoto()" class="absolute right-2 md:right-8 text-white/50 hover:text-white transition-colors p-4 z-50">
            <i class="fa-solid fa-chevron-right text-3xl md:text-5xl"></i>
        </button>
    </div>

</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var swiper = new Swiper(".fasilitasSwiper", {
            slidesPerView: 1, // Tampil 1 kartu di HP
            spaceBetween: 24, // Jarak antar kartu (sama seperti gap-6)
            loop: true, // Biar slidernya muter terus tidak ada ujungnya
            autoplay: {
                delay: 3500, // Otomatis geser tiap 3.5 detik
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next-fasilitas",
                prevEl: ".swiper-button-prev-fasilitas",
            },
            breakpoints: {
                // Konfigurasi Layar Tablet (md)
                768: {
                    slidesPerView: 2,
                },
                // Konfigurasi Layar Laptop (lg)
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    });
</script>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('lightbox', () => ({
            // ... (Kode Alpine.js lightbox Mas sama seperti sebelumnya, tidak diubah) ...
            isOpen: false,
            kumpulanFoto: [],
            indexAktif: 0,

            bukaLightbox(arrayFoto) {
                this.kumpulanFoto = arrayFoto;
                this.indexAktif = 0;
                this.isOpen = true;
                document.body.style.overflow = 'hidden';
            },

            tutupLightbox() {
                this.isOpen = false;
                document.body.style.overflow = 'auto';
            },

            nextFoto() {
                if (this.kumpulanFoto.length > 1) {
                    this.indexAktif = (this.indexAktif + 1) % this.kumpulanFoto.length;
                }
            },

            prevFoto() {
                if (this.kumpulanFoto.length > 1) {
                    this.indexAktif = (this.indexAktif - 1 + this.kumpulanFoto.length) % this.kumpulanFoto.length;
                }
            }
        }))
    })
</script>

<!-- Tentang kami -->
<section class="py-20 md:py-28 bg-gray-50 overflow-hidden border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-20 items-center">

            <div class="w-full lg:w-1/2 relative z-10 group">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-green-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-yellow-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>

                <?php
                $videoUrl = $profil['tentang_kami_video'];
                if (strpos($videoUrl, 'watch?v=') !== false) {
                    $videoUrl = str_replace('watch?v=', 'embed/', $videoUrl);
                    $videoUrl = explode('&', $videoUrl)[0];
                } elseif (strpos($videoUrl, 'youtu.be/') !== false) {
                    $videoUrl = str_replace('youtu.be/', 'youtube.com/embed/', $videoUrl);
                    $videoUrl = explode('?', $videoUrl)[0];
                }
                ?>

                <div class="relative w-full aspect-video rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-gray-800 z-20 transition-transform duration-500 group-hover:scale-[1.02]">
                    <iframe
                        src="<?= esc($videoUrl) ?>"
                        title="<?= esc($profil['tentang_kami_judul']) ?>"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        class="absolute inset-0 w-full h-full">
                    </iframe>
                </div>
            </div>

            <div class="w-full lg:w-1/2 relative z-20">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 rounded-full mb-6">
                    <span class="w-2 h-2 rounded-full bg-[#00A859] animate-pulse"></span>
                    <span class="text-xs font-bold text-[#00A859] tracking-widest uppercase">Tentang Kami</span>
                </div>

                <h2 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] leading-tight mb-6">
                    <?= esc($profil['tentang_kami_judul']) ?>
                </h2>

                <p class="text-gray-600 text-base md:text-lg leading-relaxed mb-6">
                    <?= nl2br(esc($profil['tentang_kami_deskripsi'])) ?>
                </p>

                <div class="flex gap-4 border-t border-gray-200 pt-8 mt-4">
                    <a href="<?= base_url('kegiatan') ?>" class="group inline-flex items-center justify-center px-6 py-3.5 border border-transparent text-sm md:text-base font-bold rounded-xl text-white bg-[#0B4A2D] hover:bg-[#00A859] transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1">
                        Lihat Galeri & Kegiatan
                        <i class="fa-solid fa-camera ml-2 group-hover:scale-110 transition-transform"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<?= $this->endSection() ?>
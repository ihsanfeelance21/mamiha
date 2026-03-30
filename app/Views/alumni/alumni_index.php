<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<div class="bg-gray-50 min-h-screen overflow-hidden pb-12">

    <div class="container mx-auto px-4 max-w-6xl pt-10 pb-8">
        <div class="text-center md:text-left">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800">Jejak Alumni</h1>
            <p class="text-gray-600 mt-2 text-lg">Temukan dan hubungi alumni kita di berbagai perguruan tinggi.</p>
        </div>
    </div>

    <?php if (!empty($featured_alumni)): ?>
        <div class="bg-linear-to-b from-green-700 to-green-900 w-full py-16 shadow-inner relative z-10">

            <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10 pointer-events-none">
                <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white blur-3xl"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-white blur-3xl"></div>
            </div>

            <div class="container mx-auto px-4 max-w-6xl relative z-20">
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-wide uppercase">Our Journey</h2>
                    <div class="w-20 h-1.5 bg-green-400 mx-auto mt-4 rounded-full"></div>
                </div>

                <div class="swiper alumni-slider pb-20 pt-2">
                    <div class="swiper-wrapper">
                        <?php foreach ($featured_alumni as $fa): ?>
                            <div class="swiper-slide w-full md:max-w-187.5 h-auto">
                                <div class="bg-white rounded-2xl md:rounded-3xl shadow-2xl border border-gray-100 p-5 sm:p-6 md:p-8 flex flex-col md:flex-row gap-5 md:gap-8 items-stretch h-full transition-all duration-300">

                                    <div class="w-full md:w-2/5 shrink-0 rounded-xl overflow-hidden border-4 border-gray-50 shadow-sm aspect-3/4 relative bg-gray-100">
                                        <?php if ($fa['foto']) : ?>
                                            <img src="<?= base_url('uploads/alumni/' . $fa['foto']); ?>" alt="Foto <?= esc($fa['nama_alumni']); ?>" class="absolute inset-0 w-full h-full object-cover">
                                        <?php else : ?>
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <span class="text-6xl font-bold text-gray-300"><?= strtoupper(substr($fa['nama_alumni'], 0, 1)); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="grow w-full md:w-3/5 text-left flex flex-col h-full py-1">

                                        <div class="mb-3">
                                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-50 text-green-700 rounded-lg text-xs md:text-sm font-bold border border-green-200 uppercase tracking-wide">
                                                <i class="fa-solid fa-graduation-cap"></i> Lulusan <?= esc($fa['tahun_lulus']); ?>
                                            </span>
                                        </div>

                                        <h3 class="text-2xl md:text-3xl font-extrabold text-gray-800 leading-tight mb-2 md:mb-3">
                                            <?= esc($fa['nama_alumni']); ?>
                                        </h3>

                                        <div class="space-y-3 mt-2">
                                            <div class="flex items-start gap-3">
                                                <div class="mt-1 text-gray-400"><i class="fa-solid fa-building-columns"></i></div>
                                                <div>
                                                    <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Kampus</p>
                                                    <p class="text-gray-800 font-medium"><?= esc($fa['nama_universitas'] ?? $fa['usulan_universitas'] ?? '-'); ?></p>
                                                </div>
                                            </div>
                                            <div class="flex items-start gap-3">
                                                <div class="mt-1 text-gray-400"><i class="fa-solid fa-briefcase"></i></div>
                                                <div>
                                                    <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Jurusan / Pekerjaan</p>
                                                    <p class="text-gray-800 font-medium"><?= esc($fa['jurusan'] ?: '-'); ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if (!empty($fa['pesan_kesan'])) : ?>
                                            <div class="mt-auto pt-5 border-t border-gray-100 relative">
                                                <span class="text-4xl text-gray-200 absolute -top-4 left-0 font-serif leading-none opacity-50">"</span>
                                                <p class="text-gray-600 text-sm md:text-base italic relative z-10 pl-2 line-clamp-6">
                                                    <?= esc($fa['pesan_kesan']); ?>
                                                </p>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="container mx-auto px-4 max-w-6xl pt-16 relative z-20">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-l-4 border-green-500 pl-3">Jelajahi Berdasarkan Kampus</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
            <?php foreach ($universitas as $u): ?>
                <a href="<?= base_url('alumni/kampus/' . $u['id_universitas']); ?>" class="bg-white rounded-xl shadow-sm hover:shadow-lg hover:border-green-300 transition-all duration-300 border border-gray-100 p-4 flex flex-col items-center text-center group transform hover:-translate-y-1">
                    <div class="h-24 w-24 flex items-center justify-center mb-3">
                        <?php if ($u['logo']) : ?>
                            <img src="<?= base_url('uploads/universitas/' . $u['logo']); ?>" alt="<?= esc($u['nama_universitas']); ?>" class="max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-300">
                        <?php else : ?>
                            <div class="w-16 h-16 rounded bg-gray-200 flex items-center justify-center text-gray-500 text-2xl font-bold">🏫</div>
                        <?php endif; ?>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-sm md:text-base leading-tight group-hover:text-green-600">
                        <?= esc($u['nama_universitas']); ?>
                    </h3>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="container mx-auto px-4 max-w-4xl mt-24 mb-10">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-12 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-green-50 rounded-bl-full z-0"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-green-50 rounded-tr-full z-0"></div>

            <div class="relative z-10">
                <div class="text-5xl mb-4">🎓</div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 mb-3">Belum Terdaftar di Direktori?</h2>
                <p class="text-gray-600 mb-8 max-w-xl mx-auto text-lg">Mari bergabung dan bagikan jejak langkahmu untuk menginspirasi adik-adik tingkat di sekolah.</p>
                <a href="<?= base_url('alumni/daftar'); ?>" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 px-8 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 text-lg">
                    <i class="fa-solid fa-pen-to-square"></i> Isi Data Alumni Anda
                </a>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper('.alumni-slider', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            coverflowEffect: {
                rotate: 0,
                stretch: 80,
                depth: 250,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            slideToClickedSlide: true
        });
    });
</script>

<style>
    .swiper-slide {
        width: 100%;
        max-width: 750px;
        opacity: 0.4;
        transition: opacity 0.3s ease;
    }

    .swiper-slide-active {
        opacity: 1;
    }

    .alumni-slider .swiper-pagination {
        bottom: 0px !important;
    }

    .alumni-slider .swiper-pagination-bullet {
        background: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(4px);
        width: 10px;
        height: 10px;
        transition: all 0.3s ease;
    }

    .alumni-slider .swiper-pagination-bullet-active {
        background: rgba(255, 255, 255, 1);
        width: 28px;
        border-radius: 8px;
    }
</style>

<?= $this->endSection(); ?>
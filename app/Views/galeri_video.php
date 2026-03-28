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

<section class="pt-32 pb-12 bg-green-800 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Galeri Video</h1>
        <p class="text-lg text-green-100 max-w-2xl mx-auto">Kumpulan dokumentasi video kegiatan, prestasi, dan momen seru di madrasah kami.</p>
    </div>
</section>

<section class="py-16 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-center mb-12">
            <div class="inline-flex bg-white p-1.5 rounded-xl border border-gray-200 shadow-sm">
                <a href="<?= base_url('galeri') ?>" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-gray-500 hover:text-[#00A859] transition-colors">
                    <i class="fa-regular fa-image mr-1"></i> Album Foto
                </a>
                <span class="px-5 py-2.5 rounded-lg text-sm font-bold bg-green-50 text-green-700 shadow-sm pointer-events-none">
                    <i class="fa-solid fa-play mr-1"></i> Video
                </span>
            </div>
        </div>

        <?php
        // Fungsi bantuan untuk render card video agar tidak mengulang kode (DRY)
        if (!function_exists('renderVideoCard')) {
            function renderVideoCard($video, $isPortrait = false)
            {
                $link = strtolower($video['link_video']);
                $aspectClass = $isPortrait ? 'aspect-[9/16]' : 'aspect-video';

                // Deteksi Platform
                $platform = 'Link Eksternal';
                $icon = 'fa-link';
                $iconColor = 'text-gray-500';
                $bgColor = 'bg-gray-800';
                $bgGradient = '';

                if (strpos($link, 'youtube.com') !== false || strpos($link, 'youtu.be') !== false) {
                    $platform = 'YouTube';
                    $icon = 'fa-youtube';
                    $iconColor = 'text-red-500';
                    $bgGradient = 'from-red-900 to-gray-900';
                } elseif (strpos($link, 'tiktok.com') !== false) {
                    $platform = 'TikTok';
                    $icon = 'fa-tiktok';
                    $iconColor = 'text-black';
                    $bgGradient = 'from-gray-800 to-black';
                } elseif (strpos($link, 'instagram.com') !== false) {
                    $platform = 'Instagram';
                    $icon = 'fa-instagram';
                    $iconColor = 'text-pink-600';
                    $bgGradient = 'from-purple-900 via-pink-800 to-orange-900';
                } elseif (strpos($link, 'facebook.com') !== false || strpos($link, 'fb.watch') !== false) {
                    $platform = 'Facebook';
                    $icon = 'fa-facebook';
                    $iconColor = 'text-blue-600';
                    $bgGradient = 'from-blue-900 to-blue-950';
                } elseif (strpos($link, 'drive.google') !== false) {
                    $platform = 'Google Drive';
                    $icon = 'fa-google-drive';
                    $iconColor = 'text-blue-500';
                    $bgGradient = 'from-blue-800 to-gray-900';
                }

                // Coba ambil thumbnail khusus YouTube
                $ytThumb = '';
                if ($platform === 'YouTube') {
                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video['link_video'], $match);
                    if (isset($match[1])) $ytThumb = "https://img.youtube.com/vi/{$match[1]}/hqdefault.jpg";
                }

                ob_start();
        ?>
                <a href="<?= esc($video['link_video']) ?>" data-fancybox="video-gallery" data-caption="<?= esc($video['judul']) ?>" class="block bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 border-[6px] md:border-8 border-white overflow-hidden group relative">

                    <div class="relative <?= $aspectClass ?> overflow-hidden shrink-0 bg-linear-to-br <?= $bgGradient ?: 'bg-gray-800' ?>">
                        <?php if ($ytThumb) : ?>
                            <img src="<?= $ytThumb ?>" alt="Thumbnail" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-90 group-hover:opacity-100">
                        <?php else : ?>
                            <div class="w-full h-full flex items-center justify-center opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                                <i class="fa-brands <?= $icon ?> text-5xl md:text-6xl text-white/50"></i>
                            </div>
                        <?php endif; ?>

                        <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors duration-300"></div>

                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="w-14 h-14 md:w-16 md:h-16 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center <?= $iconColor ?> text-2xl md:text-3xl shadow-lg transform group-hover:scale-110 transition-transform duration-300 pl-1">
                                <i class="fa-solid fa-play"></i>
                            </div>
                        </div>
                    </div>

                </a>
        <?php
                return ob_get_clean();
            }
        }
        ?>

        <?php if (!empty($landscape)) : ?>
            <div class="mb-16">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2 border-b-2 border-gray-100 pb-3">
                    <i class="fa-solid fa-tv text-[#00A859]"></i> Galeri Video Youtube
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">
                    <?php foreach ($landscape as $vid) echo renderVideoCard($vid, false); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($portrait)) : ?>
            <div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2 border-b-2 border-gray-100 pb-3">
                    <i class="fa-solid fa-mobile-screen text-[#00A859]"></i> Galeri Video Shorts, Reels & Tiktok
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-5">
                    <?php foreach ($portrait as $vid) echo renderVideoCard($vid, true); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (empty($landscape) && empty($portrait)) : ?>
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm max-w-2xl mx-auto">
                <i class="fa-solid fa-photo-film text-6xl text-gray-300 mb-4 block"></i>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Video</h3>
                <p class="text-gray-500">Saat ini belum ada dokumentasi video yang ditambahkan.</p>
            </div>
        <?php endif; ?>

    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Fancybox.bind('[data-fancybox="video-gallery"]', {
            Html: {
                videoAutoplay: true
            }
        });
    });
</script>
<?= $this->endSection() ?>
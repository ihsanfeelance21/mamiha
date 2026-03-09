<?= $this->extend('layouts/main') ?>
<?php
$pengaturan = (new \App\Models\PengaturanModel())->first();
$ppdbModel = new \App\Models\PendaftaranModel();
$ppdb = $ppdbModel->first();
// --- LOGIKA STATUS TOMBOL PENDAFTARAN ---
$isBuka = ($ppdb && $ppdb['status_ppdb'] == 'buka');
$linkDaftar = '#';
$targetDaftar = '';
$onclickDaftar = '';

if ($isBuka) {
    // Jika BUKA: arahkan ke link
    $linkDaftar = ($ppdb['tipe_daftar'] == 'eksternal' && !empty($ppdb['link_daftar'])) ? $ppdb['link_daftar'] : base_url('daftar');
    $targetDaftar = ($ppdb['tipe_daftar'] == 'eksternal') ? 'target="_blank"' : '';
} else {
    // Jika TUTUP: cegah aksi klik (preventDefault) dan tampilkan pop-up
    $onclickDaftar = 'onclick="event.preventDefault(); document.getElementById(\'modalTutup\').classList.remove(\'hidden\'); document.getElementById(\'modalTutup\').classList.add(\'flex\');"';
}
?>
<?= $this->section('content') ?>
<!-- Hero Section -->
<section class="relative w-full h-[85vh] min-h-125 bg-gray-900 overflow-hidden">
    <div class="swiper heroSwiper w-full h-full">
        <div class="swiper-wrapper">

            <?php if (empty($sliders)): ?>
                <div class="swiper-slide relative w-full h-full">
                    <div class="absolute inset-0 bg-gray-900 flex items-center justify-center">
                        <p class="text-white text-xl">Belum ada slide. Silakan tambahkan dari panel Admin.</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($sliders as $slide): ?>
                    <div class="swiper-slide relative w-full h-full flex flex-col justify-center">

                        <?php $imgMobile = !empty($slide['gambar_mobile']) ? $slide['gambar_mobile'] : $slide['gambar']; ?>

                        <img src="<?= base_url('uploads/hero/' . $slide['gambar']) ?>" class="absolute inset-0 w-full h-full object-cover hidden md:block" alt="<?= esc($slide['judul'] ?? 'Hero Desktop') ?>">

                        <img src="<?= base_url('uploads/hero/' . $imgMobile) ?>" class="absolute inset-0 w-full h-full object-cover block md:hidden" alt="<?= esc($slide['judul'] ?? 'Hero Mobile') ?>">

                        <div class="absolute inset-0 bg-linear-to-r from-black/80 via-black/50 to-transparent"></div>

                        <div class="absolute inset-0 flex items-center max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="max-w-2xl text-left">

                                <?php if (!empty($slide['label'])): ?>
                                    <span class="inline-block py-1 px-4 rounded-full bg-[#00A859] text-white text-xs md:text-sm font-bold mb-5 tracking-widest uppercase shadow-lg">
                                        <?= esc($slide['label']) ?>
                                    </span>
                                <?php endif; ?>

                                <?php if (!empty($slide['judul'])): ?>
                                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6 drop-shadow-lg">
                                        <?= esc($slide['judul']) ?>
                                    </h2>
                                <?php endif; ?>

                                <?php if (!empty($slide['subjudul'])): ?>
                                    <p class="text-base md:text-lg lg:text-xl text-gray-200 mb-8 font-light leading-relaxed drop-shadow-md">
                                        <?= esc($slide['subjudul']) ?>
                                    </p>
                                <?php endif; ?>

                                <div class="flex flex-row flex-wrap gap-3 md:gap-4 mt-4">
                                    <?php if (!empty($slide['btn1_teks'])): ?>
                                        <a href="<?= esc($slide['btn1_url'] ?? '#') ?>" class="inline-flex items-center justify-center bg-[#00A859] hover:bg-green-600 text-white px-6 py-3 rounded-lg font-bold text-sm md:text-base shadow-lg hover:-translate-y-1 transition-all duration-300">
                                            <?= esc($slide['btn1_teks']) ?>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($slide['btn2_teks'])): ?>
                                        <a href="<?= esc($slide['btn2_url'] ?? '#') ?>" class="inline-flex items-center justify-center bg-transparent border-2 border-white text-white hover:bg-white hover:text-[#0B4A2D] px-6 py-3 rounded-lg font-bold text-sm md:text-base shadow-lg hover:-translate-y-1 transition-all duration-300">
                                            <?= esc($slide['btn2_teks']) ?>
                                        </a>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

        <div class="swiper-pagination bottom-8!"></div>
    </div>
</section>
<!-- STATISTIK/Mengapa memilih kami -->
<section class="relative z-20 bg-white pt-16 pb-20 md:pt-20 md:pb-24 -mt-7 md:-mt-7 rounded-t-4xl md:rounded-t-[3rrem] shadow-[0_-10px_40px_rgba(0,0,0,0.08)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8 mb-20">
            <div class="bg-white p-6 rounded-2xl text-center border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-14 h-14 md:w-16 md:h-16 mx-auto bg-green-50 text-[#00A859] rounded-full flex items-center justify-center text-2xl md:text-3xl mb-4 group-hover:bg-[#00A859] group-hover:text-white transition-colors duration-300">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <h3 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] mb-2 font-mono" data-target="1250" id="counter1">0</h3>
                <p class="text-sm md:text-base text-gray-500 font-semibold uppercase tracking-wider">Siswa Aktif</p>
            </div>

            <div class="bg-white p-6 rounded-2xl text-center border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-14 h-14 md:w-16 md:h-16 mx-auto bg-green-50 text-[#00A859] rounded-full flex items-center justify-center text-2xl md:text-3xl mb-4 group-hover:bg-[#00A859] group-hover:text-white transition-colors duration-300">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <h3 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] mb-2 font-mono" data-target="85" id="counter2">0</h3>
                <p class="text-sm md:text-base text-gray-500 font-semibold uppercase tracking-wider">Guru & Staf</p>
            </div>

            <div class="bg-white p-6 rounded-2xl text-center border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-14 h-14 md:w-16 md:h-16 mx-auto bg-green-50 text-[#00A859] rounded-full flex items-center justify-center text-2xl md:text-3xl mb-4 group-hover:bg-[#00A859] group-hover:text-white transition-colors duration-300">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <h3 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] mb-2 font-mono" data-target="32" id="counter3">0</h3>
                <p class="text-sm md:text-base text-gray-500 font-semibold uppercase tracking-wider">Fasilitas Kelas</p>
            </div>

            <div class="bg-white p-6 rounded-2xl text-center border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-14 h-14 md:w-16 md:h-16 mx-auto bg-green-50 text-[#00A859] rounded-full flex items-center justify-center text-2xl md:text-3xl mb-4 group-hover:bg-[#00A859] group-hover:text-white transition-colors duration-300">
                    <i class="fa-solid fa-award"></i>
                </div>
                <h3 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] mb-2 font-mono" data-target="150" id="counter4">0</h3>
                <p class="text-sm md:text-base text-gray-500 font-semibold uppercase tracking-wider">Penghargaan</p>
            </div>
        </div>

        <div class="text-center max-w-3xl mx-auto mb-12 md:mb-16">
            <h2 class="text-sm font-bold text-[#00A859] tracking-widest uppercase mb-2">Mengapa Memilih Kami?</h2>
            <h3 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] leading-tight mb-4">Membangun Generasi Cerdas & Berakhlak Mulia</h3>
            <p class="text-gray-600 md:text-lg leading-relaxed">Kami berkomitmen memberikan pendidikan terbaik yang memadukan ilmu pengetahuan modern dengan nilai-nilai agama yang kuat.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-gray-50 rounded-2xl p-8 hover:bg-[#0B4A2D] hover:text-white transition-colors duration-500 group">
                <div class="w-16 h-16 bg-[#00A859] text-white rounded-xl flex items-center justify-center text-3xl mb-6 shadow-lg -rotate-3 group-hover:rotate-0 transition-transform duration-300">
                    <i class="fa-solid fa-book-quran"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 group-hover:text-white mb-3">Kurikulum Terpadu</h4>
                <p class="text-gray-600 group-hover:text-gray-300 leading-relaxed">Memadukan kurikulum nasional dan pendidikan agama islam secara komprehensif untuk mencetak generasi unggul.</p>
            </div>

            <div class="bg-gray-50 rounded-2xl p-8 hover:bg-[#0B4A2D] hover:text-white transition-colors duration-500 group">
                <div class="w-16 h-16 bg-[#00A859] text-white rounded-xl flex items-center justify-center text-3xl mb-6 shadow-lg -rotate-3 group-hover:rotate-0 transition-transform duration-300">
                    <i class="fa-solid fa-laptop-code"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 group-hover:text-white mb-3">Fasilitas Modern</h4>
                <p class="text-gray-600 group-hover:text-gray-300 leading-relaxed">Didukung dengan laboratorium komputer, perpustakaan digital, dan ruang kelas yang nyaman dan berbasis teknologi.</p>
            </div>

            <div class="bg-gray-50 rounded-2xl p-8 hover:bg-[#0B4A2D] hover:text-white transition-colors duration-500 group">
                <div class="w-16 h-16 bg-[#00A859] text-white rounded-xl flex items-center justify-center text-3xl mb-6 shadow-lg -rotate-3 group-hover:rotate-0 transition-transform duration-300">
                    <i class="fa-solid fa-medal"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 group-hover:text-white mb-3">Akreditasi A</h4>
                <p class="text-gray-600 group-hover:text-gray-300 leading-relaxed">Sekolah kami telah meraih akreditasi A (Sangat Baik), menjamin mutu pendidikan dan pelayanan yang maksimal.</p>
            </div>
        </div>

    </div>
</section>
<!-- Tentang Kami -->
<section class="py-20 md:py-28 bg-gray-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-20 items-center">

            <div class="w-full lg:w-1/2 relative z-10 group">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-green-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-yellow-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>

                <div class="relative w-full aspect-video rounded-4xl overflow-hidden shadow-2xl border-4 border-white bg-gray-800 z-20 transition-transform duration-500 group-hover:scale-[1.02]">
                    <iframe class="absolute top-0 left-0 w-full h-full"
                        src="https://www.youtube.com/embed/aqz-KE-bpKQ?si=placeholder"
                        title="Video Profil Sekolah"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>

            <div class="w-full lg:w-1/2 relative z-20">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 rounded-full mb-6">
                    <span class="w-2 h-2 rounded-full bg-[#00A859] animate-pulse"></span>
                    <span class="text-sm font-bold text-[#00A859] tracking-widest uppercase">Tentang Kami</span>
                </div>

                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-[#0B4A2D] leading-tight mb-6">
                    Menjelajahi Lingkungan Belajar yang <span class="text-[#00A859]">Inspiratif</span>
                </h2>

                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    Kami tidak hanya mengajarkan ilmu pengetahuan, tetapi juga menanamkan nilai-nilai karakter yang kuat. Melalui fasilitas yang memadai dan tenaga pendidik yang berdedikasi, kami siap mendampingi setiap langkah siswa menuju kesuksesan.
                </p>

                <ul class="space-y-4 mb-8">
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 text-[#00A859] flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fa-solid fa-check text-sm"></i>
                        </div>
                        <span class="text-gray-700 font-medium">Lingkungan Belajar Nyaman & Kondusif</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 text-[#00A859] flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fa-solid fa-check text-sm"></i>
                        </div>
                        <span class="text-gray-700 font-medium">Kurikulum Adaptif & Berbasis Teknologi</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 text-[#00A859] flex items-center justify-center shrink-0 shadow-sm">
                            <i class="fa-solid fa-check text-sm"></i>
                        </div>
                        <span class="text-gray-700 font-medium">Pembinaan Karakter & Kepemimpinan</span>
                    </li>
                </ul>

                <div class="border-t border-gray-200 pt-8 mt-8">
                    <a href="/profil" class="group inline-flex items-center justify-center px-6 py-3.5 border border-transparent text-base font-bold rounded-xl text-white bg-[#0B4A2D] hover:bg-[#00A859] transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1">
                        Lihat Profil Selengkapnya
                        <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Program unggulan -->
<section class="py-20 md:py-28 bg-white relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-30 pointer-events-none">
        <div class="absolute -top-24 -right-24 w-96 h-96 border-40 border-green-50 rounded-full"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 border-30 border-green-50 rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16 md:mb-20">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 rounded-full mb-4">
                <span class="w-2 h-2 rounded-full bg-[#00A859] animate-pulse"></span>
                <span class="text-sm font-bold text-[#00A859] tracking-widest uppercase">Program Pilihan</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] leading-tight mb-4">
                Program Unggulan Sekolah
            </h2>
            <p class="text-gray-600 md:text-lg">
                Berbagai program yang dirancang khusus untuk memaksimalkan potensi, bakat, dan karakter setiap siswa.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">

            <div class="group bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-2xl hover:border-[#00A859] hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-[#00A859] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>

                <div class="w-16 h-16 bg-green-50 text-[#00A859] rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-[#00A859] group-hover:text-white transition-colors duration-300 shadow-sm">
                    <i class="fa-solid fa-book-open-reader"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-[#0B4A2D] transition-colors">Tahfidz Al-Qur'an</h3>
                <p class="text-gray-500 leading-relaxed text-sm">Program bimbingan menghafal Al-Qur'an dengan metode yang mudah, menyenangkan, dan bersanad.</p>
            </div>

            <div class="group bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-2xl hover:border-[#00A859] hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-[#00A859] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>

                <div class="w-16 h-16 bg-green-50 text-[#00A859] rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-[#00A859] group-hover:text-white transition-colors duration-300 shadow-sm">
                    <i class="fa-solid fa-earth-americas"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-[#0B4A2D] transition-colors">Bilingual Class</h3>
                <p class="text-gray-500 leading-relaxed text-sm">Pembiasaan komunikasi menggunakan Bahasa Inggris dan Arab dalam lingkungan sekolah sehari-hari.</p>
            </div>

            <div class="group bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-2xl hover:border-[#00A859] hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-[#00A859] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>

                <div class="w-16 h-16 bg-green-50 text-[#00A859] rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-[#00A859] group-hover:text-white transition-colors duration-300 shadow-sm">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-[#0B4A2D] transition-colors">Lulusan Berkualitas</h3>
                <p class="text-gray-500 leading-relaxed text-sm">Mencetak alumni yang berdaya saing global dan sukses menembus perguruan tinggi favorit, baik di dalam maupun luar negeri.</p>
            </div>

            <div class="group bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-2xl hover:border-[#00A859] hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-[#00A859] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>

                <div class="w-16 h-16 bg-green-50 text-[#00A859] rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:bg-[#00A859] group-hover:text-white transition-colors duration-300 shadow-sm">
                    <i class="fa-solid fa-trophy"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-[#0B4A2D] transition-colors">Program Berprestasi</h3>
                <p class="text-gray-500 leading-relaxed text-sm">Pembinaan intensif untuk mencetak siswa berprestasi di berbagai kompetisi akademik maupun non-akademik di semua tingkatan.</p>
            </div>

        </div>
    </div>
</section>

<!-- Berita -->
<section class="py-20 md:py-28 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-end mb-12 md:mb-16 gap-6">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-100 shadow-sm rounded-full mb-4">
                    <span class="w-2 h-2 rounded-full bg-[#00A859] animate-pulse"></span>
                    <span class="text-sm font-bold text-[#00A859] tracking-widest uppercase">Kabar Sekolah</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] leading-tight">
                    Berita & Informasi Terbaru
                </h2>
            </div>
            <a href="/berita" class="group inline-flex items-center gap-2 text-[#00A859] font-bold hover:text-[#0B4A2D] transition-colors duration-300">
                Lihat Semua Berita
                <span class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center group-hover:bg-[#0B4A2D] group-hover:text-white transition-colors duration-300">
                    <i class="fa-solid fa-arrow-right"></i>
                </span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <div class="group bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                <div class="relative h-60 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=800&auto=format&fit=crop" alt="Thumbnail" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-bold text-[#0B4A2D] shadow-sm">
                        Prestasi
                    </div>
                </div>
                <div class="p-6 md:p-8 flex flex-col grow">
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4 font-medium">
                        <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-[#00A859]"></i> 12 Okt 2025</span>
                        <span class="flex items-center gap-1.5"><i class="fa-regular fa-user text-[#00A859]"></i> Admin</span>
                    </div>
                    <a href="#" class="block mb-4">
                        <h3 class="text-xl font-bold text-gray-800 leading-snug group-hover:text-[#00A859] transition-colors line-clamp-2">
                            Tim Robotik Sekolah Berhasil Meraih Juara 1 Tingkat Nasional
                        </h3>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-3">
                        Prestasi membanggakan kembali diraih oleh tim ekstrakurikuler robotik dalam ajang kompetisi teknologi tahunan yang diselenggarakan di Jakarta...
                    </p>
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <a href="#" class="inline-flex items-center gap-2 text-sm font-bold text-[#0B4A2D] group-hover:text-[#00A859] transition-colors">
                            Baca Selengkapnya <i class="fa-solid fa-arrow-right-long group-hover:translate-x-2 transition-transform duration-300"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="group bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                <div class="relative h-60 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800&auto=format&fit=crop" alt="Thumbnail" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-bold text-[#0B4A2D] shadow-sm">
                        Akademik
                    </div>
                </div>
                <div class="p-6 md:p-8 flex flex-col grow">
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4 font-medium">
                        <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-[#00A859]"></i> 08 Okt 2025</span>
                        <span class="flex items-center gap-1.5"><i class="fa-regular fa-user text-[#00A859]"></i> Humas</span>
                    </div>
                    <a href="#" class="block mb-4">
                        <h3 class="text-xl font-bold text-gray-800 leading-snug group-hover:text-[#00A859] transition-colors line-clamp-2">
                            Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran Depan Telah Dibuka
                        </h3>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-3">
                        Kabar gembira bagi para orang tua dan calon siswa. Pendaftaran untuk tahun ajaran baru kini dapat dilakukan secara online melalui portal resmi...
                    </p>
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <a href="#" class="inline-flex items-center gap-2 text-sm font-bold text-[#0B4A2D] group-hover:text-[#00A859] transition-colors">
                            Baca Selengkapnya <i class="fa-solid fa-arrow-right-long group-hover:translate-x-2 transition-transform duration-300"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="group bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col lg:flex">
                <div class="relative h-60 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1544928147-79a2dbc1f389?q=80&w=800&auto=format&fit=crop" alt="Thumbnail" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-bold text-[#0B4A2D] shadow-sm">
                        Kegiatan
                    </div>
                </div>
                <div class="p-6 md:p-8 flex flex-col grow">
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4 font-medium">
                        <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-[#00A859]"></i> 01 Okt 2025</span>
                        <span class="flex items-center gap-1.5"><i class="fa-regular fa-user text-[#00A859]"></i> Admin</span>
                    </div>
                    <a href="#" class="block mb-4">
                        <h3 class="text-xl font-bold text-gray-800 leading-snug group-hover:text-[#00A859] transition-colors line-clamp-2">
                            Peringatan Hari Guru Nasional dengan Berbagai Penampilan Seni Siswa
                        </h3>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-3">
                        Seluruh elemen sekolah berkumpul di lapangan utama untuk memberikan apresiasi tertinggi kepada para pahlawan tanpa tanda jasa...
                    </p>
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <a href="#" class="inline-flex items-center gap-2 text-sm font-bold text-[#0B4A2D] group-hover:text-[#00A859] transition-colors">
                            Baca Selengkapnya <i class="fa-solid fa-arrow-right-long group-hover:translate-x-2 transition-transform duration-300"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Prestasi -->
<section class="py-20 md:py-28 bg-white relative overflow-hidden border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <div class="flex flex-col md:flex-row justify-between items-end mb-12 md:mb-16 gap-6">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 border border-green-100 shadow-sm rounded-full mb-4">
                    <span class="w-2 h-2 rounded-full bg-[#00A859] animate-pulse"></span>
                    <span class="text-sm font-bold text-[#00A859] tracking-widest uppercase">Generasi Juara</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] leading-tight">
                    Prestasi Membanggakan
                </h2>
            </div>
            <a href="/prestasi" class="group inline-flex items-center gap-2 text-[#00A859] font-bold hover:text-[#0B4A2D] transition-colors duration-300">
                Lihat Semua Prestasi
                <span class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center group-hover:bg-[#0B4A2D] group-hover:text-white transition-colors duration-300">
                    <i class="fa-solid fa-arrow-right"></i>
                </span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="group bg-green-600 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col relative" style="background-image: radial-gradient(#ffffff20 2px, transparent 2px); background-size: 30px 30px;">
                <div class="relative h-60 p-8 flex flex-col justify-start">
                    <div class="absolute top-4 left-4 bg-white/90 px-4 py-2 rounded-full text-xs font-bold text-green-800 shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-circle text-green-400 text-[8px]"></i>
                        JUARA 1 NASIONAL
                    </div>

                    <div class="flex justify-center md:justify-start items-center relative z-10 mt-12">
                        <img src="path/to/your/image.png" alt="Selamat & Sukses" class="h-24 object-contain drop-shadow-lg">
                    </div>

                </div>

                <div class="bg-white rounded-t-4xl p-8 pt-6 flex flex-col grow relative z-20 shadow-[-10px_-10px_20px_rgba(0,0,0,0.03)]">
                    <div class="mb-2">
                        <span class="text-gray-400 font-bold text-xs uppercase tracking-wider">Tingkat Nasional</span>
                    </div>
                    <h3 class="text-2xl font-extrabold text-[#0B4A2D] leading-snug group-hover:text-[#00A859] transition-colors mb-3">
                        Olimpiade Matematika
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-2">
                        Berhasil meraih medali emas pada ajang bergengsi Kompetisi Sains...
                    </p>
                    <div class="mt-auto pt-5 border-t border-gray-100 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center shadow-inner">
                                <i class="fa-solid fa-user text-sm"></i>
                            </div>
                            <span class="font-bold text-gray-800">Ahmad Fauzi</span>
                        </div>
                        <div class="bg-green-50 text-green-600 px-3 py-1 rounded-lg text-sm font-bold shadow-sm">
                            2024
                        </div>
                    </div>
                </div>
            </div>

            <div class="group bg-green-600 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col relative" style="background-image: radial-gradient(#ffffff20 2px, transparent 2px); background-size: 30px 30px;">
                <div class="relative h-60 p-8 flex flex-col justify-start">
                    <div class="absolute top-4 left-4 bg-white/90 px-4 py-2 rounded-full text-xs font-bold text-green-800 shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-circle text-green-400 text-[8px]"></i>
                        JUARA 1 NASIONAL
                    </div>

                    <div class="flex justify-center md:justify-start items-center relative z-10 mt-12">
                        <img src="path/to/your/image.png" alt="Selamat & Sukses" class="h-24 object-contain drop-shadow-lg">
                    </div>

                </div>

                <div class="bg-white rounded-t-4xl p-8 pt-6 flex flex-col grow relative z-20 shadow-[-10px_-10px_20px_rgba(0,0,0,0.03)]">
                    <div class="mb-2">
                        <span class="text-gray-400 font-bold text-xs uppercase tracking-wider">Tingkat Nasional</span>
                    </div>
                    <h3 class="text-2xl font-extrabold text-[#0B4A2D] leading-snug group-hover:text-[#00A859] transition-colors mb-3">
                        Olimpiade Matematika
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-2">
                        Berhasil meraih medali emas pada ajang bergengsi Kompetisi Sains...
                    </p>
                    <div class="mt-auto pt-5 border-t border-gray-100 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center shadow-inner">
                                <i class="fa-solid fa-user text-sm"></i>
                            </div>
                            <span class="font-bold text-gray-800">Ahmad Fauzi</span>
                        </div>
                        <div class="bg-green-50 text-green-600 px-3 py-1 rounded-lg text-sm font-bold shadow-sm">
                            2024
                        </div>
                    </div>
                </div>
            </div>

            <div class="group bg-green-600 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col relative" style="background-image: radial-gradient(#ffffff20 2px, transparent 2px); background-size: 30px 30px;">
                <div class="relative h-60 p-8 flex flex-col justify-start">
                    <div class="absolute top-4 left-4 bg-white/90 px-4 py-2 rounded-full text-xs font-bold text-green-800 shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-circle text-green-400 text-[8px]"></i>
                        JUARA 1 NASIONAL
                    </div>

                    <div class="flex justify-center md:justify-start items-center relative z-10 mt-12">
                        <img src="path/to/your/image.png" alt="Selamat & Sukses" class="h-24 object-contain drop-shadow-lg">
                    </div>

                </div>

                <div class="bg-white rounded-t-4xl p-8 pt-6 flex flex-col grow relative z-20 shadow-[-10px_-10px_20px_rgba(0,0,0,0.03)]">
                    <div class="mb-2">
                        <span class="text-gray-400 font-bold text-xs uppercase tracking-wider">Tingkat Nasional</span>
                    </div>
                    <h3 class="text-2xl font-extrabold text-[#0B4A2D] leading-snug group-hover:text-[#00A859] transition-colors mb-3">
                        Olimpiade Matematika
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-2">
                        Berhasil meraih medali emas pada ajang bergengsi Kompetisi Sains...
                    </p>
                    <div class="mt-auto pt-5 border-t border-gray-100 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center shadow-inner">
                                <i class="fa-solid fa-user text-sm"></i>
                            </div>
                            <span class="font-bold text-gray-800">Ahmad Fauzi</span>
                        </div>
                        <div class="bg-green-50 text-green-600 px-3 py-1 rounded-lg text-sm font-bold shadow-sm">
                            2024
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Testimoni -->
<section class="py-20 md:py-28 bg-[#0B4A2D] relative overflow-hidden">
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-white opacity-5 filter blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 rounded-full bg-[#00A859] opacity-30 filter blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full mb-4">
                <span class="w-2 h-2 rounded-full bg-[#00A859] animate-pulse"></span>
                <span class="text-sm font-bold text-white tracking-widest uppercase">Kata Mereka</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-white leading-tight mb-4">
                Cerita Sukses & Pengalaman
            </h2>
            <p class="text-green-100/80 md:text-lg leading-relaxed">
                Kebanggaan terbesar kami adalah melihat kesuksesan alumni dan senyum kepuasan orang tua yang telah mempercayakan pendidikan putra-putrinya di sini.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-3xl p-8 relative hover:-translate-y-2 transition-transform duration-300 group">
                <i class="fa-solid fa-quote-right absolute top-6 right-8 text-6xl text-white/5 group-hover:text-[#00A859]/20 transition-colors duration-300"></i>

                <div class="flex gap-1 text-yellow-400 text-sm mb-6">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>

                <p class="text-gray-200 leading-relaxed mb-8 relative z-10 italic">
                    "Sekolah ini tidak hanya membekali anak saya dengan ilmu akademik yang luar biasa, tapi juga adab dan akhlak yang sangat baik. Terima kasih kepada seluruh ustadz dan ustadzah."
                </p>

                <div class="flex items-center gap-4 mt-auto border-t border-white/10 pt-6">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=200&auto=format&fit=crop" alt="Avatar" class="w-14 h-14 rounded-full object-cover border-2 border-[#00A859]">
                    <div>
                        <h4 class="font-bold text-white text-lg">Ibu Siti Aminah</h4>
                        <p class="text-[#00A859] text-sm font-medium">Wali Murid Kelas XII</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-3xl p-8 relative hover:-translate-y-2 transition-transform duration-300 group">
                <i class="fa-solid fa-quote-right absolute top-6 right-8 text-6xl text-white/5 group-hover:text-[#00A859]/20 transition-colors duration-300"></i>

                <div class="flex gap-1 text-yellow-400 text-sm mb-6">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>

                <p class="text-gray-200 leading-relaxed mb-8 relative z-10 italic">
                    "Fasilitas lab komputernya sangat lengkap. Dari sinilah saya mulai menyukai coding dan berhasil diterima di jurusan Teknik Informatika Universitas impian saya."
                </p>

                <div class="flex items-center gap-4 mt-auto border-t border-white/10 pt-6">
                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=200&auto=format&fit=crop" alt="Avatar" class="w-14 h-14 rounded-full object-cover border-2 border-[#00A859]">
                    <div>
                        <h4 class="font-bold text-white text-lg">Rizky Ramadhan</h4>
                        <p class="text-[#00A859] text-sm font-medium">Alumni Angkatan 2022</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-3xl p-8 relative hover:-translate-y-2 transition-transform duration-300 group">
                <i class="fa-solid fa-quote-right absolute top-6 right-8 text-6xl text-white/5 group-hover:text-[#00A859]/20 transition-colors duration-300"></i>

                <div class="flex gap-1 text-yellow-400 text-sm mb-6">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>

                <p class="text-gray-200 leading-relaxed mb-8 relative z-10 italic">
                    "Lingkungan yang asri dan program ekstrakurikulernya sangat mendukung bakat anak. Anak saya yang awalnya pemalu kini sangat percaya diri mengikuti lomba pidato."
                </p>

                <div class="flex items-center gap-4 mt-auto border-t border-white/10 pt-6">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200&auto=format&fit=crop" alt="Avatar" class="w-14 h-14 rounded-full object-cover border-2 border-[#00A859]">
                    <div>
                        <h4 class="font-bold text-white text-lg">Bpk. Hendra Wijaya</h4>
                        <p class="text-[#00A859] text-sm font-medium">Wali Murid Kelas X</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- CTA -->
<section class="py-16 md:py-24 bg-white relative overflow-hidden border-t border-gray-100">
    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-green-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-green-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="bg-gray-50 rounded-3xl p-8 md:p-16 border border-gray-100 shadow-xl text-center relative overflow-hidden">

            <i class="fa-solid fa-bullhorn absolute top-4 right-8 text-9xl text-[#00A859] opacity-5 -rotate-12 pointer-events-none"></i>

            <h2 class="text-3xl md:text-5xl font-extrabold text-[#0B4A2D] mb-6 leading-tight relative z-10">
                Siap Mewujudkan Masa Depan <span class="text-[#00A859]">Gemilang?</span>
            </h2>

            <p class="text-gray-600 text-lg md:text-xl mb-10 max-w-2xl mx-auto leading-relaxed relative z-10">
                Pendaftaran Peserta Didik Baru (PPDB) tahun ajaran ini telah dibuka. Kuota terbatas! Segera daftarkan putra-putri Anda atau konsultasikan program pendidikan kami sekarang juga.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6 relative z-10">

                <a href="<?= $linkDaftar ?>" <?= $targetDaftar ?> <?= $onclickDaftar ?> class="w-full sm:w-auto inline-flex justify-center items-center gap-3 px-8 py-4 bg-[#00A859] text-white font-bold text-lg rounded-full shadow-lg hover:shadow-xl hover:bg-[#0B4A2D] hover:-translate-y-1 transition-all duration-300 group">
                    <i class="fa-solid fa-user-plus group-hover:scale-110 transition-transform"></i>
                    Daftar Sekarang
                </a>

                <a href="<?= $pengaturan['link_whatsapp'] ?? '#' ?>" target="_blank" class="w-full sm:w-auto inline-flex justify-center items-center gap-3 px-8 py-4 bg-white border-2 border-gray-200 text-[#0B4A2D] font-bold text-lg rounded-full shadow-sm hover:border-[#00A859] hover:text-[#00A859] hover:-translate-y-1 transition-all duration-300 group">
                    <i class="fa-brands fa-whatsapp text-2xl text-[#00A859] group-hover:scale-110 transition-transform"></i>
                    Konsultasi Program
                </a>
                <?php if (!$isBuka): ?>
                    <div id="modalTutup" class="fixed inset-0 z-9999 hidden bg-black/70 items-center justify-center p-4">
                        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-8 text-center animate__animated animate__zoomIn">

                            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-5">
                                <i class="fa-solid fa-lock text-red-500 text-4xl"></i>
                            </div>

                            <?php
                            // Logika default jika kosong
                            $pesanTutup = !empty($ppdb['pesan_tutup']) ? $ppdb['pesan_tutup'] : 'Mohon maaf, pendaftaran siswa baru saat ini belum dibuka / telah ditutup. Untuk informasi lebih lanjut, silakan hubungi admin kami.';

                            // Prioritaskan WA PPDB, jika kosong pakai WA Utama
                            $linkAdminPPDB = !empty($ppdb['link_admin_ppdb']) ? $ppdb['link_admin_ppdb'] : ($pengaturan['link_whatsapp'] ?? '#');
                            ?>

                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Pendaftaran Ditutup</h3>
                            <p class="text-gray-600 mb-8 leading-relaxed text-sm"><?= esc($pesanTutup) ?></p>

                            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                <a href="<?= esc($linkAdminPPDB) ?>" target="_blank" class="bg-[#00A859] hover:bg-green-600 text-white px-5 py-2.5 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                                    <i class="fa-brands fa-whatsapp text-lg"></i> Hubungi Admin
                                </a>

                                <button onclick="document.getElementById('modalTutup').classList.add('hidden'); document.getElementById('modalTutup').classList.remove('flex');" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-5 py-2.5 rounded-lg font-semibold transition">
                                    Kembali
                                </button>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Hero Swiper (Dengan Transisi Super Halus)
        const heroSwiper = new Swiper('.heroSwiper', {
            loop: true,
            speed: 1200, // <-- INI KUNCINYA: Durasi transisi 1,2 detik agar sangat halus
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            autoplay: {
                delay: 5000, // Gambar bertahan selama 5 detik sebelum ganti
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            }
        });
    });
    // --- ANIMASI COUNTER STATISTIK ---
    const counters = document.querySelectorAll('h3[data-target]');
    const speed = 200; // Semakin kecil semakin cepat

    // Fungsi untuk menjalankan animasi angka
    const animateCounters = () => {
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 15);
                } else {
                    counter.innerText = target + (target > 1000 ? '+' : ''); // Tambah '+' untuk angka besar
                }
            };
            updateCount();
        });
    };

    // Intersection Observer: Menjalankan animasi hanya ketika kotak statistik terlihat di layar
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.5 // Animasi jalan saat 50% elemen terlihat
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target); // Hanya jalankan 1 kali
            }
        });
    }, observerOptions);

    // Targetkan elemen pembungkus angka untuk diobservasi
    const statsSection = document.querySelector('.grid.grid-cols-2');
    if (statsSection) {
        observer.observe(statsSection);
    }
</script>

<?= $this->endSection() ?>
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

<section class="py-20 md:py-24 bg-gray-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16 items-center">

            <div class="w-full max-w-md lg:max-w-full lg:w-5/12 relative z-10 mx-auto">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-green-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-yellow-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>

                <div class="relative rounded-4xl overflow-hidden shadow-xl border-4 border-white bg-gray-200 aspect-3/4">
                    <img
                        src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop"
                        alt="Kepala Madrasah"
                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-700 ease-out" />
                </div>

                <div class="absolute -bottom-6 right-4 bg-white p-4 md:p-5 rounded-2xl shadow-lg border-b-4 border-[#00A859] flex items-center gap-3 z-20">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-green-50 text-[#00A859] rounded-full flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-medal"></i>
                    </div>
                    <div>
                        <p class="text-xl md:text-2xl font-extrabold text-[#0B4A2D]">20+</p>
                        <p class="text-[10px] md:text-xs text-gray-500 font-bold uppercase tracking-wider">Tahun Dedikasi</p>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-7/12 relative z-20">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 rounded-full mb-4">
                    <span class="w-2 h-2 rounded-full bg-[#00A859] animate-pulse"></span>
                    <span class="text-xs font-bold text-[#00A859] tracking-widest uppercase">Sambutan Kepala Madrasah</span>
                </div>

                <h2 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] leading-tight mb-5">
                    Mencetak Generasi Unggul Berwawasan <span class="text-[#00A859]">Global</span>
                </h2>

                <p class="text-gray-600 text-base md:text-lg leading-relaxed mb-5 font-medium italic border-l-4 border-[#00A859] pl-4">
                    "Pendidikan bukan sekadar mengisi pikiran, tetapi menyalakan api keingintahuan dan membentuk akhlak yang mulia."
                </p>

                <p class="text-gray-600 text-sm md:text-base leading-relaxed mb-8 text-justify">
                    Selamat datang di sekolah kami. Kami berkomitmen untuk menyediakan lingkungan belajar yang inspiratif, didukung oleh tenaga pendidik profesional dan fasilitas modern. Kami percaya bahwa setiap anak memiliki potensi unik yang siap untuk dikembangkan demi menyongsong masa depan yang cerah.
                </p>

                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between border-t border-gray-200 pt-6 mt-2 gap-4">
                    <div>
                        <h4 class="text-lg md:text-xl font-bold text-gray-800">
                            Bpk. Glen Ega Ahmad Andhika, S.Pd.
                        </h4>
                        <p class="text-[#00A859] font-medium text-sm">Kepala Madrasah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                    <p class="mb-4 text-justify">
                        Madrasah ini didirikan pada tahun 2005 dengan semangat untuk mencetak generasi yang tidak hanya unggul dalam ilmu pengetahuan umum (IPTEK), tetapi juga memiliki kedalaman iman dan takwa (IMTAK). Berawal dari sebuah gedung sederhana dengan puluhan siswa, kini kami telah berkembang menjadi salah satu institusi pendidikan Islam rujukan di daerah ini.
                    </p>
                    <p class="text-justify">
                        Seiring berjalannya waktu, berbagai inovasi kurikulum dan perbaikan fasilitas terus dilakukan. Kami berkomitmen untuk terus beradaptasi dengan kemajuan teknologi tanpa meninggalkan tradisi keilmuan pesantren yang menjunjung tinggi akhlakul karimah.
                    </p>
                </div>
            </div>

            <div class="w-full lg:w-5/12 relative order-1 lg:order-2">
                <div class="absolute -inset-4 bg-green-50 rounded-3xl transform rotate-3 -z-10"></div>
                <div class="absolute -inset-4 bg-[#0B4A2D] rounded-3xl transform -rotate-2 -z-20 opacity-10"></div>

                <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800&auto=format&fit=crop" alt="Gedung Madrasah" class="w-full h-80 md:h-88 object-cover rounded-2xl shadow-lg border-4 border-white">

                <div class="absolute -bottom-6 -left-6 bg-green-100 text-[#0B4A2D] p-5 rounded-full shadow-xl border-4 border-white flex flex-col items-center justify-center w-28 h-28 transform hover:scale-105 transition-transform">
                    <span class="text-xs font-bold uppercase tracking-wider mb-1">Sejak</span>
                    <span class="text-2xl font-extrabold">2020</span>
                </div>
            </div>

        </div>
    </div>
</section>

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
                    "Terwujudnya generasi muslim yang Berakhlakul Karimah, Unggul dalam Prestasi, Mandiri, dan Berwawasan Lingkungan Global."
                </p>
            </div>

            <div class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-gray-100 hover:shadow-xl transition-shadow relative overflow-hidden group">
                <i class="fa-solid fa-bullseye absolute -top-4 -right-4 text-9xl text-yellow-50 opacity-50 group-hover:scale-110 transition-transform duration-500"></i>
                <div class="w-14 h-14 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center text-2xl mb-6 relative z-10 shadow-inner">
                    <i class="fa-solid fa-rocket"></i>
                </div>
                <h3 class="text-2xl font-bold text-[#0B4A2D] mb-5 relative z-10">Misi Madrasah</h3>
                <ul class="space-y-3 relative z-10 text-sm md:text-base">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-[#00A859] mt-1 text-base shrink-0"></i>
                        <span class="text-gray-600">Menyelenggarakan pembelajaran yang aktif, inovatif, kreatif, dan menyenangkan.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-[#00A859] mt-1 text-base shrink-0"></i>
                        <span class="text-gray-600">Menumbuhkembangkan karakter Islami melalui pembiasaan ibadah dan amaliah sehari-hari.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-[#00A859] mt-1 text-base shrink-0"></i>
                        <span class="text-gray-600">Meningkatkan kompetensi pendidik dan tenaga kependidikan sesuai perkembangan zaman.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-[#00A859] mt-1 text-base shrink-0"></i>
                        <span class="text-gray-600">Menciptakan lingkungan sekolah yang bersih, asri, dan nyaman untuk belajar.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="py-16 md:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] mb-4">Fasilitas Madrasah</h2>
            <div class="w-20 h-1.5 bg-[#00A859] mx-auto rounded-full mb-4"></div>
            <p class="text-gray-500 text-sm md:text-base">Sarana dan prasarana pendukung yang memadai untuk menciptakan lingkungan belajar yang optimal dan menyenangkan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="relative overflow-hidden rounded-2xl group min-h-64 shadow-md hover:shadow-xl transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=800&auto=format&fit=crop" alt="Ruang Kelas" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-linear-to-t from-[#0B4A2D]/95 via-[#0B4A2D]/60 to-transparent opacity-90 transition-opacity group-hover:opacity-100"></div>

                <div class="relative z-10 h-full p-6 flex flex-col justify-end">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 shrink-0 bg-white/20 backdrop-blur-sm border border-white/30 text-white rounded-xl flex items-center justify-center text-xl group-hover:bg-[#00A859] group-hover:border-[#00A859] transition-colors duration-300">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white mb-1">Ruang Kelas Nyaman</h4>
                            <p class="text-sm text-gray-200 leading-snug">Dilengkapi pendingin ruangan, proyektor, dan tata letak yang mendukung interaksi aktif.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-2xl group min-h-64 shadow-md hover:shadow-xl transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1517433670267-08bbd4be890f?q=80&w=800&auto=format&fit=crop" alt="Lab Komputer" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-linear-to-t from-[#0B4A2D]/95 via-[#0B4A2D]/60 to-transparent opacity-90 transition-opacity group-hover:opacity-100"></div>

                <div class="relative z-10 h-full p-6 flex flex-col justify-end">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 shrink-0 bg-white/20 backdrop-blur-sm border border-white/30 text-white rounded-xl flex items-center justify-center text-xl group-hover:bg-[#00A859] group-hover:border-[#00A859] transition-colors duration-300">
                            <i class="fa-solid fa-computer"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white mb-1">Laboratorium Komputer</h4>
                            <p class="text-sm text-gray-200 leading-snug">Perangkat modern dengan koneksi internet berkecepatan tinggi untuk praktik digital.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-2xl group min-h-64 shadow-md hover:shadow-xl transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=800&auto=format&fit=crop" alt="Perpustakaan" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-linear-to-t from-[#0B4A2D]/95 via-[#0B4A2D]/60 to-transparent opacity-90 transition-opacity group-hover:opacity-100"></div>

                <div class="relative z-10 h-full p-6 flex flex-col justify-end">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 shrink-0 bg-white/20 backdrop-blur-sm border border-white/30 text-white rounded-xl flex items-center justify-center text-xl group-hover:bg-[#00A859] group-hover:border-[#00A859] transition-colors duration-300">
                            <i class="fa-solid fa-book-bookmark"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white mb-1">Perpustakaan Digital</h4>
                            <p class="text-sm text-gray-200 leading-snug">Koleksi ribuan buku fisik dan e-book pendukung kurikulum serta literatur keislaman.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-2xl group min-h-64 shadow-md hover:shadow-xl transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?q=80&w=800&auto=format&fit=crop" alt="Masjid" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-linear-to-t from-[#0B4A2D]/95 via-[#0B4A2D]/60 to-transparent opacity-90 transition-opacity group-hover:opacity-100"></div>

                <div class="relative z-10 h-full p-6 flex flex-col justify-end">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 shrink-0 bg-white/20 backdrop-blur-sm border border-white/30 text-white rounded-xl flex items-center justify-center text-xl group-hover:bg-[#00A859] group-hover:border-[#00A859] transition-colors duration-300">
                            <i class="fa-solid fa-mosque"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white mb-1">Masjid Raya</h4>
                            <p class="text-sm text-gray-200 leading-snug">Pusat kegiatan ibadah harian, shalat berjamaah, dan pembinaan karakter rohani siswa.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-2xl group min-h-64 shadow-md hover:shadow-xl transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1526232761682-d26e03ac148e?q=80&w=800&auto=format&fit=crop" alt="Sarana Olahraga" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-linear-to-t from-[#0B4A2D]/95 via-[#0B4A2D]/60 to-transparent opacity-90 transition-opacity group-hover:opacity-100"></div>

                <div class="relative z-10 h-full p-6 flex flex-col justify-end">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 shrink-0 bg-white/20 backdrop-blur-sm border border-white/30 text-white rounded-xl flex items-center justify-center text-xl group-hover:bg-[#00A859] group-hover:border-[#00A859] transition-colors duration-300">
                            <i class="fa-solid fa-volleyball"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white mb-1">Sarana Olahraga</h4>
                            <p class="text-sm text-gray-200 leading-snug">Lapangan futsal, basket, dan voli terpadu untuk mendukung kebugaran fisik siswa.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-2xl group min-h-64 shadow-md hover:shadow-xl transition-all duration-300">
                <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?q=80&w=800&auto=format&fit=crop" alt="Lab IPA" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-linear-to-t from-[#0B4A2D]/95 via-[#0B4A2D]/60 to-transparent opacity-90 transition-opacity group-hover:opacity-100"></div>

                <div class="relative z-10 h-full p-6 flex flex-col justify-end">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 shrink-0 bg-white/20 backdrop-blur-sm border border-white/30 text-white rounded-xl flex items-center justify-center text-xl group-hover:bg-[#00A859] group-hover:border-[#00A859] transition-colors duration-300">
                            <i class="fa-solid fa-microscope"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white mb-1">Laboratorium IPA</h4>
                            <p class="text-sm text-gray-200 leading-snug">Fasilitas riset dan praktikum sains yang lengkap dengan standar keamanan tinggi.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="py-20 md:py-28 bg-gray-50 overflow-hidden border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-20 items-center">

            <div class="w-full lg:w-1/2 relative z-10 group">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-green-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-yellow-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>

                <div class="relative w-full aspect-video rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-gray-800 z-20 transition-transform duration-500 group-hover:scale-[1.02]">
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
                    <span class="text-xs font-bold text-[#00A859] tracking-widest uppercase">Tentang Kami</span>
                </div>

                <h2 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] leading-tight mb-6">
                    Menjelajahi Lingkungan Belajar yang <span class="text-[#00A859]">Inspiratif</span>
                </h2>

                <p class="text-gray-600 text-base md:text-lg leading-relaxed mb-6">
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
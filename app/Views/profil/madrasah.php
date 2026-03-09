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

<section class="py-20 md:py-28 bg-gray-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-20 items-center">
            <div class="w-full lg:w-1/2 relative z-10">
                <div
                    class="absolute -top-10 -left-10 w-40 h-40 bg-green-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
                <div
                    class="absolute -bottom-10 -right-10 w-40 h-40 bg-yellow-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>

                <div
                    class="relative rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white bg-gray-200">
                    <img
                        src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=800&auto=format&fit=crop"
                        alt="Kepala Sekolah"
                        class="w-full h-112.5 md:h-137.5 object-cover hover:scale-105 transition-transform duration-700 ease-out" />
                </div>

                <div
                    class="absolute -bottom-6 right-4 md:-bottom-8 md:-right-8 bg-white p-5 md:p-6 rounded-2xl shadow-xl border-b-4 border-[#00A859] flex items-center gap-4 z-20">
                    <div
                        class="w-12 h-12 md:w-14 md:h-14 bg-green-50 text-[#00A859] rounded-full flex items-center justify-center text-xl md:text-2xl font-bold">
                        <i class="fa-solid fa-medal"></i>
                    </div>
                    <div>
                        <p class="text-2xl md:text-3xl font-extrabold text-[#0B4A2D]">
                            20+
                        </p>
                        <p
                            class="text-xs md:text-sm text-gray-500 font-semibold uppercase tracking-wider">
                            Tahun Dedikasi
                        </p>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2 mt-10 lg:mt-0 relative z-20">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 rounded-full mb-6">
                    <span class="w-2 h-2 rounded-full bg-[#00A859] animate-pulse"></span>
                    <span
                        class="text-sm font-bold text-[#00A859] tracking-widest uppercase">Sambutan Kepala Madrasah</span>
                </div>

                <h2
                    class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-[#0B4A2D] leading-tight mb-6">
                    Mencetak Generasi Unggul Berwawasan
                    <span class="text-[#00A859]">Global</span>
                </h2>

                <p
                    class="text-gray-600 text-lg leading-relaxed mb-6 font-medium italic border-l-4 border-[#00A859] pl-4">
                    "Pendidikan bukan sekadar mengisi pikiran, tetapi menyalakan api
                    keingintahuan dan membentuk akhlak yang mulia."
                </p>
                <p class="text-gray-600 leading-relaxed mb-8">
                    Selamat datang di sekolah kami. Kami berkomitmen untuk menyediakan
                    lingkungan belajar yang inspiratif, didukung oleh tenaga pendidik
                    profesional dan fasilitas modern. Kami percaya bahwa setiap anak
                    memiliki potensi unik yang siap untuk dikembangkan demi menyongsong
                    masa depan yang cerah.
                </p>

                <div
                    class="flex flex-col sm:flex-row items-start sm:items-center justify-between border-t border-gray-200 pt-8 mt-8 gap-6">
                    <div>
                        <h4 class="text-xl font-bold text-gray-800">
                            Bpk. Glen Ega Ahmad Andhika, S.Pd.
                        </h4>
                        <p class="text-[#00A859] font-medium">Kepala Madrasah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 md:py-24 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">

            <div class="w-full lg:w-5/12 relative">
                <div class="absolute -inset-4 bg-green-50 rounded-3xl transform -rotate-3 -z-10"></div>
                <div class="absolute -inset-4 bg-[#0B4A2D] rounded-3xl transform rotate-2 -z-20 opacity-10"></div>

                <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800&auto=format&fit=crop" alt="Gedung Madrasah" class="w-full h-100 object-cover rounded-2xl shadow-lg border-4 border-white">

                <div class="absolute -bottom-6 -right-6 bg-green-100 text-[#0B4A2D] p-6 rounded-full shadow-xl border-4 border-white flex flex-col items-center justify-center w-32 h-32 transform hover:scale-105 transition-transform">
                    <span class="text-sm font-bold uppercase tracking-wider mb-1">Sejak</span>
                    <span class="text-3xl font-extrabold">2020</span>
                </div>
            </div>

            <div class="w-full lg:w-7/12">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 border border-green-100 rounded-full mb-4">
                    <i class="fa-solid fa-clock-rotate-left text-[#00A859]"></i>
                    <span class="text-sm font-bold text-[#0B4A2D] tracking-widest uppercase">Kilas Balik</span>
                </div>

                <h2 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] mb-6 leading-tight">
                    Sejarah Singkat Madrasah
                </h2>

                <div class="prose prose-lg text-gray-600">
                    <p class="mb-4 text-justify">
                        Madrasah ini didirikan pada tahun 2005 dengan semangat untuk mencetak generasi yang tidak hanya unggul dalam ilmu pengetahuan umum (IPTEK), tetapi juga memiliki kedalaman iman dan takwa (IMTAK). Berawal dari sebuah gedung sederhana dengan puluhan siswa, kini kami telah berkembang menjadi salah satu institusi pendidikan Islam rujukan di daerah ini.
                    </p>
                    <p class="text-justify">
                        Seiring berjalannya waktu, berbagai inovasi kurikulum dan perbaikan fasilitas terus dilakukan. Kami berkomitmen untuk terus beradaptasi dengan kemajuan teknologi tanpa meninggalkan tradisi keilmuan pesantren yang menjunjung tinggi akhlakul karimah.
                    </p>
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
            <p class="text-gray-500">Arah dan tujuan utama yang menjadi komitmen kami dalam menyelenggarakan pendidikan yang berkualitas.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

            <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100 hover:shadow-xl transition-shadow relative overflow-hidden group">
                <i class="fa-solid fa-eye absolute -top-4 -right-4 text-9xl text-green-50 opacity-50 group-hover:scale-110 transition-transform duration-500"></i>

                <div class="w-16 h-16 bg-green-100 text-[#00A859] rounded-2xl flex items-center justify-center text-3xl mb-8 relative z-10 shadow-inner">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>
                <h3 class="text-2xl font-bold text-[#0B4A2D] mb-4 relative z-10">Visi Madrasah</h3>
                <p class="text-xl text-gray-600 font-medium leading-relaxed relative z-10 italic">
                    "Terwujudnya generasi muslim yang Berakhlakul Karimah, Unggul dalam Prestasi, Mandiri, dan Berwawasan Lingkungan Global."
                </p>
            </div>

            <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100 hover:shadow-xl transition-shadow relative overflow-hidden group">
                <i class="fa-solid fa-bullseye absolute -top-4 -right-4 text-9xl text-yellow-50 opacity-50 group-hover:scale-110 transition-transform duration-500"></i>

                <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center text-3xl mb-8 relative z-10 shadow-inner">
                    <i class="fa-solid fa-rocket"></i>
                </div>
                <h3 class="text-2xl font-bold text-[#0B4A2D] mb-6 relative z-10">Misi Madrasah</h3>

                <ul class="space-y-4 relative z-10">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-[#00A859] mt-1 text-lg shrink-0"></i>
                        <span class="text-gray-600">Menyelenggarakan pembelajaran yang aktif, inovatif, kreatif, dan menyenangkan.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-[#00A859] mt-1 text-lg shrink-0"></i>
                        <span class="text-gray-600">Menumbuhkembangkan karakter Islami melalui pembiasaan ibadah dan amaliah sehari-hari.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-[#00A859] mt-1 text-lg shrink-0"></i>
                        <span class="text-gray-600">Meningkatkan kompetensi pendidik dan tenaga kependidikan sesuai perkembangan zaman.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-[#00A859] mt-1 text-lg shrink-0"></i>
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
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#0B4A2D] mb-4">Identitas Madrasah</h2>
            <p class="text-gray-500">Data singkat mengenai legalitas dan identitas resmi sekolah kami.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <div class="bg-gray-50 p-6 rounded-2xl text-center border border-gray-100 hover:border-[#00A859] hover:bg-green-50 transition-colors group">
                <i class="fa-solid fa-id-card text-3xl text-gray-400 group-hover:text-[#00A859] mb-3 transition-colors"></i>
                <h4 class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">NPSN</h4>
                <p class="text-lg font-extrabold text-[#0B4A2D]">10293847</p>
            </div>

            <div class="bg-gray-50 p-6 rounded-2xl text-center border border-gray-100 hover:border-[#00A859] hover:bg-green-50 transition-colors group">
                <i class="fa-solid fa-star text-3xl text-gray-400 group-hover:text-[#00A859] mb-3 transition-colors"></i>
                <h4 class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Akreditasi</h4>
                <p class="text-lg font-extrabold text-[#0B4A2D]">A (Unggul)</p>
            </div>

            <div class="bg-gray-50 p-6 rounded-2xl text-center border border-gray-100 hover:border-[#00A859] hover:bg-green-50 transition-colors group">
                <i class="fa-solid fa-building-flag text-3xl text-gray-400 group-hover:text-[#00A859] mb-3 transition-colors"></i>
                <h4 class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Status</h4>
                <p class="text-lg font-extrabold text-[#0B4A2D]">Swasta</p>
            </div>

            <div class="bg-gray-50 p-6 rounded-2xl text-center border border-gray-100 hover:border-[#00A859] hover:bg-green-50 transition-colors group">
                <i class="fa-solid fa-book-open text-3xl text-gray-400 group-hover:text-[#00A859] mb-3 transition-colors"></i>
                <h4 class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Kurikulum</h4>
                <p class="text-lg font-extrabold text-[#0B4A2D]">Merdeka & Kemenag</p>
            </div>
        </div>

    </div>
</section>

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

                <div class="flex gap-4 border-t border-gray-200 pt-8 mt-8">
                    <a href="<?= base_url('kegiatan') ?>" class="group inline-flex items-center justify-center px-6 py-3.5 border border-transparent text-base font-bold rounded-xl text-white bg-[#0B4A2D] hover:bg-[#00A859] transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1">
                        Lihat Galeri & Kegiatan
                        <i class="fa-solid fa-camera ml-2 group-hover:scale-110 transition-transform"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<?= $this->endSection() ?>
<?= $this->extend('layouts/main'); // Sesuaikan dengan nama file layout utama Mas 
?>

<?= $this->section('content'); ?>
<section class="relative bg-[#0B4A2D] py-16 md:py-24 overflow-hidden border-b-8 border-[#00A859]">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 2px, transparent 2px); background-size: 30px 30px;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 drop-shadow-md">Bakat Minat</h1>

        <nav class="flex justify-center text-green-100 text-sm font-medium">
            <ol class="inline-flex items-center space-x-2">
                <li><a href="<?= base_url() ?>" class="hover:text-white transition"><i class="fa-solid fa-house mr-1"></i> Beranda</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-1 opacity-70"></i></li>
                <li class="text-white opacity-80">Profil</li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-1 opacity-70"></i></li>
                <li class="text-white font-bold">Bakat Minat</li>
            </ol>
        </nav>
    </div>
</section>
<section class="py-16 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-16">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-4">Bakat & Minat</h1>
            <p class="text-gray-500 max-w-2xl mx-auto text-lg">
                Wadah pengembangan potensi, bakat, dan minat siswa melalui berbagai kegiatan ekstrakurikuler pilihan untuk mencetak generasi yang kreatif dan berprestasi.
            </p>
            <div class="w-24 h-1 bg-[#00A859] mx-auto mt-6 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 group">
                <div class="h-48 bg-gray-200 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1526976663186-3320b520b12a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Pramuka" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent"></div>
                    <h3 class="absolute bottom-4 left-4 text-white font-bold text-xl">Pramuka</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 text-sm line-clamp-3">
                        Membentuk karakter siswa yang disiplin, mandiri, dan memiliki jiwa kepemimpinan serta kepedulian sosial yang tinggi.
                    </p>
                    <button class="mt-4 text-[#00A859] font-semibold text-sm hover:underline flex items-center gap-1">
                        Lihat Detail <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 group">
                <div class="h-48 bg-gray-200 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Olahraga" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent"></div>
                    <h3 class="absolute bottom-4 left-4 text-white font-bold text-xl">Futsal & Basket</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 text-sm line-clamp-3">
                        Menyalurkan minat dan bakat di bidang olahraga untuk menjaga kebugaran fisik dan meraih prestasi dalam berbagai kompetisi.
                    </p>
                    <button class="mt-4 text-[#00A859] font-semibold text-sm hover:underline flex items-center gap-1">
                        Lihat Detail <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 group">
                <div class="h-48 bg-gray-200 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Seni Musik" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent"></div>
                    <h3 class="absolute bottom-4 left-4 text-white font-bold text-xl">Seni Tari & Musik</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 text-sm line-clamp-3">
                        Wadah berekspresi melalui seni tari tradisional dan musik, melestarikan budaya bangsa sekaligus mengembangkan kreativitas.
                    </p>
                    <button class="mt-4 text-[#00A859] font-semibold text-sm hover:underline flex items-center gap-1">
                        Lihat Detail <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>

<?= $this->endSection(); ?>
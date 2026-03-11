<?= $this->extend('layouts/main'); // Sesuaikan nama template Mas 
?>

<?= $this->section('content'); ?>

<div x-data="{ 
        isModalOpen: false, 
        modalData: {},
        openModal(data) {
            this.modalData = data;
            this.isModalOpen = true;
            document.body.classList.add('overflow-hidden'); // Kunci scroll layar utama
        },
        closeModal() {
            this.isModalOpen = false;
            document.body.classList.remove('overflow-hidden'); // Buka scroll layar utama
        }
    }">

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
                        <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Robotik" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6 text-center md:text-left">
                        <h3 class="font-bold text-xl text-gray-800 mb-2">Robotik</h3>
                        <p class="text-gray-600 text-sm line-clamp-3">
                            Mempelajari desain, konstruksi, dan pengoperasian robot untuk meningkatkan efisiensi dan kreativitas teknologi masa depan.
                        </p>

                        <button
                            @click="openModal({ 
                                judul: 'Robotik', 
                                jadwal: 'Sabtu 08.00 - 11.00', 
                                deskripsi: 'Robotik adalah bidang ilmu dan teknologi interdisipliner yang mempelajari desain, konstruksi, operasi, dan aplikasi robot, menggabungkan mekanika, elektronika, ilmu komputer, dan algoritma untuk menciptakan mesin otomatis yang bisa melakukan tugas secara mandiri atau membantu manusia. Tujuan utamanya adalah meningkatkan efisiensi, presisi, dan keselamatan dalam berbagai aktivitas.', 
                                gambar: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' 
                            })"
                            class="mt-4 text-[#00A859] font-semibold text-sm hover:underline flex items-center gap-1 justify-center md:justify-start w-full md:w-auto">
                            Lihat Detail <i class="fa-solid fa-arrow-right text-xs mt-0.5"></i>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 group">
                    <div class="h-48 bg-gray-200 relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Futsal" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6 text-center md:text-left">
                        <h3 class="font-bold text-xl text-gray-800 mb-2">Futsal</h3>
                        <p class="text-gray-600 text-sm line-clamp-3">
                            Mengembangkan kemampuan fisik, kerja sama tim, dan sportivitas melalui cabang olahraga bola sepak lapangan kecil.
                        </p>

                        <button
                            @click="openModal({ 
                                judul: 'Futsal', 
                                jadwal: 'Jumat 15.30 - 17.00', 
                                deskripsi: 'Ekstrakurikuler Futsal bertujuan untuk menyalurkan bakat olahraga siswa, melatih kerja sama tim (teamwork), kedisiplinan, dan sportivitas. Kegiatan latihan meliputi teknik dasar permainan, strategi lapangan, hingga persiapan untuk mengikuti kompetisi antar sekolah tingkat daerah maupun nasional.', 
                                gambar: 'https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' 
                            })"
                            class="mt-4 text-[#00A859] font-semibold text-sm hover:underline flex items-center gap-1 justify-center md:justify-start w-full md:w-auto">
                            Lihat Detail <i class="fa-solid fa-arrow-right text-xs mt-0.5"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-99 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">

            <div x-show="isModalOpen"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
                @click="closeModal()" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="isModalOpen"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block w-full max-w-4xl text-left align-middle transition-all transform bg-white rounded-3xl shadow-2xl overflow-hidden sm:my-8">

                <div class="flex flex-col md:flex-row h-full md:max-h-[80vh]">

                    <div class="w-full md:w-[45%] h-64 md:h-auto relative bg-gray-100 shrink-0">
                        <img :src="modalData.gambar" class="absolute inset-0 w-full h-full object-cover" alt="Gambar Bakat Minat">
                    </div>

                    <div class="w-full md:w-[55%] p-8 sm:p-10 relative overflow-y-auto">

                        <button @click="closeModal()" class="absolute top-6 right-6 flex items-center justify-center w-8 h-8 text-gray-500 bg-gray-100 rounded-full hover:bg-gray-200 hover:text-gray-800 transition-colors">
                            <i class="fa-solid fa-xmark"></i>
                        </button>

                        <div class="w-12 h-1 bg-[#D4AF37] mb-5 rounded-full"></div>

                        <h2 class="text-3xl md:text-4xl font-serif font-bold text-[#800000] mb-6" x-text="modalData.judul"></h2>

                        <div class="flex items-center gap-4 bg-[#F8F9FA] p-4 rounded-xl border border-gray-100 mb-6 w-max max-w-full">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-orange-100 text-orange-500 shrink-0">
                                <i class="fa-regular fa-clock text-lg"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold tracking-widest text-gray-400 uppercase">Jadwal Latihan</p>
                                <p class="text-sm font-extrabold text-gray-800 mt-0.5" x-text="modalData.jadwal"></p>
                            </div>
                        </div>

                        <div class="prose prose-sm text-gray-500 leading-relaxed text-justify">
                            <p x-text="modalData.deskripsi"></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->extend('layouts/main'); // Sesuaikan nama template Mas 
?>

<?= $this->section('content'); ?>

<div x-data="{ 
        modalOpen: false, 
        selected: {},
        openModal(data) {
            this.selected = data;
            this.modalOpen = true;
            document.body.classList.add('overflow-hidden');
        },
        closeModal() {
            this.modalOpen = false;
            document.body.classList.remove('overflow-hidden');
        }
    }">
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
                <h1 class="text-3xl md:text-4xl font-extrabold text-green-800 mb-4">Bakat & Minat</h1>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg">Wadah pengembangan potensi, bakat, dan minat siswa.</p>
                <div class="w-24 h-1 bg-[#00A859] mx-auto mt-6 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                <?php if (!empty($bakat_minat)) : ?>
                    <?php foreach ($bakat_minat as $row) : ?>
                        <?php
                        // 1. Tentukan Nama Pembina
                        $namaPembina = '-';
                        if ($row['tipe_pembina'] == 'guru') {
                            // Pastikan 'nama_guru' sesuai dengan alias saat JOIN di Controller Mas
                            $namaPembina = isset($row['nama_guru']) ? $row['nama_guru'] : 'Data Guru';
                        } else {
                            $namaPembina = $row['nama_pembina_manual'];
                        }

                        // 2. Tentukan Path Gambar (dengan fallback gambar default jika kosong)
                        $gambarDefault = 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80';
                        $pathGambar = $row['gambar'] ? base_url('uploads/bakat/' . $row['gambar']) : $gambarDefault;

                        // 3. Siapkan data untuk Alpine.js
                        // Kita pakai json_encode agar aman dari error tanda kutip (Enter/Spasi) pada deskripsi
                        $modalData = [
                            'judul'     => $row['judul'],
                            'jadwal'    => $row['jadwal'],
                            'deskripsi' => $row['deskripsi'],
                            'gambar'    => $pathGambar,
                            'pembina'   => $namaPembina
                        ];
                        ?>

                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100 group">
                            <div class="h-48 bg-gray-200 relative overflow-hidden">
                                <img src="<?= $pathGambar; ?>" alt="<?= esc($row['judul']); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-6 text-center md:text-left flex flex-col h-[calc(100%-12rem)]">
                                <h3 class="font-bold text-xl text-green-800 mb-2"><?= esc($row['judul']); ?></h3>

                                <p class="text-gray-600 text-sm line-clamp-3 mb-4 grow">
                                    <?= esc($row['deskripsi']); ?>
                                </p>

                                <button
                                    @click="openModal(<?= htmlspecialchars(json_encode($modalData), ENT_QUOTES, 'UTF-8'); ?>)"
                                    class="text-[#00A859] font-semibold text-sm hover:underline flex items-center gap-1 justify-center md:justify-start w-full md:w-auto mt-auto">
                                    Lihat Detail <i class="fa-solid fa-arrow-right text-xs mt-0.5"></i>
                                </button>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-span-full text-center py-10 text-gray-500">
                        Belum ada data Ekstrakurikuler / Bakat Minat.
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <div x-show="modalOpen" style="display: none;" class="fixed inset-0 z-999 flex items-center justify-center p-4 sm:p-6"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" @click="closeModal()"></div>

        <div class="relative w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row max-h-[90vh]"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0">

            <button @click="closeModal()" class="absolute top-6 right-6 z-60 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-green-500 hover:text-white transition shadow-sm">
                <i class="fas fa-times text-sm"></i>
            </button>

            <div class="w-full md:w-5/12 h-64 md:h-auto bg-gray-100 shrink-0 relative">
                <template x-if="selected.gambar">
                    <img :src="selected.gambar" class="absolute inset-0 w-full h-full object-cover object-center" alt="Foto Kegiatan">
                </template>
                <template x-if="!selected.gambar">
                    <div class="absolute inset-0 w-full h-full flex items-center justify-center text-gray-400">
                        <i class="fas fa-image text-4xl"></i>
                    </div>
                </template>
            </div>

            <div class="w-full md:w-7/12 p-8 md:p-10 flex flex-col overflow-y-auto bg-white relative z-10">
                <div class="mb-6 pr-6">

                    <h2 class="text-3xl md:text-4xl font-extrabold text-green-800 mb-5 leading-tight font-serif" x-text="selected.judul"></h2>
                    <div class="inline-flex items-center gap-4 bg-green-50 px-4 py-3 rounded-xl border border-green-100">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-100 text-green-500 shrink-0">
                            <i class="fa-regular fa-clock text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Jadwal Latihan</p>
                            <p class="text-sm font-extrabold text-gray-800 mt-0.5" x-text="selected.jadwal"></p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 grow">
                    <div>
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 flex items-center gap-2">
                            <i class="fas fa-align-left"></i> Deskripsi Kegiatan
                        </h4>
                        <p class="text-gray-600 text-sm leading-relaxed text-justify whitespace-pre-line" x-text="selected.deskripsi"></p>
                    </div>

                    <template x-if="selected.pembina && selected.pembina !== '-'">
                        <div class="pt-4 border-t border-gray-50">
                            <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-2">
                                <i class="fas fa-user-tie"></i> Guru Pembina
                            </h4>
                            <p class="text-gray-800 font-medium text-sm md:text-base" x-text="selected.pembina"></p>
                        </div>
                    </template>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 shrink-0">
                    <p class="text-xs text-gray-400 font-medium w-full text-center sm:text-left">Program Ekstrakurikuler & Pengembangan Diri</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
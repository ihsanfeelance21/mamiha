<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div x-data="guruData()">

    <section class="relative bg-[#0B4A2D] py-16 md:py-24 overflow-hidden border-b-8 border-[#00A859]">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 2px, transparent 2px); background-size: 30px 30px;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 drop-shadow-md">Struktur Organisasi</h1>

            <nav class="flex justify-center text-green-100 text-sm font-medium">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="<?= base_url() ?>" class="hover:text-white transition"><i class="fa-solid fa-house mr-1"></i> Beranda</a></li>
                    <li><i class="fa-solid fa-chevron-right text-[10px] mx-1 opacity-70"></i></li>
                    <li class="text-white opacity-80">Profil</li>
                    <li><i class="fa-solid fa-chevron-right text-[10px] mx-1 opacity-70"></i></li>
                    <li class="text-white font-bold">Struktur</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="py-20 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <?php if (!empty($pimpinan)): ?>
                <div class="flex flex-col lg:flex-row gap-12 lg:gap-20 items-start justify-between">

                    <div class="relative w-full mx-auto lg:mx-0 shrink-0 cursor-pointer group" style="max-width: 300px;"
                        @click='openModal(<?= htmlspecialchars(json_encode([
                                                "nama" => $pimpinan["nama"],
                                                "jabatan" => $pimpinan["jabatan"],
                                                "foto" => !empty($pimpinan["foto"]) ? base_url("uploads/guru/" . $pimpinan["foto"]) : "https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600",
                                                "pendidikan" => $pimpinan["pendidikan"] ?? "-",
                                                "sambutan" => $pimpinan["sambutan"] ?? "Belum ada informasi sambutan/tentang saya.",
                                                "bergabung" => $pimpinan["tahun_bergabung"] ?? "-",
                                                "facebook" => $pimpinan["facebook"] ?? "",
                                                "instagram" => $pimpinan["instagram"] ?? "",
                                                "linkedin" => $pimpinan["linkedin"] ?? "",
                                                "youtube" => $pimpinan["youtube"] ?? "",
                                                "tiktok" => $pimpinan["tiktok"] ?? "",
                                                "cv" => !empty($pimpinan["cv_file"]) ? base_url("uploads/cv/" . $pimpinan["cv_file"]) : ""
                                            ]), ENT_QUOTES, "UTF-8") ?>)'>

                        <div class="absolute -top-10 -left-10 w-48 h-48 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 z-0"></div>
                        <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 z-0"></div>

                        <div class="relative z-10 rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-gray-200">
                            <?php $fotoPimpinan = !empty($pimpinan['foto']) ? base_url('uploads/guru/' . $pimpinan['foto']) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600'; ?>
                            <img src="<?= $fotoPimpinan ?>" alt="<?= esc($pimpinan['nama']) ?>" class="w-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" style="aspect-ratio: 3/4;" />

                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-300">
                                <span class="text-white font-bold bg-[#00A859] px-4 py-2 rounded-lg"><i class="fas fa-search-plus mr-2"></i>Lihat Detail</span>
                            </div>
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

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative flex py-10 items-center justify-center mb-10">
                <div class="grow border-t border-gray-200"></div>
                <span class="shrink-0 px-6 text-gray-800 font-extrabold tracking-widest uppercase text-xl md:text-2xl">
                    Dewan Guru
                </span>
                <div class="grow border-t border-gray-200"></div>
            </div>

            <div class="flex flex-wrap justify-center gap-6">
                <?php if (!empty($dewan_guru)): ?> <?php foreach ($dewan_guru as $guru) : ?>
                        <div class="w-[calc(50%-12px)] md:w-[calc(25%-18px)] lg:w-[calc(16.66%-20px)] bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow cursor-pointer overflow-hidden border border-gray-100 group shrink-0"
                            @click='openModal(<?= htmlspecialchars(json_encode([
                                                            "nama" => $guru["nama"],
                                                            "jabatan" => $guru["jabatan"],
                                                            "foto" => !empty($guru["foto"]) ? base_url("uploads/guru/" . $guru["foto"]) : "https://ui-avatars.com/api/?name=" . urlencode($guru["nama"]) . "&background=random",
                                                            "pendidikan" => $guru["pendidikan"] ?? "-",
                                                            "sambutan" => $guru["sambutan"] ?? "Belum ada informasi sambutan/tentang saya.",
                                                            "bergabung" => $guru["tahun_bergabung"] ?? "-",
                                                            "facebook" => $guru["facebook"] ?? "",
                                                            "instagram" => $guru["instagram"] ?? "",
                                                            "linkedin" => $guru["linkedin"] ?? "",
                                                            "youtube" => $guru["youtube"] ?? "",
                                                            "tiktok" => $guru["tiktok"] ?? "",
                                                            "cv" => !empty($guru["cv_file"]) ? base_url("uploads/cv/" . $guru["cv_file"]) : ""
                                                        ]), ENT_QUOTES, "UTF-8") ?>)'>

                            <div class="aspect-3/4 bg-gray-100 relative overflow-hidden">
                                <img src="<?= !empty($guru['foto']) ? base_url('uploads/guru/' . $guru['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($guru['nama']) . '&background=random' ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-4 text-center">
                                <h3 class="font-bold text-gray-800 text-sm md:text-base line-clamp-2"><?= esc($guru['nama']) ?></h3>
                                <p class="text-xs text-[#00A859] font-semibold mt-1"><?= esc($guru['jabatan']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="w-full text-center text-gray-400">Data Dewan Guru belum ditambahkan.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative flex py-10 items-center justify-center mb-10">
                <div class="grow border-t border-gray-200"></div>
                <span class="shrink-0 px-6 text-gray-800 font-extrabold tracking-widest uppercase text-xl md:text-2xl">
                    Staff & Tata Usaha
                </span>
                <div class="grow border-t border-gray-200"></div>
            </div>

            <div class="flex flex-wrap justify-center gap-6">
                <?php if (!empty($staff)): ?>
                    <?php foreach ($staff as $guru) : ?>
                        <div class="w-[calc(50%-12px)] md:w-[calc(25%-18px)] lg:w-[calc(16.66%-20px)] bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow cursor-pointer overflow-hidden border border-gray-100 group shrink-0"
                            @click='openModal(<?= htmlspecialchars(json_encode([
                                                    "nama" => $guru["nama"],
                                                    "jabatan" => $guru["jabatan"],
                                                    "foto" => !empty($guru["foto"]) ? base_url("uploads/guru/" . $guru["foto"]) : "https://ui-avatars.com/api/?name=" . urlencode($guru["nama"]) . "&background=random",
                                                    "pendidikan" => $guru["pendidikan"] ?? "-",
                                                    "sambutan" => $guru["sambutan"] ?? "Belum ada informasi sambutan/tentang saya.",
                                                    "bergabung" => $guru["tahun_bergabung"] ?? "-",
                                                    "facebook" => $guru["facebook"] ?? "",
                                                    "instagram" => $guru["instagram"] ?? "",
                                                    "linkedin" => $guru["linkedin"] ?? "",
                                                    "youtube" => $guru["youtube"] ?? "",
                                                    "tiktok" => $guru["tiktok"] ?? "",
                                                    "cv" => !empty($guru["cv_file"]) ? base_url("uploads/cv/" . $guru["cv_file"]) : ""
                                                ]), ENT_QUOTES, "UTF-8") ?>)'>

                            <div class="aspect-3/4 bg-gray-100 relative overflow-hidden">
                                <img src="<?= !empty($guru['foto']) ? base_url('uploads/guru/' . $guru['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($guru['nama']) . '&background=random' ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-4 text-center">
                                <h3 class="font-bold text-gray-800 text-sm md:text-base line-clamp-2"><?= esc($guru['nama']) ?></h3>
                                <p class="text-xs text-[#00A859] font-semibold mt-1"><?= esc($guru['jabatan']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="w-full text-center text-gray-400">Data Staff & Tata Usaha belum ditambahkan.</p>
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

            <button @click="closeModal()" class="absolute top-6 right-6 z-60 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-red-500 hover:text-white transition shadow-sm">
                <i class="fas fa-times text-sm"></i>
            </button>

            <div class="w-full md:w-5/12 h-87.5 md:h-auto bg-gray-100 shrink-0">
                <template x-if="selected.foto">
                    <img :src="selected.foto" class="w-full h-full object-cover object-top" alt="Foto Profil">
                </template>
                <template x-if="!selected.foto">
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <i class="fas fa-image text-4xl"></i>
                    </div>
                </template>
            </div>

            <div class="w-full md:w-7/12 p-8 md:p-10 flex flex-col overflow-y-auto bg-white">

                <div class="mb-6 pr-6">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-3 leading-tight uppercase font-serif" x-text="selected.nama"></h2>
                    <span class="inline-block bg-green-900 text-white text-[11px] font-extrabold px-3 py-1.5 rounded uppercase tracking-wider shadow-sm" x-text="selected.jabatan"></span>
                </div>

                <div class="space-y-6 grow">
                    <div>
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-2">
                            <i class="fas fa-graduation-cap"></i> Pendidikan Terakhir
                        </h4>
                        <p class="text-gray-800 font-medium text-sm md:text-base" x-text="selected.pendidikan"></p>
                    </div>

                    <div>
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-2">
                            <i class="far fa-user"></i> Tentang Saya / Sambutan
                        </h4>
                        <p class="text-gray-600 text-sm leading-relaxed text-justify" x-text="selected.sambutan"></p>
                    </div>

                    <div x-show="selected.facebook || selected.instagram || selected.linkedin || selected.youtube || selected.tiktok">
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Media Sosial</h4>
                        <div class="flex flex-wrap gap-2">
                            <template x-if="selected.facebook"><a :href="selected.facebook" target="_blank" class="w-9 h-9 rounded-full bg-green-700 text-white flex items-center justify-center hover:bg-green-900 hover:text-green-50 transition"><i class="fab fa-facebook-f"></i></a></template>
                            <template x-if="selected.instagram"><a :href="selected.instagram" target="_blank" class="w-9 h-9 rounded-full bg-green-700 text-white flex items-center justify-center hover:bg-green-900 hover:text-green-50 transition"><i class="fab fa-instagram"></i></a></template>
                            <template x-if="selected.youtube"><a :href="selected.youtube" target="_blank" class="w-9 h-9 rounded-full bg-green-700 text-white flex items-center justify-center hover:bg-green-900 hover:text-green-50 transition"><i class="fab fa-youtube"></i></a></template>
                            <template x-if="selected.tiktok"><a :href="selected.tiktok" target="_blank" class="w-9 h-9 rounded-full bg-green-700 text-white flex items-center justify-center hover:bg-green-900 hover:text-green-50 transition"><i class="fab fa-tiktok"></i></a></template>
                            <template x-if="selected.linkedin"><a :href="selected.linkedin" target="_blank" class="w-9 h-9 rounded-full bg-green-700 text-white flex items-center justify-center hover:bg-green-900 hover:text-green-50 transition"><i class="fab fa-linkedin-in"></i></a></template>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 shrink-0">
                    <p class="text-xs text-gray-400 font-medium hidden sm:block">Informasi resmi dari sekolah</p>

                    <template x-if="selected.cv">
                        <a :href="selected.cv" target="_blank" class="w-full sm:w-auto text-white text-sm font-bold py-2.5 px-6 rounded-lg hover:opacity-90 transition flex items-center justify-center gap-2 shadow-md bg-green-800">
                            <i class="fas fa-download"></i> Lihat CV / Portfolio
                        </a>
                    </template>
                    <template x-if="!selected.cv">
                        <p class="w-full sm:w-auto text-xs text-gray-400 font-medium sm:hidden">Informasi resmi dari sekolah</p>
                    </template>
                </div>

            </div>
        </div>
    </div>

</div>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('guruData', () => ({
            modalOpen: false,
            selected: {},
            openModal(data) {
                this.selected = data;
                this.modalOpen = true;
                document.body.style.overflow = 'hidden'; // Kunci scroll halaman belakang
            },
            closeModal() {
                this.modalOpen = false;
                document.body.style.overflow = ''; // Buka kembali scroll halaman belakang
            }
        }))
    })
</script>

<?= $this->endSection() ?>
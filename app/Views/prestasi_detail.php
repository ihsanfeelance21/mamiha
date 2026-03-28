<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="bg-gray-50 py-12 min-h-screen">
    <div class="container mx-auto px-4 max-w-5xl">

        <a href="<?= base_url('prestasi') ?>" class="inline-flex items-center text-gray-500 hover:text-[#00A859] font-semibold mb-6 transition-colors bg-white px-5 py-2.5 rounded-full shadow-sm border border-gray-100">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Prestasi
        </a>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-10">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

                <div class="lg:col-span-5">
                    <?php if (!empty($prestasi['gambar'])) : ?>
                        <div class="w-full aspect-3/4 bg-gray-100 rounded-2xl overflow-hidden relative group shadow-md border border-gray-100">
                            <img src="<?= base_url('uploads/prestasi/' . $prestasi['gambar']) ?>" alt="<?= esc($prestasi['judul']) ?>" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-linear-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                    <?php else : ?>
                        <div class="w-full aspect-3/4 rounded-2xl bg-linear-to-b from-[#00A859] to-[#0B4A2D] flex flex-col items-center justify-center shadow-md border border-green-800">
                            <i class="fa-solid fa-trophy text-7xl text-white opacity-40 mb-4"></i>
                            <span class="text-green-100 font-medium">Tanpa Poster</span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="lg:col-span-7 flex flex-col justify-center">

                    <?php
                    $badgeClass = 'bg-gray-100 text-gray-600 border-gray-200';
                    if ($prestasi['kategori_prestasi'] == 'Siswa') $badgeClass = 'bg-blue-50 text-blue-700 border-blue-200';
                    if ($prestasi['kategori_prestasi'] == 'Guru') $badgeClass = 'bg-purple-50 text-purple-700 border-purple-200';
                    if ($prestasi['kategori_prestasi'] == 'Madrasah') $badgeClass = 'bg-green-50 text-green-700 border-green-200';
                    ?>
                    <div class="mb-4 inline-flex items-center border px-4 py-1.5 rounded-full text-xs font-bold w-max <?= $badgeClass ?>">
                        <i class="fa-solid fa-tag mr-2"></i> Prestasi <?= esc($prestasi['kategori_prestasi']) ?>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-6 leading-tight">
                        <?= esc($prestasi['judul']) ?>
                    </h1>

                    <div class="bg-linear-to-br from-green-50 to-emerald-50 rounded-2xl p-5 mb-6 flex items-center gap-4 border border-green-100 shadow-sm">
                        <div class="w-14 h-14 rounded-full bg-white shadow-sm flex items-center justify-center text-xl text-[#00A859] shrink-0">
                            <?php if ($prestasi['kategori_prestasi'] == 'Siswa') echo '<i class="fa-solid fa-user-graduate"></i>'; ?>
                            <?php if ($prestasi['kategori_prestasi'] == 'Guru') echo '<i class="fa-solid fa-chalkboard-user"></i>'; ?>
                            <?php if ($prestasi['kategori_prestasi'] == 'Madrasah') echo '<i class="fa-solid fa-school"></i>'; ?>
                        </div>
                        <div>
                            <p class="text-[11px] text-green-600 font-bold mb-0.5 uppercase tracking-wider">Peraih Penghargaan</p>
                            <h3 class="text-xl font-extrabold text-gray-800 leading-tight">
                                <?php
                                if ($prestasi['kategori_prestasi'] == 'Guru') echo esc($prestasi['nama_guru']);
                                elseif ($prestasi['kategori_prestasi'] == 'Madrasah') echo "MA Mabadi'ul Ihsan";
                                else echo esc($prestasi['nama_pemenang']);
                                ?>
                            </h3>
                            <?php if ($prestasi['kategori_prestasi'] == 'Siswa' && !empty($prestasi['kelas'])) : ?>
                                <p class="text-gray-600 mt-1 font-semibold bg-white inline-block px-2.5 py-0.5 rounded text-xs shadow-sm border border-gray-100">
                                    Kelas <?= esc($prestasi['kelas']) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-600 mb-2">
                        <div class="flex items-center p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                            <i class="fa-solid fa-calendar-days text-lg mr-3 text-[#00A859] w-5 text-center"></i>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Tahun</p>
                                <p class="font-bold text-gray-700"><?= esc($prestasi['tahun_perolehan']) ?></p>
                            </div>
                        </div>
                        <div class="flex items-center p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                            <i class="fa-solid fa-medal text-lg mr-3 text-yellow-500 w-5 text-center"></i>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Peringkat</p>
                                <p class="font-bold text-gray-700"><?= esc($prestasi['juara']) ?></p>
                            </div>
                        </div>
                        <div class="flex items-center p-3.5 bg-gray-50 rounded-xl border border-gray-100 sm:col-span-2">
                            <i class="fa-solid fa-flag-checkered text-lg mr-3 text-blue-500 w-5 text-center shrink-0"></i>
                            <div class="overflow-hidden">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Nama Lomba / Event</p>
                                <p class="font-bold text-gray-700" title="<?= esc($prestasi['nama_lomba']) ?>">
                                    <?= esc($prestasi['nama_lomba']) ?>
                                </p>
                            </div>
                        </div>

                        <?php if (!empty($prestasi['nama_penghargaan'])) : ?>
                            <div class="flex items-center p-3.5 bg-gray-50 rounded-xl border border-gray-100 sm:col-span-2 mt-2">
                                <i class="fa-solid fa-award text-lg mr-3 text-purple-500 w-5 text-center shrink-0"></i>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Nama Penghargaan Spesifik</p>
                                    <p class="font-bold text-gray-800"><?= esc($prestasi['nama_penghargaan']) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
            <div class="mt-10 pt-8 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-[#00A859]/10 flex items-center justify-center text-[#00A859]">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Detail & Kisah Prestasi</h3>
                </div>

                <div class="prose max-w-none text-gray-600 leading-relaxed text-base md:text-lg">
                    <?php if (!empty($prestasi['konten'])) : ?>
                        <div class="whitespace-pre-line text-justify">
                            <?= esc($prestasi['konten']) ?>
                        </div>
                    <?php else : ?>
                        <div class="p-6 bg-gray-50 border border-gray-200 rounded-2xl text-center text-gray-500">
                            <i class="fa-regular fa-folder-open text-3xl mb-3 text-gray-400"></i>
                            <p>Tidak ada deskripsi lebih detail mengenai kisah prestasi ini.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
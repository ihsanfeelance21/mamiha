<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="bg-gray-50 min-h-screen pb-12">

    <div class="w-full h-56 md:h-72 lg:h-80 relative overflow-hidden bg-gray-200">
        <a href="<?= base_url('alumni'); ?>" class="absolute top-6 left-4 md:left-8 bg-black/40 hover:bg-black/70 backdrop-blur-md text-white px-5 py-2.5 rounded-full shadow-lg transition-all text-sm font-bold flex items-center gap-2 z-20">
            <span>&larr;</span> Kembali ke Direktori
        </a>

        <?php if (!empty($kampus['gambar_gedung'])) : ?>
            <img src="<?= base_url('uploads/gedung/' . $kampus['gambar_gedung']); ?>" alt="Gedung <?= esc($kampus['nama_universitas']); ?>" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/10"></div>
        <?php else : ?>
            <div class="w-full h-full bg-linear-to-r from-green-700 via-green-800 to-green-900"></div>
            <div class="absolute inset-0 opacity-20 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4IiBoZWlnaHQ9IjgiPgo8cmVjdCB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjZmZmIiBmaWxsLW9wYWNpdHk9IjAuMSI+PC9yZWN0Pgo8cGF0aCBkPSJNMCAwTDggOFpNOCAwTDAgOFoiIHN0cm9rZT0iI2ZmZiIgc3Ryb2tlLXdpZHRoPSIxIiBzdHJva2Utb3BhY2l0eT0iMC4yIj48L3BhdGg+Cjwvc3ZnPg==')]"></div>
        <?php endif; ?>
    </div>

    <div class="container mx-auto px-4 max-w-6xl relative z-20">

        <div class="flex flex-col md:flex-row items-center md:items-start gap-5 md:gap-8 px-2 md:px-6 mb-12">

            <div class="-mt-20 md:-mt-24 h-40 w-40 md:h-48 md:w-48 bg-white rounded-2xl shadow-xl border-4 md:border-8 border-white flex items-center justify-center shrink-0 overflow-hidden relative z-30">
                <?php if ($kampus['logo']) : ?>
                    <img src="<?= base_url('uploads/universitas/' . $kampus['logo']); ?>" alt="<?= esc($kampus['nama_universitas']); ?>" class="max-h-full max-w-full object-contain p-2 hover:scale-105 transition-transform duration-300">
                <?php else : ?>
                    <span class="text-7xl">🏫</span>
                <?php endif; ?>
            </div>

            <div class="text-center md:text-left pt-4 md:pt-6 pb-2 w-full">
                <h1 class="text-3xl md:text-5xl font-extrabold text-gray-800 mb-2">
                    <?= esc($kampus['nama_universitas']); ?>
                </h1>
                <p class="text-gray-600 md:text-lg max-w-3xl">
                    Berikut adalah daftar alumni inspiratif yang saat ini sedang melanjutkan pendidikan atau meniti karir dari kampus ini.
                </p>
            </div>
        </div>

        <?php if (empty($alumni)) : ?>
            <div class="bg-white p-12 rounded-2xl shadow-sm border border-gray-100 text-center max-w-3xl mx-auto mt-10">
                <div class="text-6xl mb-5">📭</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Data Alumni</h3>
                <p class="text-gray-500 mb-8 text-lg">Saat ini belum ada data alumni yang terdaftar di <?= esc($kampus['nama_universitas']); ?>.</p>

                <a href="<?= base_url('alumni/daftar'); ?>" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 px-8 rounded-full shadow-md transition duration-300 transform hover:-translate-y-1">
                    <i class="fa-solid fa-pen-to-square"></i> Jadilah yang Pertama Terdaftar
                </a>
            </div>
        <?php else : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <?php foreach ($alumni as $a) : ?>
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col group">

                        <div class="p-6 flex items-center gap-4 border-b border-gray-50 relative bg-linear-to-r from-gray-50 to-white">
                            <?php if ($a['foto']) : ?>
                                <img src="<?= base_url('uploads/alumni/' . $a['foto']); ?>" alt="Foto <?= esc($a['nama_alumni']); ?>" class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-sm z-10 relative">
                            <?php else : ?>
                                <div class="w-16 h-16 rounded-full bg-linear-to-br from-green-500 to-green-700 text-white flex items-center justify-center text-2xl font-bold z-10 relative shadow-sm">
                                    <?= strtoupper(substr($a['nama_alumni'], 0, 1)); ?>
                                </div>
                            <?php endif; ?>

                            <div class="z-10 relative">
                                <h3 class="text-lg font-bold text-gray-800 leading-tight group-hover:text-green-600 transition-colors"><?= esc($a['nama_alumni']); ?></h3>
                                <span class="text-xs font-bold text-green-700 bg-green-100 px-2.5 py-1 rounded-md mt-1.5 inline-block">
                                    Lulusan <?= esc($a['tahun_lulus']); ?>
                                </span>
                            </div>
                        </div>

                        <div class="p-6 grow flex flex-col justify-between">
                            <div class="mb-4">
                                <p class="text-xs text-gray-400 uppercase tracking-wider font-bold mb-1">Pekerjaan / Jurusan</p>
                                <p class="text-gray-800 font-semibold flex items-start gap-2">
                                    <span class="mt-0.5 text-green-500"><i class="fa-solid fa-briefcase"></i></span>
                                    <span><?= esc($a['jurusan'] ?: '-'); ?></span>
                                </p>
                            </div>

                            <?php if (!empty($a['pesan_kesan'])) : ?>
                                <div class="bg-gray-50 p-4 rounded-xl relative mt-4 border border-gray-100">
                                    <span class="text-4xl text-gray-300 absolute -top-3 left-2 font-serif leading-none">"</span>
                                    <p class="text-gray-600 text-sm italic relative z-10 pl-3 pt-2 line-clamp-4">
                                        <?= esc($a['pesan_kesan']); ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="bg-[#0B4A2D] pt-32 pb-24 text-white relative">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative -mt-16 mb-20 z-10">
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">

        <?php if ($pengumuman['gambar']) : ?>
            <div class="w-full bg-gray-50 flex justify-center border-b border-gray-100">
                <img src="<?= base_url('uploads/pengumuman/' . $pengumuman['gambar']) ?>" alt="<?= esc($pengumuman['judul']) ?>" class="max-h-125 object-contain w-full">
            </div>
        <?php endif; ?>

        <div class="p-8 md:p-12">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <a href="<?= base_url('/pengumuman') ?>" class="inline-flex items-center gap-2 text-gray-500 hover:text-[#00A859] font-semibold transition-colors bg-gray-50 hover:bg-green-50 px-4 py-2 rounded-xl">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>

                <div class="flex flex-wrap items-center gap-3">
                    <span class="bg-green-700/10 text-green-900 px-3 py-1 rounded-lg text-sm font-bold border border-green-400/20 flex items-center gap-1.5 uppercase tracking-wide">
                        <i class="fa-solid fa-tag"></i> <?= esc($pengumuman['kategori']) ?>
                    </span>
                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-lg text-sm font-bold border border-gray-200 flex items-center gap-1.5">
                        <i class="fa-regular fa-calendar"></i> <?= date('d M Y', strtotime($pengumuman['tanggal_publish'])) ?>
                    </span>
                </div>
            </div>

            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 leading-tight mb-8">
                <?= esc($pengumuman['judul']) ?>
            </h1>

            <div class="prose max-w-none text-gray-600 leading-relaxed text-lg whitespace-pre-line text-justify mb-10">
                <?= esc($pengumuman['konten']) ?>
            </div>

            <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50 p-6 rounded-2xl shadow-inner border">
                <span class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-share-nodes text-[#00A859]"></i> Bagikan Informasi Ini:
                </span>
                <div class="flex gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= current_url() ?>" target="_blank" class="w-10 h-10 rounded-full bg-[#1877F2] text-white flex items-center justify-center hover:-translate-y-1 transition-transform shadow-md" title="Share ke Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?= current_url() ?>&text=<?= esc($pengumuman['judul']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-[#1DA1F2] text-white flex items-center justify-center hover:-translate-y-1 transition-transform shadow-md" title="Share ke Twitter (X)">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text=<?= esc($pengumuman['judul']) ?> - <?= current_url() ?>" target="_blank" class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:-translate-y-1 transition-transform shadow-md" title="Share ke WhatsApp">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
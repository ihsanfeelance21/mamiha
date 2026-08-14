<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="bg-gray-50 py-12 min-h-screen">
    <div class="container mx-auto px-4 max-w-4xl">

        <a href="<?= base_url('kegiatan') ?>" class="inline-flex items-center text-gray-500 hover:text-[#00A859] font-semibold mb-6 transition-colors bg-white px-5 py-2.5 rounded-full shadow-sm border border-gray-100">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Kegiatan
        </a>

        <article class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

            <?php if (!empty($kegiatan['gambar'])) : ?>
                <div class="relative h-72 md:h-96 w-full overflow-hidden">
                    <img src="<?= base_url('uploads/kegiatan/' . $kegiatan['gambar']) ?>" alt="<?= esc($kegiatan['judul']) ?>" class="w-full h-full object-cover">
                </div>
            <?php endif; ?>

            <div class="p-6 md:p-10">
                <div class="flex items-center gap-3 mb-4">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-green-50 text-[#00A859] border border-green-100 rounded-full text-xs font-bold">
                        <i class="fa-regular fa-calendar"></i> <?= date('d F Y', strtotime($kegiatan['created_at'])) ?>
                    </span>
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-6 leading-tight">
                    <?= esc($kegiatan['judul']) ?>
                </h1>

                <div class="prose max-w-none text-gray-600 leading-relaxed text-base md:text-lg whitespace-pre-line">
                    <?= esc($kegiatan['konten']) ?>
                </div>

                <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50 p-6 rounded-2xl shadow-inner">
                    <span class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-share-nodes text-[#00A859]"></i> Bagikan Kegiatan Ini:
                    </span>
                    <div class="flex gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= current_url() ?>" target="_blank" class="w-10 h-10 rounded-full bg-[#1877F2] text-white flex items-center justify-center hover:-translate-y-1 transition-transform shadow-md" title="Share ke Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?= current_url() ?>&text=<?= esc($kegiatan['judul']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-[#1DA1F2] text-white flex items-center justify-center hover:-translate-y-1 transition-transform shadow-md" title="Share ke Twitter (X)">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text=<?= esc($kegiatan['judul']) ?> - <?= current_url() ?>" target="_blank" class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:-translate-y-1 transition-transform shadow-md" title="Share ke WhatsApp">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </article>
    </div>
</div>

<?= $this->endSection() ?>

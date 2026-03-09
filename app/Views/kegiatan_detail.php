<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<article class="py-12 md:py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <a href="<?= base_url() ?>" class="inline-flex items-center text-primary hover:text-primary-hover mb-8 font-medium transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Beranda
        </a>

        <header class="mb-10 text-center">
            <p class="text-primary font-semibold mb-3">
                Dipublikasikan pada <?= date('d F Y', strtotime($kegiatan['created_at'])) ?>
            </p>
            <h1 class="text-3xl md:text-5xl font-extrabold text-text-main leading-tight mb-6">
                <?= $kegiatan['judul'] ?>
            </h1>
        </header>

        <?php if ($kegiatan['gambar']) : ?>
            <div class="mb-12 rounded-2xl overflow-hidden shadow-lg border border-gray-100">
                <img src="<?= base_url('uploads/kegiatan/' . $kegiatan['gambar']) ?>" alt="<?= $kegiatan['judul'] ?>" class="w-full h-auto object-cover max-h-125">
            </div>
        <?php endif; ?>

        <div class="text-lg text-gray-700 leading-relaxed space-y-6 text-justify">
            <?= nl2br($kegiatan['konten']) ?>
        </div>

    </div>
</article>
<?= $this->endSection() ?>
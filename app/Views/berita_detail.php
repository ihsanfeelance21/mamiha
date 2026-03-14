<?= $this->extend('layouts/main') ?>

<?= $this->section('meta') ?>
<meta name="description" content="<?= esc($meta_description ?? '') ?>">
<meta name="author" content="Admin MA Mabadi'ul Ihsan">

<meta property="og:type" content="article">
<meta property="og:title" content="<?= esc($og_title ?? '') ?>">
<meta property="og:description" content="<?= esc($og_description ?? '') ?>">
<meta property="og:image" content="<?= esc($og_image ?? '') ?>">
<meta property="og:url" content="<?= esc($og_url ?? '') ?>">
<meta property="og:site_name" content="MA Mabadi'ul Ihsan">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= esc($og_title ?? '') ?>">
<meta name="twitter:description" content="<?= esc($og_description ?? '') ?>">
<meta name="twitter:image" content="<?= esc($og_image ?? '') ?>">
<?= $this->endSection() ?>


<?= $this->section('content') ?>

<?php
// Tentukan layout berdasarkan pilihan admin dari database
$layoutMode = $berita['layout'] ?? 'block';
$imageUrl = base_url('uploads/berita/' . $berita['gambar']);
?>

<?php if ($layoutMode == 'immersive') : ?>
    <section class="relative w-full h-[60vh] min-h-[500px] flex items-end justify-center mb-12">
        <img src="<?= $imageUrl ?>" alt="<?= esc($berita['judul']) ?>" class="absolute inset-0 w-full h-full object-cover z-0">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent z-10"></div>

        <div class="relative z-20 max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 pb-16 text-center text-white">
            <span class="inline-block py-1 px-3 rounded-full bg-[#00A859] text-xs font-bold uppercase tracking-wider mb-4 shadow-sm">
                <?= esc($berita['nama_kategori'] ?? 'Berita Umum') ?>
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6 drop-shadow-lg">
                <?= esc($berita['judul']) ?>
            </h1>
            <div class="flex items-center justify-center gap-6 text-sm font-medium text-gray-200">
                <span><i class="fa-regular fa-calendar mr-2"></i> <?= date('d F Y', strtotime($berita['created_at'])) ?></span>
                <span><i class="fa-regular fa-user mr-2"></i> Admin Madrasah</span>
            </div>
        </div>
    </section>

<?php elseif ($layoutMode == 'split') : ?>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-10">
        <div class="flex flex-col lg:flex-row gap-10 items-center bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 p-6 lg:p-10 mb-8">
            <div class="w-full lg:w-1/2">
                <div class="aspect-video w-full rounded-2xl overflow-hidden shadow-inner">
                    <img src="<?= $imageUrl ?>" alt="<?= esc($berita['judul']) ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                </div>
            </div>
            <div class="w-full lg:w-1/2 flex flex-col justify-center">
                <span class="inline-block py-1 px-3 rounded-full bg-green-100 text-[#00A859] text-xs font-bold uppercase tracking-wider mb-4 w-max">
                    <?= esc($berita['nama_kategori'] ?? 'Berita Umum') ?>
                </span>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-[#0B4A2D] leading-tight mb-6">
                    <?= esc($berita['judul']) ?>
                </h1>
                <div class="flex items-center gap-6 text-sm font-medium text-gray-500 border-t border-gray-100 pt-6 mt-2">
                    <span class="flex items-center gap-2"><i class="fa-regular fa-calendar text-[#00A859]"></i> <?= date('d M Y', strtotime($berita['created_at'])) ?></span>
                    <span class="flex items-center gap-2"><i class="fa-regular fa-user text-[#00A859]"></i> Admin</span>
                </div>
            </div>
        </div>
    </section>

<?php else : ?>
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-8 text-center">
        <span class="inline-block py-1 px-3 rounded-full bg-green-100 text-[#00A859] text-xs font-bold uppercase tracking-wider mb-4">
            <?= esc($berita['nama_kategori'] ?? 'Berita Umum') ?>
        </span>
        <h1 class="text-3xl md:text-5xl font-extrabold text-[#0B4A2D] leading-tight mb-6">
            <?= esc($berita['judul']) ?>
        </h1>
        <div class="flex items-center justify-center gap-6 text-sm font-medium text-gray-500 mb-10">
            <span class="flex items-center gap-2"><i class="fa-regular fa-calendar text-[#00A859]"></i> <?= date('d M Y', strtotime($berita['created_at'])) ?></span>
            <span class="flex items-center gap-2"><i class="fa-regular fa-user text-[#00A859]"></i> Admin</span>
        </div>
        <div class="aspect-video w-full rounded-3xl overflow-hidden shadow-lg mb-8 bg-gray-100">
            <img src="<?= $imageUrl ?>" alt="<?= esc($berita['judul']) ?>" class="w-full h-full object-cover">
        </div>
    </section>
<?php endif; ?>


<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
    <div class="bg-white p-6 md:p-12 rounded-3xl shadow-sm border border-gray-100 relative top-[-2rem] z-30">

        <article class="prose prose-lg max-w-none text-gray-600 leading-loose
                [&>p]:mb-6 [&>p]:text-justify 
                [&>h2]:text-2xl [&>h2]:font-bold [&>h2]:text-[#0B4A2D] [&>h2]:mb-4 [&>h2]:mt-8
                [&>h3]:text-xl [&>h3]:font-bold [&>h3]:text-gray-800 [&>h3]:mb-3 [&>h3]:mt-6
                [&>ul]:list-disc [&>ul]:ml-6 [&>ul]:mb-6
                [&>ol]:list-decimal [&>ol]:ml-6 [&>ol]:mb-6
                [&>img]:rounded-2xl [&>img]:my-8 [&>img]:mx-auto [&>img]:shadow-md [&>img]:border [&>img]:border-gray-100
                [&>a]:text-[#00A859] [&>a]:underline [&>a:hover]:text-[#0B4A2D] [&>a]:font-medium
                [&>blockquote]:border-l-4 [&>blockquote]:border-[#00A859] [&>blockquote]:pl-5 [&>blockquote]:italic [&>blockquote]:text-gray-500 [&>blockquote]:bg-gray-50 [&>blockquote]:py-3 [&>blockquote]:pr-4 [&>blockquote]:rounded-r-lg [&>blockquote]:my-6">

            <?= $berita['konten'] ?>

        </article>

        <div class="mt-14 pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50 p-6 rounded-2xl">
            <span class="font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-share-nodes text-[#00A859]"></i> Bagikan Berita:
            </span>
            <div class="flex gap-3">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= current_url() ?>" target="_blank" class="w-10 h-10 rounded-full bg-[#1877F2] text-white flex items-center justify-center hover:-translate-y-1 transition-transform shadow-md" title="Share ke Facebook">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?= current_url() ?>&text=<?= esc($berita['judul']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-[#1DA1F2] text-white flex items-center justify-center hover:-translate-y-1 transition-transform shadow-md" title="Share ke Twitter">
                    <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="https://api.whatsapp.com/send?text=<?= esc($berita['judul']) ?> - <?= current_url() ?>" target="_blank" class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:-translate-y-1 transition-transform shadow-md" title="Share ke WhatsApp">
                    <i class="fa-brands fa-whatsapp flex"></i>
                </a>
            </div>
        </div>

    </div>
</section>

<?= $this->endSection() ?>
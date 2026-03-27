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
// Tentukan layout berdasarkan pilihan admin dari database (default: modern)
$layoutMode = $berita['layout'] ?? 'modern';
$imageUrl = base_url('uploads/berita/' . $berita['gambar']);
?>

<section class="<?= ($layoutMode == 'legacy') ? 'max-w-6xl' : 'max-w-4xl' ?> mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-8 text-center transition-all duration-300">
    <span class="inline-block py-1 px-3 rounded-full bg-green-100 text-[#00A859] text-xs font-bold uppercase tracking-wider mb-4">
        <?= esc($berita['nama_kategori'] ?? 'Berita Umum') ?>
    </span>

    <h1 class="<?= ($layoutMode == 'legacy') ? 'text-4xl md:text-5xl lg:text-6xl' : 'text-3xl md:text-5xl' ?> font-extrabold text-[#0B4A2D] leading-tight mb-6">
        <?= esc($berita['judul']) ?>
    </h1>

    <div class="flex items-center justify-center gap-6 text-sm font-medium text-gray-500 mb-10">
        <span class="flex items-center gap-2">
            <i class="fa-regular fa-calendar text-[#00A859]"></i>
            <?= date('d M Y', strtotime($berita['waktu_tayang'] ?? $berita['created_at'])) ?>
        </span>
        <span class="flex items-center gap-2">
            <i class="fa-regular fa-user text-[#00A859]"></i> Admin
        </span>
    </div>

    <?php if ($layoutMode == 'modern') : ?>
        <div class="aspect-video w-full rounded-3xl overflow-hidden shadow-lg mb-8 bg-gray-100">
            <img src="<?= $imageUrl ?>" alt="<?= esc($berita['judul']) ?>" class="w-full h-full object-cover">
        </div>
    <?php endif; ?>
</section>

<section class="<?= ($layoutMode == 'legacy') ? 'max-w-6xl' : 'max-w-4xl' ?> mx-auto px-4 sm:px-6 lg:px-8 pb-24 transition-all duration-300">
    <div class="bg-white p-6 md:p-10 lg:p-12 rounded-3xl shadow-sm border border-gray-100 relative <?= ($layoutMode == 'modern') ? 'top-[-2rem]' : '' ?> z-30">

        <?php if ($layoutMode == 'legacy') : ?>
            <div class="flex flex-col lg:flex-row gap-10 lg:gap-14">

                <div class="w-full lg:w-5/12 shrink-0">
                    <div class="sticky top-28">
                        <img src="<?= $imageUrl ?>" alt="<?= esc($berita['judul']) ?>" class="w-full h-auto aspect-4/5 object-cover rounded-2xl shadow-md border border-gray-100">
                    </div>
                </div>

                <div class="w-full lg:w-7/12">
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
                </div>
            </div>

        <?php else : ?>
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
        <?php endif; ?>

        <?php if (!empty($tags)) : ?>
            <div class="mt-12 pt-6 flex flex-wrap items-center gap-2 border-t border-gray-100">
                <span class="text-sm font-bold text-gray-700 mr-2 flex items-center">
                    <i class="fa-solid fa-tags text-[#00A859] mr-2"></i> Tags:
                </span>
                <?php foreach ($tags as $t) : ?>
                    <?php if ($t['link_eksternal']): ?>
                        <a href="<?= $t['link_eksternal'] ?>" target="_blank" class="bg-gray-50 hover:bg-green-50 text-gray-600 hover:text-[#00A859] px-4 py-1.5 rounded-full text-xs font-bold transition border border-gray-200 shadow-sm">
                            #<?= esc($t['nama_tag']) ?>
                        </a>
                    <?php else: ?>
                        <span class="bg-gray-50 text-gray-600 px-4 py-1.5 rounded-full text-xs font-bold border border-gray-200 shadow-sm">
                            #<?= esc($t['nama_tag']) ?>
                        </span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="mt-8 pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 bg-gray-50 p-6 rounded-2xl shadow-inner border">
            <span class="font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-share-nodes text-[#00A859]"></i> Bagikan Berita Ini:
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
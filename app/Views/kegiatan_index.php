<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="pt-32 pb-12 bg-[#0B4A2D] text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/20 shadow-sm rounded-full mb-4 backdrop-blur-sm">
            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
            <span class="text-sm font-bold text-green-400 tracking-widest uppercase">Aktivitas Kami</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Kegiatan Sekolah</h1>
        <p class="text-lg text-green-100 max-w-2xl mx-auto">
            Dokumentasi beragam kegiatan, agenda, dan momen berharga di lingkungan MA Mabadi'ul Ihsan.
        </p>
    </div>
</section>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mb-12">

            <?php if (!empty($kegiatan)) : ?>
                <?php foreach ($kegiatan as $item) : ?>
                    <article class="group bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col">
                        <?php if (!empty($item['gambar'])) : ?>
                            <a href="<?= base_url('kegiatan/' . $item['slug']) ?>" class="relative block h-56 overflow-hidden">
                                <img src="<?= base_url('uploads/kegiatan/' . $item['gambar']) ?>" alt="<?= esc($item['judul']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            </a>
                        <?php else : ?>
                            <div class="h-56 bg-linear-to-br from-[#00A859] to-[#0B4A2D] flex items-center justify-center text-white">
                                <i class="fa-solid fa-calendar-days text-5xl opacity-40"></i>
                            </div>
                        <?php endif; ?>

                        <div class="p-6 flex flex-col grow">
                            <h3 class="text-lg font-extrabold text-gray-800 leading-snug mb-3 line-clamp-2">
                                <a href="<?= base_url('kegiatan/' . $item['slug']) ?>" class="hover:text-[#00A859] transition-colors">
                                    <?= esc($item['judul']) ?>
                                </a>
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed mb-5 line-clamp-3">
                                <?= esc(mb_substr(strip_tags($item['konten']), 0, 140)) ?>...
                            </p>
                            <div class="pt-4 border-t border-gray-100 flex items-center justify-between mt-auto">
                                <span class="text-xs text-gray-400 font-medium flex items-center gap-2">
                                    <i class="fa-regular fa-clock text-[#00A859]"></i>
                                    <?= date('d M Y', strtotime($item['created_at'])) ?>
                                </span>
                                <a href="<?= base_url('kegiatan/' . $item['slug']) ?>" class="text-[#00A859] text-sm font-bold hover:underline flex items-center gap-1">
                                    Selengkapnya <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm">
                    <i class="fa-solid fa-calendar-xmark text-4xl text-gray-300 mb-4 block"></i>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Data Kegiatan</h3>
                    <p class="text-gray-500">Maaf, dokumentasi kegiatan belum tersedia.</p>
                </div>
            <?php endif; ?>

        </div>

        <?php if (isset($pager) && $pager) : ?>
            <div class="flex justify-center mt-8">
                <div class="[&>ul]:flex [&>ul]:gap-2 [&>ul>li>a]:px-4 [&>ul>li>a]:py-2 [&>ul>li>a]:bg-white [&>ul>li>a]:border [&>ul>li>a]:border-gray-200 [&>ul>li>a]:rounded-lg [&>ul>li>a:hover]:bg-gray-50 [&>ul>li.active>a]:bg-[#00A859] [&>ul>li.active>a]:text-white [&>ul>li.active>a]:border-[#00A859] [&>ul>li>span]:px-4 [&>ul>li>span]:py-2 [&>ul>li>span]:bg-[#00A859] [&>ul>li>span]:text-white [&>ul>li>span]:rounded-lg">
                    <?= $pager->links('kegiatan') ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>

<?= $this->endSection() ?>

<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <div>
        <h3 class="text-2xl font-bold text-gray-800">Daftar Berita Sekolah</h3>
        <p class="text-sm text-gray-500 mt-1">Kelola semua publikasi berita, pengumuman, dan artikel.</p>
    </div>
    <div class="flex gap-2">
        <a href="<?= base_url('admin/berita/kategori') ?>" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl border border-gray-200 font-medium shadow-sm text-sm flex items-center gap-2">
            <i class="fa-solid fa-tags"></i> Kelola Kategori
        </a>
        <a href="<?= base_url('admin/berita/tambah') ?>" class="bg-[#00A859] hover:bg-[#0B4A2D] text-white px-5 py-2.5 rounded-xl font-bold shadow-sm text-sm flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tulis Berita
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="bg-green-50 border-l-4 border-[#00A859] text-green-700 p-4 mb-6 rounded-xl flex items-center gap-3">
        <i class="fa-solid fa-circle-check"></i>
        <p class="text-sm font-medium"><?= esc(session()->getFlashdata('pesan')) ?></p>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-xl">
        <?php $err = session()->getFlashdata('error'); ?>
        <?php if (is_array($err)) : ?>
            <ul class="list-disc list-inside text-sm"><?php foreach ($err as $e) : ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
        <?php else : ?>
            <p class="text-sm font-medium"><?= esc($err) ?></p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-4 flex flex-col lg:flex-row gap-3 justify-between">
    <form method="get" class="flex flex-col sm:flex-row gap-2 flex-1">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fa-solid fa-magnifying-glass text-sm"></i></span>
            <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari judul/kategori..." class="w-full pl-9 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 text-sm">
        </div>
        <select name="kategori" class="px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm">
            <option value="">Semua Kategori</option>
            <?php foreach ($kategoriList as $k) : ?>
                <option value="<?= $k['id'] ?>" <?= ($kategoriAktif ?? '') == $k['id'] ? 'selected' : '' ?>><?= esc($k['nama_kategori']) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="status" class="px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm">
            <option value="">Semua Status</option>
            <option value="terbit" <?= ($statusAktif ?? '') == 'terbit' ? 'selected' : '' ?>>Terbit</option>
            <option value="draft" <?= ($statusAktif ?? '') == 'draft' ? 'selected' : '' ?>>Draft</option>
            <option value="terjadwal" <?= ($statusAktif ?? '') == 'terjadwal' ? 'selected' : '' ?>>Terjadwal</option>
        </select>
        <button type="submit" class="bg-gray-800 hover:bg-black text-white px-5 rounded-xl text-sm font-bold">Cari</button>
        <?php if (!empty($keyword) || !empty($statusAktif) || !empty($kategoriAktif)) : ?>
            <a href="<?= base_url('admin/berita') ?>" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-100 px-4 py-2.5 rounded-xl text-sm font-bold flex items-center justify-center"><i class="fa-solid fa-rotate-left"></i></a>
        <?php endif; ?>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-[11px] uppercase font-bold tracking-wider border-b border-gray-100">
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Thumbnail</th>
                    <th class="px-4 py-3">Judul Berita</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Status & Waktu</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php if (empty($berita)) : ?>
                    <tr>
                        <td colspan="6" class="p-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fa-regular fa-newspaper text-5xl text-gray-300 mb-3"></i>
                                <p class="text-gray-800 font-bold">Belum ada berita</p>
                                <p class="text-sm text-gray-500">Belum ada berita yang ditulis atau filter tidak cocok.</p>
                            </div>
                        </td>
                    </tr>
                <?php else : ?>
                    <?php $i = 1 + (isset($pager) ? ($pager->getCurrentPage('berita') - 1) * 15 : 0); foreach ($berita as $b) : ?>
                        <tr class="hover:bg-green-50/30 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-500"><?= $i++ ?></td>
                            <td class="px-4 py-3">
                                <?php if ($b['gambar']) : ?>
                                    <img src="<?= base_url('uploads/berita/' . $b['gambar']) ?>" alt="Thumb" class="w-20 h-14 object-cover rounded-lg shadow-sm border border-gray-200" loading="lazy">
                                <?php else : ?>
                                    <div class="w-20 h-14 bg-gray-100 rounded-lg flex flex-col items-center justify-center border">
                                        <i class="fa-regular fa-image text-gray-400"></i><span class="text-[9px] text-gray-400">No Image</span>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 max-w-xs">
                                <p class="font-semibold text-gray-800 line-clamp-1" title="<?= esc($b['judul']) ?>"><?= esc($b['judul']) ?></p>
                                <p class="text-xs text-gray-400 mt-1">Layout: <span class="uppercase font-bold text-gray-500"><?= esc($b['layout']) ?></span></p>
                            </td>
                            <td class="px-4 py-3">
                                <span class="bg-blue-50 text-blue-600 text-xs px-2.5 py-1 rounded-full font-bold border border-blue-100">
                                    <?= esc($b['nama_kategori'] ?? 'Tanpa Kategori') ?>
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <?php if ($b['status'] == 'terbit') : ?>
                                    <span class="bg-green-100 text-green-700 text-[11px] px-2.5 py-1 rounded-full font-bold border border-green-200">Terbit</span>
                                    <div class="text-xs text-gray-500 mt-1"><?= date('d M Y, H:i', strtotime($b['waktu_tayang'] ?? $b['created_at'])) ?></div>
                                <?php elseif ($b['status'] == 'draft') : ?>
                                    <span class="bg-gray-100 text-gray-600 text-[11px] px-2.5 py-1 rounded-full font-bold border">Draft</span>
                                    <div class="text-xs text-gray-400 mt-1"><?= date('d M Y', strtotime($b['created_at'])) ?></div>
                                <?php else : ?>
                                    <span class="bg-purple-100 text-purple-700 text-[11px] px-2.5 py-1 rounded-full font-bold border border-purple-200">Terjadwal</span>
                                    <div class="text-xs text-purple-600 mt-1 font-medium"><?= date('d M Y, H:i', strtotime($b['waktu_tayang'])) ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= base_url('berita/baca/' . $b['slug']) ?>" target="_blank" class="w-8 h-8 flex items-center justify-center bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-800 hover:text-white transition" title="Lihat"><i class="fa-solid fa-eye text-xs"></i></a>
                                    <a href="<?= base_url('admin/berita/edit/' . $b['id']) ?>" class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition" title="Edit"><i class="fa-solid fa-pen text-xs"></i></a>
                                    <form action="<?= base_url('admin/berita/hapus/' . $b['id']) ?>" method="post" onsubmit="return confirm('Hapus berita ini permanen?')" style="display:inline"><?= csrf_field() ?><button type="submit" class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition" title="Hapus"><i class="fa-solid fa-trash text-xs"></i></button></form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (isset($pager)) : ?>
        <div class="p-4 border-t border-gray-100 flex justify-center">
            <div class="[&>ul]:flex [&>ul]:gap-2 [&>ul>li>a]:px-3 [&>ul>li>a]:py-1.5 [&>ul>li>a]:bg-white [&>ul>li>a]:border [&>ul>li>a]:rounded-lg [&>ul>li.active>a]:bg-[#00A859] [&>ul>li.active>a]:text-white [&>ul>li.active>a]:border-[#00A859]">
                <?= $pager->links('berita') ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

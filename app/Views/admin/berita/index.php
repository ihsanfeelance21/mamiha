<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="bg-green-100 border-l-4 border-primary text-green-700 p-4 mb-4 rounded shadow-sm">
        <?= session()->getFlashdata('pesan') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h3 class="text-xl font-bold text-text-main">Daftar Berita Sekolah</h3>
            <p class="text-sm text-gray-500 mt-1">Kelola semua publikasi berita, pengumuman, dan artikel.</p>
        </div>
        <div class="flex gap-2">
            <a href="<?= base_url('admin/berita/kategori') ?>" class="bg-surface hover:bg-gray-200 text-text-main px-4 py-2 rounded transition font-medium border border-gray-300 shadow-sm text-sm flex items-center">
                Kelola Kategori
            </a>
            <a href="<?= base_url('admin/berita/tambah') ?>" class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded transition font-medium shadow-sm text-sm flex items-center">
                + Tulis Berita
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface border-b border-gray-200">
                    <th class="p-3 text-text-muted font-semibold text-sm">No</th>
                    <th class="p-3 text-text-muted font-semibold text-sm">Thumbnail</th>
                    <th class="p-3 text-text-muted font-semibold text-sm">Judul Berita</th>
                    <th class="p-3 text-text-muted font-semibold text-sm">Kategori</th>
                    <th class="p-3 text-text-muted font-semibold text-sm">Status & Waktu</th>
                    <th class="p-3 text-text-muted font-semibold text-sm text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($berita)) : ?>
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400 italic border-b border-gray-100">Belum ada berita yang ditulis.</td>
                    </tr>
                <?php else : ?>
                    <?php $i = 1;
                    foreach ($berita as $b) : ?>
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="p-3 text-sm text-gray-600"><?= $i++ ?></td>

                            <td class="p-3">
                                <?php if ($b['gambar']) : ?>
                                    <img src="<?= base_url('uploads/berita/' . $b['gambar']) ?>" alt="Thumbnail" class="w-20 h-14 object-cover rounded shadow-sm border border-gray-200">
                                <?php else : ?>
                                    <div class="w-20 h-14 bg-gray-100 rounded flex items-center justify-center text-[10px] text-gray-400 border border-gray-200">No Image</div>
                                <?php endif; ?>
                            </td>

                            <td class="p-3 font-medium text-text-main leading-tight max-w-xs">
                                <div class="truncate" title="<?= $b['judul'] ?>"><?= $b['judul'] ?></div>
                                <div class="text-xs text-gray-400 mt-1 font-normal">
                                    Layout: <span class="uppercase font-semibold text-gray-500"><?= $b['layout'] ?></span>
                                </div>
                            </td>

                            <td class="p-3">
                                <span class="bg-blue-50 text-blue-600 text-xs px-2.5 py-1 rounded font-medium border border-blue-100">
                                    <?= $b['nama_kategori'] ?? 'Tanpa Kategori' ?>
                                </span>
                            </td>

                            <td class="p-3">
                                <?php if ($b['status'] == 'terbit') : ?>
                                    <span class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded font-bold border border-green-200">Terbit</span>
                                    <div class="text-xs text-gray-500 mt-1.5"><?= date('d M Y, H:i', strtotime($b['waktu_tayang'] ?? $b['created_at'])) ?></div>

                                <?php elseif ($b['status'] == 'draft') : ?>
                                    <span class="bg-gray-100 text-gray-700 text-xs px-2.5 py-1 rounded font-bold border border-gray-300">Draft</span>
                                    <div class="text-xs text-gray-400 mt-1.5">Disimpan: <?= date('d M Y', strtotime($b['created_at'])) ?></div>

                                <?php elseif ($b['status'] == 'terjadwal') : ?>
                                    <span class="bg-purple-100 text-purple-700 text-xs px-2.5 py-1 rounded font-bold border border-purple-200">Terjadwal</span>
                                    <div class="text-xs text-purple-600 mt-1.5 font-medium">
                                        <?= date('d M Y, H:i', strtotime($b['waktu_tayang'])) ?>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td class="p-3 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="<?= base_url('admin/berita/edit/' . $b['id']) ?>" class="text-blue-500 hover:text-blue-700 text-sm font-medium transition">Edit</a>
                                    <span class="text-gray-300">|</span>
                                    <a href="<?= base_url('admin/berita/hapus/' . $b['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini secara permanen?')" class="text-red-500 hover:text-red-700 text-sm font-medium transition">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
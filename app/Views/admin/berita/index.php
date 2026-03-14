<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="bg-green-100 border-l-4 border-primary text-green-700 p-4 mb-4 rounded shadow-sm">
        <?= session()->getFlashdata('pesan') ?>
    </div>
<?php endif; ?>

<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h3 class="text-xl font-bold text-text-main">Daftar Berita Sekolah</h3>
        </div>
        <div class="flex gap-2">
            <a href="<?= base_url('admin/kategori-berita') ?>" class="bg-surface hover:bg-gray-200 text-text-main px-4 py-2 rounded transition font-medium border border-gray-300">
                Kelola Kategori
            </a>
            <a href="<?= base_url('admin/berita/tambah') ?>" class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded transition font-medium shadow-sm">
                + Tulis Berita
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface border-b border-gray-200">
                    <th class="p-3 text-text-muted font-semibold">No</th>
                    <th class="p-3 text-text-muted font-semibold">Thumbnail</th>
                    <th class="p-3 text-text-muted font-semibold">Judul Berita</th>
                    <th class="p-3 text-text-muted font-semibold">Kategori</th>
                    <th class="p-3 text-text-muted font-semibold">Tanggal</th>
                    <th class="p-3 text-text-muted font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($berita)) : ?>
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400 italic">Belum ada berita.</td>
                    </tr>
                <?php else : ?>
                    <?php $i = 1;
                    foreach ($berita as $b) : ?>
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="p-3"><?= $i++ ?></td>
                            <td class="p-3">
                                <?php if ($b['gambar']) : ?>
                                    <img src="<?= base_url('uploads/berita/' . $b['gambar']) ?>" alt="Thumbnail" class="w-16 h-12 object-cover rounded shadow-sm border border-gray-200">
                                <?php else : ?>
                                    <div class="w-16 h-12 bg-gray-100 rounded flex items-center justify-center text-[10px] text-gray-400 border border-gray-200">No Image</div>
                                <?php endif; ?>
                            </td>
                            <td class="p-3 font-medium text-text-main leading-tight">
                                <?= $b['judul'] ?>
                                <div class="text-xs text-gray-400 mt-1 font-normal">Layout: <span class="uppercase"><?= $b['layout'] ?></span></div>
                            </td>
                            <td class="p-3">
                                <span class="bg-blue-50 text-blue-600 text-xs px-2 py-1 rounded font-medium border border-blue-100">
                                    <?= $b['nama_kategori'] ?>
                                </span>
                            </td>
                            <td class="p-3 text-sm text-gray-500"><?= date('d M Y', strtotime($b['created_at'])) ?></td>
                            <td class="p-3 whitespace-nowrap">
                                <a href="<?= base_url('admin/berita/hapus/' . $b['id']) ?>" onclick="return confirm('Yakin hapus?')" class="text-red-500 hover:text-red-700 text-sm transition">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
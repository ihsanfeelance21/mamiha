<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <h3 class="text-2xl font-bold text-text-main">Manajemen Kategori Berita</h3>
    <p class="text-gray-500 text-sm mt-1">Kelola topik atau label untuk mengelompokkan berita Anda.</p>
</div>

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="bg-green-100 border-l-4 border-primary text-green-700 p-4 mb-6 rounded shadow-sm">
        <?= session()->getFlashdata('pesan') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 h-fit">
        <h4 class="font-semibold text-text-main mb-4 border-b pb-2">Tambah Kategori Baru</h4>
        <form action="<?= base_url('admin/kategori-berita/simpan') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label for="nama_kategori" class="block text-sm font-medium text-text-main mb-1">Nama Kategori</label>
                <input type="text" id="nama_kategori" name="nama_kategori" required placeholder="Cth: Akademik, Ekstrakurikuler..."
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
            </div>
            <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded font-medium transition">
                Simpan Kategori
            </button>
        </form>
    </div>

    <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <h4 class="font-semibold text-text-main mb-4 border-b pb-2">Daftar Kategori</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface border-b border-gray-200">
                        <th class="p-3 text-text-muted font-semibold w-12">No</th>
                        <th class="p-3 text-text-muted font-semibold">Nama Kategori</th>
                        <th class="p-3 text-text-muted font-semibold">Slug (URL)</th>
                        <th class="p-3 text-text-muted font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($kategori)) : ?>
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-400 italic">Belum ada kategori yang dibuat.</td>
                        </tr>
                    <?php else : ?>
                        <?php $i = 1;
                        foreach ($kategori as $k) : ?>
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="p-3"><?= $i++ ?></td>
                                <td class="p-3 font-medium text-text-main"><?= $k['nama_kategori'] ?></td>
                                <td class="p-3 text-sm text-gray-500"><?= $k['slug_kategori'] ?></td>
                                <td class="p-3 text-right">
                                    <a href="<?= base_url('admin/kategori-berita/hapus/' . $k['id']) ?>" onclick="return confirm('Yakin ingin menghapus kategori ini? Pastikan tidak ada berita yang menggunakan kategori ini.')" class="text-red-500 hover:text-red-700 text-sm font-medium transition">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>
<div class="max-w-3xl bg-white p-6 rounded-lg shadow-sm border border-gray-100">
    <div class="mb-6 flex items-center justify-between">
        <h3 class="text-xl font-bold text-text-main">Tambah Kegiatan Baru</h3>
        <a href="<?= base_url('admin/kegiatan') ?>" class="text-text-muted hover:text-gray-800 transition text-sm flex items-center">
            &larr; Kembali
        </a>
    </div>

    <form action="<?= base_url('admin/kegiatan/simpan') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-4">
            <label for="judul" class="block text-sm font-medium text-text-main mb-1">Judul Kegiatan</label>
            <input type="text" id="judul" name="judul" required autofocus
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
        </div>

        <div class="mb-6">
            <label for="konten" class="block text-sm font-medium text-text-main mb-1">Isi / Detail Kegiatan</label>
            <textarea id="konten" name="konten" rows="6" required
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition"></textarea>
        </div>
        <div class="mb-6">
            <label for="gambar" class="block text-sm font-medium text-text-main mb-1">Foto Kegiatan (Opsional)</label>
            <input type="file" id="gambar" name="gambar" accept="image/png, image/jpeg, image/webp"
                class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-surface file:text-primary hover:file:bg-gray-100 transition">
            <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-primary hover:bg-primary-hover text-white px-6 py-2 rounded font-medium transition">
                Simpan Kegiatan
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-3xl bg-white p-6 rounded-lg shadow-sm border border-gray-100">
    <div class="mb-6 flex items-center justify-between">
        <h3 class="text-xl font-bold text-text-main">Edit Kegiatan</h3>
        <a href="<?= base_url('admin/kegiatan') ?>" class="text-text-muted hover:text-gray-800 transition text-sm flex items-center">
            &larr; Batal
        </a>
    </div>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/kegiatan/update/' . $kegiatan['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-4">
            <label for="judul" class="block text-sm font-medium text-text-main mb-1">Judul Kegiatan</label>
            <input type="text" id="judul" name="judul" value="<?= old('judul', $kegiatan['judul']) ?>" required
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
        </div>

        <div class="mb-6">
            <label for="konten" class="block text-sm font-medium text-text-main mb-1">Isi / Detail Kegiatan</label>
            <textarea id="konten" name="konten" rows="6" required
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition"><?= old('konten', $kegiatan['konten']) ?></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-text-main mb-1">Gambar Saat Ini</label>
            <?php if ($kegiatan['gambar']) : ?>
                <img src="<?= base_url('uploads/kegiatan/' . $kegiatan['gambar']) ?>" class="w-32 h-32 object-cover rounded mb-2 border border-gray-200">
            <?php else : ?>
                <p class="text-sm text-gray-500 mb-2 italic">Belum ada gambar.</p>
            <?php endif; ?>

            <label for="gambar" class="block text-sm font-medium text-text-main mb-1 mt-4">Ganti Gambar (Opsional)</label>
            <input type="file" id="gambar" name="gambar" accept="image/png, image/jpeg, image/webp"
                class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-surface file:text-primary hover:file:bg-gray-100 transition">
            <p class="text-xs text-gray-400 mt-1">Biarkan kosong jika tidak ingin mengganti gambar.</p>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-primary hover:bg-primary-hover text-white px-6 py-2 rounded font-medium transition">
                Update Kegiatan
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="p-6 md:p-8 max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="<?= base_url('admin/pengumuman') ?>" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Pengumuman</h1>
            <p class="text-sm text-gray-500">Perbarui informasi pengumuman</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <form action="<?= base_url('admin/pengumuman/update/' . $pengumuman['id']) ?>" method="post" enctype="multipart/form-data">

            <div class="mb-6">
                <label for="judul" class="block text-sm font-bold text-gray-700 mb-2">Judul Pengumuman <span class="text-red-500">*</span></label>
                <input type="text" name="judul" id="judul" value="<?= esc($pengumuman['judul']) ?>" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="kategori" class="block text-sm font-bold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" id="kategori" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all cursor-pointer">
                        <option value="Akademik" <?= $pengumuman['kategori'] == 'Akademik' ? 'selected' : '' ?>>Akademik</option>
                        <option value="Kesiswaan" <?= $pengumuman['kategori'] == 'Kesiswaan' ? 'selected' : '' ?>>Kesiswaan</option>
                        <option value="Keuangan" <?= $pengumuman['kategori'] == 'Keuangan' ? 'selected' : '' ?>>Keuangan</option>
                        <option value="Sarpras" <?= $pengumuman['kategori'] == 'Sarpras' ? 'selected' : '' ?>>Sarpras</option>
                        <option value="Umum" <?= $pengumuman['kategori'] == 'Umum' ? 'selected' : '' ?>>Umum</option>
                    </select>
                </div>
                <div>
                    <label for="tanggal_publish" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Publish <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_publish" id="tanggal_publish" value="<?= esc($pengumuman['tanggal_publish']) ?>" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all cursor-pointer">
                </div>
            </div>

            <div class="mb-6">
                <label for="gambar" class="block text-sm font-bold text-gray-700 mb-2">Poster / Gambar</label>
                <?php if ($pengumuman['gambar']) : ?>
                    <div class="mb-3">
                        <img src="<?= base_url('uploads/pengumuman/' . $pengumuman['gambar']) ?>" alt="Poster" class="w-32 rounded-lg border border-gray-200 shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Poster saat ini</p>
                    </div>
                <?php endif; ?>
                <input type="file" name="gambar" id="gambar" accept="image/*" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-[#00A859]/10 file:text-[#00A859] hover:file:bg-[#00A859]/20 transition-all">
                <p class="text-xs text-gray-500 mt-1.5"><i class="fa-solid fa-circle-info text-blue-500 mr-1"></i> Biarkan kosong jika tidak ingin mengubah poster.</p>
            </div>

            <div class="mb-8">
                <label for="konten" class="block text-sm font-bold text-gray-700 mb-2">Isi Pengumuman <span class="text-red-500">*</span></label>
                <textarea name="konten" id="konten" rows="8" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all"><?= esc($pengumuman['konten']) ?></textarea>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-xl font-bold transition-colors shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
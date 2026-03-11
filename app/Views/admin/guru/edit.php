<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="p-6">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Edit Data Guru / Pimpinan</h1>
        <p class="text-sm text-gray-500 mt-1">Ubah informasi untuk <?= esc($guru['nama']) ?>.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-base font-bold text-gray-800">Formulir Edit Data</h2>
        </div>

        <form action="<?= base_url('admin/guru/update/' . $guru['id']) ?>" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
            <?= csrf_field(); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col">
                    <label for="nama" class="text-sm font-semibold mb-2 text-gray-700">Nama Lengkap & Gelar</label>
                    <input type="text" id="nama" name="nama" value="<?= old('nama', $guru['nama']) ?>" class="border <?= ($validation->hasError('nama')) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg p-2.5 outline-none focus:ring-2 focus:ring-[#00A859]" required>
                </div>

                <div class="flex flex-col">
                    <label for="jabatan" class="text-sm font-semibold mb-2 text-gray-700">Jabatan</label>
                    <input type="text" id="jabatan" name="jabatan" value="<?= old('jabatan', $guru['jabatan']) ?>" class="border <?= ($validation->hasError('jabatan')) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg p-2.5 outline-none focus:ring-2 focus:ring-[#00A859]" required>
                </div>

                <div class="flex flex-col">
                    <label for="kategori" class="text-sm font-semibold mb-2 text-gray-700">Kategori</label>
                    <select id="kategori" name="kategori" class="border border-gray-300 rounded-lg p-2.5 outline-none focus:ring-2 focus:ring-[#00A859]">
                        <option value="pimpinan" <?= old('kategori', $guru['kategori']) == 'pimpinan' ? 'selected' : '' ?>>Pimpinan Sekolah</option>
                        <option value="guru" <?= old('kategori', $guru['kategori']) == 'guru' ? 'selected' : '' ?>>Dewan Guru</option>
                        <option value="staff" <?= old('kategori', $guru['kategori']) == 'staff' ? 'selected' : '' ?>>Staff & Tata Usaha</option>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label for="urutan" class="text-sm font-semibold mb-2 text-gray-700">Urutan Tampil</label>
                    <input type="number" id="urutan" name="urutan" value="<?= old('urutan', $guru['urutan']) ?>" class="border border-gray-300 rounded-lg p-2.5 outline-none focus:ring-2 focus:ring-[#00A859]">
                </div>
            </div>

            <div class="flex flex-col mt-6">
                <label for="sambutan" class="text-sm font-semibold mb-2 text-gray-700">Sambutan / Quotes</label>
                <textarea id="sambutan" name="sambutan" rows="3" class="border border-gray-300 rounded-lg p-2.5 outline-none focus:ring-2 focus:ring-[#00A859]"><?= old('sambutan', $guru['sambutan']) ?></textarea>
            </div>

            <div class="flex flex-col mt-6">
                <label for="foto" class="text-sm font-semibold mb-2 text-gray-700">Foto Profil (Kosongkan jika tidak diganti)</label>
                <div class="flex items-center gap-4 mb-2">
                    <img src="<?= base_url('uploads/guru/' . $guru['foto']) ?>" class="w-16 h-16 object-cover rounded-lg border">
                    <p class="text-xs text-gray-500">File saat ini: <?= $guru['foto'] ?></p>
                </div>
                <input type="file" id="foto" name="foto" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-50 file:text-green-700 border border-dashed border-gray-300 p-2 rounded-lg">
            </div>

            <div class="mt-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Pendidikan Terakhir</label>
                <input type="text" name="pendidikan" value="<?= old('pendidikan', $guru['pendidikan']) ?>" class="border rounded w-full py-2 px-3 text-gray-700 outline-none focus:ring-2 focus:ring-[#00A859]">
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Link Facebook</label>
                    <input type="url" name="facebook" value="<?= old('facebook', $guru['facebook']) ?>" class="border rounded w-full py-2 px-3 text-gray-700 outline-none focus:ring-2 focus:ring-[#00A859]">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Link Instagram</label>
                    <input type="url" name="instagram" value="<?= old('instagram', $guru['instagram']) ?>" class="border rounded w-full py-2 px-3 text-gray-700 outline-none focus:ring-2 focus:ring-[#00A859]">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Link LinkedIn</label>
                    <input type="url" name="linkedin" value="<?= old('linkedin', $guru['linkedin']) ?>" class="border rounded w-full py-2 px-3 text-gray-700 outline-none focus:ring-2 focus:ring-[#00A859]">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Link YouTube</label>
                    <input type="url" name="youtube" value="<?= old('youtube', $guru['youtube']) ?>" class="border rounded w-full py-2 px-3 text-gray-700 outline-none focus:ring-2 focus:ring-[#00A859]">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Link TikTok</label>
                    <input type="url" name="tiktok" value="<?= old('tiktok', $guru['tiktok']) ?>" class="border rounded w-full py-2 px-3 text-gray-700 outline-none focus:ring-2 focus:ring-[#00A859]">
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Upload File CV (PDF)</label>
                <?php if ($guru['cv_file']): ?>
                    <p class="text-xs text-blue-600 mb-2">File ada: <a href="<?= base_url('uploads/cv/' . $guru['cv_file']) ?>" target="_blank" class="underline">Lihat CV saat ini</a></p>
                <?php endif; ?>
                <input type="file" name="cv_file" accept=".pdf" class="border rounded w-full py-2 px-3 text-gray-700 outline-none focus:ring-2 focus:ring-[#00A859]">
            </div>

            <div class="mt-8 flex items-center gap-3 border-t pt-6">
                <button type="submit" class="bg-[#00A859] hover:bg-green-700 text-white font-semibold py-2.5 px-6 rounded-lg transition-colors text-sm flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="<?= base_url('admin/guru') ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 px-6 rounded-lg text-sm">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
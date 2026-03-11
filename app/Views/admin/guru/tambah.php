<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="p-6">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Data Guru / Pimpinan</h1>
        <p class="text-sm text-gray-500 mt-1">Isi formulir di bawah untuk menambahkan anggota struktural baru.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-base font-bold text-gray-800">Formulir Tambah Data</h2>
        </div>

        <form action="<?= base_url('admin/guru/simpan') ?>" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
            <?= csrf_field(); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col">
                    <label for="nama" class="text-sm font-semibold mb-2 text-gray-700">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                    <input type="text" id="nama" name="nama" value="<?= old('nama') ?>" class="border <?= ($validation->hasError('nama')) ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#00A859]' ?> rounded-lg p-2.5 focus:ring-2 outline-none transition-all bg-white" required placeholder="Contoh: Muhamad Ihsan Kurniawan, S.Kom.">
                    <?php if ($validation->hasError('nama')): ?>
                        <p class="text-red-500 text-xs mt-1"><?= $validation->getError('nama') ?></p>
                    <?php endif; ?>
                </div>

                <div class="flex flex-col">
                    <label for="jabatan" class="text-sm font-semibold mb-2 text-gray-700">Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" id="jabatan" name="jabatan" value="<?= old('jabatan') ?>" class="border <?= ($validation->hasError('jabatan')) ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#00A859]' ?> rounded-lg p-2.5 focus:ring-2 outline-none transition-all bg-white" required placeholder="Contoh: Kepala Madrasah / Waka Kurikulum">
                    <?php if ($validation->hasError('jabatan')): ?>
                        <p class="text-red-500 text-xs mt-1"><?= $validation->getError('jabatan') ?></p>
                    <?php endif; ?>
                </div>

                <div class="flex flex-col">
                    <label for="kategori" class="text-sm font-semibold mb-2 text-gray-700">Kategori</label>
                    <select id="kategori" name="kategori" class="border border-gray-300 focus:ring-[#00A859] rounded-lg p-2.5 focus:ring-2 outline-none transition-all bg-white">
                        <option value="pimpinan" <?= old('kategori') == 'pimpinan' ? 'selected' : '' ?>>Pimpinan Sekolah</option>
                        <option value="guru" <?= old('kategori') == 'guru' ? 'selected' : '' ?>>Dewan Guru</option>
                        <option value="staff" <?= old('kategori') == 'staff' ? 'selected' : '' ?>>Staff & Tata Usaha</option>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label for="urutan" class="text-sm font-semibold mb-2 text-gray-700">Urutan Tampil (Angka)</label>
                    <input type="number" id="urutan" name="urutan" value="<?= old('urutan') !== null ? old('urutan') : '0' ?>" class="border border-gray-300 focus:ring-[#00A859] rounded-lg p-2.5 focus:ring-2 outline-none transition-all bg-white">
                    <p class="text-[11px] text-gray-400 mt-1">Angka terkecil akan tampil paling awal (0, 1, 2, dst).</p>
                </div>
            </div>

            <div class="flex flex-col mt-6">
                <label for="sambutan" class="text-sm font-semibold mb-2 text-gray-700">Sambutan / Quotes (Opsional)</label>
                <textarea id="sambutan" name="sambutan" rows="3" class="border border-gray-300 focus:ring-[#00A859] rounded-lg p-2.5 focus:ring-2 outline-none transition-all bg-white placeholder:text-sm" placeholder="Hanya diisi untuk Pimpinan/Kepala Madrasah..."><?= old('sambutan') ?></textarea>
            </div>

            <div class="flex flex-col mt-6">
                <label for="foto" class="text-sm font-semibold mb-2 text-gray-700">Foto Profil</label>
                <input type="file" id="foto" name="foto" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border border-dashed <?= ($validation->hasError('foto')) ? 'border-red-500' : 'border-gray-300' ?> p-2 rounded-lg cursor-pointer transition-all bg-gray-50/30">
                <p class="text-[11px] text-gray-400 mt-1">Format: JPG, JPEG, PNG. Maks 2MB. Biarkan kosong jika belum ada foto.</p>
                <?php if ($validation->hasError('foto')): ?>
                    <p class="text-red-500 text-xs mt-1"><?= $validation->getError('foto') ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Pendidikan Terakhir</label>
                <input type="text" name="pendidikan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: S1 - Universitas Negeri Malang">
            </div>

            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Link Facebook</label>
                    <input type="url" name="facebook" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="https://facebook.com/username">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Link Instagram</label>
                    <input type="url" name="instagram" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="https://instagram.com/username">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Link LinkedIn</label>
                    <input type="url" name="linkedin" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="https://linkedin.com/in/username">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Link Youtube</label>
                    <input type="url" name="youtube" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="https://youtube.com/@username">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Link TikTok</label>
                    <input type="url" name="tiktok" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="https://tiktok.com/@username">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Upload File CV (PDF)</label>
                <input type="file" name="cv_file" accept=".pdf" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p class="text-xs text-gray-500 mt-1">*Hanya file PDF. Kosongkan jika tidak ingin mengubah/mengupload.</p>
            </div>

            <div class="mt-8 flex items-center gap-3 border-t border-gray-100 pt-6">
                <button type="submit" class="bg-[#00A859] hover:bg-green-700 text-white font-semibold py-2.5 px-6 rounded-lg shadow-sm transition-colors text-sm flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
                <a href="<?= base_url('admin/guru') ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 px-6 rounded-lg transition-colors text-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
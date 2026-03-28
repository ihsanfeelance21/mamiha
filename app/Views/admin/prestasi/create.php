<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Tambah Prestasi Baru</h2>
        <p class="text-sm text-gray-500">Masukkan detail penghargaan dengan lengkap.</p>
    </div>
    <a href="<?= base_url('admin/prestasi') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<?php if (session('errors')) : ?>
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-start gap-3">
        <i class="fa-solid fa-triangle-exclamation mt-0.5"></i>
        <div class="text-sm">
            <p class="font-bold mb-1">Terjadi kesalahan input:</p>
            <ul class="list-disc list-inside">
                <?php foreach (session('errors') as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <form action="<?= base_url('admin/prestasi/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kategori Prestasi <span class="text-red-500">*</span></label>

                    <?php
                    // Di create.php, kita hanya pakai old() tanpa menarik data $prestasi
                    $kategoriTerpilih = old('kategori_prestasi');
                    ?>

                    <select name="kategori_prestasi" id="kategori_prestasi" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] transition-colors" required onchange="toggleFormPemenang()">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Siswa" <?= ($kategoriTerpilih === 'Siswa') ? 'selected' : '' ?>>Prestasi Siswa</option>
                        <option value="Guru" <?= ($kategoriTerpilih === 'Guru') ? 'selected' : '' ?>>Prestasi Guru</option>
                        <option value="Madrasah" <?= ($kategoriTerpilih === 'Madrasah') ? 'selected' : '' ?>>Prestasi Madrasah</option>
                    </select>
                </div>

                <div id="form-siswa" class="hidden p-4 bg-blue-50 border border-blue-100 rounded-xl space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Siswa Pemenang</label>
                        <input type="text" name="nama_pemenang" value="<?= old('nama_pemenang') ?>" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#00A859] transition-colors" placeholder="Cth: Khuzaimah Syifa">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kelas</label>
                        <input type="text" name="kelas" value="<?= old('kelas') ?>" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#00A859] transition-colors" placeholder="Cth: XII IPA 1">
                    </div>
                </div>

                <div id="form-guru" class="hidden p-4 bg-purple-50 border border-purple-100 rounded-xl space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Guru</label>
                        <input type="text" name="nama_guru" value="<?= old('nama_guru') ?>" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#00A859] transition-colors" placeholder="Cth: Bapak Ahmad S.Pd">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Tampilan <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="<?= old('judul') ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] transition-colors" required placeholder="Cth: Lomba Baca Puisi Soekarno">
                    <p class="text-[11px] text-gray-400 mt-1">Ini yang akan tampil paling besar di card.</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lomba / Event <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lomba" value="<?= old('nama_lomba') ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] transition-colors" required placeholder="Cth: Lomba KSN Tingkat Kabupaten 2025">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Peringkat / Juara <span class="text-red-500">*</span></label>
                        <input type="text" name="juara" value="<?= old('juara') ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] transition-colors" required placeholder="Cth: Juara 1">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tahun <span class="text-red-500">*</span></label>
                        <input type="number" name="tahun_perolehan" value="<?= old('tahun_perolehan', date('Y')) ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] transition-colors" required>
                    </div>
                </div>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Poster / Gambar Ucapan</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center hover:bg-gray-50 transition-colors cursor-pointer" id="upload-area" onclick="document.getElementById('gambar').click()">
                        <i class="fa-regular fa-image text-4xl text-gray-300 mb-3"></i>
                        <p class="text-sm font-bold text-gray-600 mb-1">Klik untuk upload gambar</p>
                        <p class="text-xs text-gray-400">Rekomendasi Portrait / Berdiri (Rasio 3:4) minimal 720 x 960 pixels. Max 2MB (JPG/PNG)</p>
                        <input type="file" name="gambar" id="gambar" class="hidden" accept="image/*" onchange="previewImage(this)">
                        <div id="preview-container" class="mt-4 hidden relative">
                            <img id="image-preview" src="" class="mx-auto rounded-lg max-h-48 object-cover shadow-sm">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Singkat</label>
                    <textarea name="konten" rows="5" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] transition-colors" placeholder="Tuliskan cerita singkat tentang prestasi ini..."><?= old('konten') ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Trofi/Penghargaan (Opsional)</label>
                    <input type="text" name="nama_penghargaan" value="<?= old('nama_penghargaan') ?>" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] transition-colors" placeholder="Cth: Piala Bergilir Bupati">
                </div>
            </div>

        </div>

        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
            <button type="reset" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-colors">Reset</button>
            <button type="submit" class="px-6 py-2.5 bg-[#00A859] hover:bg-[#0B4A2D] text-white font-bold rounded-xl transition-colors shadow-sm">
                <i class="fa-solid fa-save mr-2"></i> Simpan Prestasi
            </button>
        </div>

    </form>
</div>

<script>
    function toggleFormPemenang() {
        const kategori = document.getElementById('kategori_prestasi').value;
        const formSiswa = document.getElementById('form-siswa');
        const formGuru = document.getElementById('form-guru');

        formSiswa.classList.add('hidden');
        formGuru.classList.add('hidden');

        // Ubah pengecekannya di sini
        if (kategori === 'Siswa') {
            formSiswa.classList.remove('hidden');
        } else if (kategori === 'Guru') {
            formGuru.classList.remove('hidden');
        }
    }

    // Panggil saat pertama kali halaman diload (jika ada old value)
    document.addEventListener('DOMContentLoaded', function() {
        toggleFormPemenang();
    });

    // Preview Gambar
    function previewImage(input) {
        const previewContainer = document.getElementById('preview-container');
        const imagePreview = document.getElementById('image-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            imagePreview.src = '';
            previewContainer.classList.add('hidden');
        }
    }
</script>

<?= $this->endSection() ?>
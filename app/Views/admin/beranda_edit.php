<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Hero Slide</h2>
        <a href="<?= base_url('admin/beranda') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow transition text-sm flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-[#0B4A2D]">
        <form action="<?= base_url('admin/beranda/update/' . $slide['id']) ?>" method="post" enctype="multipart/form-data" class="space-y-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 border border-gray-200 rounded-lg">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2"><i class="fa-solid fa-desktop text-[#0B4A2D] mr-1"></i> Gambar Desktop (Landscape)</label>

                    <?php if ($slide['gambar'] && file_exists('uploads/hero/' . $slide['gambar'])): ?>
                        <img src="<?= base_url('uploads/hero/' . $slide['gambar']) ?>" alt="Preview Desktop" class="w-full h-40 object-cover rounded border border-gray-300 mb-3 shadow-sm">
                    <?php else: ?>
                        <div class="w-full h-40 bg-gray-200 border border-gray-300 rounded flex items-center justify-center mb-3">
                            <span class="text-gray-500 italic text-sm">Gambar tidak ditemukan</span>
                        </div>
                    <?php endif; ?>

                    <input type="file" name="gambar" accept="image/*" class="w-full border border-gray-300 bg-white rounded px-3 py-2 text-sm focus:ring-1 focus:ring-green-500">
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                        * Gunakan rasio <strong>Landscape (Cth: 1920x1080px)</strong>.<br>
                        * Biarkan kosong jika tidak ingin mengganti gambar saat ini.
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2"><i class="fa-solid fa-mobile-screen text-[#0B4A2D] mr-1"></i> Gambar Mobile (Portrait)</label>

                    <div class="flex gap-4 mb-3">
                        <?php if (!empty($slide['gambar_mobile']) && file_exists('uploads/hero/' . $slide['gambar_mobile'])): ?>
                            <img src="<?= base_url('uploads/hero/' . $slide['gambar_mobile']) ?>" alt="Preview Mobile" class="w-24 h-40 object-cover rounded border border-gray-300 shadow-sm">
                        <?php else: ?>
                            <div class="w-24 h-40 bg-gray-200 border border-gray-300 rounded flex items-center justify-center text-center p-2">
                                <span class="text-gray-500 italic text-xs">Belum ada gambar mobile</span>
                            </div>
                        <?php endif; ?>

                        <div class="flex-1 flex flex-col justify-end">
                            <input type="file" name="gambar_mobile" accept="image/*" class="w-full border border-gray-300 bg-white rounded px-3 py-2 text-sm focus:ring-1 focus:ring-green-500">
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                        * Gunakan rasio <strong>Portrait (Cth: 1080x1920px)</strong>.<br>
                        * Biarkan kosong jika tidak ingin mengganti. Jika dari awal kosong, otomatis mengikuti gambar Desktop.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Label / Tag (Opsional)</label>
                    <input type="text" name="label" value="<?= esc($slide['label']) ?>" placeholder="Cth: Akreditasi A" class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-1 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Utama (Opsional)</label>
                    <input type="text" name="judul" value="<?= esc($slide['judul']) ?>" placeholder="Cth: Pendidikan Berkualitas Tinggi" class="w-full border border-gray-300 rounded px-4 py-2 text-sm font-bold focus:ring-1 focus:ring-green-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subjudul / Deskripsi Singkat</label>
                <textarea name="subjudul" rows="3" class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-1 focus:ring-green-500"><?= esc($slide['subjudul']) ?></textarea>
            </div>

            <div class="bg-gray-50 p-4 rounded border border-gray-200 mt-4">
                <p class="text-sm font-semibold text-gray-700 mb-3"><i class="fa-solid fa-link text-green-600 mr-1"></i> Pengaturan Tombol (Opsional)</p>
                <p class="text-xs text-gray-500 mb-4">Isi URL dengan link web (cth: https://google.com) atau link halaman (cth: /pendaftaran atau #statistik).</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <div class="bg-white p-3 border border-gray-200 rounded shadow-sm">
                        <label class="block text-xs font-bold text-green-700 mb-2">TOMBOL 1 (Utama)</label>
                        <input type="text" name="btn1_teks" value="<?= esc($slide['btn1_teks']) ?>" placeholder="Teks (Cth: Daftar)" class="w-full border border-gray-300 rounded px-3 py-2 text-sm mb-2 focus:ring-1 focus:ring-green-500">
                        <input type="text" name="btn1_url" value="<?= esc($slide['btn1_url']) ?>" placeholder="URL Tombol 1" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-green-500">
                    </div>
                    <div class="bg-white p-3 border border-gray-200 rounded shadow-sm">
                        <label class="block text-xs font-bold text-gray-600 mb-2">TOMBOL 2 (Sekunder)</label>
                        <input type="text" name="btn2_teks" value="<?= esc($slide['btn2_teks']) ?>" placeholder="Teks (Cth: Profil)" class="w-full border border-gray-300 rounded px-3 py-2 text-sm mb-2 focus:ring-1 focus:ring-green-500">
                        <input type="text" name="btn2_url" value="<?= esc($slide['btn2_url']) ?>" placeholder="URL Tombol 2" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-green-500">
                    </div>
                </div>
            </div>

            <div class="text-right mt-6 pt-4 border-t border-gray-200">
                <button type="submit" class="bg-[#00A859] hover:bg-green-600 text-white font-bold py-2.5 px-8 rounded-md shadow transition flex items-center justify-center gap-2 ml-auto">
                    <i class="fa-solid fa-save"></i> Perbarui Slide
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
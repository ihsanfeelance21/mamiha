<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="max-w-5xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Kelola Hero Slider (Beranda)</h2>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">
            <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow-md p-6 mb-8 border-t-4 border-[#0B4A2D]">
        <h4 class="font-semibold text-gray-700 mb-4">Tambah Slide Baru</h4>
        <form action="<?= base_url('admin/beranda/tambah') ?>" method="post" enctype="multipart/form-data" class="space-y-4">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 border border-gray-200 rounded-lg mb-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fa-solid fa-desktop text-[#0B4A2D] mr-1"></i> Gambar Desktop (Landscape) <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="gambar" accept="image/*" required class="w-full border border-gray-300 bg-white rounded px-3 py-2 text-sm focus:ring-1 focus:ring-green-500">
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                        * Wajib diisi.<br>
                        * Gunakan rasio <strong>Landscape (Cth: 1920x1080px)</strong>.
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fa-solid fa-mobile-screen text-[#0B4A2D] mr-1"></i> Gambar Mobile (Portrait)
                    </label>
                    <input type="file" name="gambar_mobile" accept="image/*" class="w-full border border-gray-300 bg-white rounded px-3 py-2 text-sm focus:ring-1 focus:ring-green-500">
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                        * Opsional.<br>
                        * Gunakan rasio <strong>Portrait (Cth: 1080x1920px)</strong>.<br>
                        * Jika dikosongkan, akan otomatis menggunakan gambar Desktop.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Label / Tag (Opsional)</label>
                    <input type="text" name="label" placeholder="Cth: Akreditasi A" class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-1 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Utama (Opsional)</label>
                    <input type="text" name="judul" placeholder="Cth: Pendidikan Berkualitas Tinggi" class="w-full border border-gray-300 rounded px-4 py-2 text-sm font-bold focus:ring-1 focus:ring-green-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subjudul / Deskripsi Singkat</label>
                <textarea name="subjudul" rows="2" class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:ring-1 focus:ring-green-500"></textarea>
            </div>

            <div class="bg-gray-50 p-4 rounded border border-gray-200 mt-4">
                <p class="text-sm font-semibold text-gray-700 mb-3"><i class="fa-solid fa-link text-green-600 mr-1"></i> Pengaturan Tombol (Opsional)</p>
                <p class="text-xs text-gray-500 mb-4">Isi URL dengan link web (cth: https://google.com) atau link halaman (cth: /pendaftaran atau #statistik).</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <div class="bg-white p-3 border border-gray-200 rounded shadow-sm">
                        <label class="block text-xs font-bold text-green-700 mb-2">TOMBOL 1 (Utama)</label>
                        <input type="text" name="btn1_teks" placeholder="Teks Tombol 1 (Cth: Daftar)" class="w-full border border-gray-300 rounded px-3 py-2 text-sm mb-1 focus:ring-1 focus:ring-green-500">
                        <input type="text" name="btn1_url" placeholder="URL Tombol 1" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-green-500">
                    </div>
                    <div class="bg-white p-3 border border-gray-200 rounded shadow-sm">
                        <label class="block text-xs font-bold text-gray-600 mb-2">TOMBOL 2 (Sekunder)</label>
                        <input type="text" name="btn2_teks" placeholder="Teks Tombol 2 (Cth: Profil)" class="w-full border border-gray-300 rounded px-3 py-2 text-sm mb-1 focus:ring-1 focus:ring-green-500">
                        <input type="text" name="btn2_url" placeholder="URL Tombol 2" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-green-500">
                    </div>
                </div>
            </div>

            <div class="text-right mt-4 pt-4 border-t border-gray-200">
                <button type="submit" class="bg-[#00A859] hover:bg-green-600 text-white font-bold py-2.5 px-8 rounded-md shadow transition flex items-center justify-center gap-2 ml-auto">
                    <i class="fa-solid fa-plus"></i> Simpan Slide
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-sm uppercase tracking-wider">
                    <th class="py-3 px-6 border-b">Gambar Desktop</th>
                    <th class="py-3 px-6 border-b">Gambar Mobile</th>
                    <th class="py-3 px-6 border-b">Konten</th>
                    <th class="py-3 px-6 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                <?php if (empty($sliders)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-6 italic text-gray-400">Belum ada slide.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($sliders as $slide): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-6 w-40">
                                <img src="<?= base_url('uploads/hero/' . $slide['gambar']) ?>" class="w-32 h-20 object-cover rounded shadow-sm">
                            </td>
                            <td class="py-3 px-6 w-32 text-center">
                                <?php if (!empty($slide['gambar_mobile'])): ?>
                                    <img src="<?= base_url('uploads/hero/' . $slide['gambar_mobile']) ?>" class="w-16 h-24 mx-auto object-cover rounded shadow-sm border border-gray-200">
                                <?php else: ?>
                                    <span class="text-[10px] text-gray-400 italic block mt-2">Pakai Desktop</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-6">
                                <?php if ($slide['label']): ?><span class="inline-block bg-yellow-400 text-xs font-bold px-2 py-0.5 rounded mb-1"><?= esc($slide['label']) ?></span><br><?php endif; ?>
                                <strong class="text-gray-800 text-base"><?= esc($slide['judul'] ?? 'Tanpa Judul') ?></strong>
                                <p class="text-gray-500 text-xs mt-1 truncate max-w-xs"><?= esc($slide['subjudul']) ?></p>

                                <div class="mt-2 flex gap-2">
                                    <?php if ($slide['btn1_teks']): ?><span class="bg-green-100 text-green-700 text-[10px] px-2 py-1 rounded">Btn 1: <?= esc($slide['btn1_teks']) ?></span><?php endif; ?>
                                    <?php if ($slide['btn2_teks']): ?><span class="bg-blue-100 text-blue-700 text-[10px] px-2 py-1 rounded">Btn 2: <?= esc($slide['btn2_teks']) ?></span><?php endif; ?>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= base_url('admin/beranda/edit/' . $slide['id']) ?>" class="text-blue-500 hover:text-blue-700 font-semibold px-3 py-1 bg-blue-50 hover:bg-blue-100 rounded transition flex items-center gap-1">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <a href="<?= base_url('admin/beranda/hapus/' . $slide['id']) ?>" onclick="return confirm('Hapus slide ini?')" class="text-red-500 hover:text-red-700 font-semibold px-3 py-1 bg-red-50 hover:bg-red-100 rounded transition flex items-center gap-1">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </a>
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
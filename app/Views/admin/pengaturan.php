<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl bg-white p-6 rounded-lg shadow-sm border border-gray-100">
    <h3 class="text-xl font-bold text-text-main mb-6">Pengaturan Identitas & Kontak Website</h3>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="bg-green-100 border-l-4 border-primary text-green-700 p-4 mb-6 rounded shadow-sm">
            <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/pengaturan/update') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="space-y-4">
                <h4 class="font-semibold text-gray-700 border-b pb-2">Identitas Dasar</h4>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sekolah</label>
                    <input type="text" name="nama_sekolah" value="<?= $pengaturan['nama_sekolah'] ?>" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary">
                </div>
                <div class="mb-6 space-y-4">
                    <h4 class="font-semibold text-gray-700 border-b pb-2">Informasi Umum</h4>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Madrasah / Sekolah</label>
                        <input type="text" name="nama_sekolah" value="<?= esc($pengaturan['nama_sekolah']) ?>" required class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Slogan</label>
                            <input type="text" name="slogan" value="<?= esc($pengaturan['slogan'] ?? '') ?>" placeholder="Cth: Madrasah Kreatif, Inovatif..." class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary">
                            <p class="text-[10px] text-gray-500 mt-1">Muncul di bawah nama sekolah pada Logo.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Singkat</label>
                            <input type="text" name="alamat_singkat" value="<?= esc($pengaturan['alamat_singkat'] ?? '') ?>" placeholder="Cth: Karangdoro - Tegalsari - Banyuwangi" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary">
                            <p class="text-[10px] text-gray-500 mt-1">Muncul di baris ketiga pada Logo.</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat (Footer)</label>
                        <textarea name="deskripsi_footer" rows="4" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary"><?= $pengaturan['deskripsi_footer'] ?></textarea>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-700 border-b pb-2">Kontak & Alamat</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon (Teks Tampilan)</label>
                            <input type="text" name="telepon" value="<?= esc($pengaturan['telepon']) ?>" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Link WhatsApp (API)</label>
                            <input type="text" name="link_whatsapp" placeholder="https://wa.me/6281..." value="<?= esc($pengaturan['link_whatsapp'] ?? '') ?>" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Sekolah</label>
                        <input type="email" name="email" value="<?= $pengaturan['email'] ?>" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap (Teks)</label>
                            <textarea name="alamat" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary"><?= esc($pengaturan['alamat']) ?></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Link Google Maps (URL)</label>
                            <textarea name="link_maps" placeholder="https://goo.gl/maps/..." class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary"><?= esc($pengaturan['link_maps'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6 space-y-4">
                <h4 class="font-semibold text-gray-700 border-b pb-2">Link Sosial Media</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                        <input type="text" name="facebook" value="<?= $pengaturan['facebook'] ?>" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                        <input type="text" name="instagram" value="<?= $pengaturan['instagram'] ?>" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">YouTube URL</label>
                        <input type="text" name="youtube" value="<?= $pengaturan['youtube'] ?>" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">TikTok URL</label>
                        <input type="text" name="tiktok" value="<?= $pengaturan['tiktok'] ?>" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary">
                    </div>
                </div>
            </div>

            <div class="mb-6 space-y-4">
                <h4 class="font-semibold text-gray-700 border-b pb-2">SEO & Metadata</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meta Deskripsi (Untuk Google)</label>
                        <textarea name="meta_deskripsi" rows="3" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary"><?= $pengaturan['meta_deskripsi'] ?? '' ?></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords (Pisahkan dengan koma)</label>
                        <textarea name="meta_keywords" rows="3" placeholder="sekolah, madrasah, banyuwangi, mamiha" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary"><?= $pengaturan['meta_keywords'] ?? '' ?></textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Favicon (.png / .ico)</label>
                    <?php if (!empty($pengaturan['favicon'])) : ?>
                        <div class="mb-2">
                            <img src="<?= base_url('uploads/pengaturan/' . $pengaturan['favicon']) ?>" alt="Favicon" class="h-16 w-auto object-contain border p-1 rounded">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="favicon" accept="image/png, image/jpeg, image/x-icon" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary">
                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah favicon.</p>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Logo Utama (.png / .jpeg)</label>
                    <?php if (!empty($pengaturan['logo'])) : ?>
                        <div class="mb-2 bg-gray-100 inline-block p-2 rounded">
                            <img src="<?= base_url('uploads/pengaturan/' . $pengaturan['logo']) ?>" alt="Logo" class="h-16 w-auto object-contain">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="logo" accept="image/png, image/jpeg, image/webp" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-primary">
                    <p class="text-xs text-gray-500 mt-1">Logo ini akan muncul di Header (Navbar) dan Footer. Gunakan background transparan (PNG) untuk hasil terbaik.</p>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t">
                <button type="submit" class="bg-primary hover:bg-primary-hover text-white px-8 py-2 rounded font-medium transition">
                    Simpan Pengaturan
                </button>
            </div>
    </form>
</div>
<?= $this->endSection() ?>
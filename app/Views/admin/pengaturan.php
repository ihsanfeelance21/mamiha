<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-5xl mx-auto pb-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h3 class="text-2xl font-bold text-gray-800">Pengaturan Website</h3>
            <p class="text-gray-500 text-sm">Kelola identitas, kontak, dan tampilan utama website sekolah.</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm">
            <i class="fa-solid fa-circle-check text-green-500"></i>
            <p class="text-sm font-medium"><?= session()->getFlashdata('pesan') ?></p>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/pengaturan/update') ?>" method="post" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>

        <div class="bg-white rounded-xl shadow-sm border border-green-200 overflow-hidden transition-shadow hover:shadow-md">
            <div class="bg-green-800 px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                <i class="fa-solid fa-school text-white"></i>
                <h4 class="font-bold text-white uppercase text-xs tracking-wider">Identitas & Branding</h4>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Madrasah / Sekolah</label>
                    <input type="text" name="nama_sekolah" value="<?= esc($pengaturan['nama_sekolah']) ?>" required
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500/10 focus:border-[#00A859] transition-all outline-none bg-white">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Slogan</label>
                        <input type="text" name="slogan" value="<?= esc($pengaturan['slogan'] ?? '') ?>" placeholder="Cth: Kreatif & Inovatif"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500/10 focus:border-[#00A859] transition-all outline-none bg-white">
                        <p class="text-[11px] text-gray-400 mt-1 italic">*Muncul di bawah logo pada kop/header.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Singkat (Logo)</label>
                        <input type="text" name="alamat_singkat" value="<?= esc($pengaturan['alamat_singkat'] ?? '') ?>" placeholder="Cth: Tegalsari - Banyuwangi"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500/10 focus:border-[#00A859] transition-all outline-none bg-white">
                        <p class="text-[11px] text-gray-400 mt-1 italic">*Muncul di baris ketiga pada logo samping.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Singkat (Footer)</label>
                    <textarea name="deskripsi_footer" rows="3"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500/10 focus:border-[#00A859] transition-all outline-none bg-white"><?= $pengaturan['deskripsi_footer'] ?></textarea>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-green-200 overflow-hidden transition-shadow hover:shadow-md">
                <div class="bg-green-800 px-6 py-4 border-b border-green-200 flex items-center gap-2">
                    <i class="fa-solid fa-phone text-white"></i>
                    <h4 class="font-bold text-white uppercase text-xs tracking-wider">Kontak Madrasah</h4>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" name="telepon" value="<?= esc($pengaturan['telepon']) ?>"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500/10 focus:border-[#00A859] transition-all outline-none bg-white">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1 items-center gap-2">
                            <i class="fa-brands fa-whatsapp"></i> Link WhatsApp (API)
                        </label>
                        <input type="text" name="link_whatsapp" placeholder="https://wa.me/6281..." value="<?= esc($pengaturan['link_whatsapp'] ?? '') ?>"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500/10 focus:border-[#00A859] transition-all outline-none bg-white">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1 items-center gap-2">
                            <i class="fa-solid fa-envelope"></i> Email Resmi
                        </label>
                        <input type="email" name="email" value="<?= $pengaturan['email'] ?>"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500/10 focus:border-[#00A859] transition-all outline-none bg-white">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-green-200 overflow-hidden transition-shadow hover:shadow-md">
                <div class="bg-green-800 px-6 py-4 border-b border-green-200 flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-white"></i>
                    <h4 class="font-bold text-white uppercase text-xs tracking-wider">Lokasi Google Maps</h4>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500/10 focus:border-[#00A859] outline-none bg-white"><?= esc($pengaturan['alamat']) ?></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Link Google Maps (URL Share)</label>
                        <textarea name="link_maps" rows="2" placeholder="https://goo.gl/maps/..." class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500/10 focus:border-[#00A859] outline-none bg-white"><?= esc($pengaturan['link_maps'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-green-200 overflow-hidden transition-shadow hover:shadow-md">
            <div class="bg-green-800 px-6 py-4 border-b border-green-200 flex items-center gap-2">
                <i class="fa-solid fa-share-nodes text-white"></i>
                <h4 class="font-bold text-white uppercase text-xs tracking-wider">Tautan Media Sosial</h4>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-blue-700 mb-1 uppercase tracking-tighter">Facebook</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fa-brands fa-facebook"></i>
                            </span>
                            <input type="text" name="facebook" value="<?= $pengaturan['facebook'] ?>" class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-sm outline-none focus:border-blue-500 bg-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-pink-600 mb-1 uppercase tracking-tighter">Instagram</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fa-brands fa-instagram"></i>
                            </span>
                            <input type="text" name="instagram" value="<?= $pengaturan['instagram'] ?>" class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-sm outline-none focus:border-pink-500 bg-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-red-600 mb-1 uppercase tracking-tighter">YouTube</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fa-brands fa-youtube"></i>
                            </span>
                            <input type="text" name="youtube" value="<?= $pengaturan['youtube'] ?>" class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-sm outline-none focus:border-red-500 bg-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-black mb-1 uppercase tracking-tighter">TikTok</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fa-brands fa-tiktok"></i>
                            </span>
                            <input type="text" name="tiktok" value="<?= $pengaturan['tiktok'] ?>" class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-sm outline-none focus:border-gray-800 bg-white">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-green-200 overflow-hidden transition-shadow hover:shadow-md">
            <div class="bg-green-800 px-6 py-4 border-b border-green-200 flex items-center gap-2">
                <i class="fa-solid fa-image text-white"></i>
                <h4 class="font-bold text-white uppercase text-xs tracking-wider">Visual & SEO Meta</h4>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Favicon Madrasah</label>
                            <div class="flex items-center gap-4 border border-dashed border-gray-200 p-4 rounded-lg bg-white">
                                <?php if (!empty($pengaturan['favicon'])) : ?>
                                    <img src="<?= base_url('uploads/pengaturan/' . $pengaturan['favicon']) ?>" alt="Favicon" class="h-12 w-12 object-contain bg-white p-1 rounded shadow-sm border">
                                <?php endif; ?>
                                <input type="file" name="favicon" accept="image/png, image/x-icon" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-[#00A859] hover:file:bg-green-100">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Utama</label>
                            <div class="flex flex-col gap-3 border border-dashed border-gray-200 p-4 rounded-lg bg-white text-center">
                                <?php if (!empty($pengaturan['logo'])) : ?>
                                    <img src="<?= base_url('uploads/pengaturan/' . $pengaturan['logo']) ?>" alt="Logo" class="h-14 w-fit object-contain mx-auto mb-2">
                                <?php endif; ?>
                                <input type="file" name="logo" accept="image/png, image/jpeg, image/webp" class="text-xs text-gray-500 file:mx-auto file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-[#00A859] hover:file:bg-green-100">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 border-l border-gray-100 md:pl-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Meta Deskripsi (SEO)</label>
                            <textarea name="meta_deskripsi" rows="3" placeholder="Tuliskan gambaran sekolah untuk pencarian Google..." class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-[#00A859] bg-white"><?= $pengaturan['meta_deskripsi'] ?? '' ?></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Meta Keywords</label>
                            <textarea name="meta_keywords" rows="2" placeholder="contoh: sekolah islam, banyuwangi, terbaik..." class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-[#00A859] bg-white"><?= $pengaturan['meta_keywords'] ?? '' ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4">
            <button type="reset" class="px-6 py-2.5 rounded-lg text-sm font-semibold text-gray-500 hover:text-white bg-gray-300 hover:bg-gray-500 transition-colors">
                Batalkan
            </button>
            <button type="submit" class="bg-[#00A859] hover:bg-[#0B4A2D] text-white px-10 py-2.5 rounded-lg font-bold shadow-lg shadow-green-500/20 transition-all transform hover:-translate-y-0.5 active:scale-95">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
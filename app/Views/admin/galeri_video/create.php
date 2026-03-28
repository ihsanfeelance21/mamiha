<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="p-6 md:p-8 max-w-3xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="<?= base_url('admin/galeri-video') ?>" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Video</h1>
            <p class="text-sm text-gray-500">Masukkan tautan video dari YouTube atau Google Drive</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <form action="<?= base_url('admin/galeri-video/store') ?>" method="post">

            <div class="mb-6">
                <label for="judul" class="block text-sm font-bold text-gray-700 mb-2">Judul Video <span class="text-red-500">*</span></label>
                <input type="text" name="judul" id="judul" required placeholder="Contoh: Penampilan Pentas Seni 2026" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all">
            </div>

            <div class="mb-6">
                <label for="link_video" class="block text-sm font-bold text-gray-700 mb-2">Tautan Video (URL) <span class="text-red-500">*</span></label>
                <input type="url" name="link_video" id="link_video" required placeholder="Contoh: https://www.youtube.com/watch?v=xxxxx" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all">
                <p class="text-xs text-gray-500 mt-2"><i class="fa-solid fa-circle-info text-blue-500 mr-1"></i> Paste link lengkap dari YouTube atau Google Drive yang sudah di-set Public/Anyone with the link.</p>
            </div>

            <div class="mb-6">
                <label for="orientasi" class="block text-sm font-bold text-gray-700 mb-2">Format Tampilan Video <span class="text-red-500">*</span></label>
                <select name="orientasi" id="orientasi" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all">
                    <option value="landscape">Landscape (Mendatar - 16:9) - Cocok untuk YouTube/FB</option>
                    <option value="portrait">Portrait (Tegak - 9:16) - Cocok untuk TikTok/IG Reels/Shorts</option>
                </select>
                <p class="text-xs text-gray-500 mt-2"><i class="fa-solid fa-circle-info text-blue-500 mr-1"></i> Pisahkan agar tampilan galeri tidak berantakan.</p>
            </div>

            <div class="mb-8">
                <label for="tanggal" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Kegiatan <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal" id="tanggal" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all cursor-pointer">
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="bg-[#00A859] hover:bg-[#0B4A2D] text-white px-8 py-2.5 rounded-xl font-bold transition-colors shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Video
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
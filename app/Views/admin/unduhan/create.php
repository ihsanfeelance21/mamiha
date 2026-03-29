<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="p-6 max-w-3xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="<?= base_url('admin/unduhan') ?>" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Upload File Baru</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
        <form action="<?= base_url('admin/unduhan/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Judul Dokumen <span class="text-red-500">*</span></label>
                <input type="text" name="judul" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all" placeholder="Contoh: Formulir PPDB 2024">
            </div>

            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                <select name="kategori" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Surat Edaran">Surat Edaran</option>
                    <option value="Aplikasi/Software">Aplikasi / Software</option>
                    <option value="Modul Pembelajaran">Modul Pembelajaran</option>
                    <option value="Dokumen Akademik">Dokumen Akademik</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">File Upload <span class="text-red-500">*</span></label>
                <input type="file" name="file_unduhan" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:bg-white transition-all text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                <p class="text-xs text-gray-500 mt-2">Maksimal ukuran file menyesuaikan pengaturan server (disarankan max 10MB). Format: PDF, DOC, DOCX, APK, ZIP, RAR.</p>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Atau Gunakan Link Eksternal (Opsional)</label>
                <input type="url" name="link_eksternal" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all" placeholder="Contoh: https://drive.google.com/file/d/xxxx">
                <p class="text-xs text-gray-500 mt-2"><i class="fa-solid fa-circle-info text-blue-500 mr-1"></i> Gunakan ini untuk file berukuran besar (>10MB). Jika diisi, sistem akan memprioritaskan link ini.</p>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-700 mb-2">Keterangan Singkat</label>
                <textarea name="keterangan" rows="3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all" placeholder="Tambahkan deskripsi singkat mengenai file ini (opsional)..."></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="<?= base_url('admin/unduhan') ?>" class="px-6 py-2.5 rounded-lg text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-lg text-sm font-semibold text-white bg-[#00A859] hover:bg-green-700 transition-colors shadow-sm">
                    <i class="fa-solid fa-cloud-arrow-up mr-1"></i> Upload Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
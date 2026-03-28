<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="p-6 md:p-8 max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="<?= base_url('admin/galeri') ?>" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Album Baru</h1>
            <p class="text-sm text-gray-500">Buat album dulu, nanti foto-fotonya bisa diupload setelah album dibuat</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <form action="<?= base_url('admin/galeri/store') ?>" method="post" enctype="multipart/form-data">

            <div class="mb-6">
                <label for="judul" class="block text-sm font-bold text-gray-700 mb-2">Judul Album <span class="text-red-500">*</span></label>
                <input type="text" name="judul" id="judul" required placeholder="Contoh: Lomba Kompetensi Siswa (LKS) Kab. Banyuwangi" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all">
            </div>

            <div class="mb-6">
                <label for="tanggal" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Kegiatan <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal" id="tanggal" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all cursor-pointer">
            </div>

            <div class="mb-6">
                <label for="sampul" class="block text-sm font-bold text-gray-700 mb-2">Gambar Sampul (Cover Album) <span class="text-red-500">*</span></label>
                <input type="file" name="sampul" id="sampul" required accept="image/*" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-[#00A859]/10 file:text-[#00A859] hover:file:bg-[#00A859]/20 transition-all">
            </div>

            <div class="mb-8">
                <label for="deskripsi" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Singkat (Opsional)</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Tuliskan keterangan singkat mengenai album ini..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all"></textarea>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="bg-[#00A859] hover:bg-[#0B4A2D] text-white px-8 py-2.5 rounded-xl font-bold transition-colors shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Album
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
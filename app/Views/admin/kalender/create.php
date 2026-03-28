<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="p-6 md:p-8 max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="<?= base_url('admin/kalender') ?>" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Agenda</h1>
            <p class="text-sm text-gray-500">Tambahkan jadwal kegiatan baru ke kalender akademik</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <form action="<?= base_url('admin/kalender/store') ?>" method="post">

            <div class="mb-6">
                <label for="judul" class="block text-sm font-bold text-gray-700 mb-2">Judul Agenda <span class="text-red-500">*</span></label>
                <input type="text" name="judul" id="judul" required placeholder="Contoh: Libur Idul Fitri 2026" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all cursor-pointer">
                </div>
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Selesai (Opsional)</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all cursor-pointer">
                    <p class="text-xs text-gray-500 mt-1.5"><i class="fa-solid fa-circle-info mr-1 text-blue-500"></i> Kosongkan jika kegiatan hanya berlangsung 1 hari.</p>
                </div>
            </div>

            <div class="mb-8">
                <label for="deskripsi" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Keterangan</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Tuliskan keterangan lebih lanjut mengenai agenda ini..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all"></textarea>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="bg-[#00A859] hover:bg-[#0B4A2D] text-white px-8 py-2.5 rounded-xl font-bold transition-colors shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Agenda
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
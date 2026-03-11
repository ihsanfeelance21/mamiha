<?= $this->extend('layouts/admin') ?> <?= $this->section('content') ?>
<div class="p-6">

    <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-images text-[#00A859]"></i> Galeri: <?= esc($fasilitas['judul']) ?>
            </h2>
            <p class="text-gray-500 text-sm mt-1">Kelola foto-foto yang akan muncul pada popup fasilitas ini.</p>
        </div>

        <a href="<?= base_url('admin/profil') ?>" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg shadow-sm transition-colors flex items-center gap-2 border border-gray-300">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Profil
        </a>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p><?= session()->getFlashdata('pesan') ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="md:col-span-1">
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm sticky top-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Upload Foto Baru</h3>
                <form action="<?= base_url('admin/profil/fasilitas/galeri/simpan') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="fasilitas_id" value="<?= $fasilitas['id'] ?>">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Gambar</label>
                        <input type="file" name="foto" required accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    </div>

                    <button type="submit" class="w-full px-4 py-2 bg-[#00A859] hover:bg-[#0B4A2D] text-white font-bold rounded-lg shadow transition-colors flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Upload Foto
                    </button>
                </form>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm min-h-75">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Daftar Foto Galeri</h3>

                <?php if (empty($galeri)): ?>
                    <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                        <i class="fa-regular fa-image text-6xl mb-3 text-gray-300"></i>
                        <p>Belum ada foto galeri untuk fasilitas ini.</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                        <?php foreach ($galeri as $g): ?>
                            <div class="relative group rounded-lg overflow-hidden border border-gray-200 shadow-sm aspect-square bg-gray-100">
                                <img src="<?= base_url('uploads/fasilitas/galeri/' . $g['foto']) ?>" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" alt="Galeri">

                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <a href="<?= base_url('admin/profil/fasilitas/galeri/hapus/' . $g['id']) ?>" onclick="return confirm('Hapus foto ini dari galeri?')" class="w-10 h-10 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors transform hover:scale-110" title="Hapus Foto">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>
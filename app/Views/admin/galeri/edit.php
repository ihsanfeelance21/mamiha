<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

<div class="p-6 md:p-8 max-w-5xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="<?= base_url('admin/galeri') ?>" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Album & Foto</h1>
            <p class="text-sm text-gray-500">Edit detail album dan tambahkan foto-foto kegiatan</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mb-8">
        <h2 class="text-lg font-bold border-b border-gray-100 pb-3 mb-5 text-[#0B4A2D]">Detail Album</h2>
        <form action="<?= base_url('admin/galeri/update/' . $galeri['id']) ?>" method="post" enctype="multipart/form-data">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="mb-6 md:mb-0">
                    <label for="judul" class="block text-sm font-bold text-gray-700 mb-2">Judul Album <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" id="judul" value="<?= esc($galeri['judul']) ?>" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all">
                </div>
                <div>
                    <label for="tanggal" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Kegiatan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" value="<?= esc($galeri['tanggal']) ?>" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all cursor-pointer">
                </div>
            </div>

            <div class="mb-6">
                <label for="deskripsi" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Singkat</label>
                <textarea name="deskripsi" id="deskripsi" rows="2" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all"><?= esc($galeri['deskripsi']) ?></textarea>
            </div>

            <div class="mb-6">
                <label for="sampul" class="block text-sm font-bold text-gray-700 mb-2">Ubah Sampul (Opsional)</label>
                <?php if ($galeri['sampul']) : ?>
                    <img src="<?= base_url('uploads/galeri/' . $galeri['sampul']) ?>" class="w-32 h-24 object-cover rounded-lg mb-3 border border-gray-200 shadow-sm">
                <?php endif; ?>
                <input type="file" name="sampul" id="sampul" accept="image/*" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-[#00A859]/10 file:text-[#00A859] hover:file:bg-[#00A859]/20 transition-all">
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-xl font-bold transition-colors shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Update Detail
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mb-8">
        <h2 class="text-lg font-bold border-b border-gray-100 pb-3 mb-5 text-[#0B4A2D] flex justify-between items-center">
            <span>Upload Foto Ke Album Ini</span>
        </h2>

        <form action="<?= base_url('admin/galeri/uploadPhotos/' . $galeri['id']) ?>" class="dropzone border-2 border-dashed border-[#00A859]/50 rounded-2xl bg-green-50/50 hover:bg-green-50 transition-colors flex flex-col items-center justify-center min-h-50" id="my-awesome-dropzone">
            <div class="dz-message" data-dz-message>
                <i class="fa-solid fa-cloud-arrow-up text-4xl text-[#00A859] mb-3"></i><br>
                <span class="text-gray-600 font-medium">Klik atau Tarik foto ke sini untuk mengunggah</span>
                <p class="text-xs text-gray-400 mt-2">(Bisa pilih banyak foto sekaligus)</p>
            </div>
        </form>
        <div class="mt-3 text-right">
            <button type="button" onclick="location.reload()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold transition-colors">
                <i class="fa-solid fa-rotate-right"></i> Refresh Halaman (Setelah Upload)
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <h2 class="text-lg font-bold border-b border-gray-100 pb-3 mb-5 text-[#0B4A2D]">Koleksi Foto (<?= count($fotos) ?>)</h2>

        <?php if (!empty($fotos)) : ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($fotos as $foto) : ?>
                    <div class="relative group rounded-xl overflow-hidden shadow-sm border border-gray-100" id="foto-<?= $foto['id'] ?>">
                        <img src="<?= base_url('uploads/galeri/fotos/' . $foto['nama_file']) ?>" class="w-full h-40 object-cover">
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <button type="button" onclick="hapusFoto(<?= $foto['id'] ?>)" class="bg-red-500 hover:bg-red-600 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg transform scale-0 group-hover:scale-100 transition-transform">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="text-center text-gray-500 py-8"><i class="fa-regular fa-image text-3xl mb-2 block text-gray-300"></i> Belum ada foto di album ini.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
    // Konfigurasi Dropzone
    Dropzone.options.myAwesomeDropzone = {
        paramName: "file",
        maxFilesize: 5, // MB maksimal
        acceptedFiles: "image/*",
        dictDefaultMessage: "Tarik foto ke sini untuk upload",
    };

    // Fungsi AJAX untuk menghapus foto
    function hapusFoto(id) {
        if (confirm('Yakin ingin menghapus foto ini?')) {
            let formData = new FormData();
            formData.append('id', id);

            fetch('<?= base_url('admin/galeri/deletePhoto/' . $galeri['id']) ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Hilangkan foto dari tampilan dengan animasi fade out
                        let el = document.getElementById('foto-' + id);
                        el.style.opacity = '0';
                        setTimeout(() => el.remove(), 300);
                    } else {
                        alert('Gagal menghapus foto!');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }
</script>

<?= $this->endSection() ?>
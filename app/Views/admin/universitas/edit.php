<?= $this->extend('layouts/admin'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Universitas</h1>
        <a href="<?= base_url('admin/universitas'); ?>" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded text-sm transition duration-150">Kembali</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
        <form action="<?= base_url('admin/universitas/update/' . $kampus['id_universitas']); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_universitas">Nama Universitas</label>
                <input type="text" name="nama_universitas" id="nama_universitas" value="<?= esc($kampus['nama_universitas']); ?>" required class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="logo">Logo Universitas (Opsional)</label>
                <?php if ($kampus['logo']) : ?>
                    <div class="mb-2">
                        <img src="<?= base_url('uploads/universitas/' . $kampus['logo']); ?>" alt="Logo Lama" class="h-16 w-16 object-contain border p-1 rounded bg-gray-50">
                    </div>
                <?php endif; ?>
                <input type="file" name="logo" id="logo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah logo.</p>
            </div>

            <div class="mb-8">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="gambar_gedung">Banner / Gedung Universitas (Opsional)</label>
                <?php if (isset($kampus['gambar_gedung']) && $kampus['gambar_gedung']) : ?>
                    <div class="mb-2">
                        <img src="<?= base_url('uploads/gedung/' . $kampus['gambar_gedung']); ?>" alt="Gedung Lama" class="h-24 w-48 object-cover border p-1 rounded bg-gray-50">
                    </div>
                <?php endif; ?>
                <input type="file" name="gambar_gedung" id="gambar_gedung" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah banner.</p>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
                Update Data Universitas
            </button>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>
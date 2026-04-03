<?= $this->extend('layouts/admin'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800"><?= $title; ?></h1>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p><?= session()->getFlashdata('pesan'); ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Tambah Universitas</h2>
            <form action="<?= base_url('admin/universitas/simpan'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_universitas">Nama Universitas</label>
                    <input type="text" name="nama_universitas" id="nama_universitas" required class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="logo">Logo Universitas</label>
                    <input type="file" name="logo" id="logo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Rasio 1:1.</p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="gambar_gedung">Banner / Gedung Universitas (Opsional)</label>
                    <input type="file" name="gambar_gedung" id="gambar_gedung" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Rekomendasi lanskap.</p>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
                    Simpan Data
                </button>
            </form>
        </div>

        <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-md border border-gray-100 overflow-x-auto">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">Daftar Universitas</h2>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-4 border-b">No</th>
                        <th class="py-3 px-4 border-b">Logo & Banner</th>
                        <th class="py-3 px-4 border-b">Nama Universitas</th>
                        <th class="py-3 px-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php $no = 1;
                    foreach ($universitas as $u) : ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-4"><?= $no++; ?></td>
                            <td class="py-3 px-4 flex gap-2">
                                <?php if ($u['logo']) : ?>
                                    <img src="<?= base_url('uploads/universitas/' . $u['logo']); ?>" alt="Logo" class="h-10 w-10 object-contain rounded-full bg-white border" title="Logo">
                                <?php else : ?>
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-xs">No</div>
                                <?php endif; ?>

                                <?php if (isset($u['gambar_gedung']) && $u['gambar_gedung']) : ?>
                                    <img src="<?= base_url('uploads/gedung/' . $u['gambar_gedung']); ?>" alt="Gedung" class="h-10 w-16 object-cover rounded bg-white border" title="Banner Gedung">
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 font-medium text-gray-700"><?= esc($u['nama_universitas']); ?></td>
                            <td class="py-3 px-4 text-center">
                                <a href="<?= base_url('admin/universitas/edit/' . $u['id_universitas']); ?>" class="bg-yellow-100 text-yellow-600 hover:bg-yellow-500 hover:text-white py-1 px-3 rounded text-xs transition duration-150 mr-1">Edit</a>
                                <a href="<?= base_url('admin/universitas/hapus/' . $u['id_universitas']); ?>" class="bg-red-100 text-red-600 hover:bg-red-500 hover:text-white py-1 px-3 rounded text-xs transition duration-150" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
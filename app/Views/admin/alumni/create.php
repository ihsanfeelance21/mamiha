<?= $this->extend('layouts/admin'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Alumni Baru</h1>
        <a href="<?= base_url('admin/alumni'); ?>" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded text-sm transition duration-150">Kembali</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
        <form action="<?= base_url('admin/alumni/simpan'); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_alumni">Nama Lengkap</label>
                    <input type="text" name="nama_alumni" id="nama_alumni" required class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="tahun_lulus">Tahun Lulus</label>
                    <input type="number" name="tahun_lulus" id="tahun_lulus" required class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="id_universitas">Universitas</label>
                    <select name="id_universitas" id="id_universitas" class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Universitas --</option>
                        <?php foreach ($universitas as $u) : ?>
                            <option value="<?= $u['id_universitas']; ?>"><?= esc($u['nama_universitas']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="jurusan">Jurusan Saat Ini</label>
                    <input type="text" name="jurusan" id="jurusan" class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="pesan_kesan">Testimoni / Pesan Singkat</label>
                <textarea name="pesan_kesan" id="pesan_kesan" rows="4" class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="foto">Foto Profil</label>
                <input type="file" name="foto" id="foto" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <input type="hidden" name="status" value="approved">

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded focus:outline-none transition duration-150">
                Simpan Data Alumni
            </button>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>
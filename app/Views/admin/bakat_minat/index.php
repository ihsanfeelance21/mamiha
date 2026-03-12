<?= $this->extend('layouts/admin'); ?>
<?= $this->section('content'); ?>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<div class="p-6 bg-gray-50 min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Kelola Bakat & Minat</h1>
        <a href="/admin/bakat-minat/create" class="bg-[#00A859] text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            + Tambah Data
        </a>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="bg-green-100 border-l-4 border-[#00A859] text-green-700 p-4 mb-6 rounded">
            <?= session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-sm">
                    <th class="p-4 border-b">No</th>
                    <th class="p-4 border-b">Gambar</th>
                    <th class="p-4 border-b">Judul</th>
                    <th class="p-4 border-b">Pembina / Pelatih</th>
                    <th class="p-4 border-b">Jadwal</th>
                    <th class="p-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($bakat_minat as $row) : ?>
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4"><?= $i++; ?></td>
                        <td class="p-4">
                            <img src="/uploads/bakat/<?= $row['gambar'] ?? 'default.jpg'; ?>" class="w-16 h-16 object-cover rounded-lg">
                        </td>
                        <td class="p-4 font-semibold"><?= esc($row['judul']); ?></td>
                        <td class="p-4">
                            <?php if ($row['tipe_pembina'] == 'guru') : ?>
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">Guru: <?= esc($row['nama'] ?? '-'); ?></span>
                            <?php else : ?>
                                <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs rounded-full">Manual: <?= esc($row['nama_pembina_manual']); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 text-sm text-gray-600"><?= esc($row['jadwal']); ?></td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center items-center gap-2">
                                <a href="/admin/bakat-minat/edit/<?= $row['id']; ?>" class="bg-blue-100 text-blue-700 px-3 py-1.5 rounded-md text-sm font-medium hover:bg-blue-200 transition">
                                    Edit
                                </a>
                                <a href="/admin/bakat-minat/delete/<?= $row['id']; ?>" onclick="return confirm('Yakin hapus data ini?');" class="bg-red-100 text-red-700 px-3 py-1.5 rounded-md text-sm font-medium hover:bg-red-200 transition">
                                    Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>
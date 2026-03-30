<?= $this->extend('layouts/admin'); ?>

<?= $this->section('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800"><?= $title ?? 'Kelola Data Alumni'; ?></h1>
        <a href="<?= base_url('admin/alumni/create'); ?>" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-sm text-sm transition duration-150">
            + Tambah Manual
        </a>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            <p><?= session()->getFlashdata('pesan'); ?></p>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
            <p><?= session()->getFlashdata('error'); ?></p>
        </div>
    <?php endif; ?>

    <div class="bg-white p-4 rounded-t-lg border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <form action="" method="get" class="flex items-center gap-2 w-full md:w-auto">
            <label for="limit" class="text-sm font-semibold text-gray-600">Tampilkan:</label>
            <select name="limit" id="limit" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="10" <?= ($limit == 10) ? 'selected' : ''; ?>>10</option>
                <option value="50" <?= ($limit == 50) ? 'selected' : ''; ?>>50</option>
                <option value="100" <?= ($limit == 100) ? 'selected' : ''; ?>>100</option>
                <option value="all" <?= ($limit == 'all') ? 'selected' : ''; ?>>All</option>
            </select>
            <span class="text-sm text-gray-600">data</span>
            <?php if (!empty($keyword)) : ?>
                <input type="hidden" name="keyword" value="<?= esc($keyword); ?>">
            <?php endif; ?>
        </form>

        <form action="" method="get" class="flex w-full md:w-auto gap-2">
            <input type="hidden" name="limit" value="<?= esc($limit); ?>">
            <input type="text" name="keyword" value="<?= esc($keyword ?? ''); ?>" placeholder="Cari nama atau kampus..." class="w-full md:w-64 border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded text-sm font-semibold transition">Cari</button>
            <?php if (!empty($keyword)) : ?>
                <a href="<?= base_url('admin/alumni'); ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-1.5 rounded text-sm font-semibold transition text-center">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="bg-white rounded-b-lg shadow-md border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 uppercase text-xs leading-normal">
                        <th class="py-3 px-4 border-b">Profil</th>
                        <th class="py-3 px-4 border-b">Nama & Lulusan</th>
                        <th class="py-3 px-4 border-b">Kampus</th>
                        <th class="py-3 px-4 border-b text-center">Status</th>
                        <th class="py-3 px-4 border-b text-center">Featured (Slider)</th>
                        <th class="py-3 px-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    <?php foreach ($alumni as $a) : ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <?php if ($a['foto']) : ?>
                                    <img src="<?= base_url('uploads/alumni/' . $a['foto']); ?>" alt="Foto" class="w-12 h-12 rounded-full object-cover shadow-sm border">
                                <?php else : ?>
                                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold border">
                                        <?= substr($a['nama_alumni'], 0, 1); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-bold text-gray-800"><?= esc($a['nama_alumni']); ?></div>
                                <div class="text-xs text-gray-500">Angkatan: <?= esc($a['tahun_lulus']); ?></div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-medium text-blue-600"><?= esc($a['nama_universitas'] ?? 'Belum Diatur'); ?></div>
                                <?php if ($a['usulan_universitas']) : ?>
                                    <div class="text-xs text-orange-500 font-semibold mt-1">Usulan: <?= esc($a['usulan_universitas']); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <?php if ($a['status'] == 'pending') : ?>
                                    <span class="bg-yellow-100 text-yellow-700 py-1 px-3 rounded-full text-xs font-semibold">Pending</span>
                                <?php elseif ($a['status'] == 'approved') : ?>
                                    <span class="bg-green-100 text-green-700 py-1 px-3 rounded-full text-xs font-semibold">Approved</span>
                                <?php else : ?>
                                    <span class="bg-red-100 text-red-700 py-1 px-3 rounded-full text-xs font-semibold">Rejected</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <a href="<?= base_url('admin/alumni/toggle-featured/' . $a['id_alumni']); ?>"
                                    class="inline-block py-1 px-3 rounded-full text-xs font-bold transition duration-150 border <?= $a['is_featured'] == 1 ? 'bg-indigo-600 text-white border-indigo-700 hover:bg-indigo-700 shadow-sm' : 'bg-white hover:bg-gray-100' ?>"
                                    title="Klik untuk ubah status slider">
                                    <?= $a['is_featured'] == 1 ? '★ Tampil di Slider' : 'Sembunyikan' ?>
                                </a>
                            </td>
                            <td class="py-3 px-4 text-center space-x-1">
                                <?php if ($a['status'] == 'pending') : ?>
                                    <a href="<?= base_url('admin/alumni/approve/' . $a['id_alumni']); ?>" class="bg-green-500 text-white py-1 px-2 rounded hover:bg-green-600 text-xs font-semibold transition" title="Setujui">Approve</a>
                                    <a href="<?= base_url('admin/alumni/reject/' . $a['id_alumni']); ?>" class="bg-red-500 text-white py-1 px-2 rounded hover:bg-red-600 text-xs font-semibold transition" title="Tolak">Reject</a>
                                <?php endif; ?>
                                <a href="<?= base_url('admin/alumni/edit/' . $a['id_alumni']); ?>" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600 text-xs font-semibold transition inline-block mt-1" title="Edit Data">Edit</a>
                                <a href="<?= base_url('admin/alumni/hapus/' . $a['id_alumni']); ?>" class="bg-gray-500 text-white py-1 px-3 rounded hover:bg-gray-600 text-xs font-semibold transition inline-block mt-1" onclick="return confirm('Yakin ingin menghapus data alumni ini?');" title="Hapus">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($alumni)) : ?>
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500 italic">Belum ada data atau data tidak ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($limit != 'all' && isset($pager)) : ?>
            <div class="p-4 border-t border-gray-100 flex justify-end">
                <?= $pager->links('alumni', 'default_full'); // Ganti 'default_full' kalau Mas punya template pagination tailwind sendiri 
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Unduhan</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola file dokumen, aplikasi, dan surat untuk diunduh pengunjung.</p>
        </div>
        <a href="<?= base_url('admin/unduhan/create') ?>" class="px-4 py-2 bg-[#00A859] text-white rounded-lg hover:bg-green-700 transition-colors shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-cloud-arrow-up"></i> Upload File
        </a>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
            <i class="fa-solid fa-circle-check mr-2"></i> <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-600">
                        <th class="p-4 font-semibold w-12 text-center">No</th>
                        <th class="p-4 font-semibold">Informasi File</th>
                        <th class="p-4 font-semibold w-32">Kategori</th>
                        <th class="p-4 font-semibold w-40">File</th>
                        <th class="p-4 font-semibold w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <?php $no = 1;
                    foreach ($unduhan as $item) : ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-center text-gray-500"><?= $no++ ?></td>
                            <td class="p-4">
                                <p class="font-bold text-gray-800"><?= esc($item['judul']) ?></p>
                                <p class="text-gray-500 text-xs mt-1 line-clamp-1"><?= esc($item['keterangan'] ?? '-') ?></p>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wider bg-blue-50 text-blue-600 border border-blue-100">
                                    <?= esc($item['kategori']) ?>
                                </span>
                            </td>
                            <td class="p-4">
                                <a href="<?= base_url('uploads/unduhan/' . $item['file_unduhan']) ?>" target="_blank" class="text-[#00A859] hover:underline text-xs flex items-center gap-1.5">
                                    <i class="fa-solid fa-file-arrow-down"></i> Lihat/Unduh
                                </a>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= base_url('admin/unduhan/edit/' . $item['id']) ?>" class="w-8 h-8 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center hover:bg-yellow-100 transition-colors" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="<?= base_url('admin/unduhan/delete/' . $item['id']) ?>" onclick="return confirm('Yakin ingin menghapus file ini? File asli juga akan terhapus.')" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition-colors" title="Hapus">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($unduhan)): ?>
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">Belum ada file yang diunggah.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
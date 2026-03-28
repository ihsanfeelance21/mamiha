<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="p-6 md:p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Galeri Video</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola tautan video YouTube / Google Drive</p>
        </div>
        <a href="<?= base_url('admin/galeri-video/create') ?>" class="bg-[#00A859] hover:bg-[#0B4A2D] text-white px-5 py-2.5 rounded-xl font-semibold transition-colors flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i> Tambah Video
        </a>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="bg-green-50 border-l-4 border-[#00A859] p-4 mb-6 rounded-r-xl flex items-center shadow-sm">
            <i class="fa-solid fa-circle-check text-[#00A859] text-xl mr-3"></i>
            <p class="text-green-700 font-medium"><?= session()->getFlashdata('pesan') ?></p>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-sm uppercase tracking-wider text-gray-500">
                        <th class="p-4 font-bold text-center w-16">No</th>
                        <th class="p-4 font-bold">Judul Video</th>
                        <th class="p-4 font-bold">Tautan (Link)</th>
                        <th class="p-4 font-bold">Tanggal</th>
                        <th class="p-4 font-bold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (!empty($videos)) : ?>
                        <?php $no = 1;
                        foreach ($videos as $item) : ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 text-center text-gray-500 font-medium"><?= $no++ ?></td>
                                <td class="p-4">
                                    <h3 class="font-bold text-gray-800 text-base"><?= esc($item['judul']) ?></h3>
                                </td>
                                <td class="p-4">
                                    <a href="<?= esc($item['link_video']) ?>" target="_blank" class="text-blue-500 hover:text-blue-700 text-sm flex items-center gap-1 line-clamp-1 max-w-xs">
                                        <i class="fa-solid fa-link"></i> <?= esc($item['link_video']) ?>
                                    </a>
                                </td>
                                <td class="p-4">
                                    <div class="text-sm text-gray-600 flex items-center gap-2">
                                        <i class="fa-regular fa-calendar text-[#00A859]"></i>
                                        <?= date('d M Y', strtotime($item['tanggal'])) ?>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?= base_url('admin/galeri-video/edit/' . $item['id']) ?>" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors" title="Edit">
                                            <i class="fa-solid fa-pen-to-square text-sm"></i>
                                        </a>
                                        <a href="<?= base_url('admin/galeri-video/delete/' . $item['id']) ?>" onclick="return confirm('Yakin ingin menghapus video ini?')" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-colors" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                <i class="fa-brands fa-youtube text-4xl text-gray-300 mb-3 block"></i>
                                Belum ada data video.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
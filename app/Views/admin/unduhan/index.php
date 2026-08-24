<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Unduhan</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola file dokumen, aplikasi, dan surat untuk diunduh pengunjung.</p>
        </div>
        <a href="<?= base_url('admin/unduhan/create') ?>" class="px-5 py-2.5 bg-[#00A859] hover:bg-[#0B4A2D] text-white rounded-xl font-bold shadow-sm text-sm flex items-center gap-2">
            <i class="fa-solid fa-cloud-arrow-up"></i> Upload File
        </a>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="bg-green-50 border-l-4 border-[#00A859] text-green-700 p-4 mb-6 rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-circle-check"></i>
            <p class="text-sm font-medium"><?= esc(session()->getFlashdata('pesan')) ?></p>
        </div>
    <?php endif; ?>

    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-4">
        <form method="get" class="flex gap-2">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fa-solid fa-magnifying-glass text-sm"></i></span>
                <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari judul/kategori..." class="w-full pl-9 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 text-sm">
            </div>
            <button type="submit" class="bg-gray-800 hover:bg-black text-white px-5 rounded-xl text-sm font-bold">Cari</button>
            <?php if (!empty($keyword)) : ?>
                <a href="<?= base_url('admin/unduhan') ?>" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-100 px-4 py-2.5 rounded-xl text-sm font-bold flex items-center justify-center"><i class="fa-solid fa-rotate-left"></i></a>
            <?php endif; ?>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-[11px] uppercase font-bold tracking-wider border-b border-gray-100">
                        <th class="px-4 py-3 w-12 text-center">No</th>
                        <th class="px-4 py-3">Informasi File</th>
                        <th class="px-4 py-3 w-32">Kategori</th>
                        <th class="px-4 py-3 w-40">File</th>
                        <th class="px-4 py-3 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php if (empty($unduhan)) : ?>
                        <tr>
                            <td colspan="5" class="p-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fa-solid fa-cloud-arrow-down text-5xl text-gray-300 mb-3"></i>
                                    <p class="text-gray-800 font-bold">Belum ada file</p>
                                    <p class="text-sm text-gray-500">Belum ada file diunggah atau filter tidak cocok.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1 + (isset($pager) ? ($pager->getCurrentPage('unduhan') - 1) * 15 : 0); foreach ($unduhan as $item) : ?>
                            <tr class="hover:bg-green-50/30 transition-colors">
                                <td class="px-4 py-3 text-center text-sm text-gray-500"><?= $no++ ?></td>
                                <td class="px-4 py-3">
                                    <p class="font-bold text-gray-800 text-sm"><?= esc($item['judul']) ?></p>
                                    <p class="text-gray-500 text-xs mt-1 line-clamp-1" title="<?= esc($item['keterangan'] ?? '') ?>"><?= esc($item['keterangan'] ?? '-') ?></p>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-blue-50 text-blue-600 border border-blue-100">
                                        <?= esc($item['kategori']) ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if (!empty($item['link_eksternal'])) : ?>
                                        <a href="<?= esc($item['link_eksternal'], 'attr') ?>" target="_blank" rel="noopener" class="text-blue-600 hover:underline text-xs flex items-center gap-1.5">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Link Eksternal
                                        </a>
                                    <?php elseif (!empty($item['file_unduhan'])) : ?>
                                        <a href="<?= base_url('uploads/unduhan/' . $item['file_unduhan']) ?>" target="_blank" class="text-[#00A859] hover:underline text-xs flex items-center gap-1.5">
                                            <i class="fa-solid fa-file-arrow-down"></i> Lihat/Unduh
                                        </a>
                                    <?php else : ?>
                                        <span class="text-xs text-gray-400 italic">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?= base_url('admin/unduhan/edit/' . $item['id']) ?>" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors" title="Edit">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        <form action="<?= base_url('admin/unduhan/delete/' . $item['id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus file ini? File asli juga akan terhapus.')" style="display:inline"><?= csrf_field() ?><button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-colors" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button></form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if (isset($pager)) : ?>
            <div class="p-4 border-t border-gray-100 flex justify-center">
                <div class="[&>ul]:flex [&>ul]:gap-2 [&>ul>li>a]:px-3 [&>ul>li>a]:py-1.5 [&>ul>li>a]:bg-white [&>ul>li>a]:border [&>ul>li>a]:rounded-lg [&>ul>li.active>a]:bg-[#00A859] [&>ul>li.active>a]:text-white">
                    <?= $pager->links('unduhan') ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <div>
        <h3 class="text-2xl font-bold text-gray-800">Daftar Kegiatan Sekolah</h3>
        <p class="text-sm text-gray-500 mt-1">Kelola kegiatan ekstrakurikuler dan agenda sekolah.</p>
    </div>
    <a href="<?= base_url('admin/kegiatan/tambah') ?>" class="bg-[#00A859] hover:bg-[#0B4A2D] text-white px-5 py-2.5 rounded-xl font-bold shadow-sm text-sm flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Tambah Kegiatan
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
            <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari judul kegiatan..." class="w-full pl-9 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 text-sm">
        </div>
        <button type="submit" class="bg-gray-800 hover:bg-black text-white px-5 rounded-xl text-sm font-bold">Cari</button>
        <?php if (!empty($keyword)) : ?>
            <a href="<?= base_url('admin/kegiatan') ?>" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-100 px-4 py-2.5 rounded-xl text-sm font-bold flex items-center justify-center"><i class="fa-solid fa-rotate-left"></i></a>
        <?php endif; ?>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-[11px] uppercase font-bold tracking-wider border-b border-gray-100">
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Foto</th>
                    <th class="px-4 py-3">Judul Kegiatan</th>
                    <th class="px-4 py-3">Tanggal Dibuat</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php if (empty($kegiatan)) : ?>
                    <tr>
                        <td colspan="5" class="p-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-person-running text-5xl text-gray-300 mb-3"></i>
                                <p class="text-gray-800 font-bold">Belum ada kegiatan</p>
                                <p class="text-sm text-gray-500">Belum ada data atau filter tidak cocok.</p>
                            </div>
                        </td>
                    </tr>
                <?php else : ?>
                    <?php $i = 1 + (isset($pager) ? ($pager->getCurrentPage('kegiatan') - 1) * 15 : 0); foreach ($kegiatan as $k) : ?>
                        <tr class="hover:bg-green-50/30 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-500"><?= $i++ ?></td>
                            <td class="px-4 py-3">
                                <?php if ($k['gambar']) : ?>
                                    <img src="<?= base_url('uploads/kegiatan/' . $k['gambar']) ?>" alt="<?= esc($k['judul']) ?>" class="w-16 h-16 object-cover rounded-lg shadow-sm border border-gray-200" loading="lazy">
                                <?php else : ?>
                                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex flex-col items-center justify-center border"><i class="fa-regular fa-image text-gray-400"></i><span class="text-[9px] text-gray-400">No Image</span></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 font-semibold text-gray-800 max-w-xs truncate" title="<?= esc($k['judul']) ?>"><?= esc($k['judul']) ?></td>
                            <td class="px-4 py-3 text-sm text-gray-500"><?= date('d M Y', strtotime($k['created_at'])) ?></td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= base_url('admin/kegiatan/edit/' . $k['id']) ?>" class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition" title="Edit"><i class="fa-solid fa-pen text-xs"></i></a>
                                    <form action="<?= base_url('admin/kegiatan/hapus/' . $k['id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')" style="display:inline"><?= csrf_field() ?><button type="submit" class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition" title="Hapus"><i class="fa-solid fa-trash text-xs"></i></button></form>
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
                <?= $pager->links('kegiatan') ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

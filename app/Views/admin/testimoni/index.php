<?= $this->extend('layouts/admin') ?> <?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Testimoni</h1>
            <p class="text-sm text-gray-500">Moderasi testimoni dari wali murid & alumni</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="bg-green-50 border-l-4 border-[#00A859] text-green-700 p-4 mb-6 rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-circle-check"></i>
            <p class="text-sm font-medium"><?= esc(session()->getFlashdata('pesan')) ?></p>
        </div>
    <?php endif; ?>

    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-4">
        <form method="get" class="flex flex-col sm:flex-row gap-2">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fa-solid fa-magnifying-glass text-sm"></i></span>
                <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama/isi testimoni..." class="w-full pl-9 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 text-sm">
            </div>
            <select name="status" class="px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                <option value="">Semua Status</option>
                <option value="pending" <?= ($statusAktif ?? '') == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="approved" <?= ($statusAktif ?? '') == 'approved' ? 'selected' : '' ?>>Approved</option>
            </select>
            <button type="submit" class="bg-gray-800 hover:bg-black text-white px-5 rounded-xl text-sm font-bold">Cari</button>
            <?php if (!empty($keyword) || !empty($statusAktif)) : ?>
                <a href="<?= base_url('admin/testimoni') ?>" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-100 px-4 py-2.5 rounded-xl text-sm font-bold flex items-center justify-center"><i class="fa-solid fa-rotate-left"></i></a>
            <?php endif; ?>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-sm text-gray-600 uppercase tracking-wider">
                        <th class="p-4 font-semibold">Pengirim</th>
                        <th class="p-4 font-semibold">Rating</th>
                        <th class="p-4 font-semibold">Isi Testimoni</th>
                        <th class="p-4 font-semibold text-center">Status</th>
                        <th class="p-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($testimoni)) : ?>
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">Belum ada data testimoni.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($testimoni as $t) : ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <?php if ($t['foto']) : ?>
                                            <img src="<?= base_url('uploads/testimoni/' . $t['foto']) ?>" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                        <?php else : ?>
                                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                <i class="fa-solid fa-user"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <p class="font-bold text-gray-800"><?= esc($t['nama']) ?></p>
                                            <p class="text-xs text-gray-500"><?= esc($t['status_user']) ?></p>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4 text-yellow-400 text-sm">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <i class="fa-<?= $i <= $t['rating'] ? 'solid' : 'regular' ?> fa-star"></i>
                                    <?php endfor; ?>
                                </td>

                                <td class="p-4 text-sm text-gray-600 max-w-xs truncate" title="<?= esc($t['isi_testimoni']) ?>">
                                    "<?= esc($t['isi_testimoni']) ?>"
                                </td>

                                <td class="p-4 text-center">
                                    <?php if ($t['is_approved'] == 1) : ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            Approved
                                        </span>
                                    <?php else : ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            Pending
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <?php if ($t['is_approved'] == 0) : ?>
                                            <form action="<?= base_url('admin/testimoni/approve/' . $t['id']) ?>" method="post" style="display:inline"><?= csrf_field() ?><button type="submit" class="p-2 text-white bg-[#00A859] hover:bg-green-600 rounded-lg shadow-sm transition-colors">
                                                <i class="fa-solid fa-check"></i>
                                            </button></form>
                                        <?php else : ?>
                                            <form action="<?= base_url('admin/testimoni/reject/' . $t['id']) ?>" method="post" style="display:inline"><?= csrf_field() ?><button type="submit" class="p-2 text-white bg-yellow-500 hover:bg-yellow-600 rounded-lg shadow-sm transition-colors">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button></form>
                                        <?php endif; ?>

                                        <form action="<?= base_url('admin/testimoni/delete/' . $t['id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus testimoni ini secara permanen?')" style="display:inline"><?= csrf_field() ?><button type="submit" class="p-2 text-white bg-red-500 hover:bg-red-600 rounded-lg shadow-sm transition-colors">
                                            <i class="fa-solid fa-trash"></i>
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
                    <?= $pager->links('testimoni') ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
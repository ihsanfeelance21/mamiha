<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Kotak Masuk Pesan</h1>
        <p class="text-gray-500 text-sm mt-1">Daftar pertanyaan, kritik, dan saran dari pengunjung website.</p>
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
                <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama/pesan/kategori..." class="w-full pl-9 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 text-sm">
            </div>
            <select name="status" class="px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm">
                <option value="">Semua Status</option>
                <option value="belum dibaca" <?= ($statusAktif ?? '') == 'belum dibaca' ? 'selected' : '' ?>>Baru</option>
                <option value="sudah dibaca" <?= ($statusAktif ?? '') == 'sudah dibaca' ? 'selected' : '' ?>>Dibaca</option>
            </select>
            <button type="submit" class="bg-gray-800 hover:bg-black text-white px-5 rounded-xl text-sm font-bold">Cari</button>
            <?php if (!empty($keyword) || !empty($statusAktif)) : ?>
                <a href="<?= base_url('admin/kontak') ?>" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-100 px-4 py-2.5 rounded-xl text-sm font-bold flex items-center justify-center"><i class="fa-solid fa-rotate-left"></i></a>
            <?php endif; ?>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-600">
                        <th class="p-4 font-semibold w-12 text-center">No</th>
                        <th class="p-4 font-semibold">Pengirim</th>
                        <th class="p-4 font-semibold w-48">Kategori</th>
                        <th class="p-4 font-semibold w-40">Tanggal</th>
                        <th class="p-4 font-semibold w-32 text-center">Status</th>
                        <th class="p-4 font-semibold w-24 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <?php $no = 1;
                    foreach ($pesan as $item) : ?>
                        <?php $isUnread = ($item['status'] == 'belum dibaca'); ?>

                        <tr class="hover:bg-gray-50 transition-colors <?= $isUnread ? 'bg-blue-50/30' : '' ?>">
                            <td class="p-4 text-center text-gray-500"><?= $no++ ?></td>
                            <td class="p-4">
                                <p class="font-bold <?= $isUnread ? 'text-gray-900' : 'text-gray-700' ?>"><?= esc($item['nama']) ?></p>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-1"><?= esc($item['pesan']) ?></p>
                            </td>
                            <td class="p-4">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-gray-100 text-gray-600 border border-gray-200">
                                    <?= esc($item['kategori']) ?>
                                </span>
                            </td>
                            <td class="p-4 text-gray-500 text-xs">
                                <?= date('d M Y, H:i', strtotime($item['created_at'])) ?>
                            </td>
                            <td class="p-4 text-center">
                                <?php if ($isUnread): ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-red-50 text-red-600 border border-red-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span> Baru
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-green-50 text-green-600 border border-green-100">
                                        <i class="fa-solid fa-check-double"></i> Dibaca
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= base_url('admin/kontak/show/' . $item['id']) ?>" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition-colors" title="Buka Pesan">
                                        <i class="fa-solid fa-envelope-open-text"></i>
                                    </a>
                                    <form action="<?= base_url('admin/kontak/delete/' . $item['id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')" style="display:inline"><?= csrf_field() ?><button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition-colors">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button></form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($pesan)): ?>
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">Belum ada pesan yang masuk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if (isset($pager)) : ?>
            <div class="p-4 border-t border-gray-100 flex justify-center">
                <div class="[&>ul]:flex [&>ul]:gap-2 [&>ul>li>a]:px-3 [&>ul>li>a]:py-1.5 [&>ul>li>a]:bg-white [&>ul>li>a]:border [&>ul>li>a]:rounded-lg [&>ul>li.active>a]:bg-[#00A859] [&>ul>li.active>a]:text-white">
                    <?= $pager->links('pesan') ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
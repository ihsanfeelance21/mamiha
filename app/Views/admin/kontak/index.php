<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Kotak Masuk Pesan</h1>
        <p class="text-gray-500 text-sm mt-1">Daftar pertanyaan, kritik, dan saran dari pengunjung website.</p>
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
                                    <a href="<?= base_url('admin/kontak/delete/' . $item['id']) ?>" onclick="return confirm('Yakin ingin menghapus pesan ini?')" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition-colors" title="Hapus">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
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
    </div>
</div>
<?= $this->endSection() ?>
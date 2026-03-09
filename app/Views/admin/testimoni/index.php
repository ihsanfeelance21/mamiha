<?= $this->extend('layouts/admin') ?> <?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Kelola Testimoni</h1>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg shadow-sm">
            <p class="font-medium"><?= session()->getFlashdata('pesan') ?></p>
        </div>
    <?php endif; ?>

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
                                            <a href="<?= base_url('admin/testimoni/approve/' . $t['id']) ?>" class="p-2 text-white bg-[#00A859] hover:bg-green-600 rounded-lg shadow-sm transition-colors" title="Approve">
                                                <i class="fa-solid fa-check"></i>
                                            </a>
                                        <?php else : ?>
                                            <a href="<?= base_url('admin/testimoni/reject/' . $t['id']) ?>" class="p-2 text-white bg-yellow-500 hover:bg-yellow-600 rounded-lg shadow-sm transition-colors" title="Sembunyikan">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>
                                        <?php endif; ?>

                                        <a href="<?= base_url('admin/testimoni/delete/' . $t['id']) ?>" onclick="return confirm('Yakin ingin menghapus testimoni ini secara permanen?')" class="p-2 text-white bg-red-500 hover:bg-red-600 rounded-lg shadow-sm transition-colors" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
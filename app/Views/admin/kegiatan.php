<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="bg-green-100 border-l-4 border-primary text-green-700 p-4 mb-4 rounded shadow-sm">
        <?= session()->getFlashdata('pesan') ?>
    </div>
<?php endif; ?>

<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-text-main">Daftar Kegiatan Sekolah</h3>
        <a href="<?= base_url('admin/kegiatan/tambah') ?>" class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded transition font-medium">
            + Tambah Kegiatan
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface border-b border-gray-200">
                    <th class="p-3 text-text-muted font-semibold">No</th>
                    <th class="p-3 text-text-muted font-semibold">Foto</th>
                    <th class="p-3 text-text-muted font-semibold">Judul Kegiatan</th>
                    <th class="p-3 text-text-muted font-semibold">Tanggal Dibuat</th>
                    <th class="p-3 text-text-muted font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($kegiatan)) : ?>
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-400 italic">Belum ada data kegiatan.</td>
                    </tr>
                <?php else : ?>
                    <?php $i = 1;
                    foreach ($kegiatan as $k) : ?>
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="p-3"><?= $i++ ?></td>

                            <td class="p-3">
                                <?php if ($k['gambar']) : ?>
                                    <img src="<?= base_url('uploads/kegiatan/' . $k['gambar']) ?>" alt="<?= $k['judul'] ?>" class="w-16 h-16 object-cover rounded shadow-sm border border-gray-200">
                                <?php else : ?>
                                    <div class="w-16 h-16 bg-gray-100 rounded flex items-center justify-center text-xs text-gray-400 border border-gray-200">No Image</div>
                                <?php endif; ?>
                            </td>

                            <td class="p-3 font-medium text-text-main"><?= $k['judul'] ?></td>
                            <td class="p-3 text-sm text-gray-500"><?= date('d M Y', strtotime($k['created_at'])) ?></td>
                            <td class="p-3">
                                <a href="<?= base_url('admin/kegiatan/edit/' . $k['id']) ?>" class="text-blue-500 hover:text-blue-700 mr-3 text-sm font-medium transition">Edit</a>
                                <a href="<?= base_url('admin/kegiatan/hapus/' . $k['id']) ?>" onclick="return confirm('Yakin ingin menghapus kegiatan ini?')" class="text-red-500 hover:text-red-700 text-sm font-medium transition">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
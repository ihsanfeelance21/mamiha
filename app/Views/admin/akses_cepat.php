<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Kelola Akses Cepat</h2>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">
            <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow-md p-6 mb-8 border-t-4 border-[#0B4A2D]">
        <h4 class="font-semibold text-gray-700 mb-4">Tambah Link Baru</h4>
        <form action="<?= base_url('admin/akses-cepat/tambah') ?>" method="post" class="flex flex-col sm:flex-row gap-4">
            <?= csrf_field() ?>
            <div class="flex-1">
                <input type="text" name="nama_link" placeholder="Nama Link (Cth: E-Learning)" required class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-green-500">
            </div>
            <div class="flex-1">
                <input type="url" name="url_link" placeholder="URL (Cth: https://elearning.sekolah.com)" required class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-green-500">
            </div>
            <button type="submit" class="bg-[#00A859] hover:bg-green-600 text-white font-bold py-2 px-6 rounded-md shadow transition">
                Simpan
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 text-sm uppercase tracking-wider">
                    <th class="py-3 px-6 border-b">Nama Link</th>
                    <th class="py-3 px-6 border-b">URL / Tujuan</th>
                    <th class="py-3 px-6 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                <?php if (empty($akses_cepat)): ?>
                    <tr>
                        <td colspan="3" class="text-center py-6 italic text-gray-400">Belum ada link akses cepat.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($akses_cepat as $link): ?>
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="py-3 px-6 font-medium text-gray-800"><?= esc($link['nama_link']) ?></td>
                            <td class="py-3 px-6">
                                <a href="<?= esc($link['url_link']) ?>" target="_blank" class="text-blue-500 hover:underline"><?= esc($link['url_link']) ?></a>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <a href="<?= base_url('admin/akses-cepat/hapus/' . $link['id']) ?>" onclick="return confirm('Hapus link ini?')" class="text-red-500 hover:text-red-700 font-semibold px-3 py-1 bg-red-50 hover:bg-red-100 rounded transition">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
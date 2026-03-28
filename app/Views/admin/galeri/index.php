<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="p-6 md:p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Galeri</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola album foto kegiatan madrasah</p>
        </div>
        <a href="<?= base_url('admin/galeri/create') ?>" class="bg-[#00A859] hover:bg-[#0B4A2D] text-white px-5 py-2.5 rounded-xl font-semibold transition-colors flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i> Tambah Album
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
                        <th class="p-4 font-bold w-32">Sampul Album</th>
                        <th class="p-4 font-bold">Judul Album</th>
                        <th class="p-4 font-bold text-center">Jumlah Foto</th>
                        <th class="p-4 font-bold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (!empty($galeri)) : ?>
                        <?php $no = 1;
                        foreach ($galeri as $item) : ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 text-center text-gray-500 font-medium"><?= $no++ ?></td>
                                <td class="p-4">
                                    <?php if ($item['sampul']) : ?>
                                        <img src="<?= base_url('uploads/galeri/' . $item['sampul']) ?>" alt="Sampul" class="w-20 h-16 object-cover rounded-lg shadow-sm border border-gray-200">
                                    <?php else : ?>
                                        <div class="w-20 h-16 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 border border-gray-200">
                                            <i class="fa-regular fa-image text-xl"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4">
                                    <h3 class="font-bold text-gray-800 text-base mb-1"><?= esc($item['judul']) ?></h3>
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <i class="fa-regular fa-calendar text-[#00A859]"></i>
                                        <?= date('d M Y', strtotime($item['tanggal'])) ?>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center justify-center bg-yellow-100 text-yellow-700 font-bold px-3 py-1 rounded-full text-sm">
                                        <?= $item['jumlah_foto'] ?> Foto
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?= base_url('admin/galeri/edit/' . $item['id']) ?>" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors" title="Kelola Album & Foto">
                                            <i class="fa-solid fa-folder-open text-sm"></i>
                                        </a>
                                        <a href="<?= base_url('admin/galeri/delete/' . $item['id']) ?>" onclick="return confirm('Yakin ingin menghapus album ini? Semua foto di dalamnya juga akan terhapus!')" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-colors" title="Hapus Album">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                <i class="fa-regular fa-images text-4xl text-gray-300 mb-3 block"></i>
                                Belum ada data album galeri.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
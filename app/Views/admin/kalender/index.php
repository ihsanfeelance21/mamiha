<?= $this->extend('layouts/admin') ?> <?= $this->section('content') ?>

<div class="p-6 md:p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kalender Akademik</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola jadwal kegiatan dan libur madrasah</p>
        </div>
        <a href="<?= base_url('admin/kalender/create') ?>" class="bg-[#00A859] hover:bg-[#0B4A2D] text-white px-5 py-2.5 rounded-xl font-semibold transition-colors flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i> Tambah Agenda
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
                        <th class="p-4 font-bold">Judul Agenda</th>
                        <th class="p-4 font-bold">Tanggal Pelaksanaan</th>
                        <th class="p-4 font-bold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (!empty($kalender)) : ?>
                        <?php $no = 1;
                        foreach ($kalender as $item) : ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 text-center text-gray-500 font-medium"><?= $no++ ?></td>
                                <td class="p-4">
                                    <h3 class="font-bold text-gray-800 text-base"><?= esc($item['judul']) ?></h3>
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-1" title="<?= esc($item['deskripsi']) ?>">
                                        <?= esc($item['deskripsi'] ?? 'Tidak ada deskripsi') ?>
                                    </p>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-2 text-sm text-gray-700 font-medium bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
                                        <i class="fa-regular fa-calendar text-[#00A859]"></i>
                                        <?php
                                        // Format tanggal (contoh: 11 Mar 2026)
                                        $mulai = date('d M Y', strtotime($item['tanggal_mulai']));
                                        if (!empty($item['tanggal_selesai']) && $item['tanggal_selesai'] != $item['tanggal_mulai']) {
                                            $selesai = date('d M Y', strtotime($item['tanggal_selesai']));
                                            echo $mulai . ' <i class="fa-solid fa-arrow-right text-gray-400 text-xs mx-1"></i> ' . $selesai;
                                        } else {
                                            echo $mulai;
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?= base_url('admin/kalender/edit/' . $item['id']) ?>" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors" title="Edit">
                                            <i class="fa-solid fa-pen-to-square text-sm"></i>
                                        </a>
                                        <a href="<?= base_url('admin/kalender/delete/' . $item['id']) ?>" onclick="return confirm('Yakin ingin menghapus agenda ini?')" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-colors" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-500">
                                <i class="fa-regular fa-calendar-xmark text-4xl text-gray-300 mb-3 block"></i>
                                Belum ada data agenda kalender akademik.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Prestasi</h2>
        <p class="text-sm text-gray-500">Kelola data prestasi siswa, guru, dan madrasah.</p>
    </div>
    <a href="<?= base_url('admin/prestasi/create') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-[#00A859] hover:bg-[#0B4A2D] text-white text-sm font-bold rounded-xl transition-colors shadow-sm">
        <i class="fa-solid fa-plus"></i> Tambah Prestasi
    </a>
</div>

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
        <i class="fa-solid fa-circle-check"></i>
        <p class="text-sm font-bold"><?= session()->getFlashdata('pesan') ?></p>
    </div>
<?php endif; ?>

<div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
    <form action="" method="get" class="w-full sm:w-auto flex items-center gap-2">
        <div class="relative w-full sm:w-80">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input type="text" name="cari" value="<?= esc($keyword ?? '') ?>" placeholder="Cari prestasi..." class="w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 transition-all text-sm">
        </div>
        <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-bold rounded-xl transition-colors">Cari</button>
        <?php if (!empty($keyword)): ?>
            <a href="<?= base_url('admin/prestasi') ?>" class="px-4 py-2 bg-red-50 text-red-500 hover:bg-red-100 text-sm font-bold rounded-xl transition-colors border border-red-100">Reset</a>
        <?php endif; ?>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-700 text-xs uppercase font-bold border-b border-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-4">Info Prestasi</th>
                    <th scope="col" class="px-6 py-4">Detail Penghargaan</th>
                    <th scope="col" class="px-6 py-4">Peraih Prestasi</th>
                    <th scope="col" class="px-6 py-4 text-center">Tahun</th>
                    <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if (!empty($prestasi)) : ?>
                    <?php foreach ($prestasi as $item) : ?>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden shrink-0">
                                        <?php if ($item['gambar']) : ?>
                                            <img src="<?= base_url('uploads/prestasi/' . $item['gambar']) ?>" alt="Poster" class="w-full h-full object-cover">
                                        <?php else : ?>
                                            <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fa-solid fa-trophy text-xl"></i></div>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800 text-base mb-1 line-clamp-1" title="<?= esc($item['judul']) ?>"><?= esc($item['judul']) ?></div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-green-50 text-green-700 border border-green-100 uppercase tracking-wider">
                                            <?= esc($item['kategori_prestasi']) ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-yellow-600 mb-1"><?= esc($item['juara']) ?></div>
                                <div class="text-xs text-gray-500 line-clamp-1" title="<?= esc($item['nama_lomba']) ?>"><?= esc($item['nama_lomba']) ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">
                                    <?php
                                    if ($item['kategori_prestasi'] == 'Guru') echo esc($item['nama_guru']);
                                    elseif ($item['kategori_prestasi'] == 'Madrasah') echo "MA Mabadi'ul Ihsan";
                                    else echo esc($item['nama_pemenang']);
                                    ?>
                                </div>
                                <?php if ($item['kelas']): ?>
                                    <div class="text-xs text-gray-500">Kelas: <?= esc($item['kelas']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center font-bold">
                                <?= esc($item['tahun_perolehan']) ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?= base_url('admin/prestasi/edit/' . $item['id']) ?>" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors" title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                    </a>
                                    <form action="<?= base_url('admin/prestasi/delete/' . $item['id']) ?>" method="post" class="inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus prestasi ini?')">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="fa-solid fa-trophy text-4xl text-gray-300 mb-3 block"></i>
                            <p class="font-bold text-gray-800">Belum ada data prestasi</p>
                            <p class="text-sm">Klik tombol "Tambah Prestasi" untuk memasukkan data baru.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6 flex justify-center">
    <?= $pager->links('prestasi', 'tailwind_pagination') // Sesuaikan dengan template pagination CI4 Mas 
    ?>
</div>

<?= $this->endSection() ?>
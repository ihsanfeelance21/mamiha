<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="p-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Data Pimpinan & Dewan Guru</h1>
            <p class="text-sm text-gray-500 mt-1">Manajemen daftar pimpinan, guru, dan staff madrasah.</p>
        </div>
        <a href="<?= base_url('admin/guru/tambah') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-[#00A859] hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all duration-200">
            <i class="fas fa-plus fa-sm"></i>
            Tambah Data Baru
        </a>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
            <span class="font-medium">Berhasil!</span> <?= session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-base font-bold text-gray-800">Daftar Pimpinan & Guru</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold w-16 text-center">No</th>
                        <th scope="col" class="px-6 py-4 font-semibold w-32">Foto</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Nama Lengkap</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Jabatan</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Kategori</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $no = 1;
                    foreach ($guru as $g) : ?>
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4 text-center font-medium text-gray-900">
                                <?= $no++ ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($g['foto'] && $g['foto'] != 'default.jpg') : ?>
                                    <img src="<?= base_url('uploads/guru/' . $g['foto']) ?>" alt="Foto" class="w-14 h-16 object-cover rounded-lg border border-gray-200 shadow-sm">
                                <?php else: ?>
                                    <div class="w-14 h-16 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center text-gray-400">
                                        <i class="fas fa-user text-xl"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                <?= esc($g['nama']) ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= esc($g['jabatan']) ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($g['kategori'] == 'pimpinan'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-700">
                                        Pimpinan
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-blue-100 text-blue-700">
                                        Guru
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= base_url('admin/guru/edit/' . $g['id']) ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-colors tooltip" title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/guru/hapus/' . $g['id']) ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-red-50 text-red-600 hover:bg-red-500 hover:text-white transition-colors tooltip" title="Hapus Data" onclick="return confirm('Yakin ingin menghapus data Bapak/Ibu <?= esc($g['nama']) ?>?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($guru)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-folder-open text-4xl text-gray-300 mb-3"></i>
                                    <p>Belum ada data pimpinan atau dewan guru yang ditambahkan.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
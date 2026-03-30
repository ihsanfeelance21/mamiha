<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manajemen User</h1>
        <p class="text-sm text-gray-500">Kelola akun administrator dan hak akses menu.</p>
    </div>
    <a href="<?= base_url('admin/users/tambah') ?>" class="bg-[#00A859] hover:bg-[#0B4A2D] text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
        <i class="fa-solid fa-user-plus"></i> Tambah User
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50/50 text-gray-400 text-[11px] uppercase font-bold border-b border-gray-100">
                <th class="px-6 py-4">User</th>
                <th class="px-6 py-4">Role</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php foreach ($users as $u) : ?>
                <tr class="hover:bg-green-50/30 transition-all">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="<?= base_url('uploads/users/' . ($u['foto'] ?: 'default.png')) ?>" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                            <div>
                                <p class="text-sm font-bold text-gray-700"><?= $u['nama_lengkap'] ?></p>
                                <p class="text-[11px] text-gray-400">@<?= $u['username'] ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-green-100 text-[#0B4A2D] text-[10px] font-bold rounded-full uppercase italic">
                            <?= $u['role'] ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="<?= base_url('admin/users/edit/' . $u['id_user']) ?>" class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                            <?php if ($u['id_user'] != 1) : ?>
                                <a href="<?= base_url('admin/users/hapus/' . $u['id_user']) ?>" onclick="return confirm('Hapus user ini?')" class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
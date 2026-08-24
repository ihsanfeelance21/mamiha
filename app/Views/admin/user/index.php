<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manajemen User</h1>
        <p class="text-sm text-gray-500">Kelola akun administrator dan hak akses menu. Hanya superadmin.</p>
    </div>
    <a href="<?= base_url('admin/users/tambah') ?>" class="bg-[#00A859] hover:bg-[#0B4A2D] text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all flex items-center gap-2 shadow-sm">
        <i class="fa-solid fa-user-plus"></i> Tambah User
    </a>
</div>

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-xl">
        <p class="text-sm font-medium"><?= esc(session()->getFlashdata('pesan')) ?></p>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-xl">
        <?php $err = session()->getFlashdata('error'); ?>
        <?php if (is_array($err)) : ?>
            <ul class="list-disc list-inside text-sm"><?php foreach ($err as $e) : ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
        <?php else : ?>
            <p class="text-sm"><?= esc($err) ?></p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-4 flex flex-col md:flex-row gap-3 justify-between">
    <form method="get" class="flex gap-2 w-full md:w-96">
        <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama/username..." class="flex-1 bg-gray-50 border border-gray-100 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#00A859]">
        <button type="submit" class="bg-gray-800 hover:bg-black text-white px-5 rounded-xl text-sm font-bold">Cari</button>
        <?php if (!empty($keyword)) : ?>
            <a href="<?= base_url('admin/users') ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2.5 rounded-xl text-sm font-bold">Reset</a>
        <?php endif; ?>
    </form>
    <div class="text-xs text-gray-400 flex items-center">
        Total: <?= isset($pager) ? $pager->getDetails('users')['total'] ?? count($users) : count($users) ?> user
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-400 text-[11px] uppercase font-bold border-b border-gray-100">
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4">Dibuat</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php if (empty($users)) : ?>
                    <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">Tidak ada user ditemukan.</td></tr>
                <?php else : ?>
                    <?php foreach ($users as $u) : ?>
                        <tr class="hover:bg-green-50/30 transition-all">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="<?= base_url('uploads/users/' . ($u['foto'] ?: 'default.png')) ?>" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm" alt="Foto" onerror="this.src='<?= base_url('uploads/users/default.png') ?>'">
                                    <div>
                                        <p class="text-sm font-bold text-gray-700"><?= esc($u['nama_lengkap']) ?></p>
                                        <p class="text-[11px] text-gray-400">@<?= esc($u['username']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-[10px] font-bold rounded-full uppercase italic <?= $u['role'] === 'superadmin' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-[#0B4A2D]' ?>">
                                    <i class="fa-solid <?= $u['role'] === 'superadmin' ? 'fa-crown' : 'fa-user' ?> mr-1"></i><?= esc($u['role']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500"><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="<?= base_url('admin/users/edit/' . $u['id_user']) ?>" class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all" title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <?php if ($u['id_user'] != 1 && $u['id_user'] != session()->get('id_user')) : ?>
                                        <form action="<?= base_url('admin/users/hapus/' . $u['id_user']) ?>" method="post" onsubmit="return confirm('Hapus user <?= esc($u['username']) ?>?')" style="display:inline"><?= csrf_field() ?><button type="submit" class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button></form>
                                    <?php else : ?>
                                        <span class="w-8 h-8 flex items-center justify-center bg-gray-100 text-gray-300 rounded-lg" title="Dilindungi"><i class="fa-solid fa-lock text-xs"></i></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (isset($pager)) : ?>
        <div class="p-4 border-t border-gray-100 flex justify-center">
            <div class="[&>ul]:flex [&>ul]:gap-2 [&>ul>li>a]:px-3 [&>ul>li>a]:py-1.5 [&>ul>li>a]:bg-white [&>ul>li>a]:border [&>ul>li>a]:rounded-lg [&>ul>li.active>a]:bg-[#00A859] [&>ul>li.active>a]:text-white">
                <?= $pager->links('users') ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

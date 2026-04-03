<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl">
    <div class="mb-8">
        <a href="<?= base_url('admin/users') ?>" class="text-[#00A859] text-sm font-bold flex items-center gap-2 mb-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit User: <span class="text-green-600"><?= esc($user['nama_lengkap']) ?></span></h1>
    </div>

    <form action="<?= base_url('admin/users/update/' . $user['id_user']) ?>" method="POST">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-4">
                <h3 class="font-bold text-gray-800 border-b border-gray-50 pb-3 mb-4 text-sm uppercase tracking-wider">Informasi Akun</h3>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="<?= esc($user['nama_lengkap']) ?>" required class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 focus:outline-none focus:border-[#00A859]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Username</label>
                    <input type="text" name="username" value="<?= esc($user['username']) ?>" required class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 focus:outline-none focus:border-[#00A859]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Role Utama</label>
                    <select name="role" required class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 focus:outline-none focus:border-[#00A859]">
                        <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : '' ?>>Admin Biasa</option>
                        <option value="superadmin" <?= ($user['role'] == 'superadmin') ? 'selected' : '' ?>>Superadmin</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Password Baru <br><span class="text-gray-400 font-normal normal-case">(Kosongkan jika tidak ingin diganti)</span></label>
                    <input type="password" name="password" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 focus:outline-none focus:border-[#00A859]">
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 border-b border-gray-50 pb-3 mb-4 text-sm uppercase tracking-wider">Hak Akses Menu</h3>
                <p class="text-[11px] text-gray-400 mb-4 italic">*Pilih / sesuaikan menu yang boleh dikelola oleh user ini.</p>

                <div class="overflow-hidden border border-gray-50 rounded-2xl">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-500 text-[10px] uppercase font-bold">
                            <tr>
                                <th class="px-4 py-3">Nama Menu</th>
                                <th class="px-4 py-3 text-center text-green-600 font-black italic underline">Akses</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <?php foreach ($menus as $menu) : ?>
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-600"><?= esc($menu['nama']) ?></td>
                                    <td class="px-4 py-3 text-center">
                                        <input type="checkbox" name="permissions[]" value="<?= esc($menu['slug']) ?>"
                                            class="w-5 h-5 accent-[#00A859] rounded border-gray-300"
                                            <?= in_array($menu['slug'], $user_permissions) ? 'checked' : '' ?>>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <button type="submit" class="w-full bg-[#00A859] hover:bg-[#0B4A2D] text-white font-bold py-4 rounded-2xl shadow-lg transition-all">
            Perbarui Data User
        </button>
    </form>
</div>

<?= $this->endSection() ?>
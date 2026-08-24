<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="<?= base_url('admin/users') ?>" class="text-[#00A859] text-sm font-bold flex items-center gap-2 mb-2 hover:underline">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Edit User: <span class="text-green-600"><?= esc($user['nama_lengkap']) ?></span></h1>
            <p class="text-sm text-gray-500">Perbarui data akun & hak akses granular.</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-xl">
            <?php $err = session()->getFlashdata('error'); ?>
            <?php if (is_array($err)) : ?>
                <ul class="list-disc list-inside text-sm">
                    <?php foreach ($err as $e) : ?><li><?= esc($e) ?></li><?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="text-sm"><?= esc($err) ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/users/update/' . $user['id_user']) ?>" method="POST" enctype="multipart/form-data" x-data="{ role: '<?= old('role', $user['role']) ?>' }">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-4">
                <h3 class="font-bold text-gray-800 border-b border-gray-50 pb-3 text-sm uppercase tracking-wider">Informasi Akun</h3>

                <div class="flex items-center gap-4">
                    <img src="<?= base_url('uploads/users/' . ($user['foto'] ?: 'default.png')) ?>" class="w-16 h-16 rounded-full object-cover border-2 border-gray-100 shadow-sm" alt="Foto">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase">Foto Saat Ini</p>
                        <p class="text-sm font-medium text-gray-700"><?= esc($user['foto'] ?? 'default.png') ?></p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Ganti Foto <span class="text-gray-400 font-normal normal-case">(opsional, max 2MB)</span></label>
                    <input type="file" name="foto" accept="image/*" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2.5 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="<?= old('nama_lengkap', esc($user['nama_lengkap'])) ?>" required class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 focus:outline-none focus:border-[#00A859]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Username <span class="text-red-500">*</span></label>
                    <input type="text" name="username" value="<?= old('username', esc($user['username'])) ?>" required class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 focus:outline-none focus:border-[#00A859]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Role Utama <span class="text-red-500">*</span></label>
                    <select name="role" x-model="role" required class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 focus:outline-none">
                        <option value="admin" <?= old('role', $user['role']) == 'admin' ? 'selected' : '' ?>>Admin Biasa</option>
                        <option value="superadmin" <?= old('role', $user['role']) == 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
                    </select>
                    <p class="text-[11px] text-gray-500 mt-2">
                        <span x-show="role === 'superadmin'" class="text-amber-600 font-semibold"><i class="fa-solid fa-crown mr-1"></i>Superadmin bypass semua izin.</span>
                        <span x-show="role === 'admin'" class="text-gray-400">Hanya akses menu dicentang.</span>
                    </p>
                </div>

                <div x-data="{ show: false, show2: false }">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Password Baru <span class="text-gray-400 font-normal normal-case">(kosongkan jika tidak ganti)</span></label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 pr-10 focus:outline-none focus:border-[#00A859]" placeholder="Minimal 8 karakter jika diisi">
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"><i :class="show ? 'fa-eye-slash' : 'fa-eye'" class="fa-solid"></i></button>
                    </div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2 mt-3">Konfirmasi Password</label>
                    <div class="relative">
                        <input :type="show2 ? 'text' : 'password'" name="password_confirm" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 pr-10 focus:outline-none focus:border-[#00A859]" placeholder="Ulangi password baru">
                        <button type="button" @click="show2 = !show2" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"><i :class="show2 ? 'fa-eye-slash' : 'fa-eye'" class="fa-solid"></i></button>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col" x-data="{ allChecked: false }">
                <div class="flex items-center justify-between border-b border-gray-50 pb-3 mb-4">
                    <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wider">Hak Akses Menu</h3>
                    <label class="flex items-center gap-2 text-xs font-bold text-[#00A859] cursor-pointer">
                        <input type="checkbox" @click="allChecked = !allChecked; document.querySelectorAll('.perm-check').forEach(c => { if(!c.disabled) c.checked = allChecked })" class="w-4 h-4 accent-[#00A859]"> Pilih Semua
                    </label>
                </div>

                <div class="space-y-4 overflow-y-auto max-h-[520px] pr-1" :class="role === 'superadmin' ? 'opacity-40 pointer-events-none' : ''">
                    <?php foreach ($menus_grouped as $group => $items) : ?>
                        <div class="border border-gray-50 rounded-2xl overflow-hidden" x-data="{ groupChecked: false }">
                            <div class="bg-gray-50 px-4 py-2.5 flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-600 uppercase tracking-wider"><?= esc($group) ?></span>
                                <label class="flex items-center gap-1.5 text-[11px] font-bold text-gray-500 cursor-pointer">
                                    <input type="checkbox" @click="groupChecked = !groupChecked; $el.closest('.border').querySelectorAll('.perm-check').forEach(c => c.checked = groupChecked)" class="w-3.5 h-3.5 accent-[#00A859]"> Semua
                                </label>
                            </div>
                            <div class="divide-y divide-gray-50">
                                <?php foreach ($items as $menu) : ?>
                                    <?php $checked = in_array($menu['slug'], old('permissions', $user_permissions)) ? 'checked' : ''; ?>
                                    <label class="flex items-center justify-between px-4 py-2.5 hover:bg-green-50/50 cursor-pointer transition">
                                        <span class="text-sm font-medium text-gray-600"><?= esc($menu['nama']) ?></span>
                                        <input type="checkbox" name="permissions[]" value="<?= esc($menu['slug']) ?>" <?= $checked ?> class="perm-check w-5 h-5 accent-[#00A859] rounded border-gray-300">
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p x-show="role === 'superadmin'" class="text-xs text-amber-600 mt-3 bg-amber-50 p-2 rounded-lg"><i class="fa-solid fa-info-circle mr-1"></i> Superadmin akses penuh, centang diabaikan.</p>
            </div>
        </div>

        <button type="submit" class="w-full bg-[#00A859] hover:bg-[#0B4A2D] text-white font-bold py-4 rounded-2xl shadow-lg transition-all flex items-center justify-center gap-2">
            <i class="fa-solid fa-floppy-disk"></i> Perbarui Data User
        </button>
    </form>
</div>

<?= $this->endSection() ?>

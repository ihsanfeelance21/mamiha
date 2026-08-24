<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="<?= base_url('admin/users') ?>" class="text-[#00A859] text-sm font-bold flex items-center gap-2 mb-2 hover:underline">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Tambah User Baru</h1>
            <p class="text-sm text-gray-500">Buat akun admin dengan hak akses granular per-menu.</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-xl">
            <p class="font-bold text-sm">Gagal menyimpan</p>
            <?php $err = session()->getFlashdata('error'); ?>
            <?php if (is_array($err)) : ?>
                <ul class="list-disc list-inside text-sm mt-1">
                    <?php foreach ($err as $e) : ?><li><?= esc($e) ?></li><?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="text-sm"><?= esc($err) ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/users/simpan') ?>" method="POST" enctype="multipart/form-data" x-data="{ role: '<?= old('role', 'admin') ?>' }">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Informasi Akun -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 space-y-4">
                <h3 class="font-bold text-gray-800 border-b border-gray-50 pb-3 text-sm uppercase tracking-wider">Informasi Akun</h3>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Foto Profil <span class="text-gray-400 font-normal normal-case">(opsional, max 2MB)</span></label>
                    <input type="file" name="foto" accept="image/*" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#00A859] text-sm">
                    <p class="text-[11px] text-gray-400 mt-1">Format: JPG, PNG, WebP. Kosongkan untuk pakai default.png</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" required minlength="3" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 focus:outline-none focus:border-[#00A859] focus:bg-white" placeholder="Contoh: Ahmad Surya">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Username <span class="text-red-500">*</span></label>
                    <input type="text" name="username" value="<?= old('username') ?>" required minlength="4" pattern="[A-Za-z0-9]+"
                        class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 focus:outline-none focus:border-[#00A859] focus:bg-white" placeholder="huruf/angka tanpa spasi">
                    <p class="text-[11px] text-gray-400 mt-1">Minimal 4 karakter, unik, tanpa spasi.</p>
                </div>

                <div x-data="{ show: false, show2: false }">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" required minlength="8"
                            class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 pr-10 focus:outline-none focus:border-[#00A859] focus:bg-white" placeholder="Minimal 8 karakter">
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i :class="show ? 'fa-eye-slash' : 'fa-eye'" class="fa-solid"></i>
                        </button>
                    </div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2 mt-3">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input :type="show2 ? 'text' : 'password'" name="password_confirm" required minlength="8"
                            class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 pr-10 focus:outline-none focus:border-[#00A859] focus:bg-white" placeholder="Ulangi password">
                        <button type="button" @click="show2 = !show2" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i :class="show2 ? 'fa-eye-slash' : 'fa-eye'" class="fa-solid"></i>
                        </button>
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">Gunakan kombinasi huruf & angka untuk keamanan.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Role Utama <span class="text-red-500">*</span></label>
                    <select name="role" x-model="role" required class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 focus:outline-none focus:border-[#00A859]">
                        <option value="admin">Admin Biasa</option>
                        <option value="superadmin">Superadmin</option>
                    </select>
                    <p class="text-[11px] text-gray-500 mt-2 leading-relaxed">
                        <span x-show="role === 'superadmin'" class="text-amber-600 font-semibold"><i class="fa-solid fa-crown mr-1"></i>Superadmin bypass semua cek izin (akses semua menu otomatis, hak granular diabaikan).</span>
                        <span x-show="role === 'admin'" class="text-gray-400">Admin biasa hanya bisa akses menu yang dicentang di samping.</span>
                    </p>
                </div>
            </div>

            <!-- Hak Akses Menu -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col" x-data="{ allChecked: false }">
                <div class="flex items-center justify-between border-b border-gray-50 pb-3 mb-4">
                    <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wider">Hak Akses Menu</h3>
                    <label class="flex items-center gap-2 text-xs font-bold text-[#00A859] cursor-pointer">
                        <input type="checkbox" @click="allChecked = !allChecked; document.querySelectorAll('.perm-check').forEach(c => { if(!c.disabled) c.checked = allChecked })" class="w-4 h-4 accent-[#00A859]">
                        Pilih Semua
                    </label>
                </div>
                <p class="text-[11px] text-gray-400 mb-3 italic">*Pilih menu yang boleh dikelola user ini. Kosong = tidak ada akses (kecuali superadmin).</p>

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
                                    <label class="flex items-center justify-between px-4 py-2.5 hover:bg-green-50/50 cursor-pointer transition">
                                        <span class="text-sm font-medium text-gray-600"><?= esc($menu['nama']) ?></span>
                                        <input type="checkbox" name="permissions[]" value="<?= esc($menu['slug']) ?>" <?= in_array($menu['slug'], old('permissions', [])) ? 'checked' : '' ?> class="perm-check w-5 h-5 accent-[#00A859] rounded border-gray-300">
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p x-show="role === 'superadmin'" class="text-xs text-amber-600 mt-3 bg-amber-50 p-2 rounded-lg"><i class="fa-solid fa-info-circle mr-1"></i> Superadmin tidak perlu centang, otomatis akses penuh.</p>
            </div>
        </div>

        <button type="submit" class="w-full bg-[#00A859] hover:bg-[#0B4A2D] text-white font-bold py-4 rounded-2xl shadow-lg transition-all flex items-center justify-center gap-2">
            <i class="fa-solid fa-floppy-disk"></i> Simpan User Baru
        </button>
    </form>
</div>

<?= $this->endSection() ?>

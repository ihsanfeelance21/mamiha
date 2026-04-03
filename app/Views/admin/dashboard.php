<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="relative overflow-hidden bg-linear-to-br from-[#0B4A2D] to-[#00A859] rounded-4xl p-8 mb-8 shadow-xl text-white">
    <div class="relative z-10">
        <div class="flex items-center gap-2 bg-white/20 backdrop-blur-md w-fit px-4 py-1.5 rounded-full border border-white/10 mb-6">
            <i class="fa-solid fa-calendar-day text-xs"></i>
            <span class="text-[11px] font-bold uppercase tracking-wider"><?= date('d F Y') ?></span>
        </div>

        <h1 class="text-3xl md:text-4xl font-black mb-3 leading-tight">
            Selamat Datang, <br class="md:hidden">
            <span class="text-yellow-300"><?= session()->get('nama_lengkap') ?>!</span> 👋
        </h1>
        <p class="text-green-50/80 max-w-2xl text-sm md:text-base leading-relaxed mb-8">
            Ini adalah pusat kendali utama Anda. Pantau perkembangan data akademik, publikasikan berita terbaru, dan kelola konfigurasi website dengan mudah.
        </p>

        <div class="flex flex-wrap gap-3">
            <a href="<?= base_url() ?>" target="_blank" class="bg-white text-[#0B4A2D] px-6 py-3 rounded-xl font-bold text-sm hover:shadow-lg hover:scale-105 transition-all flex items-center gap-2">
                <i class="fa-solid fa-globe"></i> Lihat Website
            </a>
            <a href="<?= base_url('admin/profil') ?>" class="bg-[#083a23]/40 backdrop-blur-md text-white border border-white/20 px-6 py-3 rounded-xl font-bold text-sm hover:bg-[#083a23]/60 transition-all flex items-center gap-2">
                <i class="fa-solid fa-user-gear"></i> Pengaturan Profil
            </a>
        </div>
    </div>

    <div class="absolute -right-12 -bottom-12 opacity-10 text-[200px] rotate-12">
        <i class="fa-solid fa-mosque"></i>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 hover:border-[#00A859] transition-all group">
        <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-[#00A859] group-hover:bg-[#00A859] group-hover:text-white transition-all">
            <i class="fa-solid fa-user-plus text-xl"></i>
        </div>
        <div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">PPDB</p>
            <p class="text-2xl font-black text-gray-800"><?= $stats['pendaftar'] ?></p>
        </div>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
        <h3 class="font-bold text-gray-800 flex items-center gap-3">
            <div class="w-2 h-6 bg-[#00A859] rounded-full"></div>
            Riwayat Aktivitas Login
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="text-gray-400 text-[11px] uppercase font-bold border-b border-gray-50">
                <tr>
                    <th class="px-8 py-4">Administrator</th>
                    <th class="px-8 py-4">Waktu Akses</th>
                    <th class="px-8 py-4">Alamat IP</th>
                    <th class="px-8 py-4">Perangkat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($logs as $log) : ?>
                    <tr class="hover:bg-green-50/30 transition-all">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <img src="<?= base_url('uploads/users/' . ($log['foto'] ?: 'default.png')) ?>" class="w-9 h-9 rounded-full object-cover border-2 border-white shadow-sm">
                                <span class="text-sm font-bold text-gray-700"><?= $log['nama_lengkap'] ?></span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-sm text-gray-500 font-medium">
                            <?= date('d M Y, H:i', strtotime($log['login_at'])) ?>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 bg-gray-100 rounded-lg text-[10px] font-mono font-bold text-gray-600 italic"><?= $log['ip_address'] ?></span>
                        </td>
                        <td class="px-8 py-5 text-[11px] text-gray-400 max-w-xs truncate italic">
                            <?= $log['user_agent'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (session()->getFlashdata('success_login')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Masuk!',
            text: 'Selamat bertugas di panel admin.',
            showConfirmButton: false,
            timer: 2500,
            background: '#ffffff',
            iconColor: '#00A859',
            customClass: {
                popup: 'rounded-3xl'
            }
        });
    </script>
<?php endif; ?>
<?= $this->endSection() ?>
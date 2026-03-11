<?= $this->extend('layouts/admin') ?> <?= $this->section('content') ?>
<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Kelola Profil Madrasah</h2>
        <p class="text-gray-500 text-sm mt-1">Atur informasi Kilas Balik, Visi Misi, Fasilitas, dan Tentang Kami.</p>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p><?= session()->getFlashdata('pesan') ?></p>
        </div>
    <?php endif; ?>

    <div x-data="{ activeTab: 'umum' }" class="bg-white rounded-xl shadow-sm border border-gray-100">

        <div class="flex border-b border-gray-200">
            <button @click="activeTab = 'umum'" :class="activeTab === 'umum' ? 'border-b-2 border-[#00A859] text-[#00A859] font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-4 text-sm font-medium focus:outline-none transition-colors">
                Informasi Umum (Kilas Balik, Visi Misi, Video)
            </button>
            <button @click="activeTab = 'fasilitas'" :class="activeTab === 'fasilitas' ? 'border-b-2 border-[#00A859] text-[#00A859] font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-4 text-sm font-medium focus:outline-none transition-colors">
                Kelola Fasilitas & Galeri
            </button>
        </div>

        <div class="p-6">

            <div x-show="activeTab === 'umum'" x-transition>
                <form action="<?= base_url('admin/profil/update-umum') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                        <div class="space-y-6">
                            <h3 class="text-lg font-bold text-gray-800 border-b pb-2">1. Kilas Balik Madrasah</h3>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Kilas Balik</label>
                                <textarea name="kilas_balik_deskripsi" rows="5" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#00A859] focus:ring focus:ring-[#00A859]/20"><?= old('kilas_balik_deskripsi', $profil['kilas_balik_deskripsi']) ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Kilas Balik</label>
                                <?php if ($profil['kilas_balik_foto']): ?>
                                    <img src="<?= base_url('uploads/profil/' . $profil['kilas_balik_foto']) ?>" class="h-32 rounded-lg mb-2 object-cover">
                                <?php endif; ?>
                                <input type="file" name="kilas_balik_foto" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                <p class="text-xs text-gray-400 mt-1">*Kosongkan jika tidak ingin mengganti foto.</p>
                            </div>

                            <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mt-8">2. Visi & Misi</h3>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Visi</label>
                                <textarea name="visi" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#00A859] focus:ring focus:ring-[#00A859]/20"><?= old('visi', $profil['visi']) ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Misi</label>
                                <textarea name="misi" rows="5" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#00A859] focus:ring focus:ring-[#00A859]/20"><?= old('misi', $profil['misi']) ?></textarea>
                            </div>
                        </div>

                        <div class="space-y-6 bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-800 border-b pb-2">3. Tentang Kami (Beranda)</h3>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Section</label>
                                <input type="text" name="tentang_kami_judul" value="<?= old('tentang_kami_judul', $profil['tentang_kami_judul']) ?>" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#00A859] focus:ring focus:ring-[#00A859]/20">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Pendek</label>
                                <textarea name="tentang_kami_deskripsi" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#00A859] focus:ring focus:ring-[#00A859]/20"><?= old('tentang_kami_deskripsi', $profil['tentang_kami_deskripsi']) ?></textarea>
                            </div>

                            <div class="pt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Video</label>
                                <select name="tentang_kami_video_tipe" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#00A859] focus:ring focus:ring-[#00A859]/20 mb-4">
                                    <option value="link" <?= $profil['tentang_kami_video_tipe'] == 'link' ? 'selected' : '' ?>>Link Youtube</option>
                                    <option value="upload" <?= $profil['tentang_kami_video_tipe'] == 'upload' ? 'selected' : '' ?>>Upload File (Belum aktif, pakai Link dulu)</option>
                                </select>

                                <label class="block text-sm font-medium text-gray-700 mb-2">Link Youtube (Embed URL)</label>
                                <input type="text" name="tentang_kami_video" value="<?= old('tentang_kami_video', $profil['tentang_kami_video']) ?>" placeholder="Contoh: https://www.youtube.com/embed/xxxxx" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#00A859] focus:ring focus:ring-[#00A859]/20">
                                <p class="text-xs text-gray-500 mt-2">Gunakan URL Embed Youtube agar bisa diputar langsung di website.</p>
                            </div>
                        </div>

                    </div>
                    <div class="mt-8 flex justify-end border-t pt-4">
                        <button type="submit" class="px-6 py-2.5 bg-[#00A859] hover:bg-[#0B4A2D] text-white font-bold rounded-lg shadow-md transition-colors">
                            <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>

            <div x-show="activeTab === 'fasilitas'" x-cloak x-data="{ showModalAdd: false, showModalEdit: false, editData: {} }">

                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Daftar Fasilitas Madrasah</h3>
                        <p class="text-sm text-gray-500">Kelola card fasilitas yang tampil di beranda.</p>
                    </div>
                    <button @click="showModalAdd = true" class="px-4 py-2 bg-[#00A859] hover:bg-[#0B4A2D] text-white font-bold rounded-lg shadow transition-colors">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Fasilitas
                    </button>
                </div>

                <div class="overflow-x-auto bg-white rounded-xl border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fasilitas & Cover</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php if (empty($fasilitas)): ?>
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-gray-500">Belum ada data fasilitas. Silakan tambah baru.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($fasilitas as $f): ?>
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="h-12 w-16 shrink-0 rounded overflow-hidden bg-gray-100">
                                                    <?php if ($f['foto_cover']): ?>
                                                        <img class="h-full w-full object-cover" src="<?= base_url('uploads/fasilitas/' . $f['foto_cover']) ?>" alt="">
                                                    <?php else: ?>
                                                        <div class="flex items-center justify-center h-full w-full text-gray-400"><i class="fa-solid fa-image"></i></div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900">
                                                        <i class="<?= esc($f['icon']) ?> text-[#00A859] w-5"></i> <?= esc($f['judul']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-500 line-clamp-2"><?= esc($f['deskripsi']) ?></div>
                                        </td>
                                        <td class="px-6 py-4 text-center space-x-2">
                                            <a href="<?= base_url('admin/profil/fasilitas/galeri/' . $f['id']) ?>" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 text-sm font-medium transition-colors">
                                                <i class="fa-solid fa-images mr-1"></i> Galeri
                                            </a>

                                            <button @click="editData = <?= htmlspecialchars(json_encode($f)) ?>; showModalEdit = true" class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 rounded-md hover:bg-yellow-200 text-sm font-medium transition-colors">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <a href="<?= base_url('admin/profil/fasilitas/hapus/' . $f['id']) ?>" onclick="return confirm('Yakin ingin menghapus fasilitas ini? Semua foto galeri di dalamnya akan ikut terhapus!')" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 text-sm font-medium transition-colors">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div x-show="showModalAdd" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div x-show="showModalAdd" @click="showModalAdd = false" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
                        <div class="relative inline-block w-full max-w-lg p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Tambah Fasilitas Baru</h3>
                            <form action="<?= base_url('admin/profil/fasilitas/simpan') ?>" method="POST" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Fasilitas</label>
                                        <input type="text" name="judul" required placeholder="Contoh: Laboratorium Komputer" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#00A859] focus:ring focus:ring-[#00A859]/20">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Class Icon (FontAwesome)</label>
                                        <input type="text" name="icon" required placeholder="Contoh: fa-solid fa-computer" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#00A859] focus:ring focus:ring-[#00A859]/20">
                                        <a href="https://fontawesome.com/search?o=r&m=free" target="_blank" class="text-xs text-[#00A859] hover:underline mt-1 inline-block">Cari referensi icon di sini &rarr;</a>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                                        <textarea name="deskripsi" rows="3" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#00A859] focus:ring focus:ring-[#00A859]/20"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Utama (Cover)</label>
                                        <input type="file" name="foto_cover" required accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end gap-3">
                                    <button type="button" @click="showModalAdd = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Batal</button>
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-[#00A859] border border-transparent rounded-lg hover:bg-[#0B4A2D]">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div x-show="showModalEdit" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div x-show="showModalEdit" @click="showModalEdit = false" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
                        <div class="relative inline-block w-full max-w-lg p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Fasilitas</h3>
                            <form :action="'<?= base_url('admin/profil/fasilitas/update/') ?>' + editData.id" method="POST" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Fasilitas</label>
                                        <input type="text" name="judul" x-model="editData.judul" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#00A859] focus:ring focus:ring-[#00A859]/20">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Class Icon (FontAwesome)</label>
                                        <input type="text" name="icon" x-model="editData.icon" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#00A859] focus:ring focus:ring-[#00A859]/20">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                                        <textarea name="deskripsi" x-model="editData.deskripsi" rows="3" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-[#00A859] focus:ring focus:ring-[#00A859]/20"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Foto Utama (Opsional)</label>
                                        <input type="file" name="foto_cover" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end gap-3">
                                    <button type="button" @click="showModalEdit = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Batal</button>
                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-[#00A859] border border-transparent rounded-lg hover:bg-[#0B4A2D]">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<?= $this->endSection() ?>
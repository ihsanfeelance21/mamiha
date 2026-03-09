<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Pendaftaran (PPDB)</h2>
            <p class="text-sm text-gray-600">Atur poster, brosur, dan metode pendaftaran siswa baru.</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm" role="alert">
            <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/pendaftaran/update') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="mb-8 border-b pb-6">
                <h4 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-toggle-on text-green-600"></i> Status Pendaftaran
                </h4>
                <div class="flex items-center gap-6 mb-4">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="status_ppdb" value="buka" onclick="toggleTutup(false)" class="w-4 h-4 text-green-600" <?= ($pendaftaran['status_ppdb'] == 'buka') ? 'checked' : '' ?>>
                        <span class="ml-2 text-sm font-medium text-gray-700">Buka Pendaftaran</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="status_ppdb" value="tutup" onclick="toggleTutup(true)" class="w-4 h-4 text-red-600" <?= ($pendaftaran['status_ppdb'] == 'tutup') ? 'checked' : '' ?>>
                        <span class="ml-2 text-sm font-medium text-gray-700">Tutup Pendaftaran</span>
                    </label>
                </div>

                <div id="pengaturanTutup" class="p-4 bg-red-50 border border-red-100 rounded-lg <?= ($pendaftaran['status_ppdb'] == 'tutup') ? '' : 'hidden' ?>">
                    <h5 class="font-semibold text-red-700 mb-3 text-sm">Kustomisasi Pop-up "Pendaftaran Ditutup"</h5>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pesan Pemberitahuan</label>
                            <textarea name="pesan_tutup" rows="2" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-red-500 text-sm" placeholder="Contoh: Mohon maaf, kuota telah terpenuhi..."><?= esc($pendaftaran['pesan_tutup'] ?? '') ?></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Link WA Admin PPDB</label>
                            <input type="text" name="link_admin_ppdb" value="<?= esc($pendaftaran['link_admin_ppdb'] ?? '') ?>" placeholder="https://wa.me/6281..." class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-red-500 text-sm">
                            <p class="text-[10px] text-gray-500 mt-1 italic">*Kosongkan jika ingin menggunakan nomor WA utama sekolah.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Poster PPDB (Pop-up)</label>
                    <?php if (!empty($pendaftaran['poster'])) : ?>
                        <div class="mb-3">
                            <img src="<?= base_url('uploads/ppdb/' . $pendaftaran['poster']) ?>" class="w-40 h-auto rounded border shadow-sm">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="poster" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 w-full">
                    <p class="text-[10px] text-gray-500 mt-2 italic">*Akan muncul sebagai jendela pop-up saat web dibuka.</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Brosur PPDB (PDF/Image)</label>
                    <?php if (!empty($pendaftaran['brosur'])) : ?>
                        <div class="mb-3 flex items-center gap-2 p-2 bg-gray-50 rounded border">
                            <i class="fa-solid fa-file-pdf text-red-500 text-xl"></i>
                            <span class="text-xs truncate max-w-37.5"><?= $pendaftaran['brosur'] ?></span>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="brosur" accept=".pdf,image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 w-full">
                    <p class="text-[10px] text-gray-500 mt-2 italic">*File yang bisa diunduh oleh calon pendaftar.</p>
                </div>
            </div>

            <div class="border-t pt-6">
                <h4 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-link text-green-600"></i> Pengaturan Tombol Daftar
                </h4>

                <div class="space-y-4">
                    <div class="flex items-center gap-6 mb-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="tipe_daftar" value="internal" onclick="toggleLink(false)" class="w-4 h-4 text-green-600" <?= ($pendaftaran['tipe_daftar'] == 'internal') ? 'checked' : '' ?>>
                            <span class="ml-2 text-sm text-gray-700">Gunakan Form Website</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="tipe_daftar" value="eksternal" onclick="toggleLink(true)" class="w-4 h-4 text-green-600" <?= ($pendaftaran['tipe_daftar'] == 'eksternal') ? 'checked' : '' ?>>
                            <span class="ml-2 text-sm text-gray-700">Link Eksternal (Google Form/Lainnya)</span>
                        </label>
                    </div>

                    <div id="inputLinkEksternal" class="<?= ($pendaftaran['tipe_daftar'] == 'eksternal') ? '' : 'hidden' ?>">
                        <label class="block text-sm font-medium text-gray-700 mb-1">URL Pendaftaran Eksternal</label>
                        <input type="url" name="link_daftar" value="<?= $pendaftaran['link_daftar'] ?>" placeholder="https://forms.gle/..." class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-1 focus:ring-green-500">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-[#0B4A2D] hover:bg-green-800 text-white font-bold py-2 px-8 rounded-md shadow-md transition duration-200">
                Simpan Konfigurasi PPDB
            </button>
        </div>
    </form>
</div>

<script>
    function toggleLink(isExternal) {
        const linkInput = document.getElementById('inputLinkEksternal');
        if (isExternal) {
            linkInput.classList.remove('hidden');
        } else {
            linkInput.classList.add('hidden');
        }
    }

    function toggleTutup(isTutup) {
        const divTutup = document.getElementById('pengaturanTutup');
        if (isTutup) {
            divTutup.classList.remove('hidden');
        } else {
            divTutup.classList.add('hidden');
        }
    }
</script>
<?= $this->endSection() ?>
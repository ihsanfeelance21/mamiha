<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-2xl font-bold text-text-main"><?= $title ?></h3>
        <p class="text-sm text-gray-500 mt-1">Buat label atau hashtag untuk mengelompokkan berita.</p>
    </div>
    <a href="<?= base_url('admin/berita') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded transition font-medium text-sm flex items-center gap-2">
        &larr; Kembali ke Berita
    </a>
</div>

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="bg-green-100 border-l-4 border-primary text-green-700 p-4 mb-6 rounded shadow-sm">
        <?= session()->getFlashdata('pesan') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 sticky top-6">
            <h4 class="text-lg font-semibold text-text-main mb-4 border-b pb-2">Tambah Tag Baru</h4>
            <form action="<?= base_url('admin/berita/simpanTag') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-4">
                    <label class="block text-text-main font-medium mb-2 text-sm">Nama Tag <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_tag" value="<?= old('nama_tag') ?>" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition" placeholder="Contoh: PPDB 2026, Prestasi..." required>
                </div>

                <div class="mb-5">
                    <label class="block text-text-main font-medium mb-2 text-sm">Link Eksternal (Opsional)</label>
                    <input type="url" name="link_eksternal" value="<?= old('link_eksternal') ?>" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition" placeholder="https://kemenag.go.id">
                    <p class="text-xs text-gray-400 mt-1">Isi jika tag ini ingin diarahkan ke website luar.</p>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white font-medium py-2 px-4 rounded shadow-sm transition">
                    Simpan Tag
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 overflow-x-auto">
            <h4 class="text-lg font-semibold text-text-main mb-4 border-b pb-2">Daftar Tag Tersedia</h4>

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface border-b border-gray-200">
                        <th class="p-3 text-text-muted font-semibold text-sm w-12 text-center">No</th>
                        <th class="p-3 text-text-muted font-semibold text-sm">Nama Tag</th>
                        <th class="p-3 text-text-muted font-semibold text-sm">Link Eksternal</th>
                        <th class="p-3 text-text-muted font-semibold text-sm text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tags)) : ?>
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-400 italic border-b border-gray-100">Belum ada tag yang dibuat.</td>
                        </tr>
                    <?php else : ?>
                        <?php $i = 1;
                        foreach ($tags as $t) : ?>
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="p-3 text-sm text-center text-gray-500"><?= $i++ ?></td>
                                <td class="p-3">
                                    <span class="bg-gray-100 text-gray-700 text-sm px-2.5 py-1 rounded-full font-medium border border-gray-200">
                                        #<?= $t['nama_tag'] ?>
                                    </span>
                                </td>
                                <td class="p-3 text-sm">
                                    <?php if ($t['link_eksternal']): ?>
                                        <a href="<?= $t['link_eksternal'] ?>" target="_blank" class="text-blue-500 hover:underline truncate inline-block max-w-50" title="<?= $t['link_eksternal'] ?>">
                                            <?= $t['link_eksternal'] ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400 italic">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3 text-center">
                                    <a href="<?= base_url('admin/berita/hapusTag/' . $t['id']) ?>" onclick="return confirm('Yakin ingin menghapus tag ini?')" class="text-red-500 hover:text-red-700 text-sm font-medium transition flex items-center justify-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
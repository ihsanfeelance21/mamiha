<?= $this->extend('layouts/admin'); ?>
<?= $this->section('content'); ?>

<div class="p-6 sm:p-10 bg-gray-50 min-h-screen">

    <div class="mb-8 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Edit Bakat & Minat</h1>
        <a href="/admin/bakat-minat" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">Kembali</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8 max-w-4xl">
        <form action="/admin/bakat-minat/update/<?= $bakat['id']; ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-semibold mb-2">Judul</label>
                    <input type="text" name="judul" value="<?= esc($bakat['judul']); ?>" required class="w-full rounded-lg border-gray-300 px-4 py-2 border">
                </div>
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-semibold mb-2">Jadwal Latihan</label>
                    <input type="text" name="jadwal" value="<?= esc($bakat['jadwal']); ?>" required class="w-full rounded-lg border-gray-300 px-4 py-2 border">
                </div>
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-semibold mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" required class="w-full rounded-lg border-gray-300 px-4 py-2 border"><?= esc($bakat['deskripsi']); ?></textarea>
                </div>
            </div>
            <?php
            // Kita pastikan nilainya secara ketat hanya 'guru' atau 'manual'
            $tipeAsli = strtolower(trim($bakat['tipe_pembina']));
            $tipePembina = ($tipeAsli == 'manual') ? 'manual' : 'guru';
            ?>
            <div x-data="{ tipePembina: '<?= $tipePembina; ?>' }" class="mb-8 p-5 border border-gray-200 rounded-xl bg-gray-50/50">
                <label class="block text-base font-bold text-gray-800 mb-4">Pengaturan Pembina</label>

                <div class="flex gap-4 mb-5">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" x-model="tipePembina" name="tipe_pembina" value="guru" class="w-4 h-4 text-[#00A859]">
                        <span class="text-sm font-medium">Dari Data Guru</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" x-model="tipePembina" name="tipe_pembina" value="manual" class="w-4 h-4 text-[#00A859]">
                        <span class="text-sm font-medium">Input Manual</span>
                    </label>
                </div>

                <div x-show="tipePembina === 'guru'" <?= ($tipePembina == 'manual') ? 'style="display: none;"' : ''; ?> class="bg-white p-4 rounded-lg border">
                    <label class="block text-sm font-semibold mb-2">Pilih Guru</label>
                    <select name="guru_id" class="w-full rounded-lg border-gray-300 px-4 py-2 border">
                        <option value="">-- Silakan Pilih --</option>
                        <?php foreach ($data_guru as $g) : ?>
                            <option value="<?= $g['id']; ?>" <?= ($bakat['guru_id'] == $g['id']) ? 'selected' : ''; ?>><?= esc($g['nama']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div x-show="tipePembina === 'manual'" <?= ($tipePembina == 'guru') ? 'style="display: none;"' : ''; ?> class="bg-white p-4 rounded-lg border">
                    <label class="block text-sm font-semibold mb-2">Nama Pelatih Manual</label>
                    <input type="text" name="nama_pembina_manual" value="<?= esc($bakat['nama_pembina_manual']); ?>" class="w-full rounded-lg border-gray-300 px-4 py-2 border">
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold mb-2">Ganti Gambar (Opsional)</label>
                <input type="file" name="gambar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-gray-100">
                <?php if ($bakat['gambar']): ?>
                    <p class="text-xs text-gray-500 mt-2">Gambar saat ini: <img src="/uploads/bakat/<?= $bakat['gambar']; ?>" class="h-16 mt-1 rounded"></p>
                <?php endif; ?>
            </div>

            <button type="submit" class="bg-[#00A859] text-white font-bold px-8 py-2.5 rounded-lg hover:bg-green-700">Update Data</button>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>
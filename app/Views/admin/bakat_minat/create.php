<?= $this->extend('layouts/admin'); // Sesuaikan dengan nama file template admin Mas 
?>

<?= $this->section('content'); ?>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<div class="p-6 sm:p-10 bg-gray-50 min-h-screen">

    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Bakat & Minat</h1>
            <p class="text-sm text-gray-500 mt-1">Tambahkan program ekstrakurikuler atau pengembangan diri baru.</p>
        </div>
        <a href="/admin/bakat-minat" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-300 transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 max-w-4xl">
        <form action="/admin/bakat-minat/store" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Ekstrakurikuler / Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" required placeholder="Contoh: Ekstrakurikuler Robotik"
                        class="w-full rounded-lg border-gray-300 focus:border-[#00A859] focus:ring focus:ring-green-100 transition shadow-sm px-4 py-2 border">
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jadwal Latihan <span class="text-red-500">*</span></label>
                    <input type="text" name="jadwal" required placeholder="Contoh: Setiap Sabtu, 08.00 - 11.00 WIB"
                        class="w-full rounded-lg border-gray-300 focus:border-[#00A859] focus:ring focus:ring-green-100 transition shadow-sm px-4 py-2 border">
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Kegiatan <span class="text-red-500">*</span></label>
                    <textarea name="deskripsi" rows="4" required placeholder="Jelaskan secara singkat tentang ekstrakurikuler ini..."
                        class="w-full rounded-lg border-gray-300 focus:border-[#00A859] focus:ring focus:ring-green-100 transition shadow-sm px-4 py-2 border"></textarea>
                </div>
            </div>

            <div x-data="{ tipePembina: 'guru' }" class="mb-8 p-5 md:p-6 border border-gray-200 rounded-xl bg-gray-50/50">
                <label class="block text-base font-bold text-gray-800 mb-4 border-b border-gray-200 pb-2">
                    <i class="fas fa-user-tie text-[#00A859] mr-2"></i> Pengaturan Guru Pembina / Pelatih
                </label>

                <div class="flex flex-col sm:flex-row gap-4 sm:gap-8 mb-5">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="radio" x-model="tipePembina" name="tipe_pembina" value="guru" class="w-4 h-4 text-[#00A859] focus:ring-[#00A859]">
                        <span class="text-sm font-medium text-gray-700 group-hover:text-[#00A859] transition">Pilih dari Data Guru</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="radio" x-model="tipePembina" name="tipe_pembina" value="manual" class="w-4 h-4 text-[#00A859] focus:ring-[#00A859]">
                        <span class="text-sm font-medium text-gray-700 group-hover:text-[#00A859] transition">Input Manual (Pelatih Luar)</span>
                    </label>
                </div>

                <div x-show="tipePembina === 'guru'"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Guru Pembina</label>
                    <select name="guru_id" class="w-full rounded-lg border-gray-300 focus:border-[#00A859] focus:ring focus:ring-green-100 transition shadow-sm px-4 py-2 border">
                        <option value="">-- Silakan Pilih Guru --</option>
                        <?php if (isset($data_guru)) : ?>
                            <?php foreach ($data_guru as $g) : ?>
                                <option value="<?= $g['id']; ?>"><?= esc($g['nama']); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <p class="text-xs text-gray-500 mt-2"><i class="fas fa-info-circle"></i> Nama guru diambil dari database master guru.</p>
                </div>

                <div x-show="tipePembina === 'manual'" style="display: none;"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pelatih / Pembina Manual</label>
                    <input type="text" name="nama_pembina_manual" placeholder="Contoh: Bpk. Jhon Doe, S.Kom (Pelatih Profesional)"
                        class="w-full rounded-lg border-gray-300 focus:border-[#00A859] focus:ring focus:ring-green-100 transition shadow-sm px-4 py-2 border">
                    <p class="text-xs text-gray-500 mt-2"><i class="fas fa-info-circle"></i> Gunakan opsi ini jika pelatih bukan bagian dari staf guru sekolah.</p>
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto / Gambar Kegiatan</label>
                <input type="file" name="gambar" accept="image/png, image/jpeg, image/jpg"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-[#00A859] hover:file:bg-green-100 transition border border-gray-200 rounded-lg">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal ukuran file 2MB.</p>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="bg-[#00A859] text-white font-bold px-8 py-2.5 rounded-lg hover:bg-green-700 transition shadow-md flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
            </div>

        </form>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<div class="bg-gray-50 min-h-screen py-10">
    <div class="container mx-auto px-4 max-w-3xl">

        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold text-gray-800">Form Pendataan Alumni</h1>
            <p class="text-gray-600 mt-2">Silakan lengkapi data diri Anda di bawah ini untuk bergabung dalam direktori alumni.</p>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
            <form action="<?= base_url('alumni/simpan-mandiri'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_alumni">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_alumni" id="nama_alumni" required placeholder="Cth: Budi Santoso" class="shadow-sm border border-gray-300 rounded-lg w-full py-2.5 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="tahun_lulus">Tahun Lulus SMA <span class="text-red-500">*</span></label>
                        <input type="number" name="tahun_lulus" id="tahun_lulus" required placeholder="Cth: 2022" class="shadow-sm border border-gray-300 rounded-lg w-full py-2.5 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="id_universitas">Pendidikan / Universitas Saat Ini <span class="text-red-500">*</span></label>
                    <select name="id_universitas" id="id_universitas" required onchange="toggleKampusLainnya()" class="shadow-sm border border-gray-300 rounded-lg w-full py-2.5 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
                        <option value="">-- Pilih Universitas Anda --</option>
                        <?php foreach ($universitas as $u) : ?>
                            <option value="<?= $u['id_universitas']; ?>"><?= esc($u['nama_universitas']); ?></option>
                        <?php endforeach; ?>
                        <option value="lainnya" class="font-bold text-green-600">Lainnya (Ketik Manual)</option>
                    </select>
                </div>

                <div id="div_kampus_lainnya" class="mb-6 hidden bg-green-50 p-4 rounded-lg border border-green-100">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="usulan_universitas">Sebutkan Nama Kampus Anda <span class="text-red-500">*</span></label>
                    <input type="text" name="usulan_universitas" id="usulan_universitas" placeholder="Cth: Universitas Indonesia" class="shadow-sm border border-gray-300 rounded-lg w-full py-2.5 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
                    <p class="text-xs text-gray-500 mt-1">Admin akan mendaftarkan kampus ini ke dalam sistem nantinya.</p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="jurusan">Pekerjaan / Jurusan Anda Saat Ini</label>
                    <input type="text" name="jurusan" id="jurusan" placeholder="Cth: S1 Teknik Informatika" class="shadow-sm border border-gray-300 rounded-lg w-full py-2.5 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="pesan_kesan">Testimoni / Pesan Kesan (Opsional)</label>
                    <textarea name="pesan_kesan" id="pesan_kesan" rows="4" placeholder="Bagikan pengalaman menarik Anda..." class="shadow-sm border border-gray-300 rounded-lg w-full py-2.5 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition"></textarea>
                </div>

                <div class="mb-8 p-4 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="foto">Upload Foto Profil Terbaru (Opsional)</label>
                    <input type="file" name="foto" id="foto" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-700 transition">
                </div>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 px-4 rounded-lg shadow-lg hover:shadow-xl transition duration-200 text-lg">
                    Kirim Data Saya
                </button>
                <div class="text-center mt-4">
                    <a href="<?= base_url('alumni'); ?>" class="text-gray-500 hover:text-green-600 text-sm transition font-medium">Batalkan dan Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Script kecil untuk memunculkan/menyembunyikan input kampus manual
    function toggleKampusLainnya() {
        var select = document.getElementById("id_universitas");
        var divUsulan = document.getElementById("div_kampus_lainnya");
        var inputUsulan = document.getElementById("usulan_universitas");

        if (select.value === "lainnya") {
            divUsulan.classList.remove("hidden");
            inputUsulan.setAttribute("required", "required");
        } else {
            divUsulan.classList.add("hidden");
            inputUsulan.removeAttribute("required");
            inputUsulan.value = ""; // Bersihkan isian kalau ga jadi pilih lainnya
        }
    }
</script>
<?= $this->endSection(); ?>
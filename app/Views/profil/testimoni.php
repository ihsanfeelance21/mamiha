<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="bg-[#0B4A2D] py-16 text-center border-b-8 border-[#00A859]">
    <h1 class="text-4xl font-extrabold text-white mb-2">Suara Mereka</h1>
    <p class="text-green-100">Apa kata alumni dan wali murid tentang madrasah kami?</p>
</section>

<section class="py-16 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="bg-green-100 border border-[#00A859] text-[#0B4A2D] px-4 py-3 rounded-xl mb-8 flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-xl"></i>
                <p><?= session()->getFlashdata('pesan') ?></p>
            </div>
        <?php endif; ?>

        <?php if (empty($testimoni)) : ?>
            <div class="text-center py-20">
                <i class="fa-regular fa-comments text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Belum ada testimoni. Jadilah yang pertama memberikan ulasan!</p>
            </div>
        <?php else : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                <?php foreach ($testimoni as $t) : ?>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative flex flex-col h-full">
                        <i class="fa-solid fa-quote-right text-4xl text-green-50 absolute top-4 right-4"></i>

                        <div class="flex text-yellow-400 mb-4 text-sm">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <i class="fa-<?= $i <= $t['rating'] ? 'solid' : 'regular' ?> fa-star"></i>
                            <?php endfor; ?>
                        </div>

                        <p class="text-gray-600 italic mb-6 grow">"<?= esc($t['isi_testimoni']) ?>"</p>

                        <div class="flex items-center gap-4 mt-auto pt-4 border-t border-gray-50">
                            <?php if ($t['foto']) : ?>
                                <img src="<?= base_url('uploads/testimoni/' . $t['foto']) ?>" class="w-12 h-12 rounded-full object-cover border-2 border-[#00A859]">
                            <?php else : ?>
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 border-2 border-gray-300">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <h4 class="font-bold text-[#0B4A2D]"><?= esc($t['nama']) ?></h4>
                                <p class="text-xs text-gray-500 uppercase tracking-wider"><?= esc($t['status_user']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="text-center mt-12 border-t border-gray-200 pt-10">
            <button onclick="toggleModal('testimoniModal')" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold rounded-xl text-white bg-[#00A859] hover:bg-[#0B4A2D] transition-colors shadow-lg hover:shadow-xl hover:-translate-y-1">
                <i class="fa-solid fa-pen-to-square mr-2"></i> Tulis Testimoni Anda
            </button>
        </div>

    </div>
</section>

<div id="testimoniModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm overflow-y-auto h-full w-full items-center justify-center px-4">
    <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl p-6 md:p-8 border-t-8 border-[#00A859] animate-fade-in-up">

        <button onclick="toggleModal('testimoniModal')" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors">
            <i class="fa-solid fa-xmark text-2xl"></i>
        </button>

        <div class="text-center mb-6">
            <h3 class="text-2xl font-extrabold text-[#0B4A2D]">Kirim Testimoni</h3>
            <p class="text-gray-500 text-sm">Bagikan pengalaman berharga Anda bersama kami.</p>
        </div>

        <form action="<?= base_url('profil/testimoni/simpan') ?>" method="post" enctype="multipart/form-data" class="space-y-4">
            <?= csrf_field() ?>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#00A859] focus:border-[#00A859] outline-none transition-all">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Status / Sebagai</label>
                <input type="text" name="status_user" placeholder="Contoh: Alumni 2021 / Wali Murid" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#00A859] focus:border-[#00A859] outline-none transition-all">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Rating Bintang</label>
                <select name="rating" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#00A859] outline-none bg-white">
                    <option value="5">⭐⭐⭐⭐⭐ (5/5 Sangat Puas)</option>
                    <option value="4">⭐⭐⭐⭐ (4/5 Puas)</option>
                    <option value="3">⭐⭐⭐ (3/5 Cukup)</option>
                    <option value="2">⭐⭐ (2/5 Kurang)</option>
                    <option value="1">⭐ (1/5 Sangat Kurang)</option>
                </select>
            </div>

            <div>
                <div class="flex justify-between items-end mb-1">
                    <label class="block text-sm font-bold text-gray-700">Isi Testimoni</label>
                    <span class="text-xs text-gray-500"><span id="charCount">0</span>/250 karakter</span>
                </div>
                <textarea id="inputTestimoni" name="isi_testimoni" rows="4" maxlength="250" required oninput="hitungKarakter()" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#00A859] focus:border-[#00A859] outline-none transition-all resize-none"></textarea>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Foto Profil <span class="text-gray-400 font-normal">(Opsional)</span></label>
                <input type="file" name="foto" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-xl file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-[#00A859] hover:file:bg-green-100 cursor-pointer">
            </div>

            <button type="submit" class="w-full py-3 mt-4 bg-[#0B4A2D] text-white font-bold rounded-xl hover:bg-[#00A859] transition-colors shadow-lg">
                <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Testimoni
            </button>
        </form>
    </div>
</div>
<div class="mt-12 flex justify-center w-full">
    <?= $pager->links('testimoni', 'tailwind_pagination') ?>
</div>


<script>
    // Fungsi buka tutup modal
    function toggleModal(modalID) {
        const modal = document.getElementById(modalID);
        modal.classList.toggle("hidden");
        modal.classList.toggle("flex");
    }

    // Fungsi hitung karakter live
    function hitungKarakter() {
        const textarea = document.getElementById("inputTestimoni");
        const countSpan = document.getElementById("charCount");
        const panjangTeks = textarea.value.length;

        countSpan.textContent = panjangTeks;

        // Ubah warna indikator jadi merah kalau sudah mau penuh (misal > 230 karakter)
        if (panjangTeks >= 230) {
            countSpan.classList.add("text-red-500", "font-bold");
        } else {
            countSpan.classList.remove("text-red-500", "font-bold");
        }
    }
</script>

<style>
    /* Animasi kecil untuk modal saat muncul */
    .animate-fade-in-up {
        animation: fadeInUp 0.3s ease-out forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<?= $this->endSection() ?>
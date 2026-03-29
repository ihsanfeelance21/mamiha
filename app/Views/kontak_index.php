<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="pt-32 pb-16 bg-[#FAFAF9] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <?php if (session()->getFlashdata('pesan_sukses')) : ?>
            <div class="mb-8 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-xl"></i>
                <p class="font-medium"><?= session()->getFlashdata('pesan_sukses') ?></p>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <div class="lg:col-span-5 space-y-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Kontak</h2>

                <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">

                    <div class="flex gap-4 mb-6">
                        <div class="w-12 h-12 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-location-dot text-gray-600"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm mb-1">Alamat Sekolah</h4>
                            <p class="text-gray-500 text-sm leading-relaxed">Jl. K.H. Achmad Musayyidi No. 177, Karangdoro, Kec. Tegalsari, Kabupaten Banyuwangi, Jawa Timur</p>
                        </div>
                    </div>

                    <div class="flex gap-4 mb-6">
                        <div class="w-12 h-12 rounded-full bg-green-50 border border-green-100 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-phone text-green-600"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm mb-1">Telepon & Email</h4>
                            <p class="text-gray-500 text-sm">Telp: 085147849869</p>
                            <p class="text-gray-500 text-sm">Email: smpplus.cordova@gmail.com</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-link text-blue-600"></i>
                        </div>
                        <div class="grow flex flex-col justify-center">
                            <h4 class="font-bold text-gray-800 text-sm mb-2">Media Sosial</h4>
                            <div class="flex gap-2">
                                <a href="#" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 transition-colors"><i class="fa-brands fa-instagram"></i></a>
                                <a href="#" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 transition-colors"><i class="fa-brands fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="bg-white p-2 rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3947.555!2d114.123456!3d-8.456789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zSMPCsDI3JzI0LjQiUyAxMTTCsDA3JzI0LjQiRQ!5e0!3m2!1sen!2sid!4v1234567890"
                        width="100%"
                        height="250"
                        style="border:0; border-radius: 1.25rem;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <div class="lg:col-span-7">
                <div class="bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-gray-100">

                    <div class="mb-8">
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Formulir Pesan</p>
                        <h1 class="text-3xl font-bold text-gray-800 mb-3">Kirim Pesan / Masukan</h1>
                        <p class="text-gray-500 text-sm">Silakan isi formulir di bawah ini. Kami akan merespons pesan Anda sesegera mungkin.</p>
                    </div>

                    <form action="<?= base_url('hubungi-kami/kirim') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-5">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-gray-400 focus:ring-2 focus:ring-gray-100 transition-all text-sm" placeholder="Contoh: Satria Yudha">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-2">Alamat Email <span class="text-gray-400 font-normal lowercase">(opsional)</span></label>
                                <input type="email" name="email" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-gray-400 focus:ring-2 focus:ring-gray-100 transition-all text-sm" placeholder="email@contoh.com">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-2">No. WhatsApp <span class="text-gray-400 font-normal lowercase">(opsional)</span></label>
                                <input type="text" name="no_wa" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-gray-400 focus:ring-2 focus:ring-gray-100 transition-all text-sm" placeholder="0812xxxx (Boleh kosong)">
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-2">Kategori Pesan <span class="text-red-500">*</span></label>
                            <select name="kategori" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-gray-400 focus:ring-2 focus:ring-gray-100 transition-all text-sm appearance-none cursor-pointer">
                                <option value="" disabled selected>Pilih Tujuan Pesan..</option>
                                <option value="Pertanyaan umum">Pertanyaan umum</option>
                                <option value="Informasi PPDB">Informasi PPDB</option>
                                <option value="Kritik & Saran">Kritik & Saran</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-8">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-2">Isi Pesan <span class="text-red-500">*</span></label>
                            <textarea name="pesan" required rows="5" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-gray-400 focus:ring-2 focus:ring-gray-100 transition-all text-sm resize-y" placeholder="Tuliskan pesan, pertanyaan, atau masukan Anda di sini..."></textarea>
                        </div>

                        <button type="submit" class="w-full px-6 py-4 rounded-xl text-sm font-bold text-white bg-green-900 hover:bg-green-800 transition-colors shadow-sm flex items-center justify-center gap-2 group">
                            Kirim Pesan Sekarang
                            <i class="fa-solid fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                        </button>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?= $this->endSection() ?>
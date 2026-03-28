<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="pt-32 pb-12 bg-[#0B4A2D] text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/20 shadow-sm rounded-full mb-4 backdrop-blur-sm">
            <i class="fa-regular fa-calendar text-yellow-400"></i>
            <span class="text-sm font-bold text-yellow-400 tracking-widest uppercase">Jadwal Kegiatan</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Kalender Akademik</h1>
        <p class="text-lg text-green-100 max-w-2xl mx-auto">
            Informasi lengkap mengenai jadwal kegiatan pembelajaran, ujian, dan hari libur di MA Mabadi'ul Ihsan.
        </p>
    </div>
</section>

<section class="py-16 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <?php if (!empty($agendaGrouped)) : ?>

            <?php foreach ($agendaGrouped as $bulanTahun => $agendas) : ?>
                <div class="flex items-center mb-6 mt-10 first:mt-0">
                    <span class="w-3 h-3 rounded-full bg-[#A08830] mr-3 shrink-0"></span>
                    <h2 class="text-2xl font-bold text-[#800000] shrink-0"><?= $bulanTahun ?></h2>
                    <div class="h-px bg-gray-200 w-full ml-4"></div>
                </div>

                <div class="flex flex-col gap-5 pl-1.5 border-l-2 border-gray-100 ml-1">
                    <?php foreach ($agendas as $item) :
                        $tglMulai = date('d', strtotime($item['tanggal_mulai']));
                        $blnMulai = (int) date('m', strtotime($item['tanggal_mulai']));

                        $isMultiDay = !empty($item['tanggal_selesai']) && $item['tanggal_selesai'] != $item['tanggal_mulai'];
                        $tglSelesai = $isMultiDay ? date('d', strtotime($item['tanggal_selesai'])) : '';

                        // Format Tanggal Text Panjang (11 Maret - 08 April 2026)
                        $blnIndoTeks = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        $teksMulai = $tglMulai . ' ' . $blnIndoTeks[$blnMulai - 1];

                        if ($isMultiDay) {
                            $blnSelesai = (int) date('m', strtotime($item['tanggal_selesai']));
                            $thnSelesai = date('Y', strtotime($item['tanggal_selesai']));
                            $teksTanggalLengkap = $teksMulai . ' - ' . $tglSelesai . ' ' . $blnIndoTeks[$blnSelesai - 1] . ' ' . $thnSelesai;
                        } else {
                            $teksTanggalLengkap = $teksMulai . ' ' . date('Y', strtotime($item['tanggal_mulai']));
                        }
                    ?>

                        <div class="relative bg-white rounded-xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-gray-100 p-5 md:p-6 ml-6 overflow-hidden flex flex-col sm:flex-row gap-5 hover:shadow-lg transition-shadow duration-300 group">
                            <div class="absolute left-0 top-4 bottom-4 w-1.5 bg-[#D4AF37] rounded-r-md"></div>

                            <div class="border border-gray-100 bg-gray-50/50 rounded-xl p-3 flex flex-col items-center justify-center min-w-20 shrink-0 shadow-sm transition-colors group-hover:bg-white group-hover:border-gray-200">
                                <span class="text-xl font-bold text-[#0B4A2D]"><?= $tglMulai ?></span>
                                <?php if ($isMultiDay) : ?>
                                    <hr class="w-8 border-gray-300 my-1.5">
                                    <span class="text-xl font-bold text-[#0B4A2D]"><?= $tglSelesai ?></span>
                                <?php endif; ?>
                                <span class="text-[10px] font-bold text-gray-400 uppercase mt-2 tracking-wider"><?= $bulanSingkat[$blnMulai] ?></span>
                            </div>

                            <div class="flex flex-col justify-center">
                                <h3 class="text-xl font-bold text-gray-800 mb-2 leading-tight"><?= esc($item['judul']) ?></h3>

                                <div class="flex items-center gap-2 text-[#D4AF37] font-medium text-sm mb-3">
                                    <i class="fa-regular fa-calendar-check"></i>
                                    <span><?= $teksTanggalLengkap ?></span>
                                </div>

                                <?php if (!empty($item['deskripsi'])) : ?>
                                    <p class="text-gray-500 text-sm leading-relaxed">
                                        <?= esc($item['deskripsi']) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php endforeach; ?>

        <?php else : ?>
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm max-w-2xl mx-auto">
                <i class="fa-regular fa-calendar-xmark text-6xl text-gray-300 mb-4 block"></i>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Jadwal</h3>
                <p class="text-gray-500 text-lg">Jadwal kalender akademik madrasah untuk saat ini belum tersedia atau belum diperbarui.</p>
            </div>
        <?php endif; ?>

    </div>
</section>

<?= $this->endSection() ?>
<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="p-6 max-w-4xl mx-auto">

    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="<?= base_url('admin/kontak') ?>" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors" title="Kembali">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Detail Pesan</h1>
        </div>
        <form action="<?= base_url('admin/kontak/delete/' . $pesan['id']) ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')" style="display:inline"><?= csrf_field() ?><button type="submit" class="px-4 py-2 rounded-lg text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 transition-colors flex items-center gap-2">
            <i class="fa-solid fa-trash-can"></i> Hapus Pesan
        </button></form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="p-6 md:p-8 border-b border-gray-100 bg-gray-50/50">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                <div class="flex gap-4">
                    <div class="w-12 h-12 rounded-full bg-[#111827] text-white flex items-center justify-center text-xl font-bold shrink-0">
                        <?= strtoupper(substr($pesan['nama'], 0, 1)) ?>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800"><?= esc($pesan['nama']) ?></h2>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1 text-sm text-gray-500">
                            <?php if (!empty($pesan['email'])): ?>
                                <span class="flex items-center gap-1.5"><i class="fa-regular fa-envelope"></i> <?= esc($pesan['email']) ?></span>
                            <?php endif; ?>

                            <?php if (!empty($pesan['no_wa'])): ?>
                                <span class="flex items-center gap-1.5"><i class="fa-brands fa-whatsapp text-green-500"></i> <?= esc($pesan['no_wa']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-flex px-3 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100 mb-2">
                        Kategori: <?= esc($pesan['kategori']) ?>
                    </span>
                    <div class="mb-2">
                        <?php if ($pesan['status'] == 'belum dibaca') : ?>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-red-50 text-red-600 border border-red-100"><span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span> Baru</span>
                        <?php else : ?>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-green-50 text-green-600 border border-green-100"><i class="fa-solid fa-check-double"></i> Dibaca</span>
                        <?php endif; ?>
                    </div>
                    <p class="text-xs text-gray-400 font-medium whitespace-nowrap">
                        <i class="fa-regular fa-calendar mr-1"></i> <?= date('d F Y - H:i', strtotime($pesan['created_at'])) ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-4">Isi Pesan / Masukan:</p>
            <div class="prose max-w-none text-gray-700 whitespace-pre-line leading-relaxed">
                <?= esc($pesan['pesan']) ?>
            </div>
        </div>

        <?php if (!empty($pesan['no_wa'])): ?>
            <div class="p-6 bg-gray-50 border-t border-gray-100">
                <?php
                $raw = preg_replace('/[^0-9]/', '', $pesan['no_wa']);
                $no_wa = preg_match('/^0/', $raw) ? preg_replace('/^0/', '62', $raw) : (preg_match('/^62/', $raw) ? $raw : '62' . $raw);
                $teks_balasan = "Halo kak " . $pesan['nama'] . ", kami dari Admin MA Mabadi'ul Ihsan membalas pesan Anda mengenai *" . $pesan['kategori'] . "*...\n\n";
                ?>
                <a href="https://wa.me/<?= esc($no_wa, 'attr') ?>?text=<?= urlencode($teks_balasan) ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-bold text-white bg-green-500 hover:bg-green-600 transition-colors shadow-sm">
                    <i class="fa-brands fa-whatsapp text-lg"></i> Balas via WhatsApp
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>
<?= $this->endSection() ?>
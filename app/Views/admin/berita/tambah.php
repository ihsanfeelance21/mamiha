<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">

<div class="max-w-4xl bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-10">
    <div class="mb-6 flex items-center justify-between border-b pb-4">
        <div>
            <h3 class="text-xl font-bold text-text-main">Tulis Berita Baru</h3>
            <p class="text-sm text-gray-500 mt-1">Publikasikan atau jadwalkan informasi terbaru website.</p>
        </div>
        <a href="<?= base_url('admin/berita') ?>" class="text-text-muted hover:text-gray-800 transition text-sm flex items-center bg-gray-100 px-3 py-1.5 rounded">
            &larr; Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/berita/simpan') ?>" method="post" enctype="multipart/form-data" id="form-berita">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="md:col-span-2">
                <label for="judul" class="block text-sm font-medium text-text-main mb-1">Judul Berita <span class="text-red-500">*</span></label>
                <input type="text" id="judul" name="judul" value="<?= old('judul') ?>" required autofocus
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition text-lg font-medium">
            </div>

            <div>
                <label for="id_kategori" class="block text-sm font-medium text-text-main mb-1">Kategori Utama <span class="text-red-500">*</span></label>
                <select id="id_kategori" name="id_kategori" required class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition bg-white">
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategori as $k) : ?>
                        <option value="<?= $k['id'] ?>" <?= old('id_kategori') == $k['id'] ? 'selected' : '' ?>><?= $k['nama_kategori'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="tags" class="block text-sm font-medium text-text-main mb-1">Tags / Hashtag</label>
                <select id="tags" name="tags[]" multiple placeholder="Pilih atau ketik tag..." class="w-full" autocomplete="off">
                    <?php if (isset($tags)) : foreach ($tags as $t) : ?>
                            <option value="<?= $t['id'] ?>"><?= $t['nama_tag'] ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
            </div>

            <div>
                <label for="layout" class="block text-sm font-medium text-text-main mb-1">Gaya Tampilan (Layout)</label>
                <select id="layout" name="layout" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition bg-white">
                    <option value="modern" <?= old('layout') == 'modern' ? 'selected' : '' ?>>Modern (Gambar Lebar Penuh di Atas)</option>
                    <option value="legacy" <?= old('layout') == 'legacy' ? 'selected' : '' ?>>Legacy (Gambar 300x300 di Samping Teks)</option>
                </select>
            </div>


            <div>
                <label for="status" class="block text-sm font-medium text-text-main mb-1">Status Publikasi</label>
                <select id="status" name="status" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition bg-white">
                    <option value="terbit" <?= old('status') == 'terbit' ? 'selected' : '' ?>>Terbitkan Langsung</option>
                    <option value="draft" <?= old('status') == 'draft' ? 'selected' : '' ?>>Simpan sebagai Draft</option>
                    <option value="terjadwal" <?= old('status') == 'terjadwal' ? 'selected' : '' ?>>Jadwalkan Tayang...</option>
                </select>
            </div>

            <div id="waktu-tayang-container" class="<?= old('status') == 'draft' ? 'hidden' : '' ?> md:col-span-2 p-4 rounded border transition-colors duration-300 <?= old('status') == 'terjadwal' ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200' ?>">
                <div class="flex items-center justify-between mb-1">
                    <label for="waktu_tayang" id="label-waktu" class="block text-sm font-medium <?= old('status') == 'terjadwal' ? 'text-blue-800' : 'text-gray-700' ?>">
                        <?= old('status') == 'terjadwal' ? 'Pilih Jadwal Tayang <span class="text-red-500">*</span>' : 'Ubah Tanggal Rilis (Opsional)' ?>
                    </label>
                    <button type="button" id="btn-reset-waktu" class="<?= old('status') == 'terbit' ? 'block' : 'hidden' ?> text-xs text-red-500 hover:text-red-700 font-medium">Reset ke Waktu Sekarang</button>
                </div>

                <input type="datetime-local" id="waktu_tayang" name="waktu_tayang" value="<?= old('waktu_tayang') ?>"
                    class="w-full md:w-1/2 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-1 transition <?= old('status') == 'terjadwal' ? 'focus:border-blue-500 focus:ring-blue-500' : 'focus:border-primary focus:ring-primary' ?>">

                <p id="desc-waktu" class="text-xs mt-2 <?= old('status') == 'terjadwal' ? 'text-blue-600' : 'text-gray-500' ?>">
                    <?= old('status') == 'terjadwal' ? 'Berita ini tidak akan terlihat oleh pengunjung sebelum tanggal dan jam yang ditentukan.' : 'Biarkan kosong jika ingin diterbitkan saat ini juga. Isi dengan tanggal lampau untuk keperluan arsip/Backdate.' ?>
                </p>
            </div>

            <div class="mb-6 p-4 bg-gray-50 rounded border border-gray-200">
                <label for="gambar" class="block text-sm font-medium text-text-main mb-1">Gambar Utama / Thumbnail (Wajib)</label>
                <input type="file" id="gambar" name="gambar" accept="image/png, image/jpeg, image/webp" required
                    class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-500 bg-white file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary-hover transition">
                <p class="text-xs text-gray-500 mt-2">Gambar ini akan otomatis dikompres dan diubah ke format WEBP. Gunakan gambar lanskap untuk layout Modern, atau persegi untuk layout Legacy.</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-text-main mb-1">Isi Berita <span class="text-red-500">*</span></label>
                <div id="editor-container" style="height: 500px; background-color: white; font-family: inherit; font-size: 16px;"></div>

                <input type="hidden" name="konten" id="konten" value="<?= htmlspecialchars(old('konten') ?? '') ?>">
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="bg-primary hover:bg-primary-hover text-white px-8 py-3 rounded font-bold transition shadow-md">
                    Simpan Berita
                </button>
            </div>
    </form>
</div>

<style>
    /* Tom Select Custom Height adjustments */
    .ts-control {
        padding: 8px 16px;
        border-color: #d1d5db;
        border-radius: 0.25rem;
    }

    .ts-control.focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 1px #16a34a;
    }

    /* CSS Tabel Quill (Tema Hijau) */
    .ql-editor table {
        border-collapse: collapse;
        width: 100%;
        margin: 1.5rem 0;
        font-size: 0.95rem;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .ql-editor td,
    .ql-editor th {
        border: 1px solid #e5e7eb;
        padding: 12px 16px;
        color: #374151;
    }

    .ql-editor table tr:first-child td {
        background-color: #16a34a;
        color: #ffffff;
        font-weight: 600;
        text-align: center;
        border-color: #15803d;
    }

    .ql-editor table tr:nth-child(even) td {
        background-color: #f0fdf4;
    }

    .ql-editor table tr:not(:first-child):hover td {
        background-color: #dcfce7;
        transition: background-color 0.2s ease;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
    // --------------------------------------------------------------
    // 1. INISIALISASI MULTI-TAGS (Tom Select)
    // --------------------------------------------------------------
    new TomSelect("#tags", {
        plugins: ['remove_button'],
        maxOptions: null,
        placeholder: "Pilih Tag..."
    });

    // --------------------------------------------------------------
    // 2. LOGIKA STATUS PENJADWALAN & BACKDATE (Dinamic UI)
    // --------------------------------------------------------------
    const statusSelect = document.getElementById('status');
    const waktuTayangContainer = document.getElementById('waktu-tayang-container');
    const waktuTayangInput = document.getElementById('waktu_tayang');
    const labelWaktu = document.getElementById('label-waktu');
    const descWaktu = document.getElementById('desc-waktu');
    const btnResetWaktu = document.getElementById('btn-reset-waktu');

    function updateWaktuUI() {
        const status = statusSelect.value;

        if (status === 'terjadwal') {
            waktuTayangContainer.classList.remove('hidden', 'bg-gray-50', 'border-gray-200');
            waktuTayangContainer.classList.add('bg-blue-50', 'border-blue-200');

            labelWaktu.innerHTML = 'Pilih Jadwal Tayang <span class="text-red-500">*</span>';
            labelWaktu.className = 'block text-sm font-medium text-blue-800 mb-1';

            descWaktu.innerHTML = 'Berita ini tidak akan terlihat oleh pengunjung sebelum tanggal dan jam yang ditentukan.';
            descWaktu.className = 'text-xs text-blue-600 mt-2';

            waktuTayangInput.setAttribute('required', 'required');
            waktuTayangInput.classList.remove('focus:border-primary', 'focus:ring-primary');
            waktuTayangInput.classList.add('focus:border-blue-500', 'focus:ring-blue-500');

            btnResetWaktu.classList.add('hidden');

        } else if (status === 'terbit') {
            waktuTayangContainer.classList.remove('hidden', 'bg-blue-50', 'border-blue-200');
            waktuTayangContainer.classList.add('bg-gray-50', 'border-gray-200');

            labelWaktu.innerHTML = 'Ubah Tanggal Rilis (Opsional)';
            labelWaktu.className = 'block text-sm font-medium text-gray-700 mb-1';

            descWaktu.innerHTML = 'Biarkan kosong jika ingin diterbitkan saat ini juga. Isi dengan tanggal lampau untuk keperluan arsip/Backdate.';
            descWaktu.className = 'text-xs text-gray-500 mt-2';

            waktuTayangInput.removeAttribute('required');
            waktuTayangInput.classList.remove('focus:border-blue-500', 'focus:ring-blue-500');
            waktuTayangInput.classList.add('focus:border-primary', 'focus:ring-primary');

            btnResetWaktu.classList.remove('hidden');

        } else if (status === 'draft') {
            waktuTayangContainer.classList.add('hidden');
            waktuTayangInput.removeAttribute('required');
            waktuTayangInput.value = ''; // Kosongkan input
        }
    }

    // Tombol untuk mereset tanggal kembali kosong
    btnResetWaktu.addEventListener('click', function() {
        waktuTayangInput.value = '';
    });

    // Jalankan saat dropdown berubah
    statusSelect.addEventListener('change', updateWaktuUI);

    // Jalankan sekali saat halaman dimuat (untuk menangani error validasi form / old value)
    updateWaktuUI();

    // --------------------------------------------------------------
    // 3. INISIALISASI QUILL EDITOR
    // --------------------------------------------------------------
    var icons = Quill.import('ui/icons');
    icons['table'] = '<svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="12" height="12" rx="1" ry="1"></rect><line x1="3" y1="9" x2="15" y2="9"></line><line x1="9" y1="3" x2="9" y2="15"></line></svg>';

    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Tulis isi berita di sini...',
        modules: {
            table: true,
            toolbar: {
                container: [
                    [{
                        'header': [2, 3, 4, false]
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'align': []
                    }],
                    ['link', 'image', 'video', 'table'],
                    ['clean']
                ],
                handlers: {
                    image: imageHandler,
                    table: function() {
                        var rows = prompt("Masukkan jumlah Baris (contoh: 3):", "3");
                        var cols = prompt("Masukkan jumlah Kolom (contoh: 3):", "3");
                        if (rows !== null && cols !== null && rows > 0 && cols > 0) {
                            this.quill.getModule('table').insertTable(parseInt(rows), parseInt(cols));
                        }
                    }
                }
            }
        }
    });

    // Mengembalikan data lama jika form gagal divalidasi
    var oldKonten = document.getElementById('konten').value;
    if (oldKonten) {
        quill.clipboard.dangerouslyPasteHTML(oldKonten);
    }

    // Custom Handler Upload Gambar AJAX
    function imageHandler() {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.click();

        input.onchange = () => {
            var file = input.files[0];
            if (file) {
                var formData = new FormData();
                formData.append('image', file);

                fetch('<?= base_url('admin/berita/upload-gambar-quill') ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            var range = quill.getSelection(true);
                            quill.insertEmbed(range.index, 'image', result.url);
                        } else {
                            alert('Gagal mengunggah gambar: ' + result.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengunggah gambar.');
                    });
            }
        };
    }

    // Sinkronisasi Data ke Input Hidden saat form di-submit
    var form = document.getElementById('form-berita');
    form.onsubmit = function() {
        var html = quill.getSemanticHTML();
        if (html === '<p><br></p>' || html.trim() === '') {
            alert('Isi berita tidak boleh kosong!');
            return false;
        }
        document.getElementById('konten').value = html;
        return true;
    };
</script>
<?= $this->endSection() ?>
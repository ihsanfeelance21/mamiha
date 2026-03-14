<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div class="max-w-4xl bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-10">
    <div class="mb-6 flex items-center justify-between border-b pb-4">
        <div>
            <h3 class="text-xl font-bold text-text-main">Tulis Berita Baru</h3>
            <p class="text-sm text-gray-500 mt-1">Publikasikan informasi terbaru untuk pengunjung website.</p>
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <div class="md:col-span-2">
                <label for="judul" class="block text-sm font-medium text-text-main mb-1">Judul Berita <span class="text-red-500">*</span></label>
                <input type="text" id="judul" name="judul" value="<?= old('judul') ?>" required autofocus
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition text-lg font-medium">
            </div>

            <div>
                <label for="id_kategori" class="block text-sm font-medium text-text-main mb-1">Kategori <span class="text-red-500">*</span></label>
                <select id="id_kategori" name="id_kategori" required class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition bg-white">
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategori as $k) : ?>
                        <option value="<?= $k['id'] ?>" <?= old('id_kategori') == $k['id'] ? 'selected' : '' ?>><?= $k['nama_kategori'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="layout" class="block text-sm font-medium text-text-main mb-1">Gaya Tampilan (Layout)</label>
                <select id="layout" name="layout" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition bg-white">
                    <option value="split" <?= old('layout') == 'split' ? 'selected' : '' ?>>Split (Gambar Kiri, Teks Kanan)</option>
                    <option value="block" <?= old('layout') == 'block' ? 'selected' : '' ?>>Block (Gambar Atas, Teks Bawah)</option>
                    <option value="immersive" <?= old('layout') == 'immersive' ? 'selected' : '' ?>>Immersive (Gambar Full Cover)</option>
                </select>
            </div>
        </div>

        <div class="mb-6 p-4 bg-gray-50 rounded border border-gray-200">
            <label for="gambar" class="block text-sm font-medium text-text-main mb-1">Gambar Utama / Thumbnail (Wajib)</label>
            <input type="file" id="gambar" name="gambar" accept="image/png, image/jpeg, image/webp" required
                class="w-full border border-gray-300 rounded px-4 py-2 text-sm text-gray-500 bg-white file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary-hover transition">
            <p class="text-xs text-gray-500 mt-2">Gambar ini akan otomatis dikompres dan diubah ke format WEBP oleh sistem.</p>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-text-main mb-1">Isi Berita <span class="text-red-500">*</span></label>
            <div id="editor-container" style="height: 400px; background-color: white; font-family: inherit; font-size: 16px;"></div>

            <input type="hidden" name="konten" id="konten" value="<?= htmlspecialchars(old('konten') ?? '') ?>">
        </div>

        <div class="flex justify-end pt-4 border-t border-gray-100">
            <button type="submit" class="bg-primary hover:bg-primary-hover text-white px-8 py-3 rounded font-bold transition shadow-md">
                Terbitkan Berita
            </button>
        </div>
    </form>
</div>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">

<style>
    /* 1. Container Tabel: Dikasih jarak dan bayangan tipis */
    .ql-editor table {
        border-collapse: collapse;
        width: 100%;
        margin: 1.5rem 0;
        font-size: 0.95rem;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    /* 2. Sel Tabel Dasar */
    .ql-editor td,
    .ql-editor th {
        border: 1px solid #e5e7eb;
        /* Garis abu-abu lembut agar rapi */
        padding: 12px 16px;
        color: #374151;
        /* Warna teks abu-abu gelap agar mudah dibaca */
    }

    /* 3. MAGIC: Baris Pertama otomatis jadi Header HIJAU! */
    .ql-editor table tr:first-child td {
        background-color: #16a34a;
        /* Warna Hijau Utama (Primary Green) */
        color: #ffffff;
        font-weight: 600;
        text-align: center;
        border-color: #15803d;
        /* Warna hijau sedikit lebih gelap untuk border */
    }

    /* 4. Variasi Baris Zebra (Belang-belang) untuk baris genap */
    .ql-editor table tr:nth-child(even) td {
        background-color: #f0fdf4;
        /* Hijau super tipis (Hampir putih) untuk variasi */
    }

    /* 5. Efek Hover: Baris menyala hijau muda saat dilewati mouse (kecuali header) */
    .ql-editor table tr:not(:first-child):hover td {
        background-color: #dcfce7;
        /* Hijau muda terang saat di-hover */
        transition: background-color 0.2s ease;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

<script>
    // ==============================================================
    // 1. SUNTIK IKON TABEL 
    // ==============================================================
    var icons = Quill.import('ui/icons');
    icons['table'] = '<svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="12" height="12" rx="1" ry="1"></rect><line x1="3" y1="9" x2="15" y2="9"></line><line x1="9" y1="3" x2="9" y2="15"></line></svg>';

    // ==============================================================
    // 2. INISIALISASI QUILL EDITOR 2.0.2
    // ==============================================================
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Tulis isi berita di sini...',
        modules: {
            table: true, // Modul tabel bawaan Quill 2 yang sudah disempurnakan
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
                    ['link', 'image', 'video', 'table'], // Ikon tabel muncul
                    ['clean']
                ],
                handlers: {
                    // Handler untuk Custom Image AJAX (Tetap aman!)
                    image: imageHandler,

                    // Handler Tabel menggunakan fungsi bawaan Quill 2
                    table: function() {
                        var rows = prompt("Masukkan jumlah Baris (contoh: 3):", "3");
                        var cols = prompt("Masukkan jumlah Kolom (contoh: 3):", "3");

                        if (rows !== null && cols !== null && rows > 0 && cols > 0) {
                            // Di Quill 2.0, fungsi ini sudah bekerja dengan sempurna!
                            this.quill.getModule('table').insertTable(parseInt(rows), parseInt(cols));
                        }
                    }
                }
            }
        }
    });

    // ==============================================================
    // 3. MENGEMBALIKAN DATA LAMA (JIKA VALIDASI GAGAL)
    // ==============================================================
    var oldKonten = document.getElementById('konten').value;
    if (oldKonten) {
        // Quill 2 lebih pintar membaca HTML mentah
        quill.clipboard.dangerouslyPasteHTML(oldKonten);
    }

    // ==============================================================
    // 4. CUSTOM IMAGE HANDLER (AJAX Upload ke Server)
    // ==============================================================
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

    // ==============================================================
    // 5. SINKRONISASI KE INPUT HIDDEN SAAT SUBMIT
    // ==============================================================
    var form = document.getElementById('form-berita');
    form.onsubmit = function() {
        var html = quill.getSemanticHTML(); // Fitur baru Quill 2 untuk mengambil HTML bersih

        if (html === '<p><br></p>' || html.trim() === '') {
            alert('Isi berita tidak boleh kosong!');
            return false;
        }

        document.getElementById('konten').value = html;
        return true;
    };
</script>
<?= $this->endSection() ?>
<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">

<div class="mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-2xl font-bold text-text-main">Edit Berita</h3>
        <p class="text-sm text-gray-500 mt-1">Perbarui konten, status, atau jadwal tayang berita.</p>
    </div>
    <a href="<?= base_url('admin/berita') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded transition font-medium text-sm">
        &larr; Kembali
    </a>
</div>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('admin/berita/update/' . $berita['id']) ?>" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <?= csrf_field() ?>

    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="mb-4">
                <label class="block text-text-main font-semibold mb-2">Judul Berita <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="<?= old('judul', $berita['judul']) ?>" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition" required placeholder="Masukkan judul berita...">
            </div>

            <div class="mb-4">
                <label class="block text-text-main font-semibold mb-2">Isi Berita <span class="text-red-500">*</span></label>
                <div id="editor" style="height: 400px;">
                    <?= old('konten', $berita['konten']) ?>
                </div>
                <input type="hidden" name="konten" id="konten_hidden">
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">

            <div class="mb-5">
                <label class="block text-text-main font-semibold mb-2">Status Publikasi</label>
                <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-primary transition bg-gray-50">
                    <option value="terbit" <?= old('status', $berita['status']) == 'terbit' ? 'selected' : '' ?>>Langsung Terbit</option>
                    <option value="draft" <?= old('status', $berita['status']) == 'draft' ? 'selected' : '' ?>>Simpan sbg Draft</option>
                    <option value="terjadwal" <?= old('status', $berita['status']) == 'terjadwal' ? 'selected' : '' ?>>Terjadwal (Otomatis)</option>
                </select>
            </div>

            <div class="mb-5" id="waktu-tayang-container">
                <label class="block text-text-main font-semibold mb-2">Jadwal Tayang <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="waktu_tayang" value="<?= old('waktu_tayang', ($berita['waktu_tayang'] ? date('Y-m-d\TH:i', strtotime($berita['waktu_tayang'])) : '')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-primary transition">
                <p class="text-xs text-gray-500 mt-1">Berita akan otomatis terbit pada waktu ini.</p>
            </div>

            <div class="mb-5">
                <label class="block text-text-main font-semibold mb-2">Kategori <span class="text-red-500">*</span></label>
                <select name="id_kategori" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-primary transition" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategori as $k) : ?>
                        <option value="<?= $k['id'] ?>" <?= old('id_kategori', $berita['id_kategori']) == $k['id'] ? 'selected' : '' ?>><?= $k['nama_kategori'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-5">
                <label class="block text-text-main font-semibold mb-2">Tags / Label</label>
                <select id="tags" name="tags[]" multiple placeholder="Pilih atau ketik tag..." autocomplete="off">
                    <?php
                    // Siapkan array tag yang terpilih (dari Controller / Old input)
                    $oldTags = old('tags', $selectedTags);
                    foreach ($tags as $t) : ?>
                        <option value="<?= $t['id'] ?>" <?= in_array($t['id'], $oldTags) ? 'selected' : '' ?>><?= $t['nama_tag'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-5">
                <label class="block text-text-main font-semibold mb-2">Tampilan Layout</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="layout" value="modern" <?= old('layout', $berita['layout']) == 'modern' ? 'checked' : '' ?> class="text-primary focus:ring-primary">
                        <span>Modern</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="layout" value="legacy" <?= old('layout', $berita['layout']) == 'legacy' ? 'checked' : '' ?> class="text-primary focus:ring-primary">
                        <span>Legacy</span>
                    </label>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-text-main font-semibold mb-2">Gambar Utama (Thumbnail)</label>
                <?php if ($berita['gambar']): ?>
                    <div class="mb-2">
                        <img src="<?= base_url('uploads/berita/' . $berita['gambar']) ?>" alt="Thumbnail Lama" class="w-full h-auto rounded border border-gray-200 shadow-sm">
                        <p class="text-xs text-gray-500 mt-1 italic">Gambar saat ini.</p>
                    </div>
                <?php endif; ?>

                <input type="file" name="gambar" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary-hover transition mt-2">
                <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah gambar.</p>
            </div>

            <button type="submit" onclick="submitForm(event)" class="w-full bg-primary hover:bg-primary-hover text-white font-bold py-3 px-4 rounded shadow transition text-center">
                Simpan Perubahan
            </button>
        </div>
    </div>
</form>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
    // 1. Logika Tampil/Sembunyi Jadwal Tayang
    const statusSelect = document.getElementById('status');
    const waktuContainer = document.getElementById('waktu-tayang-container');

    function toggleWaktuTayang() {
        if (statusSelect.value === 'terjadwal') {
            waktuContainer.classList.remove('hidden');
        } else {
            waktuContainer.classList.add('hidden');
        }
    }
    statusSelect.addEventListener('change', toggleWaktuTayang);
    toggleWaktuTayang(); // Jalankan saat halaman pertama kali diload

    // 2. Inisialisasi Tom Select (Multi Tags)
    new TomSelect("#tags", {
        plugins: ['remove_button'],
        create: false,
        maxItems: 10,
    });

    // 3. Inisialisasi Quill JS
    var quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Mulai menulis berita di sini...',
        modules: {
            toolbar: [
                [{
                    'header': [1, 2, 3, false]
                }],
                ['bold', 'italic', 'underline', 'strike'],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                ['link', 'image', 'video'],
                ['clean']
            ]
        }
    });

    // Handle Upload Gambar di dalam Editor Quill (Sama seperti di fitur Tambah)
    quill.getModule('toolbar').addHandler('image', function() {
        var fileInput = document.createElement('input');
        fileInput.setAttribute('type', 'file');
        fileInput.setAttribute('accept', 'image/*');
        fileInput.click();

        fileInput.onchange = function() {
            var file = fileInput.files[0];
            var formData = new FormData();
            formData.append('image', file);

            fetch('<?= base_url("admin/berita/uploadGambarQuill") ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        var range = quill.getSelection();
                        quill.insertEmbed(range.index, 'image', result.url);
                    } else {
                        alert(result.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        };
    });

    // 4. Sinkronisasi Quill ke Input Hidden sebelum Submit Form
    function submitForm(e) {
        var html = quill.root.innerHTML;
        if (html === '<p><br></p>') {
            html = '';
        }
        document.getElementById('konten_hidden').value = html;
    }
</script>

<?= $this->endSection() ?>
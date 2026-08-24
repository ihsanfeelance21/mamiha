<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">

<div class="mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-2xl font-bold text-gray-800">Tulis Berita Baru</h3>
        <p class="text-sm text-gray-500 mt-1">Publikasikan atau jadwalkan informasi terbaru website.</p>
    </div>
    <a href="<?= base_url('admin/berita') ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl font-medium text-sm flex items-center gap-2">
        &larr; Kembali
    </a>
</div>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-xl">
        <?php $err = session()->getFlashdata('error'); ?>
        <?php if (is_array($err)) : ?>
            <ul class="list-disc list-inside text-sm"><?php foreach ($err as $e) : ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
        <?php else : ?>
            <p class="text-sm"><?= esc($err) ?></p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('admin/berita/simpan') ?>" method="post" enctype="multipart/form-data" id="form-berita" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <?= csrf_field() ?>

    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <label class="block text-sm font-bold text-gray-700 mb-2">Judul Berita <span class="text-red-500">*</span></label>
            <input type="text" name="judul" value="<?= old('judul') ?>" required autofocus class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20 text-lg font-medium" placeholder="Masukkan judul berita...">

            <div class="mt-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Isi Berita <span class="text-red-500">*</span></label>
                <div id="editor-container" style="height: 500px; background: white;"></div>
                <input type="hidden" name="konten" id="konten" value="<?= htmlspecialchars(old('konten') ?? '') ?>">
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Status Publikasi</label>
            <select name="status" id="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-[#00A859] focus:ring-2 focus:ring-[#00A859]/20">
                <option value="terbit" <?= old('status') == 'terbit' ? 'selected' : '' ?>>Terbitkan Langsung</option>
                <option value="draft" <?= old('status') == 'draft' ? 'selected' : '' ?>>Simpan sebagai Draft</option>
                <option value="terjadwal" <?= old('status') == 'terjadwal' ? 'selected' : '' ?>>Jadwalkan Tayang...</option>
            </select>

            <div id="waktu-tayang-container" class="<?= old('status') == 'draft' ? 'hidden' : '' ?> mt-4 p-4 rounded-xl border <?= old('status') == 'terjadwal' ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200' ?>">
                <div class="flex items-center justify-between mb-2">
                    <label id="label-waktu" class="text-sm font-bold <?= old('status') == 'terjadwal' ? 'text-blue-800' : 'text-gray-700' ?>">
                        <?= old('status') == 'terjadwal' ? 'Pilih Jadwal Tayang <span class="text-red-500">*</span>' : 'Ubah Tanggal Rilis (Opsional)' ?>
                    </label>
                    <button type="button" id="btn-reset-waktu" class="<?= old('status') == 'terbit' ? 'block' : 'hidden' ?> text-xs text-red-500 font-bold">Reset ke Waktu Sekarang</button>
                </div>
                <input type="datetime-local" id="waktu_tayang" name="waktu_tayang" value="<?= old('waktu_tayang') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 <?= old('status') == 'terjadwal' ? 'focus:border-blue-500 focus:ring-blue-500' : 'focus:border-[#00A859] focus:ring-[#00A859]/20' ?>">
                <p id="desc-waktu" class="text-xs mt-2 <?= old('status') == 'terjadwal' ? 'text-blue-600' : 'text-gray-500' ?>">
                    <?= old('status') == 'terjadwal' ? 'Tidak terlihat sebelum jadwal.' : 'Biarkan kosong jika ingin diterbitkan saat ini juga. Isi tanggal lampau untuk Backdate.' ?>
                </p>
            </div>

            <div class="mt-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Kategori Utama <span class="text-red-500">*</span></label>
                <select name="id_kategori" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#00A859]">
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategori as $k) : ?>
                        <option value="<?= $k['id'] ?>" <?= old('id_kategori') == $k['id'] ? 'selected' : '' ?>><?= esc($k['nama_kategori']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mt-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Tags / Hashtag</label>
                <select id="tags" name="tags[]" multiple placeholder="Pilih atau ketik tag..." autocomplete="off">
                    <?php if (isset($tags)) : foreach ($tags as $t) : ?>
                        <option value="<?= $t['id'] ?>"><?= esc($t['nama_tag']) ?></option>
                    <?php endforeach; endif; ?>
                </select>
            </div>

            <div class="mt-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Gaya Tampilan</label>
                <select name="layout" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl">
                    <option value="modern" <?= old('layout') == 'modern' ? 'selected' : '' ?>>Modern (Gambar Lebar)</option>
                    <option value="legacy" <?= old('layout') == 'legacy' ? 'selected' : '' ?>>Legacy (Gambar Samping)</option>
                </select>
            </div>

            <div class="mt-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Gambar Utama / Thumbnail <span class="text-red-500">*</span></label>
                <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/png,image/webp" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-[#00A859] file:text-white hover:file:bg-[#0B4A2D] border border-gray-200 rounded-xl p-2 bg-gray-50">
                <div id="preview-wrap" class="hidden mt-3">
                    <img id="preview-img" class="w-full h-40 object-cover rounded-xl border">
                    <button type="button" onclick="document.getElementById('gambar').value=''; document.getElementById('preview-wrap').classList.add('hidden')" class="text-xs text-red-500 mt-1">Hapus preview</button>
                </div>
                <p class="text-xs text-gray-500 mt-2">Otomatis WebP 1200px, max 6MB. Lanskap untuk Modern, persegi untuk Legacy.</p>
            </div>

            <button type="submit" class="w-full mt-6 bg-[#00A859] hover:bg-[#0B4A2D] text-white font-bold py-3 rounded-xl shadow">Simpan Berita</button>
        </div>
    </div>
</form>

<style>
    .ts-control { padding: 8px 12px; border-radius: 0.75rem; border-color: #e5e7eb; }
    .ts-control.focus { border-color: #00A859; box-shadow: 0 0 0 2px rgba(0,168,89,0.2); }
    .ql-editor table { border-collapse: collapse; width: 100%; margin: 1rem 0; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.05); }
    .ql-editor td, .ql-editor th { border: 1px solid #e5e7eb; padding: 10px 14px; }
    .ql-editor table tr:first-child td { background: #00A859; color: #fff; font-weight: 700; text-align: center; }
    .ql-editor table tr:nth-child(even) td { background: #f0fdf4; }
</style>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect("#tags", { plugins: ['remove_button'], maxOptions: null, maxItems: 10, placeholder: "Pilih Tag..." });
    const statusSelect = document.getElementById('status');
    const waktuContainer = document.getElementById('waktu-tayang-container');
    const waktuInput = document.getElementById('waktu_tayang');
    const labelWaktu = document.getElementById('label-waktu');
    const descWaktu = document.getElementById('desc-waktu');
    const btnReset = document.getElementById('btn-reset-waktu');
    function updateWaktuUI() {
        const s = statusSelect.value;
        if (s === 'terjadwal') {
            waktuContainer.classList.remove('hidden', 'bg-gray-50', 'border-gray-200');
            waktuContainer.classList.add('bg-blue-50', 'border-blue-200');
            labelWaktu.innerHTML = 'Pilih Jadwal Tayang <span class="text-red-500">*</span>';
            labelWaktu.className = 'text-sm font-bold text-blue-800';
            descWaktu.textContent = 'Tidak terlihat sebelum jadwal.';
            descWaktu.className = 'text-xs text-blue-600 mt-2';
            waktuInput.setAttribute('required', 'required');
            btnReset.classList.add('hidden');
        } else if (s === 'terbit') {
            waktuContainer.classList.remove('hidden', 'bg-blue-50', 'border-blue-200');
            waktuContainer.classList.add('bg-gray-50', 'border-gray-200');
            labelWaktu.textContent = 'Ubah Tanggal Rilis (Opsional)';
            labelWaktu.className = 'text-sm font-bold text-gray-700';
            descWaktu.textContent = 'Biarkan kosong jika ingin diterbitkan saat ini juga. Isi tanggal lampau untuk Backdate.';
            descWaktu.className = 'text-xs text-gray-500 mt-2';
            waktuInput.removeAttribute('required');
            btnReset.classList.remove('hidden');
        } else {
            waktuContainer.classList.add('hidden');
            waktuInput.removeAttribute('required');
            waktuInput.value = '';
        }
    }
    btnReset.addEventListener('click', () => waktuInput.value = '');
    statusSelect.addEventListener('change', updateWaktuUI);
    updateWaktuUI();
    document.getElementById('gambar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = ev => {
            document.getElementById('preview-img').src = ev.target.result;
            document.getElementById('preview-wrap').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });
    var icons = Quill.import('ui/icons');
    icons['table'] = '<svg viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="12" height="12" rx="1"></rect><line x1="3" y1="9" x2="15" y2="9"></line><line x1="9" y1="3" x2="9" y2="15"></line></svg>';
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Tulis isi berita di sini...',
        modules: {
            table: true,
            toolbar: {
                container: [[{'header':[2,3,4,false]}],['bold','italic','underline','strike'],['blockquote','code-block'],[{'list':'ordered'},{'list':'bullet'}],[{'align':[]}],['link','image','video','table'],['clean']],
                handlers: {
                    image: imageHandler,
                    table: function(){ const r=prompt("Baris:", "3"); const c=prompt("Kolom:", "3"); if(r&&c) this.quill.getModule('table').insertTable(parseInt(r),parseInt(c)); }
                }
            }
        }
    });
    var oldKonten = document.getElementById('konten').value;
    if (oldKonten) quill.clipboard.dangerouslyPasteHTML(oldKonten);
    function imageHandler() {
        var input = document.createElement('input'); input.type='file'; input.accept='image/*'; input.click();
        input.onchange = () => {
            var file = input.files[0];
            var fd = new FormData(); fd.append('image', file);
            fetch('<?= base_url('admin/berita/upload-gambar-quill') ?>', {method:'POST', body: fd})
                .then(r=>r.json()).then(res=>{ if(res.success){ quill.insertEmbed(quill.getSelection(true).index, 'image', res.url); } else alert(res.message); });
        };
    }
    document.getElementById('form-berita').addEventListener('submit', function(e){
        const html = quill.getSemanticHTML();
        if (html === '<p><br></p>' || html.trim()==='') { alert('Isi berita tidak boleh kosong!'); e.preventDefault(); return false; }
        document.getElementById('konten').value = html;
    });
</script>
<?= $this->endSection() ?>

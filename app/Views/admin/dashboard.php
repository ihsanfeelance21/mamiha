<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 border-l-4 border-l-primary">
        <h3 class="text-text-muted text-sm font-semibold mb-1">Total Pendaftar</h3>
        <p class="text-3xl font-bold">142</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 border-l-4 border-l-accent">
        <h3 class="text-text-muted text-sm font-semibold mb-1">Artikel Kegiatan</h3>
        <p class="text-3xl font-bold">24</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 border-l-4 border-l-blue-500">
        <h3 class="text-text-nav text-sm font-semibold mb-1">Pesan Masuk</h3>
        <p class="text-3xl font-bold">5</p>
    </div>
</div>
<?= $this->endSection() ?>
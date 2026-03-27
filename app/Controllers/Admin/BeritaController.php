<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\KategoriBeritaModel;
use App\Models\TagModel;           // TAMBAHAN: Panggil Model Tag
use App\Models\BeritaTagModel;     // TAMBAHAN: Panggil Model Pivot Tag

class BeritaController extends BaseController
{
    protected $beritaModel;
    protected $kategoriModel;
    protected $tagModel;           // TAMBAHAN
    protected $beritaTagModel;     // TAMBAHAN

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        $this->kategoriModel = new KategoriBeritaModel();
        $this->tagModel = new TagModel();             // TAMBAHAN
        $this->beritaTagModel = new BeritaTagModel(); // TAMBAHAN
    }

    // =========================================================================
    // FITUR KATEGORI BERITA (Tetap seperti semula)
    // =========================================================================

    public function kategori()
    {
        $data = [
            'title'    => 'Kelola Kategori Berita',
            'kategori' => $this->kategoriModel->findAll()
        ];
        return view('admin/berita/kategori', $data);
    }

    public function simpanKategori()
    {
        $namaKategori = $this->request->getPost('nama_kategori');
        $slug = url_title($namaKategori, '-', true);

        if ($this->kategoriModel->where('slug_kategori', $slug)->first()) {
            return redirect()->back()->with('error', 'Kategori tersebut sudah ada!');
        }

        $this->kategoriModel->save([
            'nama_kategori' => $namaKategori,
            'slug_kategori' => $slug
        ]);

        return redirect()->back()->with('pesan', 'Kategori berhasil ditambahkan!');
    }

    public function hapusKategori($id)
    {
        $cekBerita = $this->beritaModel->where('id_kategori', $id)->first();
        if ($cekBerita) {
            return redirect()->back()->with('error', 'Kategori tidak bisa dihapus karena sedang digunakan oleh berita!');
        }

        $this->kategoriModel->delete($id);
        return redirect()->back()->with('pesan', 'Kategori berhasil dihapus!');
    }


    // =========================================================================
    // FITUR BERITA UTAMA
    // =========================================================================

    public function index()
    {
        $data = [
            'title'  => 'Manajemen Berita',
            'berita' => $this->beritaModel->getBeritaDenganKategori()
        ];
        return view('admin/berita/index', $data);
    }

    // UPDATE: Fungsi Tambah
    public function tambah()
    {
        $data = [
            'title'    => 'Tulis Berita Baru',
            'kategori' => $this->kategoriModel->findAll(),
            'tags'     => $this->tagModel->findAll() // Kirim semua data Tag ke View
        ];

        if (empty($data['kategori'])) {
            return redirect()->to(base_url('admin/berita/kategori'))->with('error', 'Silakan buat Kategori Berita terlebih dahulu sebelum menulis berita!');
        }

        return view('admin/berita/tambah', $data);
    }

    // UPDATE: Fungsi Simpan (Menangani Penjadwalan & Multiple Tags)
    public function simpan()
    {
        $statusInput = $this->request->getPost('status');

        $rules = [
            'judul'       => 'required|min_length[5]|is_unique[berita.judul]',
            'id_kategori' => 'required',
            'konten'      => 'required',
            'gambar'      => 'uploaded[gambar]|max_size[gambar,6144]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        // Validasi ekstra: Jika statusnya terjadwal, waktu tayang WAJIB diisi
        if ($statusInput == 'terjadwal') {
            $rules['waktu_tayang'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Mohon periksa kembali form Anda. Pastikan Judul unik, gambar diunggah, dan jadwal diisi (jika terjadwal).');
        }

        // 1. Proses Gambar (WebP & Resize)
        $fileGambar = $this->request->getFile('gambar');
        $namaGambarFinal = null;

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaFileAcak = $fileGambar->getRandomName();
            $namaTanpaEkstensi = pathinfo($namaFileAcak, PATHINFO_FILENAME);
            $namaGambarFinal = $namaTanpaEkstensi . '.webp';

            \Config\Services::image()
                ->withFile($fileGambar->getTempName())
                ->resize(1200, 1200, true, 'height')
                ->save(FCPATH . 'uploads/berita/' . $namaGambarFinal, 80);
        }

        // 2. Bersihkan Konten dari XSS
        $kontenKotor = $this->request->getPost('konten');
        $kontenBersih = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $kontenKotor);

        // 3. Tentukan Waktu Tayang
        $waktuTayang = null;
        if ($statusInput == 'terjadwal') {
            $waktuTayang = $this->request->getPost('waktu_tayang');
        } else if ($statusInput == 'terbit') {
            // Jika langsung terbit, waktu tayang = waktu sekarang
            $waktuTayang = date('Y-m-d H:i:s');
        }

        // 4. Simpan Data Berita Utama
        $dataBerita = [
            'id_kategori'  => $this->request->getPost('id_kategori'),
            'judul'        => $this->request->getPost('judul'),
            'slug'         => url_title($this->request->getPost('judul'), '-', true),
            'konten'       => $kontenBersih,
            'layout'       => $this->request->getPost('layout') ?? 'modern',
            'status'       => $statusInput,
            'waktu_tayang' => $waktuTayang,
            'gambar'       => $namaGambarFinal
        ];

        $this->beritaModel->insert($dataBerita);
        $idBeritaBaru = $this->beritaModel->getInsertID(); // Ambil ID berita yang baru saja disimpan

        // 5. Simpan Data Tags (Tabel Pivot)
        $inputTags = $this->request->getPost('tags'); // Array dari Tom Select
        if (!empty($inputTags)) {
            $dataPivot = [];
            foreach ($inputTags as $idTag) {
                // Kumpulkan data batch
                $dataPivot[] = [
                    'id_berita' => $idBeritaBaru,
                    'id_tag'    => $idTag
                ];
            }
            // Insert banyak data sekaligus
            $this->beritaTagModel->insertBatch($dataPivot);
        }

        return redirect()->to(base_url('admin/berita'))->with('pesan', 'Berita berhasil disimpan!');
    }

    // =========================================================================
    // FITUR EDIT & UPDATE BERITA
    // =========================================================================

    public function edit($id)
    {
        $berita = $this->beritaModel->find($id);

        if (!$berita) {
            return redirect()->to(base_url('admin/berita'))->with('error', 'Berita tidak ditemukan.');
        }

        // Ambil data tag yang sudah menempel di berita ini (untuk ditampilkan di Tom Select)
        $beritaTags = $this->beritaTagModel->where('id_berita', $id)->findAll();
        // Ekstrak hanya id_tag-nya saja menjadi array biasa (contoh: [1, 3, 5])
        $selectedTags = array_column($beritaTags, 'id_tag');

        $data = [
            'title'        => 'Edit Berita',
            'berita'       => $berita,
            'kategori'     => $this->kategoriModel->findAll(),
            'tags'         => $this->tagModel->findAll(),
            'selectedTags' => $selectedTags
        ];

        return view('admin/berita/edit', $data);
    }

    public function update($id)
    {
        // 1. Cari data lama
        $beritaLama = $this->beritaModel->find($id);
        if (!$beritaLama) {
            return redirect()->to(base_url('admin/berita'))->with('error', 'Berita tidak ditemukan.');
        }

        $statusInput = $this->request->getPost('status');

        // 2. Setup Validasi (Gambar tidak wajib, Judul unik kecuali untuk ID ini sendiri)
        $rules = [
            'judul'       => "required|min_length[5]|is_unique[berita.judul,id,{$id}]",
            'id_kategori' => 'required',
            'konten'      => 'required',
            'gambar'      => 'max_size[gambar,6144]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if ($statusInput == 'terjadwal') {
            $rules['waktu_tayang'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan! Pastikan judul tidak dipakai berita lain dan format file sesuai.');
        }

        // 3. Proses Gambar (Jika admin upload gambar baru)
        $fileGambar = $this->request->getFile('gambar');
        $namaGambarFinal = $beritaLama['gambar']; // Default: Pakai gambar lama

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            // Hapus gambar lama dari server jika file-nya benar-benar ada
            if ($beritaLama['gambar'] && file_exists(FCPATH . 'uploads/berita/' . $beritaLama['gambar'])) {
                unlink(FCPATH . 'uploads/berita/' . $beritaLama['gambar']);
            }

            // Proses gambar baru
            $namaFileAcak = $fileGambar->getRandomName();
            $namaTanpaEkstensi = pathinfo($namaFileAcak, PATHINFO_FILENAME);
            $namaGambarFinal = $namaTanpaEkstensi . '.webp';

            \Config\Services::image()
                ->withFile($fileGambar->getTempName())
                ->resize(1200, 1200, true, 'height')
                ->save(FCPATH . 'uploads/berita/' . $namaGambarFinal, 80);
        }

        // 4. Bersihkan Konten dari XSS
        $kontenKotor = $this->request->getPost('konten');
        $kontenBersih = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $kontenKotor);

        // 5. Tentukan Waktu Tayang
        $waktuTayang = null;
        if ($statusInput == 'terjadwal') {
            $waktuTayang = $this->request->getPost('waktu_tayang');
        } else if ($statusInput == 'terbit') {
            // Jika sebelumnya sudah terbit, biarkan jam tayang lama. Jika tidak, pakai jam sekarang.
            $waktuTayang = ($beritaLama['status'] == 'terbit') ? $beritaLama['waktu_tayang'] : date('Y-m-d H:i:s');
        }

        // 6. Update Data ke Tabel Berita
        $dataBerita = [
            'id_kategori'  => $this->request->getPost('id_kategori'),
            'judul'        => $this->request->getPost('judul'),
            'slug'         => url_title($this->request->getPost('judul'), '-', true),
            'konten'       => $kontenBersih,
            'layout'       => $this->request->getPost('layout') ?? 'modern',
            'status'       => $statusInput,
            'waktu_tayang' => $waktuTayang,
            'gambar'       => $namaGambarFinal
        ];

        $this->beritaModel->update($id, $dataBerita);

        // 7. Update Data Tags Pivot (Hapus Semua, lalu Insert Baru)
        $this->beritaTagModel->where('id_berita', $id)->delete();

        $inputTags = $this->request->getPost('tags');
        if (!empty($inputTags)) {
            $dataPivot = [];
            foreach ($inputTags as $idTag) {
                $dataPivot[] = [
                    'id_berita' => $id,
                    'id_tag'    => $idTag
                ];
            }
            $this->beritaTagModel->insertBatch($dataPivot);
        }

        return redirect()->to(base_url('admin/berita'))->with('pesan', 'Perubahan berita berhasil disimpan!');
    }

    public function hapus($id)
    {
        $berita = $this->beritaModel->find($id);
        if ($berita) {
            // Hapus file gambar thumbnail
            if ($berita['gambar'] && file_exists(FCPATH . 'uploads/berita/' . $berita['gambar'])) {
                unlink(FCPATH . 'uploads/berita/' . $berita['gambar']);
            }

            // Hapus data pivot tags terlebih dahulu (agar database bersih)
            $this->beritaTagModel->where('id_berita', $id)->delete();

            // Hapus data berita
            $this->beritaModel->delete($id);
            return redirect()->to(base_url('admin/berita'))->with('pesan', 'Berita berhasil dihapus.');
        }
        return redirect()->to(base_url('admin/berita'))->with('error', 'Data tidak ditemukan.');
    }

    // =========================================================================
    // HANDLER GAMBAR UNTUK QUILL.JS (Tetap seperti semula)
    // =========================================================================

    public function uploadGambarQuill()
    {
        $file = $this->request->getFile('image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaAcak = $file->getRandomName();
            $namaFinal = pathinfo($namaAcak, PATHINFO_FILENAME) . '.webp';

            \Config\Services::image()
                ->withFile($file->getTempName())
                ->resize(800, 800, true, 'width')
                ->save(FCPATH . 'uploads/berita/konten/' . $namaFinal, 80);

            return $this->response->setJSON([
                'success' => true,
                'url'     => base_url('uploads/berita/konten/' . $namaFinal)
            ]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengunggah gambar.']);
    }
    // =========================================================================
    // FITUR KELOLA TAGS / LABEL
    // =========================================================================

    public function tags()
    {
        $data = [
            'title' => 'Kelola Tags & Label',
            'tags'  => $this->tagModel->findAll()
        ];
        return view('admin/berita/tags', $data);
    }

    public function simpanTag()
    {
        $namaTag = $this->request->getPost('nama_tag');
        $linkEksternal = $this->request->getPost('link_eksternal'); // Opsional
        $slug = url_title($namaTag, '-', true);

        // Cek apakah tag sudah ada di database biar tidak double
        if ($this->tagModel->where('slug_tag', $slug)->first()) {
            return redirect()->back()->withInput()->with('error', 'Tag tersebut sudah ada! Silakan buat yang lain.');
        }

        $this->tagModel->save([
            'nama_tag'       => $namaTag,
            'slug_tag'       => $slug,
            'link_eksternal' => empty($linkEksternal) ? null : $linkEksternal
        ]);

        return redirect()->back()->with('pesan', 'Tag baru berhasil ditambahkan!');
    }

    public function hapusTag($id)
    {
        // 1. Bersihkan dulu data tag ini dari tabel pivot (berita_tags)
        // supaya tidak ada sisa data tag "hantu" di berita yang sudah terbit.
        $this->beritaTagModel->where('id_tag', $id)->delete();

        // 2. Baru hapus tag utamanya
        $this->tagModel->delete($id);

        return redirect()->back()->with('pesan', 'Tag berhasil dihapus secara permanen!');
    }
}

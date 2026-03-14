<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\KategoriBeritaModel;

class BeritaController extends BaseController
{
    protected $beritaModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        $this->kategoriModel = new KategoriBeritaModel();
    }

    // =========================================================================
    // FITUR KATEGORI BERITA
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

        // Cek apakah kategori sudah ada
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
        // Cek apakah kategori sedang dipakai di tabel berita
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
            // Gunakan fungsi join yang kita buat di Model
            'berita' => $this->beritaModel->getBeritaDenganKategori()
        ];
        return view('admin/berita/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title'    => 'Tulis Berita Baru',
            'kategori' => $this->kategoriModel->findAll()
        ];

        if (empty($data['kategori'])) {
            return redirect()->to(base_url('admin/kategori-berita'))->with('error', 'Silakan buat Kategori Berita terlebih dahulu sebelum menulis berita!');
        }

        return view('admin/berita/tambah', $data);
    }

    public function simpan()
    {
        $rules = [
            'judul'       => 'required|min_length[5]|is_unique[berita.judul]',
            'id_kategori' => 'required',
            'konten'      => 'required',
            // Tambahkan "uploaded[gambar]" agar form tidak bisa disubmit tanpa gambar thumbnail
            'gambar'      => 'uploaded[gambar]|max_size[gambar,6144]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getError('judul') ?: 'Mohon periksa kembali form Anda, pastikan gambar terisi.');
        }

        $fileGambar = $this->request->getFile('gambar');
        $namaGambarFinal = null;

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaFileAcak = $fileGambar->getRandomName();
            $namaTanpaEkstensi = pathinfo($namaFileAcak, PATHINFO_FILENAME);
            $namaGambarFinal = $namaTanpaEkstensi . '.webp';

            // Auto-Resize 1200px & Convert WebP 80%
            \Config\Services::image()
                ->withFile($fileGambar->getTempName())
                ->resize(1200, 1200, true, 'height') // Paksa maksimal dimensi 1200px
                ->save(FCPATH . 'uploads/berita/' . $namaGambarFinal, 80); // Otomatis jadi WebP
        }

        // ==========================================
        // ANTI-XSS: Bersihkan tag script dari Konten
        // ==========================================
        $kontenKotor = $this->request->getPost('konten');
        // Jika Mas belum install library HTMLPurifier, kita gunakan proteksi regex dasar dari CI4:
        $kontenBersih = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $kontenKotor);

        $this->beritaModel->save([
            'id_kategori' => $this->request->getPost('id_kategori'),
            'judul'       => $this->request->getPost('judul'),
            'slug'        => url_title($this->request->getPost('judul'), '-', true),
            'konten'      => $kontenBersih, // Simpan konten yang sudah dibersihkan
            'layout'      => $this->request->getPost('layout') ?? 'split',
            'gambar'      => $namaGambarFinal
        ]);

        return redirect()->to(base_url('admin/berita'))->with('pesan', 'Berita berhasil diterbitkan!');
    }

    // =========================================================================
    // HANDLER GAMBAR UNTUK QUILL.JS (WYSIWYG EDITOR)
    // =========================================================================



    // Fungsi Hapus, Edit, dan Update bisa ditambahkan mirip seperti yang ada di Kegiatan, 
    // namun disesuaikan nama model dan foldernya. Untuk mempersingkat, saya fokuskan ke handler gambar di bawah ini.

    public function hapus($id)
    {
        $berita = $this->beritaModel->find($id);
        if ($berita) {
            if ($berita['gambar'] && file_exists(FCPATH . 'uploads/berita/' . $berita['gambar'])) {
                unlink(FCPATH . 'uploads/berita/' . $berita['gambar']);
            }
            $this->beritaModel->delete($id);
            return redirect()->to(base_url('admin/berita'))->with('pesan', 'Berita berhasil dihapus.');
        }
        return redirect()->to(base_url('admin/berita'))->with('error', 'Data tidak ditemukan.');
    }

    // =========================================================================
    // HANDLER GAMBAR UNTUK QUILL.JS (WYSIWYG EDITOR)
    // =========================================================================

    public function uploadGambarQuill()
    {
        $file = $this->request->getFile('image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaAcak = $file->getRandomName();
            $namaFinal = pathinfo($namaAcak, PATHINFO_FILENAME) . '.webp';

            // Auto-Resize 800px untuk gambar di dalam artikel & WebP 80%
            \Config\Services::image()
                ->withFile($file->getTempName())
                ->resize(800, 800, true, 'width') // Jangan terlalu besar agar artikel tidak berat
                ->save(FCPATH . 'uploads/berita/konten/' . $namaFinal, 80);

            // Kembalikan URL gambar dalam format JSON
            return $this->response->setJSON([
                'success' => true,
                'url'     => base_url('uploads/berita/konten/' . $namaFinal)
            ]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengunggah gambar.']);
    }
}

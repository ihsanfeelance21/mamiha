<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PrestasiModel;

class Prestasi extends BaseController
{
    protected $prestasiModel;

    public function __construct()
    {
        $this->prestasiModel = new PrestasiModel();
    }

    // 1. Menampilkan Halaman List Data (Index)
    public function index()
    {
        $keyword = $this->request->getVar('cari');

        if ($keyword) {
            $this->prestasiModel->groupStart()
                ->like('judul', $keyword)
                ->orLike('nama_lomba', $keyword)
                ->orLike('nama_pemenang', $keyword)
                ->orLike('nama_guru', $keyword)
                ->groupEnd();
        }

        $data = [
            'title'    => 'Manajemen Prestasi',
            'prestasi' => $this->prestasiModel->orderBy('created_at', 'DESC')->paginate(10, 'prestasi'),
            'pager'    => $this->prestasiModel->pager,
            'keyword'  => $keyword
        ];

        return view('admin/prestasi/index', $data);
    }

    // 2. Menampilkan Form Tambah Data (Create)
    public function create()
    {
        $data = [
            'title'      => 'Tambah Prestasi Baru',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/prestasi/create', $data);
    }

    // 3. Memproses Data yang Dikirim dari Form (Store)
    public function store()
    {
        // Aturan Validasi
        $rules = [
            'kategori_prestasi' => 'required',
            'judul'             => 'required',
            'juara'             => 'required',
            'nama_lomba'        => 'required',
            'tahun_perolehan'   => 'required',
            'gambar'            => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Proses Upload Gambar
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = '';

        if ($fileGambar && $fileGambar->getError() != 4) {
            $namaGambar = $fileGambar->getRandomName();
            // Simpan gambar ke folder public/uploads/prestasi
            $fileGambar->move('uploads/prestasi', $namaGambar);
        }

        // Buat Slug
        $slug = url_title($this->request->getVar('judul'), '-', true) . '-' . uniqid();

        // Simpan Data ke Database
        $this->prestasiModel->save([
            'kategori_prestasi' => $this->request->getVar('kategori_prestasi'),
            'judul'             => $this->request->getVar('judul'),
            'slug'              => $slug,
            'konten'            => $this->request->getVar('konten'),
            'gambar'            => $namaGambar,
            'juara'             => $this->request->getVar('juara'),
            'nama_lomba'        => $this->request->getVar('nama_lomba'),
            // Logika ternary: simpan null jika bukan kategorinya
            'nama_pemenang'     => $this->request->getVar('kategori_prestasi') == 'Siswa' ? $this->request->getVar('nama_pemenang') : null,
            'kelas'             => $this->request->getVar('kategori_prestasi') == 'Siswa' ? $this->request->getVar('kelas') : null,
            'nama_guru'         => $this->request->getVar('kategori_prestasi') == 'Guru' ? $this->request->getVar('nama_guru') : null,
            'nama_penghargaan'  => $this->request->getVar('nama_penghargaan'),
            'tahun_perolehan'   => $this->request->getVar('tahun_perolehan'),
        ]);

        session()->setFlashdata('pesan', 'Data Prestasi berhasil ditambahkan!');
        return redirect()->to(base_url('admin/prestasi'));
    }

    // 4. Menghapus Data (Delete)
    public function delete($id)
    {
        $prestasi = $this->prestasiModel->find($id);

        if ($prestasi) {
            // Hapus file fisik gambar jika ada
            if ($prestasi['gambar'] && file_exists('uploads/prestasi/' . $prestasi['gambar'])) {
                unlink('uploads/prestasi/' . $prestasi['gambar']);
            }
            // Hapus data dari database
            $this->prestasiModel->delete($id);
            session()->setFlashdata('pesan', 'Data Prestasi berhasil dihapus.');
        }

        return redirect()->to(base_url('admin/prestasi'));
    }

    // 5. Menampilkan Form Edit Data
    public function edit($id)
    {
        $prestasi = $this->prestasiModel->find($id);

        if (!$prestasi) {
            session()->setFlashdata('error', 'Data prestasi tidak ditemukan.');
            return redirect()->to(base_url('admin/prestasi'));
        }

        $data = [
            'title'      => 'Edit Data Prestasi',
            'validation' => \Config\Services::validation(),
            'prestasi'   => $prestasi
        ];

        return view('admin/prestasi/edit', $data);
    }

    // 6. Memproses Update Data ke Database
    public function update($id)
    {
        $prestasiLama = $this->prestasiModel->find($id);

        // Aturan Validasi (Gambar opsional saat edit)
        $rules = [
            'kategori_prestasi' => 'required',
            'judul'             => 'required',
            'juara'             => 'required',
            'nama_lomba'        => 'required',
            'tahun_perolehan'   => 'required',
            'gambar'            => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Proses Gambar (Cek apakah user upload gambar baru)
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $prestasiLama['gambar']; // Default pakai gambar lama

        if ($fileGambar && $fileGambar->getError() != 4) {
            // Ada gambar baru yang diupload
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads/prestasi', $namaGambar);

            // Hapus gambar lama jika ada
            if ($prestasiLama['gambar'] && file_exists('uploads/prestasi/' . $prestasiLama['gambar'])) {
                unlink('uploads/prestasi/' . $prestasiLama['gambar']);
            }
        }

        // Update Data
        $this->prestasiModel->update($id, [
            'kategori_prestasi' => $this->request->getVar('kategori_prestasi'),
            'judul'             => $this->request->getVar('judul'),
            // Slug tidak wajib diupdate agar URL lama tetap jalan, tapi kalau mau diupdate bisa diaktifkan
            // 'slug'           => url_title($this->request->getVar('judul'), '-', true) . '-' . uniqid(),
            'konten'            => $this->request->getVar('konten'),
            'gambar'            => $namaGambar,
            'juara'             => $this->request->getVar('juara'),
            'nama_lomba'        => $this->request->getVar('nama_lomba'),
            // Logika dinamis: reset nilai jika kategori berubah
            'nama_pemenang'     => $this->request->getVar('kategori_prestasi') == 'Siswa' ? $this->request->getVar('nama_pemenang') : null,
            'kelas'             => $this->request->getVar('kategori_prestasi') == 'Siswa' ? $this->request->getVar('kelas') : null,
            'nama_guru'         => $this->request->getVar('kategori_prestasi') == 'Guru' ? $this->request->getVar('nama_guru') : null,
            'nama_penghargaan'  => $this->request->getVar('nama_penghargaan'),
            'tahun_perolehan'   => $this->request->getVar('tahun_perolehan'),
        ]);

        session()->setFlashdata('pesan', 'Data Prestasi berhasil diperbarui!');
        return redirect()->to(base_url('admin/prestasi'));
    }
}

<?php

namespace App\Controllers\Admin; // Sesuaikan jika beda folder

use App\Controllers\BaseController;
use App\Models\BakatMinatModel;
use App\Models\GuruStaffModel; // Pastikan model Guru sudah ada

class BakatMinat extends BaseController
{
    protected $BakatMinatModel;
    protected $GuruStaffModel;

    public function __construct()
    {
        $this->BakatMinatModel = new BakatMinatModel();
        $this->GuruStaffModel = new GuruStaffModel(); // Memanggil data guru
    }

    // 1. Menampilkan daftar data (Halaman Index)
    public function index()
    {
        // Mengambil data bakat minat sekaligus men-join nama guru pembina
        $data_bakat = $this->BakatMinatModel
            ->select('bakat_minat.*, guru_staff.nama') // <-- Diubah menjadi guru_staff.nama
            ->join('guru_staff', 'guru_staff.id = bakat_minat.guru_id', 'left')
            ->findAll();

        $data = [
            'title' => 'Kelola Bakat & Minat',
            'bakat_minat' => $data_bakat
        ];

        return view('admin/bakat_minat/index', $data);
    }

    // 2. Menampilkan Form Tambah Data
    public function create()
    {
        $data = [
            'title' => 'Tambah Bakat & Minat',
            'data_guru' => $this->GuruStaffModel->findAll() // Mengambil semua guru untuk dropdown
        ];

        return view('admin/bakat_minat/create', $data);
    }

    // 3. Proses Menyimpan Data ke Database
    public function store()
    {
        // Menangkap pilihan tipe pembina
        $tipe_pembina = $this->request->getPost('tipe_pembina');

        // Logika Saklar Pembina:
        // Jika pilih 'guru', isi guru_id, kosongkan manual. Begitu juga sebaliknya.
        $guru_id = ($tipe_pembina == 'guru') ? $this->request->getPost('guru_id') : null;
        $nama_pembina_manual = ($tipe_pembina == 'manual') ? $this->request->getPost('nama_pembina_manual') : null;

        // Proses Upload Gambar
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = null; // Default kosong jika tidak ada gambar

        if ($fileGambar && $fileGambar->isValid() && ! $fileGambar->hasMoved()) {
            // Generate nama acak agar tidak bentrok, lalu pindahkan ke folder public/uploads/bakat
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads/bakat', $namaGambar);
        }

        // Simpan semua data ke database
        $this->BakatMinatModel->save([
            'judul'               => $this->request->getPost('judul'),
            'deskripsi'           => $this->request->getPost('deskripsi'),
            'jadwal'              => $this->request->getPost('jadwal'),
            'tipe_pembina'        => $tipe_pembina,
            'guru_id'             => $guru_id,
            'nama_pembina_manual' => $nama_pembina_manual,
            'gambar'              => $namaGambar
        ]);

        // Kembali ke halaman index dengan pesan sukses
        return redirect()->to('/admin/bakat-minat')->with('pesan', 'Data Bakat & Minat berhasil ditambahkan.');
    }
    // 4. Menampilkan Form Edit
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Bakat & Minat',
            'bakat' => $this->BakatMinatModel->find($id),
            'data_guru' => $this->GuruStaffModel->findAll()
        ];
        return view('admin/bakat_minat/edit', $data);
    }

    // 5. Proses Update Data
    public function update($id)
    {
        $tipe_pembina = $this->request->getPost('tipe_pembina');
        $guru_id = ($tipe_pembina == 'guru') ? $this->request->getPost('guru_id') : null;
        $nama_pembina_manual = ($tipe_pembina == 'manual') ? $this->request->getPost('nama_pembina_manual') : null;

        $dataLama = $this->BakatMinatModel->find($id);
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $dataLama['gambar']; // Default pakai gambar lama

        if ($fileGambar && $fileGambar->isValid() && ! $fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads/bakat', $namaGambar);
            // Hapus gambar lama agar server tidak penuh
            if ($dataLama['gambar'] && file_exists('uploads/bakat/' . $dataLama['gambar'])) {
                unlink('uploads/bakat/' . $dataLama['gambar']);
            }
        }

        $this->BakatMinatModel->update($id, [
            'judul'               => $this->request->getPost('judul'),
            'deskripsi'           => $this->request->getPost('deskripsi'),
            'jadwal'              => $this->request->getPost('jadwal'),
            'tipe_pembina'        => $tipe_pembina,
            'guru_id'             => $guru_id,
            'nama_pembina_manual' => $nama_pembina_manual,
            'gambar'              => $namaGambar
        ]);

        return redirect()->to('/admin/bakat-minat')->with('pesan', 'Data berhasil diperbarui.');
    }

    // 6. Proses Hapus Data
    public function delete($id)
    {
        $data = $this->BakatMinatModel->find($id);
        // Hapus file gambar fisiknya
        if ($data['gambar'] && file_exists('uploads/bakat/' . $data['gambar'])) {
            unlink('uploads/bakat/' . $data['gambar']);
        }

        $this->BakatMinatModel->delete($id);
        return redirect()->to('/admin/bakat-minat')->with('pesan', 'Data berhasil dihapus.');
    }
}

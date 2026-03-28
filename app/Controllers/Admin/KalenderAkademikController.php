<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KalenderAkademikModel;

class KalenderAkademikController extends BaseController
{
    protected $kalenderModel;

    public function __construct()
    {
        $this->kalenderModel = new KalenderAkademikModel();
    }

    // Menampilkan daftar kalender akademik
    public function index()
    {
        $data = [
            'title'    => 'Manajemen Kalender Akademik',
            // Kita urutkan dari tanggal_mulai yang paling baru/mendatang
            'kalender' => $this->kalenderModel->orderBy('tanggal_mulai', 'DESC')->findAll()
        ];

        return view('admin/kalender/index', $data);
    }

    // Menampilkan form tambah data
    public function create()
    {
        $data = [
            'title' => 'Tambah Agenda Kalender'
        ];

        return view('admin/kalender/create', $data);
    }

    // Menyimpan data ke database
    public function store()
    {
        $judul = $this->request->getPost('judul');
        $slug = url_title($judul, '-', true) . '-' . time(); // Tambah time() agar slug pasti unik

        $this->kalenderModel->save([
            'judul'           => $judul,
            'slug'            => $slug,
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai') ?: null, // Jika kosong, set null
            'deskripsi'       => $this->request->getPost('deskripsi')
        ]);

        session()->setFlashdata('pesan', 'Agenda berhasil ditambahkan.');
        return redirect()->to('/admin/kalender');
    }

    // Menampilkan form edit data
    public function edit($id)
    {
        $data = [
            'title'    => 'Edit Agenda Kalender',
            'kalender' => $this->kalenderModel->find($id)
        ];

        if (empty($data['kalender'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Agenda tidak ditemukan');
        }

        return view('admin/kalender/edit', $data);
    }

    // Mengupdate data di database
    public function update($id)
    {
        $judul = $this->request->getPost('judul');
        // Slug bisa diupdate atau dibiarkan tetap. Kita buat tetap saja agar URL tidak berubah-ubah jika diakses.

        $this->kalenderModel->update($id, [
            'judul'           => $judul,
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai') ?: null,
            'deskripsi'       => $this->request->getPost('deskripsi')
        ]);

        session()->setFlashdata('pesan', 'Agenda berhasil diubah.');
        return redirect()->to('/admin/kalender');
    }

    // Menghapus data
    public function delete($id)
    {
        $this->kalenderModel->delete($id);
        session()->setFlashdata('pesan', 'Agenda berhasil dihapus.');
        return redirect()->to('/admin/kalender');
    }
}

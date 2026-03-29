<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UnduhanModel;

class UnduhanController extends BaseController
{
    protected $unduhanModel;

    public function __construct()
    {
        $this->unduhanModel = new UnduhanModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Manajemen Pusat Unduhan',
            'unduhan' => $this->unduhanModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/unduhan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah File Unduhan'
        ];
        return view('admin/unduhan/create', $data);
    }

    public function store()
    {
        // Ambil file yang diupload
        $fileUnduhan = $this->request->getFile('file_unduhan');
        $namaFile = '';

        // Cek apakah ada file yang diupload dan valid
        if ($fileUnduhan && $fileUnduhan->isValid() && !$fileUnduhan->hasMoved()) {
            // Generate nama file acak agar tidak bentrok
            $namaFile = $fileUnduhan->getRandomName();
            // Pindahkan file ke folder public/uploads/unduhan
            $fileUnduhan->move('uploads/unduhan', $namaFile);
        }

        $this->unduhanModel->save([
            'judul'        => $this->request->getPost('judul'),
            'kategori'     => $this->request->getPost('kategori'),
            'keterangan'   => $this->request->getPost('keterangan'),
            'file_unduhan' => $namaFile,
            'link_eksternal' => $this->request->getPost('link_eksternal')
        ]);

        session()->setFlashdata('pesan', 'File berhasil diunggah dan ditambahkan.');
        return redirect()->to('/admin/unduhan');
    }

    public function edit($id)
    {
        $data = [
            'title'   => 'Edit File Unduhan',
            'unduhan' => $this->unduhanModel->find($id)
        ];

        if (empty($data['unduhan'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        return view('admin/unduhan/edit', $data);
    }

    public function update($id)
    {
        $unduhanLama = $this->unduhanModel->find($id);
        $fileUnduhan = $this->request->getFile('file_unduhan');

        // Default nama file pakai yang lama
        $namaFile = $unduhanLama['file_unduhan'];

        // Jika user upload file baru
        if ($fileUnduhan && $fileUnduhan->isValid() && !$fileUnduhan->hasMoved()) {
            // Hapus file lama jika ada
            if ($unduhanLama['file_unduhan'] && file_exists('uploads/unduhan/' . $unduhanLama['file_unduhan'])) {
                unlink('uploads/unduhan/' . $unduhanLama['file_unduhan']);
            }

            // Simpan file baru
            $namaFile = $fileUnduhan->getRandomName();
            $fileUnduhan->move('uploads/unduhan', $namaFile);
        }

        $this->unduhanModel->update($id, [
            'judul'        => $this->request->getPost('judul'),
            'kategori'     => $this->request->getPost('kategori'),
            'keterangan'   => $this->request->getPost('keterangan'),
            'file_unduhan' => $namaFile,
            'link_eksternal' => $this->request->getPost('link_eksternal')
        ]);

        session()->setFlashdata('pesan', 'Data unduhan berhasil diperbarui.');
        return redirect()->to('/admin/unduhan');
    }

    public function delete($id)
    {
        $unduhan = $this->unduhanModel->find($id);

        // Hapus file fisik dari folder
        if ($unduhan['file_unduhan'] && file_exists('uploads/unduhan/' . $unduhan['file_unduhan'])) {
            unlink('uploads/unduhan/' . $unduhan['file_unduhan']);
        }

        $this->unduhanModel->delete($id);
        session()->setFlashdata('pesan', 'File dan data berhasil dihapus.');
        return redirect()->to('/admin/unduhan');
    }
}

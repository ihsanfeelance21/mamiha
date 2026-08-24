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
        $this->cekIzin('unduhan');
        $data = [
            'title'   => 'Manajemen Pusat Unduhan',
            'unduhan' => $this->unduhanModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/unduhan/index', $data);
    }

    public function create()
    {
        $this->cekIzin('unduhan');
        $data = [
            'title' => 'Tambah File Unduhan'
        ];
        return view('admin/unduhan/create', $data);
    }

    public function store()
    {
        $this->cekIzin('unduhan');
        $linkEksternal = $this->request->getPost('link_eksternal');
        if (!empty($linkEksternal) && (!filter_var($linkEksternal, FILTER_VALIDATE_URL) || !preg_match('#^https?://#i', $linkEksternal))) {
            return redirect()->back()->withInput()->with('error', 'Link eksternal harus valid http/https');
        }
        $fileUnduhan = $this->request->getFile('file_unduhan');
        $namaFile = '';
        $hasFile = $fileUnduhan && $fileUnduhan->isValid() && !$fileUnduhan->hasMoved() && $fileUnduhan->getSize() > 0;
        if (empty($linkEksternal) && !$hasFile) {
            return redirect()->back()->withInput()->with('error', 'Harus isi file upload atau link eksternal salah satu.');
        }
        if ($hasFile) {
            $namaFile = $this->prosesUpload($fileUnduhan, 'unduhan',
                ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/zip', 'text/plain', 'image/jpeg', 'image/png', 'image/webp'],
                ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'txt', 'jpg', 'jpeg', 'png', 'webp'], 10);
            if (! $namaFile) {
                $namaFile = '';
            }
        }

        $this->unduhanModel->save([
            'judul'        => $this->request->getPost('judul'),
            'kategori'     => $this->request->getPost('kategori'),
            'keterangan'   => $this->request->getPost('keterangan'),
            'file_unduhan' => $namaFile,
            'link_eksternal' => $linkEksternal
        ]);

        session()->setFlashdata('pesan', 'File berhasil diunggah dan ditambahkan.');
        return redirect()->to('/admin/unduhan');
    }

    public function edit($id)
    {
        $this->cekIzin('unduhan');
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
        $this->cekIzin('unduhan');
        $unduhanLama = $this->unduhanModel->find($id);
        $fileUnduhan = $this->request->getFile('file_unduhan');

        // Default nama file pakai yang lama
        $namaFile = $unduhanLama['file_unduhan'];

        // Jika user upload file baru
        if ($fileUnduhan && $fileUnduhan->isValid() && !$fileUnduhan->hasMoved()) {
            $baru = $this->prosesUpload($fileUnduhan, 'unduhan',
                ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/zip', 'text/plain', 'image/jpeg', 'image/png', 'image/webp'],
                ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'txt', 'jpg', 'jpeg', 'png', 'webp'], 10);

            if ($baru) {
                // Hapus file lama jika ada
                if ($unduhanLama['file_unduhan'] && file_exists(FCPATH . 'uploads/unduhan/' . $unduhanLama['file_unduhan'])) {
                    unlink(FCPATH . 'uploads/unduhan/' . $unduhanLama['file_unduhan']);
                }
                $namaFile = $baru;
            }
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
        $this->cekIzin('unduhan');
        $unduhan = $this->unduhanModel->find($id);

        // Hapus file fisik dari folder
        if ($unduhan['file_unduhan'] && file_exists(FCPATH . 'uploads/unduhan/' . $unduhan['file_unduhan'])) {
            unlink(FCPATH . 'uploads/unduhan/' . $unduhan['file_unduhan']);
        }

        $this->unduhanModel->delete($id);
        session()->setFlashdata('pesan', 'File dan data berhasil dihapus.');
        return redirect()->to('/admin/unduhan');
    }
}

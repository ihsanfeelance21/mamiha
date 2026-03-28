<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GaleriVideoModel;

class GaleriVideoController extends BaseController
{
    protected $galeriVideoModel;

    public function __construct()
    {
        $this->galeriVideoModel = new GaleriVideoModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Manajemen Galeri Video',
            'videos' => $this->galeriVideoModel->orderBy('tanggal', 'DESC')->findAll()
        ];

        return view('admin/galeri_video/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Video Baru'
        ];
        return view('admin/galeri_video/create', $data);
    }

    public function store()
    {
        $this->galeriVideoModel->save([
            'judul'      => $this->request->getPost('judul'),
            'link_video' => $this->request->getPost('link_video'),
            'tanggal'    => $this->request->getPost('tanggal'),
            'orientasi'  => $this->request->getPost('orientasi'),
        ]);

        session()->setFlashdata('pesan', 'Video berhasil ditambahkan.');
        return redirect()->to('/admin/galeri-video');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Video',
            'video' => $this->galeriVideoModel->find($id)
        ];

        if (empty($data['video'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Video tidak ditemukan');
        }

        return view('admin/galeri_video/edit', $data);
    }

    public function update($id)
    {
        $this->galeriVideoModel->update($id, [
            'judul'      => $this->request->getPost('judul'),
            'link_video' => $this->request->getPost('link_video'),
            'tanggal'    => $this->request->getPost('tanggal'),
            'orientasi'  => $this->request->getPost('orientasi'),
        ]);

        session()->setFlashdata('pesan', 'Video berhasil diperbarui.');
        return redirect()->to('/admin/galeri-video');
    }

    public function delete($id)
    {
        $this->galeriVideoModel->delete($id);
        session()->setFlashdata('pesan', 'Video berhasil dihapus.');
        return redirect()->to('/admin/galeri-video');
    }
}

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
        $this->cekIzin('galeri');
        $data = [
            'title'  => 'Manajemen Galeri Video',
            'videos' => $this->galeriVideoModel->orderBy('tanggal', 'DESC')->findAll()
        ];

        return view('admin/galeri_video/index', $data);
    }

    public function create()
    {
        $this->cekIzin('galeri');
        $data = [
            'title' => 'Tambah Video Baru'
        ];
        return view('admin/galeri_video/create', $data);
    }

    public function store()
    {
        $this->cekIzin('galeri');
        $rules = [
            'judul'      => 'required|min_length[5]|max_length[200]',
            'link_video' => 'required|valid_url_strict',
            'tanggal'    => 'required|valid_date',
            'orientasi'  => 'required|in_list[landscape,portrait]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $link = $this->request->getPost('link_video');
        if (!filter_var($link, FILTER_VALIDATE_URL) || !preg_match('#^https?://#i', $link)) {
            return redirect()->back()->withInput()->with('error', ['link_video' => 'Link harus http/https valid']);
        }
        $this->galeriVideoModel->save([
            'judul'      => $this->request->getPost('judul'),
            'link_video' => $link,
            'tanggal'    => $this->request->getPost('tanggal'),
            'orientasi'  => $this->request->getPost('orientasi'),
        ]);

        session()->setFlashdata('pesan', 'Video berhasil ditambahkan.');
        return redirect()->to('/admin/galeri-video');
    }

    public function edit($id)
    {
        $this->cekIzin('galeri');
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
        $this->cekIzin('galeri');
        $rules = [
            'judul'      => 'required|min_length[5]|max_length[200]',
            'link_video' => 'required|valid_url_strict',
            'tanggal'    => 'required|valid_date',
            'orientasi'  => 'required|in_list[landscape,portrait]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $link = $this->request->getPost('link_video');
        if (!filter_var($link, FILTER_VALIDATE_URL) || !preg_match('#^https?://#i', $link)) {
            return redirect()->back()->withInput()->with('error', ['link_video' => 'Link harus http/https valid']);
        }
        $this->galeriVideoModel->update($id, [
            'judul'      => $this->request->getPost('judul'),
            'link_video' => $link,
            'tanggal'    => $this->request->getPost('tanggal'),
            'orientasi'  => $this->request->getPost('orientasi'),
        ]);

        session()->setFlashdata('pesan', 'Video berhasil diperbarui.');
        return redirect()->to('/admin/galeri-video');
    }

    public function delete($id)
    {
        $this->cekIzin('galeri');
        $this->galeriVideoModel->delete($id);
        session()->setFlashdata('pesan', 'Video berhasil dihapus.');
        return redirect()->to('/admin/galeri-video');
    }
}

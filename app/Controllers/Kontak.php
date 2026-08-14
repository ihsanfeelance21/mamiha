<?php

namespace App\Controllers;

use App\Models\PesanKontakModel;

class Kontak extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Hubungi Kami | Madrasah'
        ];

        return view('kontak_index', $data);
    }

    public function kirim()
    {
        $pesanModel = new \App\Models\PesanKontakModel();

        if (! $this->validate([
            'nama'  => 'required|min_length[3]|max_length[150]',
            'email' => 'permit_empty|valid_email|max_length[100]',
            'no_wa' => 'permit_empty|max_length[30]',
            'pesan' => 'required|min_length[10]|max_length[2000]',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Mohon periksa kembali isian Anda.');
        }

        $pesanModel->save([
            'nama'     => esc($this->request->getPost('nama')),
            'email'    => esc($this->request->getPost('email')),
            'no_wa'    => esc($this->request->getPost('no_wa')),
            'kategori' => esc($this->request->getPost('kategori')),
            'pesan'    => esc($this->request->getPost('pesan')),
            'status'   => 'belum dibaca'
        ]);

        session()->setFlashdata('pesan_sukses', 'Terima kasih! Pesan Anda berhasil dikirim dan akan segera kami proses.');

        return redirect()->to('/hubungi-kami');
    }
}

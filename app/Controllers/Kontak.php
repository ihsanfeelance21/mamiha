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

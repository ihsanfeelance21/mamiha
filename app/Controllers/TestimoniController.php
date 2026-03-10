<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TestimoniModel;

class TestimoniController extends BaseController
{
    protected $testimoniModel;

    public function __construct()
    {
        $this->testimoniModel = new TestimoniModel();
    }

    public function index()
    {
        // PENTING: Gunakan $this->testimoniModel dan hapus baris findAll() yang lama

        // Ambil data testimoni dengan pagination (12 per halaman)
        $data['testimoni'] = $this->testimoniModel->where('is_approved', 1)
            ->orderBy('created_at', 'DESC')
            ->paginate(12, 'testimoni');

        // Tambahkan variabel pager untuk dikirim ke View (Wajib pakai $this-> juga)
        $data['pager'] = $this->testimoniModel->pager;

        // Kirim ke view
        return view('profil/testimoni', $data);
    }

    public function simpan()
    {
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = null;

        // Cek jika ada file foto yang diupload
        if ($fileFoto && $fileFoto->isValid() && ! $fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName(); // Generate nama acak
            $fileFoto->move('uploads/testimoni', $namaFoto); // Simpan ke public/uploads/testimoni
        }

        // Simpan ke database
        $this->testimoniModel->save([
            'nama'          => $this->request->getPost('nama'),
            'status_user'   => $this->request->getPost('status_user'),
            'rating'        => $this->request->getPost('rating'),
            'isi_testimoni' => $this->request->getPost('isi_testimoni'),
            'foto'          => $namaFoto,
            'is_approved'   => 0 // Default 0 (Belum di-approve admin)
        ]);

        // Kembali ke halaman testimoni dengan pesan sukses
        return redirect()->to('profil/testimoni')->with('pesan', 'Terima kasih! Telah memberikan Testimoni Anda.');
    }
}

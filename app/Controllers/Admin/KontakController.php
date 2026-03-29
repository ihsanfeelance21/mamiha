<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PesanKontakModel;

class KontakController extends BaseController
{
    protected $pesanModel;

    public function __construct()
    {
        $this->pesanModel = new PesanKontakModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kotak Masuk Pesan | Admin',
            // Ambil semua pesan, urutkan dari yang terbaru
            'pesan' => $this->pesanModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/kontak/index', $data);
    }

    public function show($id)
    {
        $pesan = $this->pesanModel->find($id);

        // Jika pesan tidak ditemukan
        if (!$pesan) {
            return redirect()->to('/admin/kontak')->with('error', 'Pesan tidak ditemukan.');
        }

        // Jika pesan belum dibaca, ubah statusnya menjadi sudah dibaca
        if ($pesan['status'] == 'belum dibaca') {
            $this->pesanModel->update($id, ['status' => 'sudah dibaca']);
            // Update variabel untuk ditampilkan di view
            $pesan['status'] = 'sudah dibaca';
        }

        $data = [
            'title' => 'Detail Pesan | Admin',
            'pesan' => $pesan
        ];

        return view('admin/kontak/show', $data);
    }

    public function delete($id)
    {
        $this->pesanModel->delete($id);
        session()->setFlashdata('pesan', 'Satu pesan berhasil dihapus.');
        return redirect()->to('/admin/kontak');
    }
}

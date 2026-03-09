<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TestimoniModel;

class AdminTestimoniController extends BaseController
{
    protected $testimoniModel;

    public function __construct()
    {
        $this->testimoniModel = new TestimoniModel();
    }

    public function index()
    {
        // Ambil semua testimoni, urutkan dari yang paling baru
        $data['testimoni'] = $this->testimoniModel->orderBy('created_at', 'DESC')->findAll();

        // Asumsi Anda punya layout admin, kita arahkan ke view admin
        return view('admin/testimoni/index', $data);
    }

    public function approve($id)
    {
        $this->testimoniModel->update($id, ['is_approved' => 1]);
        return redirect()->to('/admin/testimoni')->with('pesan', 'Testimoni berhasil di-approve dan akan tampil di halaman depan.');
    }

    public function reject($id)
    {
        $this->testimoniModel->update($id, ['is_approved' => 0]);
        return redirect()->to('/admin/testimoni')->with('pesan', 'Testimoni disembunyikan (Not Approved).');
    }

    public function delete($id)
    {
        $testimoni = $this->testimoniModel->find($id);

        // Hapus foto dari folder jika ada
        if ($testimoni['foto'] && file_exists('uploads/testimoni/' . $testimoni['foto'])) {
            unlink('uploads/testimoni/' . $testimoni['foto']);
        }

        $this->testimoniModel->delete($id);
        return redirect()->to('/admin/testimoni')->with('pesan', 'Data testimoni berhasil dihapus permanen.');
    }
}

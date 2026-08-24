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
        $this->cekIzin('testimoni');
        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status');
        $query = $this->testimoniModel->orderBy('created_at', 'DESC');
        if (!empty($keyword)) {
            $query = $query->groupStart()->like('nama', $keyword)->orLike('isi_testimoni', $keyword)->groupEnd();
        }
        if ($status === 'approved') {
            $query = $query->where('is_approved', 1);
        } elseif ($status === 'pending') {
            $query = $query->where('is_approved', 0);
        }
        $data = [
            'testimoni' => $query->paginate(15, 'testimoni'),
            'pager' => $this->testimoniModel->pager,
            'keyword' => $keyword,
            'statusAktif' => $status
        ];

        return view('admin/testimoni/index', $data);
    }

    public function approve($id)
    {
        $this->cekIzin('testimoni');
        $this->testimoniModel->update($id, ['is_approved' => 1]);
        return redirect()->to('/admin/testimoni')->with('pesan', 'Testimoni berhasil di-approve dan akan tampil di halaman depan.');
    }

    public function reject($id)
    {
        $this->cekIzin('testimoni');
        $this->testimoniModel->update($id, ['is_approved' => 0]);
        return redirect()->to('/admin/testimoni')->with('pesan', 'Testimoni disembunyikan (Not Approved).');
    }

    public function delete($id)
    {
        $this->cekIzin('testimoni');
        $testimoni = $this->testimoniModel->find($id);

        // Hapus foto dari folder jika ada
        if ($testimoni['foto'] && file_exists(FCPATH . 'uploads/testimoni/' . $testimoni['foto'])) {
            unlink(FCPATH . 'uploads/testimoni/' . $testimoni['foto']);
        }

        $this->testimoniModel->delete($id);
        return redirect()->to('/admin/testimoni')->with('pesan', 'Data testimoni berhasil dihapus permanen.');
    }
}

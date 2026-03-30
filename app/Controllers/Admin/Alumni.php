<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AlumniModel;
use App\Models\UniversitasModel;

class Alumni extends BaseController
{
    protected $alumniModel;
    protected $universitasModel;

    public function __construct()
    {
        $this->alumniModel = new AlumniModel();
        $this->universitasModel = new UniversitasModel();
    }

    public function index()
    {
        // 1. Tangkap request dari URL (GET)
        $keyword = $this->request->getGet('keyword');
        $limit = $this->request->getGet('limit') ?? 10; // Default tampil 10 data

        // 2. Mulai susun query dasar
        $query = $this->alumniModel->select('alumni.*, universitas.nama_universitas')
            ->join('universitas', 'universitas.id_universitas = alumni.id_universitas', 'left');

        // 3. Logika Pencarian (Search)
        if (!empty($keyword)) {
            $query->groupStart()
                ->like('alumni.nama_alumni', $keyword)
                ->orLike('universitas.nama_universitas', $keyword)
                ->orLike('alumni.usulan_universitas', $keyword)
                ->groupEnd();
        }

        // Urutkan berdasarkan data terbaru
        $query->orderBy('alumni.created_at', 'DESC');

        // 4. Logika Pagination / Limit All
        if ($limit === 'all') {
            $alumni = $query->findAll();
            $pager = null; // Tidak butuh pager kalau nampilin semua
        } else {
            $limit = (int)$limit;
            $alumni = $query->paginate($limit, 'alumni'); // 'alumni' adalah nama grup pager
            $pager = $this->alumniModel->pager;
        }

        $data = [
            'title'       => 'Alumni Journeys (Kelola Data)',
            'alumni'      => $alumni,
            'pager'       => $pager,
            'keyword'     => $keyword,
            'limit'       => $limit,
            'universitas' => $this->universitasModel->orderBy('nama_universitas', 'ASC')->findAll()
        ];

        return view('admin/alumni/index', $data);
    }

    // --- MULAI TAMBAHAN: CREATE & STORE ---

    public function create()
    {
        $data = [
            'title' => 'Tambah Data Alumni',
            'universitas' => $this->universitasModel->orderBy('nama_universitas', 'ASC')->findAll()
        ];
        return view('admin/alumni/create', $data);
    }

    public function store()
    {
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/alumni', $namaFoto);
        }

        $this->alumniModel->insert([
            'nama_alumni' => $this->request->getPost('nama_alumni'),
            'tahun_lulus' => $this->request->getPost('tahun_lulus'),
            'id_universitas' => $this->request->getPost('id_universitas') ?: null,
            'jurusan' => $this->request->getPost('jurusan'),
            'pesan_kesan' => $this->request->getPost('pesan_kesan'),
            'foto' => $namaFoto,
            'status' => $this->request->getPost('status') ?? 'approved',
            'is_featured' => 0
        ]);

        return redirect()->to('admin/alumni')->with('pesan', 'Data alumni berhasil ditambahkan secara manual.');
    }

    // --- MULAI TAMBAHAN: EDIT & UPDATE ---

    public function edit($id)
    {
        $alumni = $this->alumniModel->find($id);
        if (empty($alumni)) {
            return redirect()->to('admin/alumni')->with('error', 'Data alumni tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Data Alumni',
            'alumni' => $alumni,
            'universitas' => $this->universitasModel->orderBy('nama_universitas', 'ASC')->findAll()
        ];
        return view('admin/alumni/edit', $data);
    }

    public function update($id)
    {
        $alumniLama = $this->alumniModel->find($id);
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = $alumniLama['foto'];

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/alumni', $namaFoto);

            if ($alumniLama['foto'] && file_exists('uploads/alumni/' . $alumniLama['foto'])) {
                unlink('uploads/alumni/' . $alumniLama['foto']);
            }
        }

        $idUniversitas = $this->request->getPost('id_universitas');
        $usulanUniversitas = $this->request->getPost('usulan_universitas');

        if (!empty($idUniversitas)) {
            $usulanUniversitas = null;
        }

        $this->alumniModel->update($id, [
            'nama_alumni' => $this->request->getPost('nama_alumni'),
            'tahun_lulus' => $this->request->getPost('tahun_lulus'),
            'id_universitas' => $idUniversitas ?: null,
            'jurusan' => $this->request->getPost('jurusan'),
            'pesan_kesan' => $this->request->getPost('pesan_kesan'),
            'foto' => $namaFoto,
            'usulan_universitas' => $usulanUniversitas
        ]);

        return redirect()->to('admin/alumni')->with('pesan', 'Data alumni berhasil diperbarui.');
    }

    // --- AKHIR TAMBAHAN ---

    public function approve($id)
    {
        $alumni = $this->alumniModel->find($id);
        if ($alumni) {
            $this->alumniModel->update($id, ['status' => 'approved']);
            return redirect()->to('admin/alumni')->with('pesan', 'Data alumni berhasil disetujui.');
        }
        return redirect()->to('admin/alumni');
    }

    public function reject($id)
    {
        $this->alumniModel->update($id, ['status' => 'rejected']);
        return redirect()->to('admin/alumni')->with('error', 'Data alumni ditolak.');
    }

    public function toggleFeatured($id)
    {
        $alumni = $this->alumniModel->find($id);
        if ($alumni) {
            $newStatus = $alumni['is_featured'] == 1 ? 0 : 1;
            $this->alumniModel->update($id, ['is_featured' => $newStatus]);

            $msg = $newStatus == 1 ? 'Alumni ditambahkan ke Slider Halaman.' : 'Alumni dihapus dari Slider Halaman.';
            return redirect()->to('admin/alumni')->with('pesan', $msg);
        }
        return redirect()->to('admin/alumni');
    }

    public function delete($id)
    {
        $alumni = $this->alumniModel->find($id);
        if ($alumni['foto'] && file_exists('uploads/alumni/' . $alumni['foto'])) {
            unlink('uploads/alumni/' . $alumni['foto']);
        }
        $this->alumniModel->delete($id);
        return redirect()->to('admin/alumni')->with('pesan', 'Data alumni berhasil dihapus.');
    }
}

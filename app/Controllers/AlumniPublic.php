<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AlumniModel;
use App\Models\UniversitasModel;

class AlumniPublic extends BaseController
{
    public function index()
    {
        $alumniModel = new AlumniModel();
        $univModel = new UniversitasModel();

        // 1. Ambil data untuk Slider Atas (Hanya yang is_featured = 1 & approved)
        $featuredAlumni = $alumniModel->select('alumni.*, universitas.nama_universitas')
            ->join('universitas', 'universitas.id_universitas = alumni.id_universitas', 'left')
            ->where('alumni.status', 'approved')
            ->where('alumni.is_featured', 1)
            ->orderBy('alumni.created_at', 'DESC')
            ->findAll();

        // 2. Ambil data untuk Card Universitas di bawahnya
        $universitas = $univModel->orderBy('nama_universitas', 'ASC')->findAll();

        $data = [
            'title' => 'Direktori Alumni & Kampus',
            'featured_alumni' => $featuredAlumni,
            'universitas' => $universitas
        ];

        return view('alumni/alumni_index', $data);
    }

    // Fungsi untuk menampilkan alumni berdasarkan Kampus yang diklik
    public function kampus($id_universitas)
    {
        $alumniModel = new AlumniModel();
        $univModel = new UniversitasModel();

        $kampus = $univModel->find($id_universitas);
        if (empty($kampus)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Ambil alumni yang kuliah di kampus ini dan statusnya approved
        $alumni = $alumniModel->where('id_universitas', $id_universitas)
            ->where('status', 'approved')
            ->orderBy('tahun_lulus', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Alumni di ' . $kampus['nama_universitas'],
            'kampus' => $kampus,
            'alumni' => $alumni
        ];

        return view('alumni/kampus', $data);
    }

    // Menampilkan halaman form pendaftaran
    public function daftar()
    {
        $univModel = new UniversitasModel();

        $data = [
            'title' => 'Pendaftaran Data Alumni',
            'universitas' => $univModel->orderBy('nama_universitas', 'ASC')->findAll()
        ];

        return view('alumni/daftar', $data);
    }

    // Memproses data yang diinput alumni
    public function simpanMandiri()
    {
        $alumniModel = new AlumniModel();

        // Cek apakah ada file foto yang diupload
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/alumni', $namaFoto);
        }

        // Logika untuk Kampus (Apakah milih dari daftar atau ngetik manual)
        $idUniversitas = $this->request->getPost('id_universitas');
        $usulanUniversitas = null;

        if ($idUniversitas === 'lainnya') {
            $idUniversitas = null; // Kosongkan id_universitas
            $usulanUniversitas = $this->request->getPost('usulan_universitas'); // Ambil ketikan manual
        }

        // Simpan ke database dengan status 'pending'
        $alumniModel->insert([
            'nama_alumni' => $this->request->getPost('nama_alumni'),
            'tahun_lulus' => $this->request->getPost('tahun_lulus'),
            'id_universitas' => $idUniversitas,
            'usulan_universitas' => $usulanUniversitas,
            'jurusan' => $this->request->getPost('jurusan'),
            'pesan_kesan' => $this->request->getPost('pesan_kesan'),
            'foto' => $namaFoto,
            'status' => 'pending', // Status awal harus pending
            'is_featured' => 0
        ]);

        // Redirect kembali ke halaman utama alumni dengan pesan sukses
        return redirect()->to('alumni')->with('pesan', 'Terima kasih! Data Anda berhasil dikirim dan sedang menunggu review dari Admin.');
    }
}

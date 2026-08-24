<?php

namespace App\Controllers;

use App\Models\PrestasiModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PrestasiController extends BaseController
{
    protected $prestasiModel;

    public function __construct()
    {
        $this->prestasiModel = new PrestasiModel();
    }

    // Menampilkan daftar semua prestasi dengan filter & pagination
    public function index()
    {
        $cari = $this->request->getGet('cari');
        $kategori = $this->request->getGet('kategori');
        $tahun = $this->request->getGet('tahun');
        $urutan = $this->request->getGet('urutan') ?? 'terbaru';

        $query = $this->prestasiModel;

        if (!empty($cari)) {
            $query = $query->groupStart()->like('judul', $cari)->orLike('nama_lomba', $cari)->orLike('nama_pemenang', $cari)->orLike('nama_guru', $cari)->groupEnd();
        }
        if (!empty($kategori)) {
            // Map form values Prestasi Siswa/Guru/Madrasah to DB values Siswa/Guru/Madrasah
            $map = ['Prestasi Siswa' => 'Siswa', 'Prestasi Guru' => 'Guru', 'Prestasi Madrasah' => 'Madrasah', 'Siswa' => 'Siswa', 'Guru' => 'Guru', 'Madrasah' => 'Madrasah'];
            $kat = $map[$kategori] ?? $kategori;
            $query = $query->where('kategori_prestasi', $kat);
        }
        if (!empty($tahun)) {
            $query = $query->where('tahun_perolehan', $tahun);
        }
        if ($urutan === 'terlama') {
            $query = $query->orderBy('tahun_perolehan', 'ASC')->orderBy('id', 'ASC');
        } else {
            $query = $query->orderBy('tahun_perolehan', 'DESC')->orderBy('id', 'DESC');
        }

        $data = [
            'title'    => 'Daftar Prestasi',
            'prestasi' => $query->paginate(9, 'prestasi'),
            'pager'    => $this->prestasiModel->pager,
            'keyword'  => $cari,
            'kategoriAktif' => $kategori,
            'tahunAktif' => $tahun,
            'urutanAktif' => $urutan,
        ];

        return view('prestasi_index', $data);
    }

    // Menampilkan detail spesifik satu prestasi berdasarkan slug
    public function detail($slug)
    {
        // Cari data berdasarkan slug
        $prestasi = $this->prestasiModel->where('slug', $slug)->first();

        // Jika URL slug ngawur / data tidak ditemukan, tampilkan error 404
        if (!$prestasi) {
            throw PageNotFoundException::forPageNotFound('Halaman prestasi tidak ditemukan');
        }

        $data = [
            'title'    => $prestasi['judul'],
            'prestasi' => $prestasi
        ];

        return view('prestasi_detail', $data);
    }
}

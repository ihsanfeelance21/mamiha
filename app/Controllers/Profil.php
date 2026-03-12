<?php

namespace App\Controllers;

use App\Models\ProfilWebsiteModel;
use App\Models\FasilitasModel;
use App\Models\FasilitasGaleriModel;
use App\Models\GuruStaffModel;
use App\Models\BakatMinatModel; // <-- Ini yang baru ditambahkan

class Profil extends BaseController
{
    public function madrasah()
    {
        // 1. Inisialisasi Model
        $profilModel    = new ProfilWebsiteModel();
        $fasilitasModel = new FasilitasModel();
        $galeriModel    = new FasilitasGaleriModel();
        $guruModel      = new GuruStaffModel();

        // 2. Ambil data dari database
        $pimpinan  = $guruModel->where('kategori', 'pimpinan')->orderBy('urutan', 'ASC')->first();
        $profil    = $profilModel->first();
        $fasilitas = $fasilitasModel->findAll();

        // 3. Looping untuk mengambil galeri masing-masing fasilitas
        foreach ($fasilitas as &$f) {
            $f['galeri'] = $galeriModel->where('fasilitas_id', $f['id'])->findAll();
        }

        // 4. Masukkan semua data ke dalam array $data untuk dikirim ke View
        $data = [
            'title'     => 'Profil Madrasah',
            'profil'    => $profil,
            'fasilitas' => $fasilitas,
            'pimpinan'  => $pimpinan
        ];

        // 5. Kirim ke view profil/madrasah
        return view('profil/madrasah', $data);
    }

    public function struktur()
    {
        $guruModel = new GuruStaffModel();

        // Ambil data pimpinan (Kepala Sekolah)
        $pimpinan = $guruModel->where('kategori', 'pimpinan')->orderBy('urutan', 'ASC')->first();

        // Ambil data dewan guru
        $dewan_guru = $guruModel->where('kategori', 'guru')->orderBy('urutan', 'ASC')->findAll();

        $staff = $guruModel->where('kategori', 'staff')->orderBy('urutan', 'ASC')->findAll();

        $data = [
            'title'      => "Struktur Organisasi | MA Mabadi'ul Ihsan",
            'pimpinan'   => $pimpinan,
            'dewan_guru' => $dewan_guru,
            'staff'      => $staff
        ];

        return view('profil/struktur', $data);
    }

    public function bakatMinat()
    {
        // Inisialisasi Model
        $bakatModel = new BakatMinatModel();

        // Ambil data dengan JOIN ke guru_staff
        $data_bakat = $bakatModel
            ->select('bakat_minat.*, guru_staff.nama AS nama_guru')
            ->join('guru_staff', 'guru_staff.id = bakat_minat.guru_id', 'left')
            ->findAll();

        $data = [
            'title'       => 'Bakat & Minat Siswa',
            'bakat_minat' => $data_bakat // Melempar data ke View
        ];

        // Mengarahkan ke file view: app/Views/profil/bakat_minat.php
        return view('profil/bakat_minat', $data);
    }
}

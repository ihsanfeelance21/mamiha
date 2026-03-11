<?php

namespace App\Controllers;

use App\Models\ProfilWebsiteModel;
use App\Models\FasilitasModel;
use App\Models\FasilitasGaleriModel;
use App\Models\GuruStaffModel;

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
            'pimpinan'  => $pimpinan // <-- Cukup tambahkan baris ini saja, rapi dan aman!
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
}

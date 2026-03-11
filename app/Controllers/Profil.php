<?php

namespace App\Controllers;

use App\Models\ProfilWebsiteModel;
use App\Models\FasilitasModel;
use App\Models\FasilitasGaleriModel;

class Profil extends BaseController
{
    public function madrasah()
    {
        // 1. Inisialisasi Model
        $profilModel    = new ProfilWebsiteModel();
        $fasilitasModel = new FasilitasModel();
        $galeriModel    = new FasilitasGaleriModel();

        // 2. Ambil data dari database
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
            'fasilitas' => $fasilitas
        ];

        // 5. Kirim ke view profil/madrasah
        return view('profil/madrasah', $data);
    }

    public function struktur()
    {
        $data = [
            'title' => 'Struktur Organisasi'
        ];
        return view('profil/struktur', $data);
    }

    // Fungsi index() saya hapus karena fungsinya sudah dipindah ke madrasah()
}

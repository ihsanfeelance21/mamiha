<?php

namespace App\Controllers;

use App\Models\KegiatanModel;
use App\Models\PengaturanModel;
use App\Models\PendaftaranModel;
use App\Models\HeroSliderModel;
use App\Models\AksesCepatModel;
use App\Models\LoginLogModel;

class Admin extends BaseController
{
    public function dashboard()
    {
        $logModel = new LoginLogModel();
        $data['logs'] = $logModel->select('login_logs.*, users.nama_lengkap, users.foto')
            ->join('users', 'users.id_user = login_logs.id_user')
            ->orderBy('login_at', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        $data['title'] = 'Dashboard Utama';

        // Hitung statistik REAL dari database
        $beritaModel = new \App\Models\BeritaModel();
        $prestasiModel = new \App\Models\PrestasiModel();
        $alumniModel = new \App\Models\AlumniModel();
        $guruModel = new \App\Models\GuruStaffModel();
        $pesanModel = new \App\Models\PesanKontakModel();
        $galeriModel = new \App\Models\GaleriModel();

        $data['stats'] = [
            'berita'  => $beritaModel->countAll(),
            'prestasi' => $prestasiModel->countAll(),
            'pesan'   => $pesanModel->countAll(),
            'alumni'  => $alumniModel->countAll(),
            'guru'    => $guruModel->countAll(),
            'galeri'  => $galeriModel->countAll(),
        ];

        return view('admin/dashboard', $data);
    }

    // --- MANAJEMEN KEGIATAN ---
    public function kegiatan()
    {
        $this->cekIzin('kegiatan');
        $kegiatanModel = new KegiatanModel();
        $data = [
            'title'    => 'Kegiatan Sekolah',
            'kegiatan' => $kegiatanModel->orderBy('created_at', 'DESC')->findAll()
        ];
        return view('admin/kegiatan', $data);
    }

    public function tambah_kegiatan()
    {
        $this->cekIzin('kegiatan');
        return view('admin/kegiatan_tambah', ['title' => 'Tambah Kegiatan']);
    }

    public function simpan_kegiatan()
    {
        $this->cekIzin('kegiatan');
        $kegiatanModel = new KegiatanModel();

        $rules = [
            'judul' => 'required|min_length[3]|is_unique[kegiatan.judul]',
            'konten' => 'required',
            'gambar' => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Cek judul (harus unik) dan ukuran gambar.');
        }

        $namaGambar = $this->prosesUpload($this->request->getFile('gambar'), 'kegiatan', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);

        $kegiatanModel->save([
            'judul'  => $this->request->getPost('judul'),
            'slug'   => url_title($this->request->getPost('judul'), '-', true),
            'konten' => $this->request->getPost('konten'),
            'gambar' => $namaGambar
        ]);

        return redirect()->to('admin/kegiatan')->with('pesan', 'Kegiatan berhasil ditambahkan!');
    }

    public function hapus_kegiatan($id)
    {
        $this->cekIzin('kegiatan');
        $kegiatanModel = new KegiatanModel();
        $kegiatan = $kegiatanModel->find($id);

        if ($kegiatan) {
            if ($kegiatan['gambar'] && file_exists(FCPATH . 'uploads/kegiatan/' . $kegiatan['gambar'])) {
                unlink(FCPATH . 'uploads/kegiatan/' . $kegiatan['gambar']);
            }
            $kegiatanModel->delete($id);
            return redirect()->to('admin/kegiatan')->with('pesan', 'Data kegiatan berhasil dihapus.');
        }
        return redirect()->to('admin/kegiatan')->with('error', 'Data tidak ditemukan.');
    }

    // --- MANAJEMEN PENGATURAN ---
    public function pengaturan()
    {
        $this->cekIzin('pengaturan');
        $data = [
            'title'      => 'Pengaturan Website',
            'pengaturan' => (new PengaturanModel())->first()
        ];
        return view('admin/pengaturan', $data);
    }

    public function update_pengaturan()
    {
        $this->cekIzin('pengaturan');
        $model = new PengaturanModel();
        $lama = $model->first();

        $data = [
            'nama_sekolah'     => $this->request->getPost('nama_sekolah'),
            'email'            => $this->request->getPost('email'),
            'telepon'          => $this->request->getPost('telepon'),
            'alamat'           => $this->request->getPost('alamat'),
            'updated_at'       => date('Y-m-d H:i:s')
            // ... lengkapi field lainnya sesuai input form Mas
        ];

        // Upload Favicon/Logo
        $favicon = $this->request->getFile('favicon');
        if ($favicon && $favicon->isValid()) {
            $namaF = $this->prosesUpload($favicon, 'pengaturan', ['image/png', 'image/x-icon', 'image/vnd.microsoft.icon', 'image/jpeg', 'image/webp'], ['png', 'ico', 'jpg', 'jpeg', 'webp'], 2);
            if ($namaF) {
                $data['favicon'] = $namaF;
                if (!empty($lama['favicon'])) @unlink(FCPATH . 'uploads/pengaturan/' . $lama['favicon']);
            }
        }

        $model->update(1, $data);
        cache()->delete('pengaturan');
        return redirect()->to('admin/pengaturan')->with('pesan', 'Pengaturan diperbarui!');
    }

    public function akses_cepat()
    {
        $this->cekIzin('akses_cepat'); // Atau ganti 'akses_cepat' jika Mas punya permission khusus
        $data = [
            'title'       => 'Kelola Akses Cepat',
            'akses_cepat' => (new AksesCepatModel())->findAll()
        ];
        return view('admin/akses_cepat', $data); // Pastikan view 'admin/akses_cepat.php' ada
    }

    public function akses_cepat_tambah()
    {
        $this->cekIzin('akses_cepat');
        $model = new AksesCepatModel();

        // 1. Validasi disesuaikan dengan atribut name="..." di View
        $rules = [
            'nama_link' => 'required',
            'url_link'  => 'required|valid_url_strict'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Semua kolom wajib diisi dan URL harus valid (http/https).');
        }

        $urlLink = $this->request->getPost('url_link');
        if (!empty($urlLink) && !filter_var($urlLink, FILTER_VALIDATE_URL)) {
            return redirect()->back()->withInput()->with('error', 'URL tidak valid.');
        }
        if (!empty($urlLink) && !preg_match('#^https?://#i', $urlLink)) {
            return redirect()->back()->withInput()->with('error', 'URL harus diawali http:// atau https://');
        }

        // 2. Disimpan dengan nama kolom yang sesuai di Model
        $model->save([
            'nama_link' => $this->request->getPost('nama_link'),
            'url_link'  => $urlLink
        ]);

        cache()->delete('akses_cepat');
        return redirect()->to('admin/akses-cepat')->with('pesan', 'Menu Akses Cepat berhasil ditambahkan!');
    }

    public function akses_cepat_hapus($id)
    {
        $this->cekIzin('akses_cepat');
        $model = new AksesCepatModel();

        if ($model->find($id)) {
            $model->delete($id);
            cache()->delete('akses_cepat');
            return redirect()->to('admin/akses-cepat')->with('pesan', 'Menu Akses Cepat berhasil dihapus!');
        }

        return redirect()->to('admin/akses-cepat')->with('error', 'Data tidak ditemukan.');
    }

    // --- MANAJEMEN PPDB ---
    public function pendaftaran()
    {
        $this->cekIzin('pendaftaran');
        $data = [
            'title' => 'Manajemen PPDB',
            'pendaftaran' => (new PendaftaranModel())->first()
        ];
        return view('admin/pendaftaran', $data);
    }

    public function update_pendaftaran()
    {
        $this->cekIzin('pendaftaran');
        $model = new PendaftaranModel();
        $lama = $model->first();
        $linkDaftar = $this->request->getPost('link_daftar');
        $linkAdmin = $this->request->getPost('link_admin_ppdb');
        foreach (['link_daftar' => $linkDaftar, 'link_admin_ppdb' => $linkAdmin] as $field => $url) {
            if (!empty($url)) {
                if (!filter_var($url, FILTER_VALIDATE_URL) || !preg_match('#^https?://#i', $url)) {
                    return redirect()->back()->withInput()->with('error', 'URL ' . $field . ' harus valid dan diawali http:// atau https://');
                }
            }
        }
        $data = [
            'status_ppdb' => $this->request->getPost('status_ppdb'),
            'link_daftar' => $linkDaftar,
            'pesan_tutup' => $this->request->getPost('pesan_tutup'),
            'link_admin_ppdb' => $linkAdmin,
            'tipe_daftar' => $this->request->getPost('tipe_daftar'),
            'updated_at'  => date('Y-m-d H:i:s')
        ];

        // Upload Poster PPDB
        $poster = $this->request->getFile('poster');
        if ($poster && $poster->isValid()) {
            $namaPoster = $this->prosesUpload($poster, 'ppdb', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);
            if ($namaPoster) {
                $data['poster'] = $namaPoster;
                if (!empty($lama['poster'])) @unlink(FCPATH . 'uploads/ppdb/' . $lama['poster']);
            }
        }

        // Upload Brosur PPDB
        $brosur = $this->request->getFile('brosur');
        if ($brosur && $brosur->isValid()) {
            $namaBrosur = $this->prosesUpload($brosur, 'ppdb', ['application/pdf', 'image/jpeg', 'image/png', 'image/webp'], ['pdf', 'jpg', 'jpeg', 'png', 'webp'], 5);
            if ($namaBrosur) {
                $data['brosur'] = $namaBrosur;
                if (!empty($lama['brosur'])) @unlink(FCPATH . 'uploads/ppdb/' . $lama['brosur']);
            }
        }

        $model->update(1, $data);
        cache()->delete('pendaftaran');
        return redirect()->back()->with('pesan', 'Data PPDB berhasil diperbarui!');
    }

    // --- MANAJEMEN BERANDA (HERO SLIDER) ---
    public function beranda()
    {
        $this->cekIzin('beranda');
        $data = [
            'title'   => 'Kelola Hero Slider',
            'sliders' => (new HeroSliderModel())->findAll()
        ];
        return view('admin/beranda', $data);
    }

    public function beranda_tambah()
    {
        $this->cekIzin('beranda');
        $heroModel = new HeroSliderModel();
        $file = $this->request->getFile('gambar');
        $fileMobile = $this->request->getFile('gambar_mobile');

        $nama = $this->prosesUpload($file, 'hero', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);
        if (!$nama) {
            return redirect()->back()->withInput()->with('error', 'Gagal upload gambar desktop. Pastikan file berupa gambar (maks 5MB).');
        }
        $namaMobile = null;
        if ($fileMobile && $fileMobile->isValid() && !$fileMobile->hasMoved()) {
            $namaMobile = $this->prosesUpload($fileMobile, 'hero', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);
        }

        $heroModel->save([
            'gambar'        => $nama,
            'gambar_mobile' => $namaMobile,
            'judul'         => $this->request->getPost('judul'),
            'label'         => $this->request->getPost('label'),
            'subjudul'      => $this->request->getPost('subjudul'),
            'btn1_teks'     => $this->request->getPost('btn1_teks'),
            'btn1_url'      => $this->request->getPost('btn1_url'),
            'btn2_teks'     => $this->request->getPost('btn2_teks'),
            'btn2_url'      => $this->request->getPost('btn2_url'),
        ]);
        return redirect()->to('admin/beranda')->with('pesan', 'Slide ditambahkan!');
    }

    public function beranda_edit($id)
    {
        $this->cekIzin('beranda');
        $heroModel = new HeroSliderModel();

        $data = [
            'title' => 'Edit Hero Slider',
            'slide' => $heroModel->find($id)
        ];

        if (!$data['slide']) {
            return redirect()->to('admin/beranda')->with('error', 'Data tidak ditemukan.');
        }

        // Pastikan file view 'app/Views/admin/beranda_edit.php' tersedia
        return view('admin/beranda_edit', $data);
    }

    public function beranda_update($id)
    {
        $this->cekIzin('beranda');
        $heroModel = new HeroSliderModel();
        $slideLama = $heroModel->find($id);

        if (!$slideLama) {
            return redirect()->to('admin/beranda')->with('error', 'Data tidak ditemukan.');
        }

        // 1. Tangani Gambar Desktop
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $slideLama['gambar']; // Default pakai yang lama

        if ($fileGambar && $fileGambar->isValid()) {
            $baru = $this->prosesUpload($fileGambar, 'hero', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);
            if ($baru) {
                $namaGambar = $baru;
                if (!empty($slideLama['gambar']) && file_exists(FCPATH . 'uploads/hero/' . $slideLama['gambar'])) {
                    unlink(FCPATH . 'uploads/hero/' . $slideLama['gambar']);
                }
            }
        }

        // 2. Tangani Gambar Mobile
        $fileMobile = $this->request->getFile('gambar_mobile');
        $namaMobile = $slideLama['gambar_mobile']; // Default pakai yang lama

        if ($fileMobile && $fileMobile->isValid()) {
            $baruMobile = $this->prosesUpload($fileMobile, 'hero', $this->mimeGambar(), ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'], 5);
            if ($baruMobile) {
                $namaMobile = $baruMobile;
                if (!empty($slideLama['gambar_mobile']) && file_exists(FCPATH . 'uploads/hero/' . $slideLama['gambar_mobile'])) {
                    unlink(FCPATH . 'uploads/hero/' . $slideLama['gambar_mobile']);
                }
            }
        }

        // 3. Update SEMUA data sesuai dengan allowedFields di Model
        $heroModel->update($id, [
            'gambar'        => $namaGambar,
            'gambar_mobile' => $namaMobile,
            'label'         => $this->request->getPost('label'),
            'judul'         => $this->request->getPost('judul'),
            'subjudul'      => $this->request->getPost('subjudul'),
            'btn1_teks'     => $this->request->getPost('btn1_teks'),
            'btn1_url'      => $this->request->getPost('btn1_url'),
            'btn2_teks'     => $this->request->getPost('btn2_teks'),
            'btn2_url'      => $this->request->getPost('btn2_url'),
        ]);

        return redirect()->to('admin/beranda')->with('pesan', 'Slide berhasil diperbarui secara menyeluruh!');
    }

    public function beranda_hapus($id)
    {
        $this->cekIzin('beranda');
        $heroModel = new HeroSliderModel();
        $slide = $heroModel->find($id);

        if ($slide) {
            if (!empty($slide['gambar']) && file_exists(FCPATH . 'uploads/hero/' . $slide['gambar'])) {
                unlink(FCPATH . 'uploads/hero/' . $slide['gambar']);
            }
            if (!empty($slide['gambar_mobile']) && file_exists(FCPATH . 'uploads/hero/' . $slide['gambar_mobile'])) {
                unlink(FCPATH . 'uploads/hero/' . $slide['gambar_mobile']);
            }
            $heroModel->delete($id);
            return redirect()->to('admin/beranda')->with('pesan', 'Slide berhasil dihapus!');
        }

        return redirect()->to('admin/beranda')->with('error', 'Data tidak ditemukan.');
    }
}

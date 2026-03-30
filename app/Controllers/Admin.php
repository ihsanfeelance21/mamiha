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
    /**
     * Fungsi Private untuk mengecek hak akses user secara internal di Controller
     */
    private function cekIzin($slug)
    {
        if (session()->get('role') === 'superadmin') return true;

        $db = \Config\Database::connect();
        $hasAccess = $db->table('user_permissions')
            ->where('id_user', session()->get('id_user'))
            ->where('menu_slug', $slug)
            ->countAllResults() > 0;

        if (!$hasAccess) {
            // Jika tidak punya akses, paksa tendang ke dashboard dengan pesan error
            header('Location: ' . base_url('admin/dashboard?error=restricted'));
            exit;
        }
    }

    public function dashboard()
    {
        $logModel = new LoginLogModel();
        $data['logs'] = $logModel->select('login_logs.*, users.nama_lengkap, users.foto')
            ->join('users', 'users.id_user = login_logs.id_user')
            ->orderBy('login_at', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        $data['title'] = 'Dashboard Utama';
        $data['stats'] = [
            'pendaftar' => 142,
            'berita'    => 24,
            'pesan'     => 5,
            'alumni'    => 89
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

        $namaGambar = null;
        $fileGambar = $this->request->getFile('gambar');
        if ($fileGambar && $fileGambar->isValid()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads/kegiatan', $namaGambar);
        }

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
            if ($kegiatan['gambar'] && file_exists('uploads/kegiatan/' . $kegiatan['gambar'])) {
                unlink('uploads/kegiatan/' . $kegiatan['gambar']);
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
            $namaF = $favicon->getRandomName();
            $favicon->move('uploads/pengaturan', $namaF);
            $data['favicon'] = $namaF;
            if (!empty($lama['favicon'])) @unlink('uploads/pengaturan/' . $lama['favicon']);
        }

        $model->update(1, $data);
        return redirect()->to('admin/pengaturan')->with('pesan', 'Pengaturan diperbarui!');
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
        $data = [
            'status_ppdb' => $this->request->getPost('status_ppdb'),
            'link_daftar' => $this->request->getPost('link_daftar'),
            'updated_at'  => date('Y-m-d H:i:s')
        ];
        $model->update(1, $data);
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

        if ($file->isValid()) {
            $nama = $file->getRandomName();
            $file->move('uploads/hero', $nama);

            $heroModel->save([
                'gambar' => $nama,
                'judul'  => $this->request->getPost('judul'),
                'label'  => $this->request->getPost('label'),
            ]);
            return redirect()->to('admin/beranda')->with('pesan', 'Slide ditambahkan!');
        }
        return redirect()->back()->with('error', 'Gagal upload.');
    }
}

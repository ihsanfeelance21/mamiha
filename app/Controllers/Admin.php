<?php

namespace App\Controllers;

use App\Models\KegiatanModel; // Panggil model di sini
use App\Models\PengaturanModel;
use App\Models\PendaftaranModel;

class Admin extends BaseController
{
    public function dashboard()
    {
        $data = ['title' => 'Dashboard Admin'];
        return view('admin/dashboard', $data);
    }

    // Menampilkan daftar kegiatan (Read)
    public function kegiatan()
    {
        $kegiatanModel = new KegiatanModel();
        $data = [
            'title'    => 'Kegiatan Sekolah',
            // Ambil semua data, urutkan dari yang terbaru
            'kegiatan' => $kegiatanModel->orderBy('created_at', 'DESC')->findAll()
        ];
        return view('admin/kegiatan', $data);
    }

    // Menampilkan halaman form tambah
    public function tambah_kegiatan()
    {
        $data = ['title' => 'Tambah Kegiatan'];
        return view('admin/kegiatan_tambah', $data);
    }

    // Memproses data dari form (Create)
    public function simpan_kegiatan()
    {
        $kegiatanModel = new KegiatanModel();

        // 1. Validasi Input Dasar
        // 1. Validasi Input Dasar (Ditambahkan is_unique)
        $rules = [
            'judul' => [
                'rules'  => 'required|min_length[3]|is_unique[kegiatan.judul]',
                'errors' => [
                    'is_unique' => 'Judul kegiatan ini sudah ada! Silakan gunakan judul lain.'
                ]
            ],
            'konten' => 'required',
            'gambar' => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal, ambil pesan errornya dan kembalikan ke form
            $pesanError = $this->validator->getError('judul') ?: 'Gagal menyimpan. Pastikan form diisi dengan benar dan gambar maksimal 2MB.';

            return redirect()->back()->withInput()->with('error', $pesanError);
        }

        // 2. Persiapan Data Teks
        $judul = $this->request->getPost('judul');
        $slug = url_title($judul, '-', true);
        $namaGambar = null; // Default null jika tidak ada gambar

        // 3. Proses Upload Gambar
        $fileGambar = $this->request->getFile('gambar');

        // Cek apakah ada gambar yang diupload dan tidak ada error
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            // Generate nama acak agar tidak bentrok jika nama file sama (Best Practice)
            $namaGambar = $fileGambar->getRandomName();

            // Pindahkan file ke folder public/uploads/kegiatan
            $fileGambar->move('uploads/kegiatan', $namaGambar);
        }

        // 4. Simpan ke Database
        $kegiatanModel->save([
            'judul'  => $judul,
            'slug'   => $slug,
            'konten' => $this->request->getPost('konten'),
            'gambar' => $namaGambar // Simpan nama filenya saja (misal: 16829382.jpg)
        ]);

        return redirect()->to(base_url('admin/kegiatan'))->with('pesan', 'Kegiatan berhasil ditambahkan!');
    }

    // --- FUNGSI HAPUS ---
    public function hapus_kegiatan($id)
    {
        $kegiatanModel = new KegiatanModel();
        $kegiatan = $kegiatanModel->find($id);

        if ($kegiatan) {
            // Hapus file gambar dari folder (jika ada)
            if ($kegiatan['gambar'] && file_exists('uploads/kegiatan/' . $kegiatan['gambar'])) {
                unlink('uploads/kegiatan/' . $kegiatan['gambar']);
            }
            // Hapus data dari database
            $kegiatanModel->delete($id);
            return redirect()->to(base_url('admin/kegiatan'))->with('pesan', 'Data kegiatan berhasil dihapus.');
        }
        return redirect()->to(base_url('admin/kegiatan'))->with('error', 'Data tidak ditemukan.');
    }

    // --- FUNGSI TAMPILKAN FORM EDIT ---
    public function edit_kegiatan($id)
    {
        $kegiatanModel = new KegiatanModel();
        $data = [
            'title'    => 'Edit Kegiatan',
            'kegiatan' => $kegiatanModel->find($id)
        ];

        // Jika data tidak ada, kembalikan ke daftar
        if (empty($data['kegiatan'])) {
            return redirect()->to(base_url('admin/kegiatan'))->with('error', 'Data tidak ditemukan.');
        }

        return view('admin/kegiatan_edit', $data);
    }

    // --- FUNGSI UPDATE DATA (SIMPAN PERUBAHAN) ---
    public function update_kegiatan($id)
    {
        $kegiatanModel = new KegiatanModel();

        // Ambil data kegiatan lama dari database
        $kegiatanLama = $kegiatanModel->find($id);
        if (!$kegiatanLama) {
            return redirect()->to(base_url('admin/kegiatan'))->with('error', 'Data tidak ditemukan.');
        }

        // 1. Validasi Input
        // PENTING: Aturan is_unique kita modifikasi agar mengabaikan ID saat ini
        $rules = [
            'judul' => [
                'rules'  => "required|min_length[3]|is_unique[kegiatan.judul,id,{$id}]",
                'errors' => [
                    'is_unique' => 'Judul kegiatan ini sudah digunakan oleh kegiatan lain. Silakan gunakan judul berbeda.'
                ]
            ],
            'konten' => 'required',
            'gambar' => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if (!$this->validate($rules)) {
            $pesanError = $this->validator->getError('judul') ?: 'Gagal mengupdate. Pastikan form diisi dengan benar dan gambar maksimal 2MB.';
            return redirect()->back()->withInput()->with('error', $pesanError);
        }

        // 2. Persiapan Data
        $judul = $this->request->getPost('judul');
        $slug = url_title($judul, '-', true);
        $namaGambar = $kegiatanLama['gambar']; // Default: Tetap gunakan nama gambar lama

        // 3. Proses Upload Gambar Baru (Jika Admin Memilih File Baru)
        $fileGambar = $this->request->getFile('gambar');

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            // Generate nama file acak yang baru
            $namaGambarBaru = $fileGambar->getRandomName();
            // Pindahkan file baru ke folder uploads
            $fileGambar->move('uploads/kegiatan', $namaGambarBaru);

            // Hapus file gambar LAMA dari server (jika ada) agar tidak menumpuk
            if ($kegiatanLama['gambar'] && file_exists('uploads/kegiatan/' . $kegiatanLama['gambar'])) {
                unlink('uploads/kegiatan/' . $kegiatanLama['gambar']);
            }

            // Set nama gambar untuk disimpan ke database dengan nama gambar yang baru
            $namaGambar = $namaGambarBaru;
        }

        // 4. Update Data ke Database
        $kegiatanModel->update($id, [
            'judul'  => $judul,
            'slug'   => $slug,
            'konten' => $this->request->getPost('konten'),
            'gambar' => $namaGambar
        ]);

        // 5. Kembalikan ke halaman daftar dengan pesan sukses
        return redirect()->to(base_url('admin/kegiatan'))->with('pesan', 'Kegiatan berhasil diperbarui!');
    }

    // --- FUNGSI TAMPILKAN FORM PENGATURAN ---
    public function pengaturan()
    {
        $pengaturanModel = new PengaturanModel();

        $data = [
            'title'      => 'Pengaturan Website',
            // Gunakan first() karena datanya cuma 1 baris di tabel
            'pengaturan' => $pengaturanModel->first()
        ];

        return view('admin/pengaturan', $data);
    }

    // --- FUNGSI UPDATE PENGATURAN ---
    public function update_pengaturan()
    {
        $pengaturanModel = new PengaturanModel();
        $pengaturanLama = $pengaturanModel->first(); // Ambil data lama untuk cek favicon

        $data = [
            'nama_sekolah'     => $this->request->getPost('nama_sekolah'),
            'slogan'           => $this->request->getPost('slogan'),
            'alamat_singkat'   => $this->request->getPost('alamat_singkat'),
            'alamat'           => $this->request->getPost('alamat'),
            'telepon'          => $this->request->getPost('telepon'),
            'email'            => $this->request->getPost('email'),
            'deskripsi_footer' => $this->request->getPost('deskripsi_footer'),
            'facebook'         => $this->request->getPost('facebook'),
            'instagram'        => $this->request->getPost('instagram'),
            'youtube'          => $this->request->getPost('youtube'),
            'tiktok'          => $this->request->getPost('tiktok'),
            'meta_deskripsi'   => $this->request->getPost('meta_deskripsi'),
            'meta_keywords'    => $this->request->getPost('meta_keywords'),
            'link_maps'        => $this->request->getPost('link_maps'),
            'link_whatsapp'    => $this->request->getPost('link_whatsapp'),
            'updated_at'       => date('Y-m-d H:i:s')
        ];

        // --- PROSES UPLOAD FAVICON ---
        $fileFavicon = $this->request->getFile('favicon');
        if ($fileFavicon && $fileFavicon->isValid() && ! $fileFavicon->hasMoved()) {
            // Beri nama acak agar tidak bentrok
            $namaFavicon = $fileFavicon->getRandomName();
            // Pindahkan ke folder public/uploads/pengaturan
            $fileFavicon->move('uploads/pengaturan', $namaFavicon);

            // Simpan nama file baru ke array data
            $data['favicon'] = $namaFavicon;

            // Hapus favicon lama jika ada
            if (!empty($pengaturanLama['favicon']) && file_exists('uploads/pengaturan/' . $pengaturanLama['favicon'])) {
                unlink('uploads/pengaturan/' . $pengaturanLama['favicon']);
            }
        }
        // --- PROSES UPLOAD LOGO UTAMA ---
        $fileLogo = $this->request->getFile('logo');
        if ($fileLogo && $fileLogo->isValid() && ! $fileLogo->hasMoved()) {
            $namaLogo = $fileLogo->getRandomName();
            $fileLogo->move('uploads/pengaturan', $namaLogo);

            $data['logo'] = $namaLogo;

            // Hapus logo lama jika ada
            if (!empty($pengaturanLama['logo']) && file_exists('uploads/pengaturan/' . $pengaturanLama['logo'])) {
                unlink('uploads/pengaturan/' . $pengaturanLama['logo']);
            }
        }

        $pengaturanModel->update(1, $data);

        return redirect()->to(base_url('admin/pengaturan'))->with('pesan', 'Pengaturan website berhasil diperbarui!');
    }
    public function pendaftaran()
    {
        $model = new PendaftaranModel();
        $data = [
            'title' => 'Manajemen PPDB',
            'pendaftaran' => $model->first()
        ];
        return view('admin/pendaftaran', $data);
    }

    public function update_pendaftaran()
    {
        $model = new PendaftaranModel();
        $pendaftaranLama = $model->first();

        $data = [
            'tipe_daftar' => $this->request->getPost('tipe_daftar'),
            'link_daftar' => $this->request->getPost('link_daftar'),
            'status_ppdb' => $this->request->getPost('status_ppdb'),
            'pesan_tutup'     => $this->request->getPost('pesan_tutup'),
            'link_admin_ppdb' => $this->request->getPost('link_admin_ppdb'),
            'updated_at'  => date('Y-m-d H:i:s')
        ];

        // Proses Upload Poster
        $filePoster = $this->request->getFile('poster');
        if ($filePoster && $filePoster->isValid()) {
            $namaPoster = $filePoster->getRandomName();
            $filePoster->move('uploads/ppdb', $namaPoster);
            $data['poster'] = $namaPoster;
            if (!empty($pendaftaranLama['poster'])) @unlink('uploads/ppdb/' . $pendaftaranLama['poster']);
        }

        // Proses Upload Brosur (PDF/Image)
        $fileBrosur = $this->request->getFile('brosur');
        if ($fileBrosur && $fileBrosur->isValid()) {
            $namaBrosur = $fileBrosur->getRandomName();
            $fileBrosur->move('uploads/ppdb', $namaBrosur);
            $data['brosur'] = $namaBrosur;
            if (!empty($pendaftaranLama['brosur'])) @unlink('uploads/ppdb/' . $pendaftaranLama['brosur']);
        }

        $model->update(1, $data);
        return redirect()->back()->with('pesan', 'Data PPDB berhasil diperbarui!');
    }
    public function akses_cepat()
    {
        $aksesCepatModel = new \App\Models\AksesCepatModel();
        $data = [
            'title' => 'Kelola Akses Cepat',
            'akses_cepat' => $aksesCepatModel->findAll()
        ];
        return view('admin/akses_cepat', $data);
    }

    public function akses_cepat_tambah()
    {
        $aksesCepatModel = new \App\Models\AksesCepatModel();
        $aksesCepatModel->save([
            'nama_link' => $this->request->getPost('nama_link'),
            'url_link'  => $this->request->getPost('url_link')
        ]);
        return redirect()->to(base_url('admin/akses-cepat'))->with('pesan', 'Link Akses Cepat berhasil ditambahkan!');
    }

    public function akses_cepat_hapus($id)
    {
        $aksesCepatModel = new \App\Models\AksesCepatModel();
        $aksesCepatModel->delete($id);
        return redirect()->to(base_url('admin/akses-cepat'))->with('pesan', 'Link berhasil dihapus!');
    }
    public function beranda()
    {
        $heroModel = new \App\Models\HeroSliderModel();
        $data = [
            'title' => 'Kelola Beranda (Hero Slide)',
            'sliders' => $heroModel->findAll()
        ];
        return view('admin/beranda', $data);
    }

    public function beranda_tambah()
    {
        $heroModel = new \App\Models\HeroSliderModel();

        $fileGambar = $this->request->getFile('gambar');
        if ($fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads/hero', $namaGambar);

            // Logika Upload Gambar Mobile
            $namaGambarMobile = null;
            $fileMobile = $this->request->getFile('gambar_mobile');
            if ($fileMobile && $fileMobile->isValid() && !$fileMobile->hasMoved()) {
                $namaGambarMobile = $fileMobile->getRandomName();
                $fileMobile->move('uploads/hero', $namaGambarMobile);
            }

            $heroModel->save([
                'gambar'        => $namaGambar,
                'gambar_mobile' => $namaGambarMobile, // <-- Simpan ke database
                'label'         => $this->request->getPost('label'),
                'judul'     => $this->request->getPost('judul'),
                'subjudul'  => $this->request->getPost('subjudul'),
                'btn1_teks' => $this->request->getPost('btn1_teks'),
                'btn1_url'  => $this->request->getPost('btn1_url'),
                'btn2_teks' => $this->request->getPost('btn2_teks'),
                'btn2_url'  => $this->request->getPost('btn2_url'),
            ]);
            return redirect()->to(base_url('admin/beranda'))->with('pesan', 'Slide berhasil ditambahkan!');
        }
        return redirect()->to(base_url('admin/beranda'))->with('error', 'Gagal mengunggah gambar.');
    }

    public function beranda_edit($id)
    {
        $heroModel = new \App\Models\HeroSliderModel();
        $data = [
            'title' => 'Edit Hero Slide',
            'slide' => $heroModel->find($id)
        ];
        return view('admin/beranda_edit', $data);
    }

    public function beranda_update($id)
    {
        $heroModel = new \App\Models\HeroSliderModel();
        $slideLama = $heroModel->find($id);

        $dataUpdate = [
            'label'     => $this->request->getPost('label'),
            'judul'     => $this->request->getPost('judul'),
            'subjudul'  => $this->request->getPost('subjudul'),
            'btn1_teks' => $this->request->getPost('btn1_teks'),
            'btn1_url'  => $this->request->getPost('btn1_url'),
            'btn2_teks' => $this->request->getPost('btn2_teks'),
            'btn2_url'  => $this->request->getPost('btn2_url'),
        ];


        // Cek jika ada gambar baru diupload
        $fileMobile = $this->request->getFile('gambar_mobile');
        if ($fileMobile && $fileMobile->isValid() && !$fileMobile->hasMoved()) {
            $namaGambarMobile = $fileMobile->getRandomName();
            $fileMobile->move('uploads/hero', $namaGambarMobile);
            $dataUpdate['gambar_mobile'] = $namaGambarMobile;

            // Hapus gambar mobile lama jika ada
            if (!empty($slideLama['gambar_mobile']) && file_exists('uploads/hero/' . $slideLama['gambar_mobile'])) {
                unlink('uploads/hero/' . $slideLama['gambar_mobile']);
            }
        }

        $heroModel->update($id, $dataUpdate);
        return redirect()->to(base_url('admin/beranda'))->with('pesan', 'Slide berhasil diperbarui!');
    }

    public function beranda_hapus($id)
    {
        $heroModel = new \App\Models\HeroSliderModel();
        $slide = $heroModel->find($id);

        if ($slide && file_exists('uploads/hero/' . $slide['gambar'])) {
            unlink('uploads/hero/' . $slide['gambar']);
        }
        $heroModel->delete($id);
        return redirect()->to(base_url('admin/beranda'))->with('pesan', 'Slide berhasil dihapus!');
    }
}

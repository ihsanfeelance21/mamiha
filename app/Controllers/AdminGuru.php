<?php

namespace App\Controllers;

use App\Models\GuruStaffModel;

class AdminGuru extends BaseController
{
    protected $guruModel;

    public function __construct()
    {
        $this->guruModel = new GuruStaffModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Data Pimpinan & Guru',
            // Ambil semua data dan urutkan berdasarkan urutan, lalu nama
            'guru'  => $this->guruModel->orderBy('urutan', 'ASC')->orderBy('nama', 'ASC')->findAll()
        ];

        return view('admin/guru/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title'      => 'Tambah Data Guru & Staff',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/guru/tambah', $data);
    }

    public function simpan()
    {
        // 1. Validasi Input (Bisa tambahkan validasi PDF di sini jika mau)
        if (!$this->validate([
            'nama'    => 'required',
            'jabatan' => 'required',
            'foto'    => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
        ])) {
            return redirect()->to('/admin/guru/tambah')->withInput();
        }

        // 2. Siapkan Wadah Data
        $dataSimpan = [
            'nama'       => $this->request->getVar('nama'),
            'jabatan'    => $this->request->getVar('jabatan'),
            'kategori'   => $this->request->getVar('kategori'),
            'sambutan'   => $this->request->getVar('sambutan'),
            'urutan'     => $this->request->getVar('urutan'),
            'pendidikan' => $this->request->getVar('pendidikan'),
            'facebook'   => $this->request->getVar('facebook'),
            'instagram'  => $this->request->getVar('instagram'),
            'linkedin'   => $this->request->getVar('linkedin'),
            'youtube'    => $this->request->getVar('youtube'),
            'tiktok'     => $this->request->getVar('tiktok'),
        ];

        // 3. Kelola Upload Foto
        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto->getError() == 4) {
            $dataSimpan['foto'] = 'default.jpg'; // Jika tidak upload foto
        } else {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/guru', $namaFoto);
            $dataSimpan['foto'] = $namaFoto;
        }

        // 4. Kelola Upload CV (PDF)
        $fileCv = $this->request->getFile('cv_file');
        if ($fileCv && $fileCv->isValid() && !$fileCv->hasMoved()) {
            $namaCv = $fileCv->getRandomName();
            // Pindahkan file ke folder uploads/cv
            $fileCv->move('uploads/cv', $namaCv);
            $dataSimpan['cv_file'] = $namaCv;
        }

        // 5. Simpan ke Database (Hanya 1 kali panggil save)
        $this->guruModel->save($dataSimpan);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to('/admin/guru');
    }

    public function edit($id)
    {
        $data = [
            'title'      => 'Edit Data Guru & Staff',
            'validation' => \Config\Services::validation(),
            'guru'       => $this->guruModel->find($id)
        ];

        // Jika data tidak ditemukan
        if (empty($data['guru'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data guru tidak ditemukan');
        }

        return view('admin/guru/edit', $data);
    }

    public function update($id)
    {
        // 1. Validasi Input (Pastikan rules-nya sama dengan tambah data)
        if (!$this->validate([
            'nama'       => 'required',
            'jabatan'    => 'required',
            // Validasi file (Opsional, Mas bisa tambahkan di sini)
            'foto'       => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
            'cv_file'    => 'max_size[cv_file,5120]|ext_in[cv_file,pdf]',
        ])) {
            return redirect()->to('/admin/guru/edit/' . $id)->withInput();
        }

        // 2. Ambil data guru yang lama untuk referensi foto lama
        $guruLama = $this->guruModel->find($id);

        // 3. Siapkan Wadah Data Update (Isi dengan data teks)
        $dataUpdate = [
            'nama'       => $this->request->getPost('nama'),
            'jabatan'    => $this->request->getPost('jabatan'),
            'kategori'   => $this->request->getPost('kategori'),
            'sambutan'   => $this->request->getPost('sambutan'),
            'urutan'     => $this->request->getPost('urutan'),
            'pendidikan' => $this->request->getPost('pendidikan'),
            'youtube'    => $this->request->getPost('youtube'),
            'facebook'   => $this->request->getPost('facebook'),
            'instagram'  => $this->request->getPost('instagram'),
            'tiktok'     => $this->request->getPost('tiktok'),
            'linkedin'   => $this->request->getPost('linkedin')
        ];

        // 4. Kelola Update Foto (Jika ada upload foto baru)
        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            // Jika admin upload foto baru
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/guru', $namaFoto);
            $dataUpdate['foto'] = $namaFoto;

            // Hapus file foto lama dari folder (Kecuali default.jpg)
            if ($guruLama['foto'] != 'default.jpg' && !empty($guruLama['foto']) && file_exists('uploads/guru/' . $guruLama['foto'])) {
                unlink('uploads/guru/' . $guruLama['foto']);
            }
        }

        // 5. Kelola Update CV (PDF) (Jika ada upload file CV baru)
        $fileCv = $this->request->getFile('cv_file');
        if ($fileCv && $fileCv->isValid() && !$fileCv->hasMoved()) {
            // Jika admin upload file CV baru
            $namaCv = $fileCv->getRandomName();
            $fileCv->move('uploads/cv', $namaCv);
            $dataUpdate['cv_file'] = $namaCv;

            // Hapus file CV lama jika ada di folder
            if (!empty($guruLama['cv_file']) && file_exists('uploads/cv/' . $guruLama['cv_file'])) {
                unlink('uploads/cv/' . $guruLama['cv_file']);
            }
        }

        // 6. Update ke Database secara eksplisit menggunakan ID
        // PENTING: ID dimasukkan sebagai parameter pertama
        $this->guruModel->update($id, $dataUpdate);

        // 7. Berikan pesan sukses dan kembali ke halaman utama
        session()->setFlashdata('pesan', 'Data berhasil diperbarui.');
        return redirect()->to('/admin/guru');
    }

    public function hapus($id)
    {
        // Cari data guru berdasarkan id
        $guru = $this->guruModel->find($id);

        // Hapus file foto fisik dari folder (Kecuali default.jpg)
        if ($guru['foto'] != 'default.jpg' && !empty($guru['foto']) && file_exists('uploads/guru/' . $guru['foto'])) {
            unlink('uploads/guru/' . $guru['foto']);
        }

        // Hapus file CV fisik dari folder jika ada
        if (!empty($guru['cv_file']) && file_exists('uploads/cv/' . $guru['cv_file'])) {
            unlink('uploads/cv/' . $guru['cv_file']);
        }

        // Hapus data dari database
        $this->guruModel->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/admin/guru');
    }
}

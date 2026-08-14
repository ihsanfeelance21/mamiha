<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\UserPermissionModel;

class User extends BaseController
{
    public function index()
    {
        if (session()->get('role') !== 'superadmin') {
            return redirect()->to('admin/dashboard')->with('error', 'Akses ditolak!');
        }

        $model = new UserModel();
        $data = [
            'title' => 'Manajemen User',
            'users' => $model->findAll()
        ];
        return view('admin/user/index', $data);
    }

    public function tambah()
    {
        if (session()->get('role') !== 'superadmin') {
            return redirect()->to('admin/dashboard')->with('error', 'Akses ditolak!');
        }

        $data = [
            'title' => 'Tambah User Baru',
            'menus' => $this->list_semua_menu() // Mengambil dari fungsi pusat tadi
        ];
        return view('admin/user/tambah', $data);
    }

    public function simpan()
    {
        if (session()->get('role') !== 'superadmin') {
            return redirect()->to('admin/dashboard')->with('error', 'Akses ditolak!');
        }

        $userModel = new UserModel();
        $permModel = new UserPermissionModel();

        $userData = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'         => $this->request->getPost('role'),
        ];

        $userModel->save($userData);
        $newUserId = $userModel->getInsertID();

        $selectedMenus = $this->request->getPost('permissions');
        if ($selectedMenus && is_array($selectedMenus)) {
            foreach ($selectedMenus as $slug) {
                $permModel->insert([
                    'id_user'   => $newUserId,
                    'menu_slug' => $slug
                ]);
            }
        }

        return redirect()->to('admin/users')->with('pesan', 'User berhasil dibuat!');
    }

    public function edit($id)
    {
        // Proteksi Superadmin
        if (session()->get('role') !== 'superadmin') {
            return redirect()->to('admin/dashboard')->with('error', 'Akses ditolak!');
        }

        $userModel = new UserModel();
        $permModel = new UserPermissionModel();

        // Cari data user berdasarkan ID
        $user = $userModel->find($id);
        if (!$user) {
            return redirect()->to('admin/users')->with('error', 'User tidak ditemukan!');
        }

        // Ambil data menu yang sudah diizinkan untuk user ini
        $permissions = $permModel->where('id_user', $id)->findAll();
        $userPerms = array_column($permissions, 'menu_slug');

        $data = [
            'title'            => 'Edit User',
            'user'             => $user,
            'user_permissions' => $userPerms,
            'menus'            => $this->list_semua_menu() // Mengambil dari fungsi pusat tadi
        ];

        return view('admin/user/edit', $data);
    }

    public function update($id)
    {
        if (session()->get('role') !== 'superadmin') {
            return redirect()->to('admin/dashboard')->with('error', 'Akses ditolak!');
        }

        $userModel = new UserModel();
        $permModel = new UserPermissionModel();

        $userData = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'role'         => $this->request->getPost('role'),
        ];

        // Jika password diisi, berarti mau ganti password. Jika kosong, biarkan yang lama.
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $userModel->update($id, $userData);

        // Reset permission lama
        $permModel->where('id_user', $id)->delete();

        // Simpan permission baru
        $selectedMenus = $this->request->getPost('permissions');
        if ($selectedMenus && is_array($selectedMenus)) {
            foreach ($selectedMenus as $slug) {
                $permModel->insert([
                    'id_user'   => $id,
                    'menu_slug' => $slug
                ]);
            }
        }

        return redirect()->to('admin/users')->with('pesan', 'Data user berhasil diperbarui!');
    }

    public function hapus($id)
    {
        if (session()->get('role') !== 'superadmin') {
            return redirect()->to('admin/dashboard')->with('error', 'Akses ditolak!');
        }

        // Proteksi agar Superadmin utama (ID 1) tidak bisa dihapus
        if ($id == 1) return redirect()->back()->with('error', 'Admin utama tidak bisa dihapus!');

        (new UserModel())->delete($id);

        // Hapus juga permission terkait agar data tidak nyangkut (opsional tapi disarankan)
        (new UserPermissionModel())->where('id_user', $id)->delete();

        return redirect()->to('admin/users')->with('pesan', 'User dihapus.');
    }

    private function list_semua_menu()
    {
        return [
            // Konten Sekolah
            ['slug' => 'kegiatan',    'nama' => 'Kegiatan'],
            ['slug' => 'berita',      'nama' => 'Berita (Tulis/Daftar/Kategori/Tags)'],
            ['slug' => 'prestasi',    'nama' => 'Prestasi'],
            ['slug' => 'pengumuman',  'nama' => 'Pengumuman'],
            ['slug' => 'kalender',    'nama' => 'Kalender Akademik'],
            ['slug' => 'galeri',      'nama' => 'Galeri (Foto & Video)'],
            ['slug' => 'unduhan',     'nama' => 'Pusat Unduhan'],

            // Profil Sekolah
            ['slug' => 'beranda',     'nama' => 'Slider Beranda'],
            ['slug' => 'profil',      'nama' => 'Profil Madrasah'],
            ['slug' => 'bakat_minat', 'nama' => 'Bakat Minat'],
            ['slug' => 'testimoni',   'nama' => 'Testimoni'],
            ['slug' => 'guru',        'nama' => 'Data Guru & Staff'],

            // PPDB & Alumni
            ['slug' => 'pendaftaran', 'nama' => 'Manajemen PPDB'],
            ['slug' => 'alumni',      'nama' => 'Daftar Alumni'],
            ['slug' => 'universitas', 'nama' => 'Kelola Universitas'],

            // Lainnya
            ['slug' => 'kontak',      'nama' => 'Kotak Masuk'],
            ['slug' => 'pengaturan',  'nama' => 'Profil Web / Pengaturan'],
            ['slug' => 'akses_cepat', 'nama' => 'Menu Akses Cepat'],
        ];
    }
}

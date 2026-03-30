<?php

namespace App\Controllers\Admin; // Perbaikan Namespace

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
        $data = [
            'title' => 'Tambah User Baru',
            // Daftar menu disamakan dengan yang ada di Sidebar Layout
            'menus' => [
                ['slug' => 'beranda', 'nama' => 'Slider Beranda'],
                ['slug' => 'profil', 'nama' => 'Profil Madrasah'],
                ['slug' => 'guru', 'nama' => 'Data Guru & Staff'],
                ['slug' => 'kegiatan', 'nama' => 'Berita & Kegiatan'],
                ['slug' => 'pendaftaran', 'nama' => 'Manajemen PPDB'],
                ['slug' => 'galeri', 'nama' => 'Kelola Galeri'],
                ['slug' => 'alumni', 'nama' => 'Manajemen Alumni'],
                ['slug' => 'kontak', 'nama' => 'Kotak Masuk'],
                ['slug' => 'pengaturan', 'nama' => 'Pengaturan Sistem'],
            ]
        ];
        return view('admin/user/tambah', $data);
    }

    public function simpan()
    {
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

    public function hapus($id)
    {
        if ($id == 1) return redirect()->back()->with('error', 'Admin utama tidak bisa dihapus!');
        (new UserModel())->delete($id);
        return redirect()->to('admin/users')->with('pesan', 'User dihapus.');
    }
}

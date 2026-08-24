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
            return redirect()->to('admin/dashboard')->with('error', 'Akses ditolak! Hanya superadmin.');
        }

        $model = new UserModel();
        $keyword = $this->request->getGet('keyword');
        $query = $model;
        if (!empty($keyword)) {
            $query = $query->groupStart()->like('nama_lengkap', $keyword)->orLike('username', $keyword)->groupEnd();
        }
        $data = [
            'title' => 'Manajemen User',
            'users' => $query->orderBy('created_at', 'DESC')->paginate(12, 'users'),
            'pager' => $model->pager,
            'keyword' => $keyword
        ];
        return view('admin/user/index', $data);
    }

    public function tambah()
    {
        if (session()->get('role') !== 'superadmin') {
            return redirect()->to('admin/dashboard')->with('error', 'Akses ditolak! Hanya superadmin.');
        }

        $data = [
            'title' => 'Tambah User Baru',
            'menus' => $this->list_semua_menu(),
            'menus_grouped' => $this->list_menu_grouped()
        ];
        return view('admin/user/tambah', $data);
    }

    public function simpan()
    {
        if (session()->get('role') !== 'superadmin') {
            return redirect()->to('admin/dashboard')->with('error', 'Akses ditolak! Hanya superadmin.');
        }

        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'username'     => 'required|alpha_numeric|min_length[4]|max_length[30]|is_unique[users.username]',
            'password'     => 'required|min_length[8]|max_length[72]',
            'password_confirm' => 'required|matches[password]',
            'role'         => 'required|in_list[admin,superadmin]',
            'foto'         => 'permit_empty|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $allowedSlugs = $this->getMenuSlugs();
        $selectedMenus = $this->request->getPost('permissions');
        if (!empty($selectedMenus)) {
            if (!is_array($selectedMenus)) $selectedMenus = [$selectedMenus];
            foreach ($selectedMenus as $slug) {
                if (!in_array($slug, $allowedSlugs, true)) {
                    return redirect()->back()->withInput()->with('error', 'Hak akses tidak valid: ' . esc($slug));
                }
            }
        }
        // Superadmin tidak perlu permission granular (bypass), kosongkan
        if ($this->request->getPost('role') === 'superadmin') {
            $selectedMenus = [];
        }

        $userModel = new UserModel();
        $permModel = new UserPermissionModel();
        $db = \Config\Database::connect();
        $db->transStart();

        $fotoName = null;
        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $fotoName = $this->prosesUpload($fotoFile, 'users', $this->mimeGambar(), ['jpg','jpeg','png','webp'], 2);
        }

        $userData = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'         => $this->request->getPost('role'),
            'foto'         => $fotoName ?? 'default.png',
        ];

        $userModel->save($userData);
        $newUserId = $userModel->getInsertID();

        if (!empty($selectedMenus)) {
            foreach ($selectedMenus as $slug) {
                $permModel->insert([
                    'id_user'   => $newUserId,
                    'menu_slug' => $slug
                ]);
            }
        }

        $db->transComplete();
        if (!$db->transStatus()) {
            if ($fotoName && file_exists(FCPATH . 'uploads/users/' . $fotoName)) @unlink(FCPATH . 'uploads/users/' . $fotoName);
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan user, transaksi dibatalkan.');
        }

        return redirect()->to('admin/users')->with('pesan', 'User berhasil dibuat!');
    }

    public function edit($id)
    {
        if (session()->get('role') !== 'superadmin') {
            return redirect()->to('admin/dashboard')->with('error', 'Akses ditolak! Hanya superadmin.');
        }

        $userModel = new UserModel();
        $permModel = new UserPermissionModel();

        $user = $userModel->find($id);
        if (!$user) {
            return redirect()->to('admin/users')->with('error', 'User tidak ditemukan!');
        }

        $permissions = $permModel->where('id_user', $id)->findAll();
        $userPerms = array_column($permissions, 'menu_slug');

        $data = [
            'title'            => 'Edit User',
            'user'             => $user,
            'user_permissions' => $userPerms,
            'menus'            => $this->list_semua_menu(),
            'menus_grouped'    => $this->list_menu_grouped()
        ];

        return view('admin/user/edit', $data);
    }

    public function update($id)
    {
        if (session()->get('role') !== 'superadmin') {
            return redirect()->to('admin/dashboard')->with('error', 'Akses ditolak! Hanya superadmin.');
        }

        $userModel = new UserModel();
        $oldUser = $userModel->find($id);
        if (!$oldUser) return redirect()->to('admin/users')->with('error', 'User tidak ditemukan!');

        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'username'     => "required|alpha_numeric|min_length[4]|max_length[30]|is_unique[users.username,id_user,{$id}]",
            'role'         => 'required|in_list[admin,superadmin]',
            'foto'         => 'permit_empty|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]'
        ];
        $password = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');
        if (!empty($password) || !empty($passwordConfirm)) {
            $rules['password'] = 'required|min_length[8]|max_length[72]';
            $rules['password_confirm'] = 'required|matches[password]';
        }
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $allowedSlugs = $this->getMenuSlugs();
        $selectedMenus = $this->request->getPost('permissions');
        if (!empty($selectedMenus)) {
            if (!is_array($selectedMenus)) $selectedMenus = [$selectedMenus];
            foreach ($selectedMenus as $slug) {
                if (!in_array($slug, $allowedSlugs, true)) {
                    return redirect()->back()->withInput()->with('error', 'Hak akses tidak valid: ' . esc($slug));
                }
            }
        }
        if ($this->request->getPost('role') === 'superadmin') {
            $selectedMenus = [];
        }

        $permModel = new UserPermissionModel();
        $db = \Config\Database::connect();
        $db->transStart();

        $userData = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'role'         => $this->request->getPost('role'),
        ];

        if (!empty($password)) {
            $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $fotoFile = $this->request->getFile('foto');
        $fotoName = null;
        $fotoHapusLama = null;
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $fotoName = $this->prosesUpload($fotoFile, 'users', $this->mimeGambar(), ['jpg','jpeg','png','webp'], 2);
            if ($fotoName) {
                $userData['foto'] = $fotoName;
                if (!empty($oldUser['foto']) && $oldUser['foto'] !== 'default.png') {
                    $fotoHapusLama = $oldUser['foto'];
                }
            }
        }

        $userModel->update($id, $userData);

        $permModel->where('id_user', $id)->delete();
        if (!empty($selectedMenus)) {
            foreach ($selectedMenus as $slug) {
                $permModel->insert([
                    'id_user'   => $id,
                    'menu_slug' => $slug
                ]);
            }
        }

        $db->transComplete();
        if (!$db->transStatus()) {
            if ($fotoName && file_exists(FCPATH . 'uploads/users/' . $fotoName)) @unlink(FCPATH . 'uploads/users/' . $fotoName);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui user, transaksi dibatalkan.');
        }
        if ($fotoHapusLama && file_exists(FCPATH . 'uploads/users/' . $fotoHapusLama)) @unlink(FCPATH . 'uploads/users/' . $fotoHapusLama);

        return redirect()->to('admin/users')->with('pesan', 'Data user berhasil diperbarui!');
    }

    public function hapus($id)
    {
        if (session()->get('role') !== 'superadmin') {
            return redirect()->to('admin/dashboard')->with('error', 'Akses ditolak! Hanya superadmin.');
        }

        if ($id == 1) return redirect()->back()->with('error', 'Admin utama tidak bisa dihapus!');
        if ($id == session()->get('id_user')) return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri!');

        $user = (new UserModel())->find($id);
        if (!$user) return redirect()->back()->with('error', 'User tidak ditemukan!');

        $db = \Config\Database::connect();
        $db->transStart();
        (new UserModel())->delete($id);
        (new UserPermissionModel())->where('id_user', $id)->delete();
        $db->transComplete();
        if (!$db->transStatus()) {
            return redirect()->back()->with('error', 'Gagal menghapus user.');
        }
        if (!empty($user['foto']) && $user['foto'] !== 'default.png' && file_exists(FCPATH . 'uploads/users/' . $user['foto'])) {
            @unlink(FCPATH . 'uploads/users/' . $user['foto']);
        }

        return redirect()->to('admin/users')->with('pesan', 'User dihapus.');
    }

    private function getMenuSlugs(): array
    {
        return array_column($this->list_semua_menu(), 'slug');
    }

    private function list_menu_grouped(): array
    {
        return [
            'Konten Sekolah' => array_slice($this->list_semua_menu(), 0, 7),
            'Profil Sekolah' => array_slice($this->list_semua_menu(), 7, 5),
            'PPDB & Alumni'  => array_slice($this->list_semua_menu(), 12, 3),
            'Lainnya'        => array_slice($this->list_semua_menu(), 15, 3),
        ];
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

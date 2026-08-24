<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LoginLogModel;
use App\Models\UserPermissionModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) return redirect()->to('admin/dashboard');
        return view('auth/login');
    }

    public function loginProcess()
    {
        $userModel = new UserModel();
        $logModel = new LoginLogModel();

        // ==========================================
        // 🛡️ PROTEKSI BRUTE FORCE (Rate Limiting)
        // ==========================================
        $keyGagal = 'login_failed_' . md5($this->request->getIPAddress());
        $gagal = (int) (cache()->get($keyGagal) ?? session()->get($keyGagal) ?? 0);
        $terkunci = cache()->get($keyGagal . '_lock') ?? session()->get($keyGagal . '_lock');

        if ($terkunci && strtotime($terkunci) > time()) {
            $sisa = ceil((strtotime($terkunci) - time()) / 60);
            return redirect()->back()->with('error', "Terlalu banyak percobaan gagal. Coba lagi dalam {$sisa} menit.");
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {

            // Reset counter percobaan gagal setelah berhasil login
            session()->remove($keyGagal);
            session()->remove($keyGagal . '_lock');
            cache()->delete($keyGagal);
            cache()->delete($keyGagal . '_lock');

            // --- TAMBAHAN 2: Ambil Permission User dari Database ---
            $permModel = new UserPermissionModel();
            $permissions = $permModel->where('id_user', $user['id_user'])->findAll();
            $userPerms = array_column($permissions, 'menu_slug');
            // -------------------------------------------------------

            // Regenerate session ID untuk cegah fixation (best practice)
            session()->regenerate(true);

            // Set Session
            session()->set([
                'id_user'      => $user['id_user'],
                'username'     => $user['username'],
                'nama_lengkap' => $user['nama_lengkap'],
                'role'         => $user['role'],
                'foto'         => $user['foto'],
                'permissions'  => $userPerms, // <-- TAMBAHAN 3: Simpan izin ke session
                'logged_in'    => true
            ]);

            // Catat Log Login
            $logModel->save([
                'id_user'    => $user['id_user'],
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
                'login_at'   => date('Y-m-d H:i:s')
            ]);

            return redirect()->to('admin/dashboard')->with('success_login', true);
        }

        // ==========================================
        // 🛡️ TAMBAH COUNTER GAGAL LOGIN
        // ==========================================
        $gagal++;
        if ($gagal >= 5) {
            cache()->save($keyGagal, $gagal, 900);
            cache()->save($keyGagal . '_lock', date('Y-m-d H:i:s', strtotime('+15 minutes')), 900);
            session()->set($keyGagal, $gagal);
            session()->set($keyGagal . '_lock', date('Y-m-d H:i:s', strtotime('+15 minutes')));
            return redirect()->back()->with('error', 'Terlalu banyak percobaan gagal. Akun dibatasi 15 menit.');
        }
        cache()->save($keyGagal, $gagal, 900);
        session()->set($keyGagal, $gagal);
        return redirect()->back()->with('error', 'Username atau Password salah!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}

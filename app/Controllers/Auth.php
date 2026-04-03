<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LoginLogModel;

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

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $user = $userModel->where('username', $username)->first();

        // ==========================================
        // ðŸ›‘ KODE RESET PASSWORD SEMENTARA
        // ==========================================
        // if ($username === 'admin') {
        //     $userModel->update($user['id_user'], [
        //         'password' => password_hash('admin123', PASSWORD_DEFAULT)
        //     ]);
        //     die('âœ… BERHASIL! Password admin telah direset menjadi: admin123. Silakan hapus/comment kode ini dan ulangi login.');
        // }
        // ==========================================

        if ($user && password_verify($password, $user['password'])) {
            // Set Session
            session()->set([
                'id_user'      => $user['id_user'],
                'username'     => $user['username'],
                'nama_lengkap' => $user['nama_lengkap'],
                'role'         => $user['role'],
                'foto'         => $user['foto'],
                'logged_in'    => true
            ]);

            // Catat Log Login
            $logModel->save([
                'id_user'    => $user['id_user'],
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString()
            ]);

            return redirect()->to('admin/dashboard')->with('success_login', true);
        }
        return redirect()->back()->with('error', 'Username atau Password salah!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}

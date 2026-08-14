<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('users')->where('username', 'admin')->delete();

        $this->db->table('users')->insert([
            'nama_lengkap' => 'Administrator',
            'username'     => 'admin',
            'password'     => password_hash('admin123', PASSWORD_DEFAULT),
            'foto'         => 'default.png',
            'role'         => 'superadmin',
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

        echo "User admin dibuat (username: admin, password: admin123)\n";
    }
}

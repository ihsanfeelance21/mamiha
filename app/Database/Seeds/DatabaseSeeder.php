<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Panggil komandan WebSeeder yang tadi kita buat
        $this->call('WebSeeder');

        // Seeder User Admin (username: admin, password: admin123)
        $this->call('UserSeeder');

        // Seeder Data Dummy Lengkap (untuk demo / tampilan sementara)
        $this->call('DummySeeder');
    }
}

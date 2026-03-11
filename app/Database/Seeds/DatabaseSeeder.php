<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Panggil komandan WebSeeder yang tadi kita buat
        $this->call('WebSeeder');

        // Nanti kalau Mas punya seeder lain, tinggal tambahkan di bawahnya:
        // $this->call('UserAdminSeeder');
        // $this->call('KegiatanSeeder');
    }
}

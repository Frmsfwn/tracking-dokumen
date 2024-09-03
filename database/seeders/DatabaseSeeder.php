<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        $data_user = [
            'nip' => '12345678',
            'nama' => 'Andi',
            'username' => 'andi',
            'password' => bcrypt('andi'),
            'role' => 'SuperAdmin',
        ];

        User::create($data_user);
    }
}

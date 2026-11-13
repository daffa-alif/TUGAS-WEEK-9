<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Membuat akun default aplikasi.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'daffa', 'email' => 'daffa@gmail.com', 'password' => 'password', 'role' => 'Admin'],
            ['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => 'admin',    'role' => 'Admin'],
            ['name' => 'Staff', 'email' => 'staff@gmail.com', 'password' => 'staff',    'role' => 'Staff'],
        ];

        // Password otomatis di-hash oleh cast 'hashed' di model User
        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}

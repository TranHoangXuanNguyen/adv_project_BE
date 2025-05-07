<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'img' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Teacher John',
                'email' => 'teacher@example.com',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'img' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Student Jane',
                'email' => 'student@example.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'img' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

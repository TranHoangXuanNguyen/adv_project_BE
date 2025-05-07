<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentInClassTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('student_in_class')->insert([
            [
                'user_id' => 5,
                'class_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'class_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}


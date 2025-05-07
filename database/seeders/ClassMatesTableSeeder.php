<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassMatesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('class_mates')->insert([
            [
                'class_id' => 1,
                'name' => 'Math 101',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 2,
                'name' => 'Physics 101',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

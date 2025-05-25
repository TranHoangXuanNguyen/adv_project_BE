<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WeeklyTrackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ trong bảng nếu có
        DB::table('weekly_tracking')->delete();

        // Tạo dữ liệu mẫu cho bảng weekly_tracking
        $weeklyTrackings = [
            [
                'semester_id' => 1, // ID của học kỳ tương ứng
                'start_day' => Carbon::now()->subWeeks(4)->startOfWeek(),
                'end_day' => Carbon::now()->subWeeks(4)->endOfWeek(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'semester_id' => 1,
                'start_day' => Carbon::now()->subWeeks(3)->startOfWeek(),
                'end_day' => Carbon::now()->subWeeks(3)->endOfWeek(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'semester_id' => 1,
                'start_day' => Carbon::now()->subWeeks(2)->startOfWeek(),
                'end_day' => Carbon::now()->subWeeks(2)->endOfWeek(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'semester_id' => 1,
                'start_day' => Carbon::now()->subWeek()->startOfWeek(),
                'end_day' => Carbon::now()->subWeek()->endOfWeek(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'semester_id' => 1,
                'start_day' => Carbon::now()->startOfWeek(),
                'end_day' => Carbon::now()->endOfWeek(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Chèn dữ liệu vào bảng
        DB::table('weekly_tracking')->insert($weeklyTrackings);

        $this->command->info('Weekly tracking data seeded successfully!');
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DataSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // 1. Tạo 1 admin & 2 teacher dùng chung cho toàn hệ thống
            $adminId = DB::table('users')->insertGetId([
                'name' => 'Super Admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $teacherIds = [];
            for ($i = 1; $i <= 2; $i++) {
                $teacherIds[] = DB::table('users')->insertGetId([
                    'name' => "Teacher $i",
                    'email' => "teacher$i@mail.com",
                    'password' => Hash::make('password'),
                    'role' => 'teacher',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 2. Tạo 3 lớp học
            foreach (['Class A', 'Class B', 'Class C'] as $className) {
                $classId = DB::table('class_mates')->insertGetId([
                    'name' => $className,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // 3. Tạo 5 students và gán vào lớp
                $studentIds = [];
                for ($i = 1; $i <= 5; $i++) {
                    $studentId = DB::table('users')->insertGetId([
                        'name' => "Student {$i} of {$className}",
                        'email' => "student{$i}_".str($className)->slug()."@mail.com",
                        'password' => Hash::make('password'),
                        'role' => 'student',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $studentIds[] = $studentId;

                    DB::table('student_in_class')->insert([
                        'user_id' => $studentId,
                        'class_id' => $classId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // 4. Tạo 1 học kỳ
                $semesterId = DB::table('semesters')->insertGetId([
                    'class_id' => $classId,
                    'semester_name' => 'Semester 1',
                    'start_date' => Carbon::now()->subWeeks(3),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // 5. Tạo 2 môn học
                $subjectIds = [];
                foreach (['Math', 'Science'] as $subject) {
                    $subjectIds[] = DB::table('subjects')->insertGetId([
                        'semester_id' => $semesterId,
                        'subject_name' => $subject,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // 6. Mục tiêu học kỳ
                foreach ($studentIds as $studentId) {
                    foreach ($subjectIds as $subjectId) {
                        DB::table('semester_goals')->insert([
                            'semester_id' => $semesterId,
                            'student_id' => $studentId,
                            'subject_id' => $subjectId,
                            'course_expected' => 'Nắm vững kiến thức cơ bản',
                            'teacher_expected' => 'Tương tác tốt với giáo viên',
                            'themselves_expected' => 'Tự giác học tập',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                // 7. Tuần theo dõi
                $weekTrackIds = [];
                for ($w = 0; $w < 3; $w++) {
                    $start = Carbon::now()->subWeeks(3 - $w);
                    $end = (clone $start)->addDays(6);
                    $weekTrackIds[] = DB::table('weekly_tracking')->insertGetId([
                        'semester_id' => $semesterId,
                        'week_name' => "Tuần $w",
                        'start_day' => $start,
                        'end_day' => $end,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // 8. Weekly goals
                foreach ($weekTrackIds as $weekTrackId) {
                    DB::table('weekly_goals')->insert([
                        'week_track_id' => $weekTrackId,
                        'start_day' => now(),
                        'end_day' => now()->addDays(7),
                        'task_des' => 'Làm bài ôn tập chương 1',
                        'status' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // 9. Kế hoạch học tập (class_plans, self_study)
                foreach ($studentIds as $studentId) {
                    foreach ($subjectIds as $subjectId) {
                        foreach ($weekTrackIds as $weekTrackId) {
                            DB::table('class_plans')->insert([
                                'user_id' => $studentId,
                                'subject_id' => $subjectId,
                                'week_track_id' => $weekTrackId,
                                'lesson_learn' => 'Đã học bài 1 và bài 2',
                                'self_assessment' => rand(1, 3),
                                'difficult' => 'Khó hiểu phần đồ thị',
                                'plan_to_improve' => 'Xem lại video bài giảng',
                                'in_solve' => false,
                                'date' => now(),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);

                            DB::table('self_study_plan')->insert([
                                'user_id' => $studentId,
                                'subject_id' => $subjectId,
                                'week_track_id' => $weekTrackId,
                                'lesson_learn' => 'Tự học chương 2',
                                'time_spend' => '2h30',
                                'learning_resource' => 'Sách giáo khoa + youtube',
                                'learning_activities' => 'Ghi chép và làm bài tập',
                                'in_solve' => false,
                                'concentration' => rand(1, 3),
                                'date' => now(),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }
        });
    }
}
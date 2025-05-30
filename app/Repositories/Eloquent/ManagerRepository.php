<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\IManagerRepository;
use App\Models\Semester;
use Carbon\Carbon;

class ManagerRepository implements IManagerRepository
{
    protected $semesterModel;

    public function __construct(Semester $semesterModel)
    {
        $this->semesterModel = $semesterModel;
    }

    public function countWeekByClass(int $classId)
    {
        $start = microtime(true);
        $semester = $this->semesterModel
            ->where('class_id', $classId)
            ->latest('start_date')
            ->first();

        if (!$semester || !$semester->start_date) {
            \Log::warning("No semester or start_date found for class_id: $classId");
            return 0;
        }

        try {
            $startDate = Carbon::parse($semester->start_date);
            $currentDate = Carbon::now('Asia/Ho_Chi_Minh');
            $weeks = $startDate->diffInDays($currentDate) / 7; // Calculate precise weeks (decimal)

            // Apply rounding logic: > 3.3 -> 4, <= 3.3 -> 3
            $roundedWeeks = $weeks > 3.3 ? 4 : 3;

            \Log::info("Weeks calculated for class_id $classId: $weeks (rounded to $roundedWeeks) from $startDate to $currentDate");
            \Log::info('countWeekByClass took ' . (microtime(true) - $start) . ' seconds');
            return $roundedWeeks;
        } catch (\Exception $e) {
            \Log::error("Error calculating weeks for class_id $classId: " . $e->getMessage());
            return 0;
        }
    }
}

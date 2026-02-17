<?php
 namespace App\Services;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\StudentBill;

class RiskAnalyticsService
{
    public function highDebtStudents()
    {
        return StudentBill::where('balance','>',20000)
        ->with('student.user')
        ->orderByDesc('balance')
        ->limit(10)
        ->get();
    }

    public function classesWithoutFeeStructure()
    {
        return  Enrollment::whereDoesntHave('student.bills')
        ->distict('class_id')
        ->count('class_id');
    }

    public function unpublishedExams()
    {
        return Exam::where('is_published', false)->count();
    }

}
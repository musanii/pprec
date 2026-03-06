<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ExamAggregate;
use App\Models\Student;
use App\Models\StudentBill;
use App\Services\RiskAnalyticsService;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(RiskAnalyticsService $service)
    {
        $riskStudents = $service->highDebtStudents();
        $unpublishedExams = $service->unpublishedExams();

        $attendanceRate = round(Attendance::where('status','present')->count() / max(Attendance::count(),1) * 100,2);

        $feeCollectionRate = round((StudentBill::sum('amount') 
        - StudentBill::sum('balance'))
        / max(StudentBill::sum('amount'),1) 
        *100,2 );

        $examMean = round(ExamAggregate::avg('mean_score'),2);
        $atRiskStudents = Student::whereHas('attendances', function($q){
        $q->selectRaw('COUNT(*) as total, SUM(status="present") as present')
        ->groupBy('student_id')
        ->havingRaw('(SUM(status="present") / COUNT(*)) < 0.75');
        })->count();

        return view('admin.dashboard', compact(
            'riskStudents',
            'unpublishedExams',
            'attendanceRate',
            'feeCollectionRate',
            'examMean',
            'atRiskStudents'
            ));
    }
}

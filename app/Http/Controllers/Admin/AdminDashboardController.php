<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Services\RiskAnalyticsService;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(RiskAnalyticsService $service)
    {
        $riskStudents = $service->highDebtStudents();
        $unpublishedExams = $service->unpublishedExams();

        $attendanceRate = Attendance::where('status','present')->count() / max(Attendance::count(),1) * 100;

        return view('admin.dashboard', compact('riskStudents','unpublishedExams','attendanceRate'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RiskAnalyticsService;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(RiskAnalyticsService $service)
    {
        $riskStudents = $service->highDebtStudents();
        $unpublishedExams = $service->unpublishedExams();

        return view('admin.dashboard', compact('riskStudents','unpublishedExams'));
    }
}

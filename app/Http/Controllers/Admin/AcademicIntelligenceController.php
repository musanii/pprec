<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Term;
use App\Services\AcademicsAnalyticsService;
use Illuminate\Http\Request;

class AcademicIntelligenceController extends Controller
{
     public function index(AcademicsAnalyticsService $analytics)
     {
        $overview = $analytics->termOverview();
        $termId = Term::where('is_active', true)->value('id') ;                                                                                                                     
                          

        return view('admin.analytics.academic', [
            'overview' => $overview,
            'classPerformance' => $analytics->classPerformance($termId),
            'subjectPerformance' => $analytics->subjectPerformance($termId),
            'topStudents' => $analytics->topStudents($termId),
            'bottomStudents' => $analytics->bottomStudents($termId),
        ]);
     }
}

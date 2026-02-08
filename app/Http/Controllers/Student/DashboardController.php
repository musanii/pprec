<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Term;

class DashboardController extends Controller
{
    public function index()
    {
       $user = auth()->user();
       $student = $user->student;
       $activeYear = AcademicYear::where('is_active', true)->first();
       $activeTerm = Term::where('is_active', true)->first();
       $enrollment = $student?->activeEnrollment;

        return view('student.dashboard',
            [
                'student'=>$student,
                'enrollment'=>$enrollment,
                'activeYear'=>$activeYear,
                'activeTerm'=>$activeTerm]);
    }
}

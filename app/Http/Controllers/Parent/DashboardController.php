<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $parent = auth()->user()->parentProfile();
        $students = $parent->students->with(['activeEnrollment.schoolClass','activeEnrollment.stream'])->get(); // Assuming a parent has many students

        return view('parent.dashboard', compact('students'));
    }
}

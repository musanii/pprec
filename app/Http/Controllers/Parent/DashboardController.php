<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
{
    $parent = auth()->user()->parentProfile;

    if (!$parent) {
        abort(403);
    }

    $students = $parent->students()
        ->with(['user', 'activeEnrollment.schoolClass', 'activeEnrollment.stream'])
        ->get();

    return view('parent.dashboard', compact('students'));
}
}

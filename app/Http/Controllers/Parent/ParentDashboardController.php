<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParentDashboardController extends Controller
{
   public function index()
{
    $parent = auth()->user()->parentProfile;

    if (!$parent) {
        abort(403);
    }

    // $children = $parent->students()->withCount([
    //     'attendances as present_count'=>function($q){
    //         $q->where('status','present');
    //     },
    //     'attendances as total_count'
    // ])->get();

    $students = $parent->students()
        ->with(['user', 'activeEnrollment.schoolClass', 'activeEnrollment.stream'])
        ->get();

    return view('parent.dashboard', compact('students'));
}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->hasRole('teacher')) {
        return redirect()->route('teacher.dashboard');
    }

    if (auth()->user()->hasRole('student')) {
        return redirect()->route('student.dashboard');
    }

    if (auth()->user()->hasRole('parent')) {
        return redirect()->route('parent.dashboard');
    }

    abort(403);
}

}

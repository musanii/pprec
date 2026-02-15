<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
public function index(){
    $parent = auth()->user()->parentProfile;

    $students = $parent->students()
    ->with([
        'user',
        'bills.payments',
        'activeEnrollment.schoolClass'
    ])->get();

    return view('parent.finance.index', compact('students'));
}
}

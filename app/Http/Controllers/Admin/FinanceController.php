<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentBill;
use App\Models\Term;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index(Request $request){
        $year = AcademicYear::where('is_active', true)->first();
        $term = Term::where('is_active', true)->first();

        $billsQuery = StudentBill::with([
            'student.user',
            'student.activeEnrollment.schoolClass',
            'feeStructure'
        ])->when($year, fn($q)=>
        $q->whereHas('feeStructure', fn($qq)=>
        $qq->where('academic_year_id', $year->id)
        )
        )->when($term, fn($q)=>
        $q->whereHas('feeStructure', fn($qq)=>
        $qq->where('term_id', $term->id)
        )
        );

        if($request->class_id){
            $billsQuery->whereHas('student.activeEnrollment', function($q   ) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }

         $totalBilled = (clone $billsQuery)->sum('amount');
        $totalBalance = (clone $billsQuery)->sum('balance');
        $totalCollected = $totalBilled - $totalBalance;

        $studentsWithDebt = (clone $billsQuery)
        ->where('balance', '>', 0)
        ->distinct('student_id')
        ->count('student_id');
        $bills = $billsQuery->latest()->paginate(20)->withQueryString();
        $classes = SchoolClass::orderBy('level')->get();

        return view('admin.finance.index', compact(
         'year',
            'term',
            'totalBilled',
            'totalBalance',
            'totalCollected',
            'studentsWithDebt',
            'bills',
            'classes'
        ));
    }
}

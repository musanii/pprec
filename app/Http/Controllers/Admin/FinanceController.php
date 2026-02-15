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

        $topDebtors = (clone $billsQuery)
        ->where('balance', '>', 0)
        ->orderByDesc('balance')
        ->limit(5)
        ->get();

        $classBreakdown = (clone $billsQuery)
        ->selectRaw('
        student_id,
        SUM(balance) as total_balance')
        ->where('balance', '>', 0)
        ->groupBy('student_id')
        ->get();

        $classOutstanding = (clone $billsQuery)
        ->selectRaw('
        classes.name as class_name,
        SUM(student_bills.balance) as total_balance')
        ->join('students', 'student_bills.student_id', '=', 'students.id')
        ->join('enrollments', function($join) {
            $join->on('enrollments.student_id', '=', 'students.id')
                 ->where('enrollments.is_active', true);
        })
        ->join('classes', 'enrollments.class_id', '=', 'classes.id')
        ->groupBy('classes.name')
        ->get();


        $bills = $billsQuery->latest()->paginate(20)->withQueryString();
        $classes = SchoolClass::orderBy('level')->get();

        return view('admin.finance.index', compact(
         'year',
            'term',
            'totalBilled',
            'totalBalance',
            'totalCollected',
            'studentsWithDebt',
            'topDebtors',
            'classOutstanding',
            'bills',
            'classes'
        ));
    }
}

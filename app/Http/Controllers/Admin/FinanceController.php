<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Student;
use App\Models\StudentBill;
use App\Models\Term;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index(Request $request){
        $year = AcademicYear::where('is_active', true)->first();
        $term = Term::where('is_active', true)->first();

        $billsQuery = StudentBill::query()
        ->whereHas('feeStructure', function($q) use ($year, $term){
           if($year) $q->where('academic_year_id', $year->id);
           if($term) $q->where('term_id', $term->id);
        });

        $totalBilled = $billsQuery->sum('amount');
        $totalBalance = $billsQuery->sum('balance');
        $totalCollected = $totalBilled - $totalBalance;

        $studentsWithDebt = Student::whereHas('bills', function($q) {
            $q->where('balance', '>', 0);
        })->count();

        return view('admin.finance.index', [
            'year'=>$year,
            'term'=>$term,
            'totalBilled'=>$totalBilled,
            'totalBalance'=>$totalBalance,
            'totalCollected'=>$totalCollected,
            'studentsWithDebt'=>$studentsWithDebt
        ]);
    }
}

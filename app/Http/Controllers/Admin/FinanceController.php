<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentBillsExport;
use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Payment;
use App\Models\SchoolClass;
use App\Models\StudentBill;
use App\Models\Term;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $year = AcademicYear::where('is_active', true)->first();
        $term = Term::where('is_active', true)->first();

        $billsQuery = StudentBill::with([
            'student.user',
            'student.activeEnrollment.schoolClass',
            'feeStructure',
        ])->when($year, fn ($q) => $q->whereHas('feeStructure', fn ($qq) => $qq->where('academic_year_id', $year->id)
        )
        )->when($term, fn ($q) => $q->whereHas('feeStructure', fn ($qq) => $qq->where('term_id', $term->id)
        )
        );

        if ($request->class_id) {
            $billsQuery->whereHas('student.activeEnrollment', function ($q) use ($request) {
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
            ->join('enrollments', function ($join) {
                $join->on('enrollments.student_id', '=', 'students.id')
                    ->where('enrollments.is_active', true);
            })
            ->join('classes', 'enrollments.class_id', '=', 'classes.id')
            ->groupBy('classes.name')
            ->get();

        $bills = $billsQuery->latest()->paginate(20)->withQueryString();
        $classes = SchoolClass::orderBy('level')->get();

        $monthlyCollections = Payment::selectRaw("
        DATE_FORMAT(created_at, '%Y-%m') as month,
        SUM(amount) as total
        ")->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $months = collect(range(1, 12))->map(function ($m) {
            return now()->startOfYear()->addMonths($m - 1)->format('Y-m');
        });

        $monthlyData = $months->map(fn ($m) => $monthlyCollections[$m] ?? 0);

        $collectionRate = $totalBilled > 0 ? round(($totalCollected / $totalBilled) * 100, 2): 0;

        $topDebtClasses = StudentBill::selectRaw("
        classes.name as class_name,
        SUM(balance) as total_debt
            ")
            ->join('students', 'student_bills.student_id', '=', 'students.id')
            ->join('enrollments', function($join){
                $join->on('students.id', '=', 'enrollments.student_id')
                    ->where('enrollments.is_active', true);
            })
            ->join('classes', 'enrollments.class_id', '=', 'classes.id')
            ->groupBy('class_name')
            ->orderByDesc('total_debt')
            ->limit(5)
            ->get();


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
            'classes',
            'monthlyData',
            'collectionRate',
            'topDebtClasses'
        ));
    }

    public function exportExcel(Request $request)
    {
        $year = AcademicYear::where('is_active', true)->first();
        $term = Term::where('is_active', true)->first();

        $bills = StudentBill::with([
            'student.user',
            'student.activeEnrollment.schoolClass',
            'feeStructure',
        ])->get();

        return Excel::download(new StudentBillsExport($bills), 'student_bills.xlsx');
    }

    public function exportPdf()
    {
        $year = AcademicYear::where('is_active', true)->first();
        $term = Term::where('is_active', true)->first();

        $bills = StudentBill::with([
            'student.user',
            'student.activeEnrollment.schoolClass',
            'feeStructure',
        ])->get();

        $pdf = Pdf::loadView('admin.finance.exports.pdf', ['bills' => $bills, 'year' => $year, 'term' => $term]);

        return $pdf->download('finance-report.pdf');
    }
}

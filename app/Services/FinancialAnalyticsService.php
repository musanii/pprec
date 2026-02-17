<?php

namespace App\Services;

use App\Models\StudentBill;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinancialAnalyticsService
{
    public function overview()
    {
        $totalBilled = StudentBill::sum('amount');
        $totalBalance = StudentBill::sum('balance');
        $totalCollected = $totalBilled - $totalBalance;

        $collectionRate = $totalBilled > 0
            ? round(($totalCollected / $totalBilled) * 100, 2)
            : 0;

        return [
            'totalBilled' => $totalBilled,
            'totalCollected' => $totalCollected,
            'totalBalance' => $totalBalance,
            'collectionRate' => $collectionRate,
        ];
    }

    public function topDebtClasses()
    {
        return StudentBill::query()
            ->join('students', 'student_bills.student_id', '=', 'students.id')
            ->join('enrollments', function ($join) {
                $join->on('enrollments.student_id', '=', 'students.id')
                     ->where('enrollments.is_active', true);
            })
            ->join('classes', 'enrollments.class_id', '=', 'classes.id')
            ->groupBy('classes.id', 'classes.name')
            ->select(
                'classes.name as class_name',
                DB::raw('SUM(student_bills.balance) as total_debt')
            )
            ->orderByDesc('total_debt')
            ->limit(5)
            ->get();
    }

    public function monthlyRevenue()
    {
        return Payment::query()
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    public function chronicDefaulters()
    {
        return StudentBill::query()
            ->where('balance', '>', 0)
            ->orderByDesc('balance')
            ->with('student.user')
            ->limit(10)
            ->get();
    }
}

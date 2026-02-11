<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Term;
use App\Services\BillingService;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function generate(AcademicYear $year, Term $term, BillingService $billingService)
    {
        $billingService->generateBillsForTerm($year, $term);

        return redirect()->back()->with('success', 'Bills generated successfully for the term.');
    }
}

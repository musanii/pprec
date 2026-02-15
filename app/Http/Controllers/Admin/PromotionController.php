<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Enrollment;
use App\Models\SchoolClass;
use App\Models\Term;
use App\Services\FinanceGuardService;
use App\Services\PromotionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PromotionController extends Controller
{

public function preview(Request $request, AcademicYear $academicYear, PromotionService $service)
{


    $request->validate([
        'action' => ['required', 'in:promote,repeat,graduate'],
    ]);

    
    try {
        $summary = $service->preview($academicYear, $request->action);
    } catch (ValidationException $e) {
        return back()
            ->withErrors($e->errors())
            ->withInput();
    }

    return response()->json($summary);
}

    public function store( Request $request, AcademicYear $academicYear, PromotionService $service, FinanceGuardService $financeGuard){

    
         $request->validate([
            'action'=>['required','in:promote,repeat']
        ]);

        $term = Term::where('is_active', true)->first();
        if($financeGuard->hasOutstandingBalances($academicYear, $term)){
            return back()->with('error','Promotion blocked. Cannot process promotions while there are outstanding balances for the current term.');
        }

       try {
        $service->promote($academicYear, $request->action);
    } catch (ValidationException $e) {
        return back()
            ->withErrors($e->errors())
            ->withInput();
    }

        
    
        
        return back()->with('success','Promotions processed successfully.');
    }
}

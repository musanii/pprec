<?php
namespace App\Services;

use App\Models\AcademicYear;
use App\Models\StudentBill;
use App\Models\Term;

class FinanceGuardService
{
    public function hasOutstandingBalances(?AcademicYear $year, ? Term $term): bool
    {
      if(!$year || !$term){
        return false; // No specific year or term provided, so we can't check for balances
      }

      return StudentBill::whereHas('feeStructure',function($q) use($year, $term){
        $q->where('academic_year_id', $year->id)
          ->where('term_id', $term->id);
      })->where('balance','>',0)->exists();
    }

    public function totalOutstanding(?AcademicYear $year, ? Term $term): float
    {
        if(!$year || !$term){
            return 0.0; // No specific year or term provided, so we can't calculate balances
          }

          return StudentBill::whereHas('feesStructure',function($q) use($year, $term){
            $q->where('academic_year_id', $year->id)
              ->where('term_id', $term->id);
          })->sum('balance');
    }
}
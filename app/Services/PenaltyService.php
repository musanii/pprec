<?php

namespace App\Services;

use App\Models\StudentBill;
use Carbon\Carbon;

class PenaltyService
{
    public function  applyLatePenalties()
    {
        $today = Carbon::today();

        $bills = StudentBill::query()
        ->where('balance', '>', 0)
        ->whereNotNull('due_date')
        ->whereNull('penalty_applied_at')
        ->get();

        $applied = 0;

        foreach($bills as $bill){
            $graceEnd = Carbon::parse($bill->due_date)->addDays($bill->grace_days);

            if($today->greaterThan($graceEnd)){
                $penalty = $this->calculatePenalty($bill);

                $bill->update([
                    'penalty_amount' => $penalty,
                    'penalty_applied_at' => now(),
                ]);

                $bill->refreshBalance();
                $applied++;
            }

        }
        return $applied;
    }

    protected function calculatePenalty(StudentBill $bill)
    {
        if(!$bill->penalty_type || !$bill->penalty_value){
            return 0;
        }

       if($bill->penalty_type ==='percentage'){
        return ($bill->amount * $bill->penalty_value) / 100;
       }
       return $bill->penalty_value;
    }
}
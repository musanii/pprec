<?php
namespace App\Services;

use App\Models\Payment;
use App\Models\Student;
use App\Models\StudentBill;
use Illuminate\Support\Facades\DB;


class PaymentAllocationService
{
    public function allocatePayment(Student $student, $amount, string $strategy = 'oldest')
    {

    DB::transaction(function() use ($student, $amount, $strategy) {
        $bills = $this->getEligibleBills($student, $strategy);

        foreach ($bills as $bill) {
            if ($amount <= 0) {
                break;
            }

            $allocation = min($amount, $bill->balance);

            // Create payment record
       Payment::create([
            'student_id' => $student->id,
            'student_bill_id' => $bill->id,
            'amount' => $allocation,
            'method' => $data['method'] ?? 'manual',
            'reference' => $data['reference'] ?? null,
            'recorded_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

            // Refresh bill status
            $bill->refreshBalance();

            // Decrease remaining amount
            $amount -= $allocation;
        }
        
    });
    }


    public function getEligibleBills(Student $student, string $strategy)
    {
        $query = StudentBill::query()
            ->where('student_id', $student->id)
            ->where('balance', '>', 0);

            if($strategy ==='highest'){
                return $query->orderByDesc('balance')->get();
            }
        // Default to oldest if strategy is unrecognized
        return $query->orderBy('created_at')->get();
    }
}
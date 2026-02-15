<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePaymentRequest;
use App\Models\Payment;
use App\Models\StudentBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
public function store(StorePaymentRequest $request, StudentBill $bill = null)
{
    $data = $request->validated();

    DB::transaction(function () use ($data, $bill) {

    if($this->ensureYearNotLocked($bill ?? StudentBill::find($data['student_bill_id']))) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'student_bill_id' => 'The academic year for this bill is locked.'
        ]);
    }

        if ($bill) {
            // === Manual Bill Payment Mode ===

            if ($data['amount'] > $bill->balance) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'amount' => 'Payment amount cannot exceed outstanding balance.'
                ]);
            }

            Payment::create([
                'student_bill_id' => $bill->id,
                'student_id'      => $bill->student_id,
                'amount'          => $data['amount'],
                'method'          => $data['method'],
                'reference'       => $data['reference'],
                'recorded_by'     => auth()->id(),
                'updated_by'      => auth()->id(),
            ]);

            $bill->refreshBalance();

        } else {
            // === Auto Allocation Mode ===

            $student = \App\Models\Student::findOrFail($data['student_id']);

            app(\App\Services\PaymentAllocationService::class)
                ->allocate(
                    $student,
                    $data['amount'],
                    $data['strategy'] ?? 'oldest'
                );
        }

    });

    return back()->with('success', 'Payment recorded successfully.');
}


    public function receipt(Payment $payment)
    {
        $payment->load([
            'student.user',
            'bill.feeStructure',
            'recorder'
        ]);

        return view('admin.finance.receipt', compact('payment'));
    }

    protected function ensureYearNotLocked($studentBill)
{
    $year = $studentBill->feeStructure->academicYear;

    if ($year?->is_locked) {
        abort(403, 'This academic year is locked.');
    }
}


}

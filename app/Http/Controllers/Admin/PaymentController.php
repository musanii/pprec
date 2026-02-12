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
    public function Store(StorePaymentRequest $request, StudentBill $bill)
    {


    $request->validated();
    if($request->amount > $bill->balance){
        return back()->withErrors(['amount' => 'Payment amount cannot exceed the outstanding balance.']);
    }

    DB::transaction(function()use ($request, $bill){
         Payment::create([
                'student_bill_id' => $bill->id,
                'student_id'      => $bill->student_id,
                'amount'          => $request->amount,
                'method'          => $request->method,
                'reference'       => $request->reference,
                'recorded_by'     => auth()->id(),
            ]);

            $bill->decrement('balance', $request->amount);
    });
    return back()->with('success', 'Payment recorded successfully.');

}
}

<?php

namespace App\Exports;

use App\Models\StudentBill;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class StudentBillsExport implements FromView
{

    protected  $bills;
    public function __construct($bills)
    {
        $this->bills = $bills;
    }

    public function view(): View
    {
        
        return view('admin.finance.exports.bills', [
            'bills' => $this->bills
        ]);
    }
}
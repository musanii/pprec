<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentBill extends Model
{
    protected $fillable = [
        'student_id',
        'fee_structure_id',
        'amount',
        'balance',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feeStructure()
    {
        return $this->belongsTo(FeeStructure::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

public function refreshBalance(): void
{
    $paid = $this->payments()->sum('amount');

    $total = $this->amount + $this->penalty_amount;

    $this->balance = $total - $paid;

    $this->save();
}


    public function scopeUnpaid($query)
    {
        return $query->where('balance', '>', 0);
    }
}

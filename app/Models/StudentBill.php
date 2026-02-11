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
}

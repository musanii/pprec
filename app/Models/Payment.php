<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'student_bill_id',
        'student_id',
        'amount',
        'method',
        'reference',
        'recorded_by',
    ];

    public function bill()
    {
        return $this->belongsTo(StudentBill::class,'student_bill_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}

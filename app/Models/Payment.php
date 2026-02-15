<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'student_bill_id',
        'student_id',
        'amount',
        'method',
        'reference',
        'recorded_by',
        'updated_by',
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

    public function isLocked(): bool
{
    return $this->studentBill->feeStructure->academicYear->is_locked;
}

}

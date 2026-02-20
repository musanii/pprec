<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolPeriod extends Model
{
    protected $fillable = [
        'name',
        'period_number',
        'start_time',
        'end_time',
        'is_break',
        'is_active',

    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_break' => 'boolean',
        'is_active' => 'boolean',

    ];

    public function timeTableSlots()
    {
        return $this->hasMany(TimeTableSlot::class);
    }
}

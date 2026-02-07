<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable =[
        'name',
        'code',
        'is_core',
        'is_active'

    ];

    public function classes()
{
    return $this->belongsToMany(
        SchoolClass::class,
        'class_subject',          // 👈 explicit table
        'subject_id',
        'class_id'
    )
    ->withPivot('is_compulsory')
    ->withTimestamps();
}

}

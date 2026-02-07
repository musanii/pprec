<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable =[
        'user_id',
        'staff_no',
        'phone',
        'gender',
        'is_active',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}

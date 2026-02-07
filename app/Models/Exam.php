<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable=[
        'term_id',
        'name',
        'start_date',
        'end_date',
        'is_published',
    ];

     protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_published' => 'boolean',
    ];


    public function term(){
        return $this->belongsTo(Term::class);
    }
}

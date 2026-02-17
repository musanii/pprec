<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'term_id',
        'name',
        'start_date',
        'end_date',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'published_at'=>'date',
        'is_published' => 'boolean',
    ];

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function results()
    {
        return $this->hasMany(ExamResult::class);
    }

    public function aggregates()
    {
        return $this->hasMany(ExamAggregate::class);
    }
}

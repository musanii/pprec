<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Student;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function show(Student $student){
        abort_unless($student->parent_id === auth()->user()->parentProfile()->id,403);

        $exams = Exam::query()
        ->whereHas('marks', fn($q)=>$q->where('student_id', $student->id))
        ->with(['marks' => fn($q)=>$q->where('student_id', $student->id)])->with(['subject'])->latest()->get();

        return view('parent.results.show', compact('student','exams'));

    }
}

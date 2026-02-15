<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Student;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function show(Student $student)
{
    $user = auth()->user();
    $parent = $user->parentProfile;

    abort_if(!$parent, 403);

    abort_unless($student->parent_id === $parent->id, 403);

    $exams = Exam::query()
        ->whereHas('results', function ($q) use ($student) {
            $q->where('student_id', $student->id);
        })
        ->with([
            'results' => function ($q) use ($student) {
                $q->where('student_id', $student->id);
            },
            'results.subject'
        ])
        ->latest()
        ->get();

    return view('parent.results.show', compact('student', 'exams'));
}

}

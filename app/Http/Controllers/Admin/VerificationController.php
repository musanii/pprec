<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamAggregate;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function  verify(string $hash)
    {
        $record = ExamAggregate::query()
        ->with([
            'student.user',
            'exam.term.academicYear'
        ])
        ->where('result_hash', $hash)
        ->firstOrFail();

        return view('admin.verification.show', compact('record'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransferStudentRequest;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentTransferController extends Controller
{
    public function store(TransferStudentRequest $request, Student $student, StudentService $studentService){

    $data = $request->validated();
    $studentService->enroll($student,$data['class_id'],$data['stream_id'] ?? null);
    return redirect()
    ->route('admin.students.show',$student)
    ->with('success','Student transfered successfully');
    }
}

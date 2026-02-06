<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateStudentStatusRequest;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StudentStatusController extends Controller
{
    public function update(UpdateStudentStatusRequest $request, Student $student, StudentService $studentService){


    
    try{
        $studentService->changeStatus($student, $request->validated()['status']);
        return back()->with('success','Student status updated.');
    }catch(ValidationException $e){
        return back()
        ->withErrors($e->errors())
        ->with('error','Status update failed. Please check requirements');
    }
    }
}

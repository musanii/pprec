<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Services\GradingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamMarkController extends Controller
{
    public function edit(Exam $exam, Request $request){
        $classId = $request->integer('class_id');
        $subjectId= (int)$request->input('subject_id');

        $students = collect();

        if($classId && $subjectId){
            $students = Enrollment::with('student.user')
            ->where('class_id',$classId)
            ->where('is_active', true)
            ->get()
            ->map(fn ($en)=> $en->student);

        }
        return view('admin.exams.marks',[
            'exam'=>$exam,
            'classes'=>SchoolClass::orderBy('level')->get(),
            'subjects'=>Subject::orderBy('name')->get(),
            'students'=>$students,
            'classId'=>$classId,
            'subjectId'=>$subjectId,
        ]);
    }

    public function update(Exam $exam, Request $request,GradingService $grading){
        $data=$request->validate([
            'class_id' => ['required','exists:classes,id'],
            'subject_id' => ['required','exists:subjects,id'],
            'marks' => ['required','array'],
        ]);
    


        DB::transaction(function() use($data,$exam,$grading){
            foreach($data['marks'] as $studentId=>$mark){
                if($mark === null || $mark ==='') continue;
                $grade = $grading->grade((float) $mark);

                ExamResult::updateOrCreate(
                    [
                        'exam_id'=>$exam->id,
                        'student_id'=>$studentId,
                        'subject_id'=>$data['subject_id'],
                        'class_id'=>$data['class_id'],
                    ],
                    [
                        'marks'=>$mark,
                        'grade'=>$grade,
                        'remarks'=>$grading->remark($grade),
                    ]
                );
            }

        });

        return back()->with('success','Marks saved successfully.');
    }
}

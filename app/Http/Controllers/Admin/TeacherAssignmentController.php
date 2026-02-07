<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherAssignmentController extends Controller
{
    public function edit(Teacher $teacher){
        $classes =SchoolClass::orderBy('level')->get();
        $subjects = Subject::where('is_active',true)->orderBy('name')->get();

        $assigned = DB::table('teacher_subject_class')
        ->where('teacher_id',$teacher->id)
        ->get()
        ->groupBy('class_id')
        ->map(fn($rows)=>$rows->pluck('subject_id')->toArray())
        ->toArray();

        return view('admin.teachers.assignments',compact(
            'teacher',
            'classes',
            'subjects',
            'assigned'
        ));

        

    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'assignments'=>['array'],
            'assignments.*'=>['array'],
            'assignments.*.*'=>['exists:subjects,id'],
        ]);


        DB::transaction(function() use($teacher, $data){
            DB::table('teacher_subject_class')
            ->where('teacher_id',$teacher->id)
            ->delete();
            foreach ($data['assignments'] ?? [] as $classId => $subjects) {
                foreach($subjects as $subjectId){
                    DB::table('teacher_subject_class')->insert([
                        'teacher_id'=>$teacher->id,
                        'class_id'=>$classId,
                        'subject_id'=>$subjectId,
                        'created_at'=>now(),
                        'updated_at'=>now(),
                    ]);
                }
            }

        });
        return redirect()
        ->route('admin.teachers.assignments.edit',$teacher)
        ->with('success','Teaching assignments updated');
    }
}

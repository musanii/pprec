<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class ClassSubjectController extends Controller
{
public function edit(SchoolClass $class){
    $subjects = Subject::where('is_active',true)->orderBy('name')->get();
    $assigned = $class->subjects->mapWithKeys(fn($s)=>[
        $s->id =>['is_compulsory'=>$s->pivot->is_compulsory],
    ])->toArray();

    return view('admin.classes.subjects', compact('class', 'subjects', 'assigned'));

}

public function update(REquest $request, SchoolClass $class)
{
    $data = $request->validate([
        'subjects'=>['array'],
        'subject.*.is_compulsory'=>'boolean',
    ]);

    $sync = [];

    foreach($data['subjects'] ??[] as $subjectId=>$meta){
        $sync[$subjectId] = [
            'is_compulsory'=>$meta['is_compulsory'] ?? false,
        ];
    }

    $class->subjects()->sync($sync);

    return redirect()
    ->route('admin.classes.subjects.edit',$class)
    ->with('success','Subjects updated for class.');
}
}

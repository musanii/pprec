<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTimeTableRequest;
use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\SchoolPeriod;
use App\Models\Stream;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Term;
use App\Models\TimeTableSlot;
use App\Services\TimetableService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TimetableController extends Controller
{
    public function index(Request $request)
    {

  
        $year = AcademicYear::where('is_active', true)->first();
        $term = Term::where('is_active', true)->first();

        $classId = $request->class_id;
        $streamId = $request->stream_id;

        $class = SchoolClass::find($classId);
        $hasStreams = $class ? $class->streams()->exists():false;

        $classes = SchoolClass::orderBy('level')->get();
        // $streams = Stream::orderBy('name')->get();
        $periods = SchoolPeriod::where('is_active', true)->orderBy('period_number')->get();
        $subjects = Subject::where('is_active', true)->orderBy('name')->get();
        $teachers = Teacher::with('user')->orderBy('id')->get();

        $slots = collect();

        $streams = collect();
        if($classId)
            {
                $streams = Stream::where('class_id',$classId)->orderBy('name')->get();
            }

      if ($classId && $term) {

    if ($streamId) {

        $slots = TimeTableSlot::with(['subject','teacher','schoolPeriod'])
            ->where('class_id', $classId)
            ->where('term_id', $term->id)
            ->where('stream_id', $streamId)
            ->get()
            ->groupBy(['school_period_id','day_of_week']);

    } else {

        // Load all streams separately
        $slots = TimeTableSlot::with(['subject','teacher','schoolPeriod'])
            ->where('class_id', $classId)
            ->where('term_id', $term->id)
            ->get()
            ->groupBy(['stream_id','school_period_id','day_of_week']);
    }
}

        return view('admin.timetable.index', compact(
            'year',
            'term',
            'classes',
            'streams',
            'periods',
            'slots',
            'classId',
            'streamId',
            'subjects',
            'teachers',
            'hasStreams',

        ));

    }

    public function store(StoreTimeTableRequest $request, TimetableService $service)
    {

   
        $data = $request->validated();

        if($request->hasStreams && !$data['stream_id'])
            {
                return back()->withErrors([
                    'stream_id'=>'Stream selection is required.'
                ]);
            }

        try {
            $service->assign($data);

            return back()->with('success', 'Slot assigned successfully.');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        }

    }

    public function  update(StoreTimeTableRequest $request, TimeTableSlot $timetable, TimetableService $service)
    {
        $data = $request->validated();
        try {
            $service->assign($data,$timetable);
            return back()->with('success','Slot updated.');
        } catch (ValidationException $e) {
            return back()
            ->withErrors($e->errors())
            ->withInput();
        }
        

    }

    public function destroy(TimeTableSlot $timetable)
    {


 
        $timetable->delete();
        return back()->with('success', 'Slot removed.');
    }
 

}
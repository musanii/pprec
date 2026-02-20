<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTimeTableRequest;
use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\SchoolPeriod;
use App\Models\Stream;
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

        $classes = SchoolClass::orderBy('level')->get();
        $streams = Stream::orderBy('name')->get();
        $periods = SchoolPeriod::where('is_active', true)->orderBy('period_number')->get();

        $slots = collect();

        if($classId && $term) 
            {
                $slots = TimeTableSlot::with(['subject','teacher','period'])
                ->where('class_id', $classId)
                ->where('term_id', $term->id)
                ->when($streamId, fn($q) =>$q->where('stream_id', $streamId))
                ->get()
                ->groupBy(['school_period_id','day_of_week']);
            }

            return view('admin.timetable.index',compact(
                'year',
                'term',
                'classes',
                'streams',
                'periods',
                'slots',
                'classId',
                'streamId'
            ));



    }
    public function store(StoreTimeTableRequest $request, TimetableService $service)
    {
        $data = $request->validated();
         try {
         $service->assign($data);
        return back()->with('success', 'Slot assigned');
    } catch (ValidationException $e) {
        return back()
            ->withErrors($e->errors())
            ->withInput();
    }

  
    }
}

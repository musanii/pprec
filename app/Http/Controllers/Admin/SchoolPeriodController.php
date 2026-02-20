<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSchoolPeriodRequest;
use App\Models\SchoolPeriod;
use Illuminate\Http\Request;

class SchoolPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periods = SchoolPeriod::orderBy('period_number')->paginate(20);
        return view('admin.school-periods.index', compact('periods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.school-periods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchoolPeriodRequest $request)
    {
        $data = $request->validated();

        SchoolPeriod::create([
            ...$data,
            'is_break'=>$request->boolean('is_break'),
        ]);

        return redirect()
        ->route('admin.school-periods.index')
        ->with('success','Period created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolPeriod $schoolPeriod)
    {
        return view('admin.school-periods.edit', compact('schoolPeriod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolPeriod $schoolPeriod)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'period_number' => [
                'required',
                'integer',
                'unique:school_periods,period_number,' . $schoolPeriod->id
            ],
            'start_time' => ['required'],
            'end_time' => ['required', 'after:start_time'],
            'is_break' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $schoolPeriod->update([
            ...$data,
            'is_break'=>$request->boolean('is_break'),
            'is_active'=>$request->boolean('is_active')
        ]);

        return redirect()
        ->route('admin.school-periods.index')
        ->with('success','PEriod updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolPeriod $schoolPeriod)
    {
        if($schoolPeriod->timeTableSlots()->exists())
            {
                return back()->with('error','Cannot delete period in use.');
            }

            $schoolPeriod->delete();
            return back()->with('success', 'Period deleted.');
    }
}

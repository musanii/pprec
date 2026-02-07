<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSchoolRequest;
use App\Http\Requests\Admin\UpdateSchoolClassRequest;
use App\Http\Requests\Admin\UpdateSchoolRequest;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $classes = SchoolClass::query()
        ->when($request->filled('is_active'), fn($q) => $q->where('is_active', (bool)$request->input('is_active')))

        ->withCount('streams')
        ->orderBy('level')
        ->paginate(20);
        return view('admin.academics.classes.index',compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.academics.classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchoolRequest $request)
    {
        SchoolClass::create([
            'name'=>$request->name,
            'level'=>$request->level,
            'is_active'=>(bool)($request->boolean('is_active',true))
        ]);
         return redirect()->route('admin.classes.index')->with('success', 'Class created.');
    }

   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolClass $class)
    {
        return view('admin.academics.classes.edit', compact('class'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateSchoolClassRequest $request, SchoolClass $class)
    {
        $class->update([
            'name' => $request->name,
            'level' => $request->level,
            'is_active' => (bool)($request->boolean('is_active', true)),
        ]);

        return redirect()->route('admin.classes.index')->with('success', 'Class updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

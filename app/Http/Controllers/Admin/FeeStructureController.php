<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFeeStructureRequest;
use App\Http\Requests\Admin\UpdateFeeStructureRequest;
use App\Models\AcademicYear;
use App\Models\FeeStructure;
use App\Models\SchoolClass;
use App\Models\Term;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $fees = FeeStructure::with([
        'academicYear',
        'term',
        'schoolClass',
    ])
    ->when($request->q, fn ($q) =>
        $q->where('name', 'like', '%'.$request->q.'%')
    )
    ->when($request->is_active !== null && $request->is_active !== '', fn ($q) =>
        $q->where('is_active', $request->is_active)
    )
    ->latest()
    ->paginate(15)
    ->withQueryString();

    return view('admin.fee_structures.index', compact('fees'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'admin.fee_structures.create',
            [
                'years' => AcademicYear::all(),
                'terms' =>Term::all(),
                'classes' => SchoolClass::all(),
            ]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeeStructureRequest $request)
    {
        $data = $request->validated();
        FeeStructure::create($data);
        return redirect()->route('admin.fee-structures.index')->with('success', 'Fee structure created successfully.');

    }

 
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeeStructure $feeStructure)
    {
        return view('admin.fee_structures.edit',[
            'feeStructure' => $feeStructure,
            'years' => AcademicYear::all(),
            'terms' =>Term::all(),
            'classes' => SchoolClass::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeeStructureRequest $request, FeeStructure $feeStructure)
    {
        $data = $request->validated();

        $feeStructure->update($data);
        return redirect()->route('admin.fee-structures.index')->with('success', 'Fee structure updated successfully.');
    }

   
    public function toggle(FeeStructure $feeStructure)
     {
        
     $feeStructure->update(['active' => !$feeStructure->active]);

        return redirect()->route('admin.fee-structures.index')->with('success', 'Fee structure status updated successfully.');
     }  
    
}

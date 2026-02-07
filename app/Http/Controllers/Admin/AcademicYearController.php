<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAcademicYearRequest;
use App\Http\Requests\Admin\UpdateAcademicYearRequest;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $isActive = $request->input('is_active', '');

        $years = AcademicYear::query()
            ->when($q, fn ($query) => $query->where('name', 'like', "%{$q}"))
            ->when($isActive !== '', fn ($query) => $query->where('is_active', (bool) $isActive))
            ->orderByDesc('start_date')
            ->paginate(20)
            ->withQueryString();

        return view('admin.academics.years.index', compact('years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.academics.years.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcademicYearRequest $request)
    {
        $data = $request->validated();
        DB::transaction(function () use ($data) {
            $makeActive = (bool) ($data['is_active'] ?? false);
            if ($makeActive) {
                AcademicYear::where('is_active', true)->update(['is_active' => false]);
            }
            AcademicYear::create([
                'name' => $data['name'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'is_active' => $makeActive,
            ]);
        });

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicYear $academicYear)
    {
          return view('admin.academics.years.edit', ['year' => $academicYear]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAcademicYearRequest $request,AcademicYear $academicYear)
    {
        $data = $request->validated();

        DB::transaction(function () use ($academicYear, $data) {
            $makeActive = (bool)($data['is_active'] ?? false);

            if ($makeActive) {
                AcademicYear::where('is_active', true)->where('id', '!=', $academicYear->id)->update(['is_active' => false]);
            }

            $academicYear->update([
                'name' => $data['name'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'is_active' => $makeActive,
            ]);
        });

        return redirect()->route('admin.academics.years.index')->with('success', 'Academic year updated.');
    }

 

    public function activate(AcademicYear $academic_year, Request $request)
{
    DB::transaction(function () use ($academic_year) {
        AcademicYear::where('is_active', true)->update(['is_active' => false]);
        $academic_year->update(['is_active' => true]);
    });

    $redirect = $request->input('_redirect') ?: route('admin.academic-years.index');

    return redirect($redirect)->with('success', "Academic year '{$academic_year->name}' is now active.");
}

}

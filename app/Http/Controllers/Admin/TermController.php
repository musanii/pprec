<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateTermRequest;
use App\Models\AcademicYear;
use App\Models\Term;
use App\Services\FinanceGuardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $yearId = $request->integer('academic_year_id') ?: null;
        $isActive = $request->input('is_active', '');

        $terms = Term::query()
            ->with('academicYear')
            ->when($q, fn($qry) => $qry->where('name', 'like', "%{$q}%"))
            ->when($yearId, fn($qry) => $qry->where('academic_year_id', $yearId))
            ->when($isActive !== '', fn($qry) => $qry->where('is_active', (bool)$isActive))
            ->orderByDesc('start_date')
            ->paginate(20)
            ->withQueryString();

        $years = AcademicYear::orderByDesc('start_date')->get();

        return view('admin.academics.terms.index', compact('terms', 'years', 'yearId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $years = AcademicYear::orderByDesc('start_date')->get();
        return view('admin.academics.terms.create', compact('years'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $makeActive = (bool)($data['is_active'] ?? false);

            if ($makeActive) {
                // Activate its academic year too, then ensure only one active term.
                AcademicYear::where('is_active', true)->update(['is_active' => false]);
                AcademicYear::where('id', $data['academic_year_id'])->update(['is_active' => true]);

                Term::where('is_active', true)->update(['is_active' => false]);
            }

            Term::create([
                'academic_year_id' => $data['academic_year_id'],
                'name' => $data['name'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'is_active' => $makeActive,
            ]);
        });

        return redirect()->route('admin.terms.index')->with('success', 'Term created.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Term $term)
    {
        $years = AcademicYear::orderByDesc('start_date')->get();
        return view('admin.academics.terms.edit', compact('term', 'years'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTermRequest $request, Term $term)
    {
        $data = $request->validated();

        DB::transaction(function () use ($term, $data) {
            $makeActive = (bool)($data['is_active'] ?? false);

            if ($makeActive) {
                AcademicYear::where('is_active', true)->update(['is_active' => false]);
                AcademicYear::where('id', $data['academic_year_id'])->update(['is_active' => true]);

                Term::where('is_active', true)->where('id', '!=', $term->id)->update(['is_active' => false]);
            }

            $term->update([
                'academic_year_id' => $data['academic_year_id'],
                'name' => $data['name'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'is_active' => $makeActive,
            ]);
        });

        return redirect()->route('admin.terms.index')->with('success', 'Term updated.');
    }

 

    public function activate(Term $term, Request $request, FinanceGuardService $financeGuard)
{
    // DB::transaction(function () use ($term) {
    //     AcademicYear::where('is_active', true)->update(['is_active' => false]);
    //     $term->academicYear()->update(['is_active' => true]);

    //     Term::where('is_active', true)->update(['is_active' => false]);
    //     $term->update(['is_active' => true]);
    // });

     $year = AcademicYear::where('is_active', true)->first();
    $currentTerm = Term::where('is_active', true)->first();

    if ($currentTerm && $financeGuard->hasOutstandingBalances($year, $currentTerm)) {
        return back()->with(
            'error',
            'Cannot activate new term. Outstanding balances must be cleared first.'
        );
    }

    Term::query()->update(['is_active' => false]);
    $term->update(['is_active' => true]);

    $redirect = $request->input('_redirect') ?: route('admin.terms.index');

    return redirect($redirect)->with('success', "Term '{$term->name}' is now active.");
}

}

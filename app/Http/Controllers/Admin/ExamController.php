<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Term;
use App\Services\ResultComputationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Exam::with('term.academicYear')
            ->orderBy('created_at')
            ->paginate(20);

        return view('admin.exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $terms = Term::with('academicYear')
            ->orderByDesc('is_active')
            ->orderBy('start_date')
            ->get();

        return view('admin.exams.create', compact('terms'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->is_published) {
            return back()->with('error', 'Results are published and cannot be modified.');
        }
        $data = $request->validate([
            'term_id' => ['required', 'exists:terms,id'],
            'name' => ['required', 'string', 'max:100'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        Exam::create($data);

        return redirect()
            ->route('admin.exams.index')
            ->with('success', 'Exam created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        if ($exam->is_published) {
    return back()->with('error', 'Results are published and cannot be modified.');
}
        $terms = Term::with('academicYear')
            ->orderByDesc('is_active')
            ->orderBy('start_date')
            ->get();

        return view('admin.exams.edit', compact('exam', 'terms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        if ($exam->is_published) {
            return back()->with('error', 'Results are published and cannot be modified.');
        }

        $data = $request->validate([
            'term_id' => ['required', 'exists:terms,id'],
            'name' => [
                'required', 'string', 'max:100',
                Rule::unique('exams', 'name')
                    ->where(fn ($q) => $q->where('term_id', $request->term_id))
                    ->ignore($exam->id),
            ],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $exam->update($data);

        return redirect()
            ->route('admin.exams.index')
            ->with('success', 'Exam updated successfully.');
    }

    /**
     * Publish the specified resource from storage.
     */
    public function publish(Exam $exam, ResultComputationService $service)
    {

        if ($exam->is_published) {
            return back()->with('error', 'Exam already published.');
        }

        if ($exam->results()->count() === 0) {
            dd('here');
            return back()->with('error', 'Cannot publish exam without marks.');
        }

        DB::transaction(function () use ($exam, $service) {

            $service->computeExam($exam);
            

            $exam->update([
                'is_published' => true,
                'published_at' => now(),
            ]);

            $exam->aggregates()->update([
                'is_locked' => true,
            ]);

        });

        return back()->with('success', 'Exam published and locked.');
    }

    /**
     * Unpublish the specified resource from storage.
     */
    public function unpublish(Exam $exam)
    {
        $exam->update([
            'is_published' => false,
            'published_at' => null,
        ]);

        return back()->with('success', 'Results unlocked for editing.');
    }
}

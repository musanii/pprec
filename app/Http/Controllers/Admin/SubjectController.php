<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSubjectRequest;
use App\Http\Requests\Admin\UpdateSubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $status = $request->input('is_active');

        $subjects = Subject::query()
            ->when($q, fn ($query) => $query->where('name', 'like', "%{$q}")
                ->orWhere('code', 'like', "%{$q}")
            )->when($status !== null && $status !== '',
                fn ($query) => $query->where('is_active', (bool) $status))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request, Subject $subject)
    {
        $data = $request->validated();
        $subject->create([
            'name' => $data['name'],
            'code' => strtoupper($data['code']),
            'is_core' => $data['is_core'] ?? false,
            'is_active' => $data['is_active'] ?? true,
        ]);

        return redirect()
            ->route('admin.subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $data = $request->validated();

        $subject->update([
            'name' => $data['name'],
            'code' => strtoupper($data['code']),
            'is_core' => $data['is_core'] ?? false,
            'is_active' => $data['is_active'] ?? true,
        ]);

        return redirect()
            ->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    /**
     * activate the specified resource from storage.
     */
    public function activate(Subject $subject, Request $request)
    {
        $subject->update(['is_active' => true]);
        $redirect = $request->input('_redirect') ?: route('admin.subjects.index');

        return redirect($redirect)->with('success', 'Subject activated.');
    }
}

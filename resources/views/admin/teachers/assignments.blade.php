@extends('layouts.app')

@section('page_title', 'Teacher Assignments')

@section('content')
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">
            {{ $teacher->user->name }} — Assignments
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Assign subjects per class
        </p>
    </div>

    <a href="{{ route('admin.teachers.index') }}"
       class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm hover:bg-slate-50">
        Back
    </a>
</div>

<form method="POST" action="{{ route('admin.teachers.assignments.update', $teacher) }}"
      class="space-y-6 max-w-4xl">
    @csrf

    @foreach($classes as $class)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-100">
                <div class="font-semibold text-slate-900">{{ $class->name }}</div>
                <div class="text-xs text-slate-500">Subjects taught in this class</div>
            </div>

            <div class="p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($subjects as $subject)
                    <label class="flex items-center gap-2 text-sm text-slate-700">
                        <input
                            type="checkbox"
                            name="assignments[{{ $class->id }}][]"
                            value="{{ $subject->id }}"
                            class="rounded border-slate-300"
                            @checked(in_array(
                                $subject->id,
                                $assigned[$class->id] ?? []
                            ))
                        >
                        {{ $subject->name }}
                    </label>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="flex justify-end">
        <button
            class="rounded-xl bg-primary px-6 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
            Save Assignments
        </button>
    </div>
</form>
@endsection

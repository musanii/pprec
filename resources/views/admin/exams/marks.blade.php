@extends('layouts.app')

@section('page_title', 'Enter Marks')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">
        {{ $exam->name }} — Marks Entry
    </h1>
    <p class="text-sm text-slate-500 mt-1">
        {{ $exam->term->name }} • {{ $exam->term->academicYear->name }}
    </p>
</div>

{{-- Filters --}}
<form method="GET"
      class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-6
             grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
    <div>
        <label class="text-xs font-medium text-slate-600">Class</label>
        <select name="class_id" class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
            <option value="">Select class</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" @selected($classId == $class->id)>
                    {{ $class->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="text-xs font-medium text-slate-600">Subject</label>
        <select name="subject_id" class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
            <option value="">Select subject</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" @selected($subjectId == $subject->id)>
                    {{ $subject->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="rounded-xl bg-primary px-4 py-2.5 text-sm text-white">
        Load Students
    </button>
</form>

@if($students->count())
<form method="POST"
      action="{{ route('admin.exams.marks.update', $exam) }}"
      class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    @csrf
    <input type="hidden" name="class_id" value="{{ $classId }}">
    <input type="hidden" name="subject_id" value="{{ $subjectId }}">

    <table class="min-w-full">
        <thead class="bg-slate-50 text-xs text-slate-600">
            <tr>
                <th class="px-6 py-3 text-left">Student</th>
                <th class="px-6 py-3 text-left">Marks</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($students as $student)
                <tr>
                    <td class="px-6 py-4 font-medium text-slate-900">
                        {{ $student->user->name }}
                    </td>
                    <td class="px-6 py-4">
                        <input type="number"
                               name="marks[{{ $student->id }}]"
                               min="0" max="100" step="0.01"
                               class="w-28 rounded-lg border px-3 py-2 text-sm">
                    </td>
                </tr>
                @empty
                <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                            No students found.
                        </td>
                    </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-4 border-t flex justify-end">
        <button class="rounded-xl bg-primary px-6 py-2.5 text-sm text-white">
            Save Marks
        </button>
    </div>
</form>
@endif
@endsection

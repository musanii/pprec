@extends('layouts.app')

@section('page_title', isset($exam) ? 'Edit Exam' : 'Add Exam')

@section('content')
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">
            {{ isset($exam) ? 'Edit Exam' : 'Add Exam' }}
        </h1>
        <p class="text-sm text-slate-500 mt-1">Exam configuration</p>
    </div>

    <a href="{{ route('admin.exams.index') }}"
       class="rounded-xl border px-4 py-2.5 text-sm hover:bg-slate-50">
        Back
    </a>
</div>

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4">
        <ul class="text-sm text-red-700 list-disc list-inside">
            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
@endif

<form method="POST"
      action="{{ isset($exam) ? route('admin.exams.update',$exam) : route('admin.exams.store') }}"
      class="max-w-3xl space-y-6">
    @csrf
    @isset($exam) @method('PUT') @endisset

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-4">
        <div>
            <label class="text-xs font-medium text-slate-600">Term</label>
            <select name="term_id" class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
                @foreach($terms as $term)
                    <option value="{{ $term->id }}"
                        @selected(old('term_id', $exam->term_id ?? null) === $term->id)>
                        {{ $term->name }} — {{ $term->academicYear->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-xs font-medium text-slate-600">Exam Name</label>
            <input name="name"
                   value="{{ old('name', $exam->name ?? '') }}"
                   class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-medium text-slate-600">Start Date</label>
                <input type="date" name="start_date"
                       value="{{ old('start_date', $exam->start_date ?? '') }}"
                       class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
            </div>

            <div>
                <label class="text-xs font-medium text-slate-600">End Date</label>
                <input type="date" name="end_date"
                       value="{{ old('end_date', $exam->end_date ?? '') }}"
                       class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
            </div>
        </div>

        <label class="inline-flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_published" value="1"
                   @checked(old('is_published', $exam->is_published ?? false))>
            Published
        </label>
    </div>

    <div class="flex justify-end">
        <button class="rounded-xl bg-primary px-6 py-2.5 text-sm text-white">
            Save Exam
        </button>
    </div>
</form>
@endsection

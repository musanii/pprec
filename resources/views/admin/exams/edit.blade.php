@extends('layouts.app')

@section('page_title', 'Edit Exam')

@section('content')
{{-- Page header --}}
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Edit Exam</h1>
        <p class="text-sm text-slate-500 mt-1">
            Update exam details and publication status.
        </p>
    </div>

    <a href="{{ route('admin.exams.index') }}"
       class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
        Back to Exams
    </a>
</div>

{{-- Validation errors --}}
@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4">
        <div class="text-sm font-semibold text-red-800">Please fix the errors below.</div>
        <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST"
      action="{{ route('admin.exams.update', $exam) }}"
      class="max-w-3xl space-y-6">
    @csrf
    @method('PUT')

    {{-- Exam details --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <div class="text-sm font-semibold text-slate-900">Exam Details</div>
            <div class="text-xs text-slate-500 mt-1">Basic exam configuration.</div>
        </div>

        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Term --}}
            <div class="md:col-span-2">
                <label class="text-xs font-medium text-slate-600">Term</label>
                <select name="term_id"
                        class="mt-1 w-full rounded-xl border bg-white px-3 py-2.5 text-sm
                               focus:outline-none focus:ring-2 focus:ring-primary/20
                               @error('term_id') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror">
                    @foreach($terms as $term)
                        <option value="{{ $term->id }}"
                            @selected(old('term_id', $exam->term_id) === $term->id)>
                            {{ $term->name }} — {{ $term->academicYear->name }}
                        </option>
                    @endforeach
                </select>
                @error('term_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Exam name --}}
            <div class="md:col-span-2">
                <label class="text-xs font-medium text-slate-600">Exam Name</label>
                <input name="name"
                       value="{{ old('name', $exam->name) }}"
                       placeholder="e.g. Mid Term Examination"
                       class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm bg-white
                              focus:outline-none focus:ring-2 focus:ring-primary/20
                              @error('name') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror">
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Start date --}}
            <div>
                <label class="text-xs font-medium text-slate-600">Start Date</label>
                <input type="date"
                       name="start_date"
                       value="{{ old('start_date', $exam->start_date?->format('Y-m-d')) }}"
                       class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm bg-white
                              focus:outline-none focus:ring-2 focus:ring-primary/20
                              @error('start_date') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror">
                @error('start_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- End date --}}
            <div>
                <label class="text-xs font-medium text-slate-600">End Date</label>
                <input type="date"
                       name="end_date"
                       value="{{ old('end_date', $exam->end_date?->format('Y-m-d')) }}"
                       class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm bg-white
                              focus:outline-none focus:ring-2 focus:ring-primary/20
                              @error('end_date') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror">
                @error('end_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Published --}}
            <div class="md:col-span-2 flex items-center gap-3 pt-2">
                <input type="checkbox"
                       name="is_published"
                       value="1"
                       id="is_published"
                       {{ $exam->is_published ? 'disabled' : '' }}

                       @checked(old('is_published', $exam->is_published))
                       class="rounded border-slate-300 text-primary focus:ring-primary">
                <label for="is_published" class="text-sm text-slate-700">
                    Publish exam (visible for marks entry)
                </label>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex justify-end gap-2">
        <a href="{{ route('admin.exams.index') }}"
           class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
            Cancel
        </a>

        <button class="rounded-xl bg-primary px-6 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
            Save Changes
        </button>
    </div>
</form>
@endsection

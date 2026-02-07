@extends('layouts.app')

@section('page_title', 'Add Academic Year')

@section('content')
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Add Academic Year</h1>
        <p class="text-sm text-slate-500 mt-1">Define a year period and optionally activate it</p>
    </div>

    <a href="{{ route('admin.academic-years.index') }}"
       class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
        Back
    </a>
</div>

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4">
        <div class="text-sm font-semibold text-red-800">Please fix the errors below.</div>
        <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1">
            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.academic-years.store') }}" class="max-w-3xl space-y-6">
    @csrf

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <div class="text-sm font-semibold text-slate-900">Year Details</div>
            <div class="text-xs text-slate-500 mt-1">Name and date range.</div>
        </div>

        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="text-xs font-medium text-slate-600">Name</label>
                <input name="name" value="{{ old('name') }}" placeholder="e.g. 2025/2026"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-primary/20 @error('name') border-red-300 ring-2 ring-red-100 @enderror"
                       required>
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs font-medium text-slate-600">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-primary/20 @error('start_date') border-red-300 ring-2 ring-red-100 @enderror"
                       required>
                @error('start_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs font-medium text-slate-600">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-primary/20 @error('end_date') border-red-300 ring-2 ring-red-100 @enderror"
                       required>
                @error('end_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300"
                           @checked(old('is_active', false))>
                    Set as active immediately
                </label>
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-2">
        <a href="{{ route('admin.academic-years.index') }}"
           class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
            Cancel
        </a>
        <button class="rounded-xl bg-primary px-5 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
            Save Year
        </button>
    </div>
</form>
@endsection

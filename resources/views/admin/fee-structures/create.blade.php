@extends('layouts.app')

@section('page_title', 'Add Fee Structure')

@section('content')

{{-- Header --}}
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Add Fee Structure</h1>
        <p class="text-sm text-slate-500 mt-1">
            Create a new fee component for a class and term.
        </p>
    </div>

    <a href="{{ route('admin.fee-structures.index') }}"
       class="hidden sm:inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
        Back to List
    </a>
</div>

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4">
        <div class="text-sm font-semibold text-red-800">
            Please fix the errors below.
        </div>
        <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.fee-structures.store') }}">
    @csrf

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <div class="text-sm font-semibold text-slate-900">Fee Details</div>
            <div class="text-xs text-slate-500 mt-1">
                Define fee component and amount.
            </div>
        </div>

        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Academic Year --}}
            <div>
                <label class="text-xs font-medium text-slate-600">Academic Year</label>
                <select name="academic_year_id"
                        class="mt-1 w-full rounded-xl border bg-white px-3 py-2.5 text-sm
                        focus:outline-none focus:ring-2 focus:ring-primary/20
                        @error('academic_year_id') border-red-300 @else border-slate-200 @enderror">
                    <option value="">Select Year</option>
                    @foreach($years as $year)
                        <option value="{{ $year->id }}" @selected(old('academic_year_id') == $year->id)>
                            {{ $year->name }}
                        </option>
                    @endforeach
                </select>
                @error('academic_year_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Term --}}
            <div>
                <label class="text-xs font-medium text-slate-600">Term</label>
                <select name="term_id"
                        class="mt-1 w-full rounded-xl border bg-white px-3 py-2.5 text-sm
                        focus:outline-none focus:ring-2 focus:ring-primary/20
                        @error('term_id') border-red-300 @else border-slate-200 @enderror">
                    <option value="">Select Term</option>
                    @foreach($terms as $term)
                        <option value="{{ $term->id }}" @selected(old('term_id') == $term->id)>
                            {{ $term->name }}
                        </option>
                    @endforeach
                </select>
                @error('term_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Class --}}
            <div>
                <label class="text-xs font-medium text-slate-600">Class</label>
                <select name="class_id"
                        class="mt-1 w-full rounded-xl border bg-white px-3 py-2.5 text-sm
                        focus:outline-none focus:ring-2 focus:ring-primary/20
                        @error('class_id') border-red-300 @else border-slate-200 @enderror">
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" @selected(old('class_id') == $class->id)>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
                @error('class_id')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Fee Name --}}
            <div>
                <label class="text-xs font-medium text-slate-600">Fee Name</label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="e.g Tuition"
                       class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm bg-white
                       focus:outline-none focus:ring-2 focus:ring-primary/20
                       @error('name') border-red-300 @else border-slate-200 @enderror" />
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Amount --}}
            <div class="md:col-span-2">
                <label class="text-xs font-medium text-slate-600">Amount</label>
                <input type="number"
                       step="0.01"
                       min="0"
                       name="amount"
                       value="{{ old('amount') }}"
                       placeholder="0.00"
                       class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm bg-white
                       focus:outline-none focus:ring-2 focus:ring-primary/20
                       @error('amount') border-red-300 @else border-slate-200 @enderror" />
                @error('amount')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>

    <div class="mt-6 flex justify-end gap-2">
        <a href="{{ route('admin.fee-structures.index') }}"
           class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
            Cancel
        </a>

        <button class="rounded-xl bg-primary px-5 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
            Save Fee
        </button>
    </div>

</form>

@endsection

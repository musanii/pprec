@extends('layouts.app')

@section('page_title','Create School Period')

@section('content')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 max-w-xl">

    <form method="POST" action="{{ route('admin.school-periods.store') }}">
        @csrf

        <div class="mb-4">
            <label class="text-xs text-slate-600">Name</label>
            <input name="name" required
                   class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
        </div>

        <div class="mb-4">
            <label class="text-xs text-slate-600">Period Number</label>
            <input name="period_number" type="number" required
                   class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
        </div>

        <div class="mb-4">
            <label class="text-xs text-slate-600">Start Time</label>
            <input name="start_time" type="time" required
                   class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
        </div>

        <div class="mb-4">
            <label class="text-xs text-slate-600">End Time</label>
            <input name="end_time" type="time" required
                   class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
        </div>

        <div class="mb-6">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_break">
                Break Period
            </label>
        </div>

        <div class="flex justify-end">
            <button class="px-4 py-2 rounded-xl bg-primary text-white">
                Save
            </button>
        </div>

    </form>

</div>

@endsection
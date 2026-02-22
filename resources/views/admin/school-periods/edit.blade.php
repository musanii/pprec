@extends('layouts.app')

@section('page_title','Edit School Period')

@section('content')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 max-w-xl">

    <form method="POST" action="{{ route('admin.school-periods.update',$schoolPeriod) }}">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label class="text-xs text-slate-600">Name</label>
            <input name="name" value="{{ $schoolPeriod->name }}" required
                   class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
        </div>

        <div class="mb-4">
            <label class="text-xs text-slate-600">Period Number</label>
            <input name="period_number" type="number"
                   value="{{ $schoolPeriod->period_number }}" required
                   class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
        </div>

        <div class="mb-4">
            <label class="text-xs text-slate-600">Start Time</label>
            <input name="start_time" type="time"
                   value="{{ $schoolPeriod->start_time }}"
                   required
                   class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
        </div>

        <div class="mb-4">
            <label class="text-xs text-slate-600">End Time</label>
            <input name="end_time" type="time"
                   value="{{ $schoolPeriod->end_time }}"
                   required
                   class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
        </div>

        <div class="mb-4">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_break"
                       @checked($schoolPeriod->is_break)>
                Break Period
            </label>
        </div>

        <div class="mb-6">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_active"
                       @checked($schoolPeriod->is_active)>
                Active
            </label>
        </div>

        <div class="flex justify-end">
            <button class="px-4 py-2 rounded-xl bg-primary text-white">
                Update
            </button>
        </div>

    </form>

</div>

@endsection
@extends('layouts.app')

@section('page_title','Attendance Reports')

@section('content')

<div class="bg-white rounded-2xl border p-6">
    <form method="GET" class="flex flex-wrap items-end gap-4">
        
        <div class="flex-1 min-w-[150px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">Class</label>
            <select name="class_id" class="w-full rounded-xl border px-3 py-2 text-sm">
                <option value="">Select Class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" @selected($classId == $class->id)>{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-1 min-w-[150px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">Stream</label>
            <select name="stream_id" class="w-full border rounded-xl px-3 py-2 text-sm">
                <option value="">All Streams</option>
                @foreach($streams as $stream)
                    <option value="{{ $stream->id }}" @selected($streamId == $stream->id)>{{ $stream->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-1 min-w-[150px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">From</label>
            <input type="date" name="from" value="{{ $from }}" class="w-full border rounded-xl px-3 py-2 text-sm">
        </div>

        <div class="flex-1 min-w-[150px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">To</label>
            <input type="date" name="to" value="{{ $to }}" class="w-full border rounded-xl px-3 py-2 text-sm">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-indigo-600 text-white rounded-xl px-4 py-2 text-sm font-medium">
                Filter
            </button>
            <a href="{{ request()->url() }}" class="bg-gray-100 text-gray-600 rounded-xl px-4 py-2 text-sm font-medium border text-center">
                Clear
            </a>
        </div>

    </form>
</div>

@if($summary)

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

    <x-kpi-card title="Total Records" :value="$summary->total" />
    <x-kpi-card title="Present" :value="$summary->present ?? 0" />
    <x-kpi-card title="Absent" :value="$summary->absent ?? 0" />
    <x-kpi-card title="Late" :value="$summary->late ?? 0" />
    <x-kpi-card title="Attendance %" :value="$percentage.'%'" />

</div>

@endif

@endsection 
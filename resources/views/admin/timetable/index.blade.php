@extends('layouts.app')

@section('page_title','Timetable')

@section('content')

<div class="mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="text-xs font-medium text-slate-600">Class</label>
            <select name="class_id"
                    class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
                <option value="">Select Class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}"
                        @selected($classId == $class->id)>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-xs font-medium text-slate-600">Stream</label>
            <select name="stream_id"
                    class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
                <option value="">All</option>
                @foreach($streams as $stream)
                    <option value="{{ $stream->id }}"
                        @selected($streamId == $stream->id)>
                        {{ $stream->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <button class="rounded-xl bg-primary px-4 py-2.5 text-white">
                Load Timetable
            </button>
        </div>
    </form>
</div>

@if($classId)

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-x-auto">

<table class="min-w-full text-sm">
    <thead class="bg-slate-50 text-slate-600 text-xs">
        <tr>
            <th class="px-4 py-3 text-left">Period</th>
            @foreach(['monday','tuesday','wednesday','thursday','friday'] as $day)
                <th class="px-4 py-3 text-center capitalize">
                    {{ $day }}
                </th>
            @endforeach
        </tr>
    </thead>

    <tbody class="divide-y">

    @foreach($periods as $period)
        <tr>
            <td class="px-4 py-3 font-medium bg-slate-50">
                {{ $period->name }}
                <div class="text-xs text-slate-500">
                    {{ \Carbon\Carbon::parse($period->start_time)->format('H:i') }}
                    -
                    {{ \Carbon\Carbon::parse($period->end_time)->format('H:i') }}
                </div>
            </td>

            @foreach(['monday','tuesday','wednesday','thursday','friday'] as $day)

                @php
                    $slot = $slots[$period->id][$day][0] ?? null;
                @endphp

                <td class="px-4 py-3 text-center border-l">

                    @if($slot)
                        <div class="font-medium text-slate-900">
                            {{ $slot->subject->name }}
                        </div>
                        <div class="text-xs text-slate-500">
                            {{ $slot->teacher->user->name }}
                        </div>
                    @else
                        <div class="text-xs text-slate-400">
                            —
                        </div>
                    @endif

                </td>

            @endforeach
        </tr>
    @endforeach

    </tbody>
</table>

</div>

@endif

@endsection
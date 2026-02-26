@extends('layouts.app')

@section('page_title','Teacher Dashboard')

@section('content')

{{-- KPI Row --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <x-kpi-card title="Today's Classes" :value="$todaySlots->count()" />
    <x-kpi-card title="Attendance Completed" :value="$completedToday" />
    <x-kpi-card title="Attendance Pending" :value="$pendingToday" />
    <x-kpi-card title="Weekly Periods" :value="$weekSlots" />
</div>

{{-- Teaching Exposure --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">

    <div class="bg-white rounded-2xl border p-6">
        <div class="text-xs text-slate-500">Classes Handled</div>
        <div class="text-3xl font-semibold mt-2">
            {{ $uniqueClasses }}
        </div>
    </div>

    <div class="bg-white rounded-2xl border p-6">
        <div class="text-xs text-slate-500">Students Reached</div>
        <div class="text-3xl font-semibold mt-2">
            {{ $studentsCount }}
        </div>
    </div>

</div>


{{-- Today's Timetable --}}
<div class="mt-10 bg-white rounded-2xl border shadow-sm">

    <div class="p-6 border-b font-semibold">
        Today's Timetable
    </div>

    <div class="divide-y">

        @foreach($todaySlots as $slot)

            @php
                $done = in_array($slot->id, $todaySessions);
            @endphp

            <div class="p-4 flex justify-between items-center">

                <div>
                    <div class="font-semibold">
                        {{ $slot->subject->name }}
                    </div>
                    <div class="text-xs text-slate-500">
                        {{ $slot->schoolClass->name }}
                        @if($slot->stream)
                            - {{ $slot->stream->name }}
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-4">

                    <span class="text-xs px-3 py-1 rounded-full
                        {{ $done ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $done ? 'Completed' : 'Pending' }}
                    </span>

                    <a href="{{ route('teacher.attendance.take',$slot) }}"
                       class="text-sm text-primary underline">
                        {{ $done ? 'Edit' : 'Take Attendance' }}
                    </a>

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection
@extends('layouts.app')

@section('page_title','Teacher Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded-2xl shadow-sm border">
        <div class="text-xs text-slate-500">Today's Periods</div>
        <div class="text-3xl font-semibold mt-2">
            {{ $todaySlots->count() }}
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border">
        <div class="text-xs text-slate-500">Attendance Taken Today</div>
        <div class="text-3xl font-semibold mt-2">
            {{ $todaySessions }}
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border">
        <div class="text-xs text-slate-500">Sessions This Week</div>
        <div class="text-3xl font-semibold mt-2">
            {{ $weeklySessions }}
        </div>
    </div>

</div>

<div class="mt-8 bg-white rounded-2xl border shadow-sm">

    <div class="p-6 border-b font-semibold">
        Today's Classes
    </div>

    <div class="divide-y">

        @forelse($todaySlots as $slot)

            <a href="{{ route('teacher.attendance.take',$slot) }}"
               class="block p-4 hover:bg-slate-50">

                <div class="flex justify-between">
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

                    <div class="text-xs text-slate-500">
                        {{ $slot->period->name }}
                    </div>
                </div>

            </a>

        @empty

            <div class="p-6 text-center text-slate-400">
                No classes today
            </div>

        @endforelse

    </div>

</div>

@endsection
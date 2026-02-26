@extends('layouts.app')

@section('page_title','My Attendance')

@section('content')

<div class="bg-white rounded-2xl border shadow-sm">

    <div class="p-6 border-b">
        <h2 class="font-semibold text-lg">
            Today's Periods
        </h2>
    </div>

    <div class="divide-y">

        @forelse($slots as $slot)

            <a href="{{ route('teacher.attendance.take', $slot) }}"
               class="block p-4 hover:bg-slate-50">

                <div class="flex justify-between items-center">
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

            <div class="p-6 text-center text-slate-500">
                No periods today.
            </div>

        @endforelse

    </div>

</div>

@endsection
@extends('layouts.app')

@section('page_title', 'Academic Intelligence')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">
            Academic Intelligence
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Term performance overview and analytics
        </p>
    </div>
</div>



{{-- Overview Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="text-xs text-slate-500">Active Term</div>
        <div class="text-lg font-semibold text-slate-900 mt-1">
            {{ $overview['term']}}
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="text-xs text-slate-500">Overall Mean Score</div>
        <div class="text-2xl font-bold text-slate-900 mt-1">
            {{ $overview['overall_mean'] }}
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="text-xs text-slate-500">Marks Entries</div>
        <div class="text-2xl font-bold text-slate-900 mt-1">
            {{ $overview['entries'] }}
        </div>
    </div>
</div>

{{-- Class Performance --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-6">
    <div class="p-5 border-b border-slate-100">
        <div class="text-sm font-semibold text-slate-900">
            Class Performance Ranking
        </div>
    </div>
    <div class="divide-y">
        @forelse($classPerformance as $row)
            <div class="p-4 flex justify-between text-sm">
                <span>{{ $row->class_name }}</span>
                <span class="font-medium">{{ round($row->mean_score, 2) }}</span>
            </div>
        @empty
            <div class="p-4 text-sm text-slate-500">
                No class performance data available.
            </div>
        @endforelse
    </div>
</div>

{{-- Subject Performance --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-6">
    <div class="p-5 border-b border-slate-100">
        <div class="text-sm font-semibold text-slate-900">
            Subject Performance Ranking
        </div>
    </div>
    <div class="divide-y">
        @forelse($subjectPerformance as $row)
            <div class="p-4 flex justify-between text-sm">
                <span>{{ $row->subject_name }}</span>
                <span class="font-medium">{{ round($row->mean_score, 2) }}</span>
            </div>
        @empty
            <div class="p-4 text-sm text-slate-500">
                No subject performance data available.
            </div>
        @endforelse
    </div>
</div>

{{-- Top & Bottom Students --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 text-sm font-semibold">
            Top Students
        </div>
        <div class="divide-y">
            @forelse($topStudents as $row)
                <div class="p-4 flex justify-between text-sm">
                    <span>{{ $row->student?->user?->name }}</span>
                    <span class="font-medium">{{ round($row->mean_score, 2) }}</span>
                </div>
            @empty
                
                <div class="p-4 text-sm text-slate-500">
                    No top student data available.
                </div>

            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 text-sm font-semibold">
            Bottom Students
        </div>
        <div class="divide-y">
            @forelse($bottomStudents as $row)
                <div class="p-4 flex justify-between text-sm">
                    <span>{{ $row->student?->user?->name }}</span>
                    <span class="font-medium">{{ round($row->mean_score, 2) }}</span>
                </div>
            @empty
                <div class="p-4 text-sm text-slate-500">
                    No bottom student data available.
                </div>
            @endforelse
        </div>
    </div>

</div>

@endsection

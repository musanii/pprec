@extends('layouts.app')

@section('page_title', 'My Dashboard')

@section('content')

@php

     $user = auth()->user();
       $student = $user->studentProfile;
       $activeYear = App\Models\AcademicYear::where('is_active', true)->first();
       $activeTerm = App\Models\Term::where('is_active', true)->first();
       $enrollment = $student?->activeEnrollment;

@endphp
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Main card --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">
                Welcome, {{ auth()->user()->name }}
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Admission No: {{ $student->admission_no ?? '—' }}
            </p>
        </div>

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="rounded-xl bg-slate-50 p-4 border border-slate-100">
                <div class="text-xs text-slate-500">Class</div>
                <div class="text-sm font-medium text-slate-900 mt-1">
                    {{ $enrollment?->schoolClass?->name ?? '—' }}
                </div>
                <div class="text-xs text-slate-500">
                    {{ $enrollment?->stream?->name ? 'Stream '.$enrollment->stream->name : '' }}
                </div>
            </div>

            <div class="rounded-xl bg-slate-50 p-4 border border-slate-100">
                <div class="text-xs text-slate-500">Academic Year</div>
                <div class="text-sm font-medium text-slate-900 mt-1">
                    {{ $activeYear?->name ?? '—' }}
                </div>
            </div>

            <div class="rounded-xl bg-slate-50 p-4 border border-slate-100">
                <div class="text-xs text-slate-500">Term</div>
                <div class="text-sm font-medium text-slate-900 mt-1">
                    {{ $activeTerm?->name ?? '—' }}
                </div>
            </div>

            <div class="rounded-xl bg-slate-50 p-4 border border-slate-100">
                <div class="text-xs text-slate-500">Status</div>
                <div class="text-sm font-medium text-slate-900 mt-1 capitalize">
                    {{ $student->status ?? '—' }}
                </div>
            </div>
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="text-sm font-semibold text-slate-900 mb-4">
            Quick Actions
        </h3>

        <a href="{{ route('student.results') }}"
           class="block rounded-xl border border-slate-200 px-4 py-2.5 text-sm hover:bg-slate-50">
            View My Results
        </a>

        <p class="mt-4 text-xs text-slate-500">
            Your results are available once exams are published by the school.
        </p>
    </div>

</div>
@endsection

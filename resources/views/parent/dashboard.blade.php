@extends('layouts.app')

@section('page_title', 'Parent Dashboard')

@section('content')


<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    @forelse($students as $student)
        <div class="bg-white rounded-2xl border border-slate-100 p-6">
            <div class="text-lg font-semibold text-slate-900">
                {{ $student->user->name }}
            </div>

            <div class="mt-2 text-sm text-slate-600 space-y-1">
                <div><strong>Admission:</strong> {{ $student->admission_no }}</div>
                <div>
                    <strong>Class:</strong>
                    {{ $student->activeEnrollment?->schoolClass?->name ?? '—' }}
                </div>
                <div>
                    <strong>Stream:</strong>
                    {{ $student->activeEnrollment?->stream?->name ?? '—' }}
                </div>
            </div>

            <a href="{{ route('parent.students.results', $student) }}"
               class="mt-4 inline-flex w-full justify-center rounded-xl bg-primary px-4 py-2.5 text-sm text-white hover:opacity-90">
                View Results
            </a>
        </div>
    @empty
        <div class="col-span-full text-center text-slate-500 py-12">
            No students linked to this account.
        </div>
    @endforelse

</div>
@endsection

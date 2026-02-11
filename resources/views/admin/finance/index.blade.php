@extends('layouts.app')

@section('page_title', 'Finance Dashboard')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Finance Overview</h1>
        <p class="text-sm text-slate-500 mt-1">
            Summary for {{ $year?->name ?? 'No Active Year' }}
            — {{ $term?->name ?? 'No Active Term' }}
        </p>
    </div>

    <a href="{{ route('admin.fee-structures.index') }}"
       class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm hover:bg-slate-50">
        Manage Fee Structures
    </a>
</div>

{{-- KPI Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="text-xs text-slate-500">Total Billed</div>
        <div class="text-2xl font-semibold text-slate-900 mt-2">
            {{ number_format($totalBilled, 2) }}
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="text-xs text-slate-500">Collected</div>
        <div class="text-2xl font-semibold text-green-600 mt-2">
            {{ number_format($totalCollected, 2) }}
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="text-xs text-slate-500">Outstanding</div>
        <div class="text-2xl font-semibold text-red-600 mt-2">
            {{ number_format($totalBalance, 2) }}
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="text-xs text-slate-500">Students Owing</div>
        <div class="text-2xl font-semibold text-slate-900 mt-2">
            {{ $studentsWithDebt }}
        </div>
    </div>

</div>

{{-- Action Card --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
    <div class="text-sm font-semibold text-slate-900 mb-2">
        Billing Operations
    </div>

    <p class="text-sm text-slate-500 mb-4">
        Generate student bills for the current academic year and term.
    </p>

    @if($year && $term)
        <form method="POST"
              action="{{ route('admin.billing.generate', [$year, $term]) }}">
            @csrf

            <button class="rounded-xl bg-primary px-5 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
                Generate Bills
            </button>
        </form>
    @else
        <div class="text-sm text-red-600">
            You must activate an academic year and term first.
        </div>
    @endif
</div>

@endsection

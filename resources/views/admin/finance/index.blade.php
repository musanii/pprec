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

{{-- Student Bills Table --}}
<div class="mt-8 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    {{-- Filter --}}
    <div class="p-4 sm:p-5 border-b border-slate-100">
        <form method="GET"
              class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">

            <div class="md:col-span-4">
                <label class="text-xs font-medium text-slate-600">Filter by Class</label>
                <select name="class_id"
                        class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm
                               focus:outline-none focus:ring-2 focus:ring-primary/20">
                    <option value="">All Classes</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}"
                            @selected(request('class_id') == $class->id)>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-8 flex justify-end gap-2 pt-1">
                <button class="rounded-xl bg-primary px-4 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
                    Apply
                </button>

                <a href="{{ route('admin.finance.index') }}"
                   class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-50 text-slate-600 text-xs">
                <tr>
                    <th class="px-6 py-3 text-left font-medium">Student</th>
                    <th class="px-6 py-3 text-left font-medium">Class</th>
                    <th class="px-6 py-3 text-left font-medium">Fee</th>
                    <th class="px-6 py-3 text-left font-medium">Amount</th>
                    <th class="px-6 py-3 text-left font-medium">Balance</th>
                    <th class="px-6 py-3 text-left font-medium">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($bills as $bill)

                    @php
                        $status =
                            $bill->balance == 0 ? 'paid' :
                            ($bill->balance < $bill->amount ? 'partial' : 'unpaid');
                    @endphp

                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">
                                {{ $bill->student?->user?->name }}
                            </div>
                        </td>

                        <td class="px-6 py-4 text-slate-700">
                            {{ $bill->student?->activeEnrollment?->schoolClass?->name }}
                        </td>

                        <td class="px-6 py-4 text-slate-700">
                            {{ $bill->feeStructure?->name }}
                        </td>

                        <td class="px-6 py-4 font-medium text-slate-900">
                            {{ number_format($bill->amount, 2) }}
                        </td>

                        <td class="px-6 py-4 font-medium
                            {{ $bill->balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ number_format($bill->balance, 2) }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs border rounded-full
                                {{
                                    $status === 'paid'
                                    ? 'bg-green-50 text-green-700 border-green-200'
                                    : ($status === 'partial'
                                        ? 'bg-yellow-50 text-yellow-700 border-yellow-200'
                                        : 'bg-red-50 text-red-700 border-red-200')
                                }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="6"
                            class="px-6 py-12 text-center text-slate-500">
                            No student bills found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="p-4 sm:p-5 border-t border-slate-100 bg-white">
        {{ $bills->links() }}
    </div>

</div>


@endsection

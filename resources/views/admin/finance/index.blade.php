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

    

    <div class="flex gap-2">
        <a href="{{ route('admin.fee-structures.index') }}"
       class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm hover:bg-slate-50">
        Manage Fee Structures
    </a>

    
    <a href="{{ route('admin.finance.export.excel') }}"
       class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm hover:bg-slate-50">
        Export Excel
    </a>

    <a href="{{ route('admin.finance.export.pdf') }}"
       class="rounded-xl bg-primary px-4 py-2.5 text-sm text-white hover:opacity-90">
        Export PDF
    </a>
</div>
<form method="POST" 
      action="{{ route('admin.finance.penalties.apply') }}">
    @csrf
    <button class="rounded-xl border bg-red-600 px-4 py-2.5 text-sm text-white hover:opacity-90">
        Apply Late Penalties
    </button>
</form>

</div>





{{-- KPI Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-4 gap-6 mb-6">

    <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
        <div class="text-xs text-slate-500">Total Billed</div>
        <div class="text-2xl font-semibold mt-2">
            {{ number_format($overview['totalBilled']) }}
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
        <div class="text-xs text-slate-500">Collected</div>
        <div class="text-2xl font-semibold mt-2 text-green-600">
            {{ number_format($overview['totalCollected']) }}
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
        <div class="text-xs text-slate-500">Outstanding</div>
        <div class="text-2xl font-semibold mt-2 text-red-600">
            {{ number_format($overview['totalBalance']) }}
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
        <div class="text-xs text-slate-500">Collection Rate</div>
        <div class="text-2xl font-semibold mt-2">
            {{ $overview['collectionRate'] }}%
        </div>
    </div>



  

    <div class="mt-6 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100">
        <div class="text-sm font-semibold text-slate-900">
            Top Outstanding Students
        </div>
    </div>

    <div class="divide-y">
        @forelse($topDebtors as $bill)
            <div class="p-4 flex items-center justify-between">
                <div>
                    <div class="text-sm font-medium text-slate-900">
                        {{ $bill->student->user->name }}
                    </div>
                </div>
                <div class="text-sm font-semibold text-red-600">
                    {{ number_format($bill->balance, 2) }}
                </div>
            </div>
        @empty
            <div class="p-4 text-sm text-slate-500">
                No outstanding balances.
            </div>
        @endforelse
    </div>
</div>

<div class="mt-6 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100">
        <div class="text-sm font-semibold text-slate-900">
            Outstanding by Class
        </div>
    </div>

    <div class="divide-y">
        @foreach($classOutstanding as $row)
            <div class="p-4 flex items-center justify-between">
                <div class="text-sm text-slate-700">
                    {{ $row->class_name }}
                </div>
                <div class="text-sm font-semibold text-slate-900">
                    {{ number_format($row->total_balance, 2) }}
                </div>
            </div>
        @endforeach
    </div>
</div>


    

@if($totalBalance > 0)
    <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4">
        <div class="text-sm font-semibold text-red-800">
            Financial Lock Active
        </div>
        <div class="text-sm text-red-700 mt-1">
            Promotion and term closure are blocked until balances are cleared.
        </div>
    </div>
@endif






</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <div class="text-sm font-semibold text-slate-900">
                Monthly Collection ({{ now()->year }})
            </div>
            <div class="text-xs text-slate-500">
                Total payments received per month
            </div>
        </div>
    </div>

    <canvas id="monthlyCollectionChart" height="80"></canvas>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm mb-6">
    <div class="p-5 border-b border-slate-100">
        <div class="font-semibold">Top Debt Classes</div>
    </div>

    <table class="min-w-full">
        <thead class="bg-slate-50 text-xs text-slate-600">
            <tr>
                <th class="px-6 py-3 text-left">Class</th>
                <th class="px-6 py-3 text-right">Total Debt</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($topDebtClasses as $class)
                <tr>
                    <td class="px-6 py-4">{{ $class->class_name }}</td>
                    <td class="px-6 py-4 text-right font-medium text-red-600">
                        {{ number_format($class->total_debt) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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

                        <td class="px-6 py-4 ">

                        @if($bill->balance > 0)
                            <button
                                x-data
                                @click="$dispatch('open-payment-{{ $bill->id }}')"
                                class="rounded-lg bg-primary px-3 py-1.5 text-white text-xs hover:opacity-90">
                                Record Payment
                            </button>
                        @else
                            <span class="text-green-600 text-xs font-medium">Fully Paid</span>
                        @endif

                        @foreach($bill->payments as $payment)
                        <div class="flex justify-between items-center">
                            <div>
                                {{ $payment->created_at->format('d M Y') }}
                                — {{ number_format($payment->amount, 2) }}
                            </div>

                            <a href="{{ route('admin.payments.receipt', $payment) }}"
                            target="_blank"
                            class="text-xs text-primary underline">
                                Receipt
                            </a>
                        </div>
                    @endforeach

 

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

        @foreach($bills as $bill)
<div
    x-data="{ open:false }"
    @open-payment-{{ $bill->id }}.window="open=true"
    x-show="open"
    x-cloak
    class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
>
    <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl">
        <h3 class="text-lg font-semibold mb-4">
            Record Payment
        </h3>

        <form method="POST"
              action="{{ route('admin.payments.store', $bill) }}">
            @csrf

            <div class="mb-4">
                <label class="text-xs text-slate-600">Amount</label>
                <input type="number"
                       name="amount"
                       step="0.01"
                       max="{{ $bill->balance }}"
                       required
                       class="mt-1 w-full rounded-xl border px-3 py-2 text-sm">
                <div class="text-xs text-slate-500 mt-1">
                    Balance: {{ number_format($bill->balance,2) }}
                </div>
            </div>

            <div class="mb-4">
                <label class="text-xs text-slate-600">Method</label>
                <select name="method"
                        class="mt-1 w-full rounded-xl border px-3 py-2 text-sm">
                    <option value="cash">Cash</option>
                    <option value="mpesa">M-Pesa</option>
                    <option value="bank">Bank</option>
                </select>
            </div>
            <div class="mb-4">
                <select name="strategy"
        class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
                <option value="oldest">Allocate to Oldest Bills</option>
                <option value="highest">Allocate to Highest Balance</option>
            </select>

            </div>
            

            <div class="mb-4">
                <label class="text-xs text-slate-600">Reference No</label>
                <input type="text"
                       name="reference"
                       class="mt-1 w-full rounded-xl border px-3 py-2 text-sm">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button"
                        @click="open=false"
                        class="px-4 py-2 text-sm border rounded-xl">
                    Cancel
                </button>
                <button class="px-4 py-2 text-sm bg-primary text-white rounded-xl">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

    </div>

    {{-- Pagination --}}
    <div class="p-4 sm:p-5 border-t border-slate-100 bg-white">
        {{ $bills->links() }}
    </div>

</div>


@endsection


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('monthlyCollectionChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                'Jan','Feb','Mar','Apr','May','Jun',
                'Jul','Aug','Sep','Oct','Nov','Dec'
            ],
            datasets: [{
                label: 'Collected',
                data: @json($monthlyData),
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79,70,229,0.1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});
</script>



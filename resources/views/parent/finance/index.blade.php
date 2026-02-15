@extends('layouts.app')

@section('page_title', 'Child Finance')

@section('content')

<div class="space-y-6">

@foreach($students as $student)

    @php
        $totalBilled = $student->bills->sum('amount');
        $totalBalance = $student->bills->sum('balance');
        $totalPaid = $totalBilled - $totalBalance;
    @endphp

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <div class="text-sm font-semibold text-slate-900">
                    {{ $student->user->name }}
                </div>
                <div class="text-xs text-slate-500">
                    {{ $student->activeEnrollment?->schoolClass?->name }}
                </div>
            </div>

            <div class="text-sm font-semibold 
                {{ $totalBalance > 0 ? 'text-red-600' : 'text-green-600' }}">
                Balance: {{ number_format($totalBalance,2) }}
            </div>
        </div>

        <div class="p-5 grid grid-cols-3 gap-4 text-sm">
            <div>
                <div class="text-slate-500">Total Billed</div>
                <div class="font-semibold text-slate-900">
                    {{ number_format($totalBilled,2) }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Total Paid</div>
                <div class="font-semibold text-slate-900">
                    {{ number_format($totalPaid,2) }}
                </div>
            </div>

            <div>
                <div class="text-slate-500">Outstanding</div>
                <div class="font-semibold text-slate-900">
                    {{ number_format($totalBalance,2) }}
                </div>
            </div>
        </div>

        {{-- Bills Table --}}
        <div class="border-t border-slate-100">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-2 text-left">Description</th>
                        <th class="px-4 py-2 text-left">Amount</th>
                        <th class="px-4 py-2 text-left">Balance</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($student->bills as $bill)
                        <tr>
                            <td class="px-4 py-2">
                                {{ $bill->feeStructure->name }}
                            </td>
                            <td class="px-4 py-2">
                                {{ number_format($bill->amount,2) }}
                            </td>
                            <td class="px-4 py-2">
                                {{ number_format($bill->balance,2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

@endforeach

</div>

@endsection

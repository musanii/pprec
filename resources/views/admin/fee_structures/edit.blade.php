@extends('layouts.app')

@section('page_title', 'Edit Fee Structure')

@section('content')

<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Edit Fee Structure</h1>
        <p class="text-sm text-slate-500 mt-1">
            Update fee details.
        </p>
    </div>

    <a href="{{ route('admin.fee-structures.index') }}"
       class="hidden sm:inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
        Back to List
    </a>
</div>

<form method="POST" action="{{ route('admin.fee-structures.update', $feeStructure) }}">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <div class="text-sm font-semibold text-slate-900">Fee Details</div>
        </div>

        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="text-xs font-medium text-slate-600">Fee Name</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $feeStructure->name) }}"
                       class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm border-slate-200
                       focus:outline-none focus:ring-2 focus:ring-primary/20" />
            </div>

            <div>
                <label class="text-xs font-medium text-slate-600">Amount</label>
                <input type="number"
                       step="0.01"
                       name="amount"
                       value="{{ old('amount', $feeStructure->amount) }}"
                       class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm border-slate-200
                       focus:outline-none focus:ring-2 focus:ring-primary/20" />
            </div>

        </div>
    </div>

    <div class="mt-6 flex justify-end gap-2">
        <a href="{{ route('admin.fee-structures.index') }}"
           class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
            Cancel
        </a>

        <button class="rounded-xl bg-primary px-5 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
            Update Fee
        </button>
    </div>

</form>

@endsection

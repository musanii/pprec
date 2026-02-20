@extends('layouts.app')

@section('page_title','School Periods')

@section('content')

<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">School Periods</h1>
        <p class="text-sm text-slate-500 mt-1">Define official daily schedule</p>
    </div>

    <a href="{{ route('admin.school-periods.create') }}"
       class="inline-flex items-center rounded-xl bg-primary px-4 py-2.5 text-white hover:opacity-90 shadow-sm">
        + Add Period
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-slate-50 text-xs text-slate-600">
            <tr>
                <th class="px-6 py-3 text-left">#</th>
                <th class="px-6 py-3 text-left">Name</th>
                <th class="px-6 py-3 text-left">Time</th>
                <th class="px-6 py-3 text-left">Type</th>
                <th class="px-6 py-3 text-right">Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @foreach($periods as $period)
                <tr>
                    <td class="px-6 py-4">{{ $period->period_number }}</td>
                    <td class="px-6 py-4 font-medium">{{ $period->name }}</td>
                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($period->start_time)->format('H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($period->end_time)->format('H:i') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($period->is_break)
                            <span class="text-xs px-2 py-1 rounded bg-yellow-50 text-yellow-700">Break</span>
                        @else
                            <span class="text-xs px-2 py-1 rounded bg-blue-50 text-blue-700">Class</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.school-periods.edit', $period) }}"
                           class="text-sm text-primary">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="p-4 border-t">
        {{ $periods->links() }}
    </div>
</div>

@endsection
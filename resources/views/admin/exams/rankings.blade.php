@extends('layouts.app')

@section('page_title', 'Class Rankings')

@section('content')
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">
            {{ $exam->name }} — {{ $class->name }}
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Class performance ranking
        </p>
    </div>

    <a href="{{ route('admin.exams.index') }}"
       class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
        Back to Exams
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    <table class="min-w-full">
        <thead class="bg-slate-50 text-slate-600 text-xs">
            <tr>
                <th class="px-6 py-3 text-left font-medium">Position</th>
                <th class="px-6 py-3 text-left font-medium">Student</th>
                <th class="px-6 py-3 text-right font-medium">Total Marks</th>
                <th class="px-6 py-3 text-right font-medium">Average</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse($rankings as $row)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 font-semibold text-slate-900">
                        {{ $row['position'] }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-900">
                            {{ $row['student']->user?->name }}
                        </div>
                        <div class="text-xs text-slate-500">
                            {{ $row['student']->admission_no }}
                        </div>
                    </td>

                    <td class="px-6 py-4 text-right text-slate-700">
                        {{ $row['total'] }}
                    </td>

                    <td class="px-6 py-4 text-right text-slate-700">
                        {{ $row['average'] }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                        No results available for this class.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

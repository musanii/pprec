@extends('layouts.app')

@section('page_title','Academic Transcript')

@section('content')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    <div class="p-6 border-b">
        <h2 class="font-semibold text-lg">
            {{ $student->user->name }}
        </h2>
    </div>

    <table class="min-w-full">
        <thead class="bg-slate-50 text-xs text-slate-600">
            <tr>
                <th class="px-6 py-3 text-left">Year</th>
                <th class="px-6 py-3 text-left">Term</th>
                <th class="px-6 py-3 text-left">Exam</th>
                <th class="px-6 py-3 text-right">Total</th>
                <th class="px-6 py-3 text-right">Mean</th>
                <th class="px-6 py-3 text-right">Rank</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($records as $record)
            <tr>
                <td class="px-6 py-4">
                    {{ $record->exam->academicYear->name ?? '-' }}
                </td>
                <td class="px-6 py-4">
                    {{ $record->exam->term->name ?? '-' }}
                </td>
                <td class="px-6 py-4">
                    {{ $record->exam->name }}
                </td>
                <td class="px-6 py-4 text-right">
                    {{ $record->total_marks }}
                </td>
                <td class="px-6 py-4 text-right">
                    {{ $record->mean_score }}
                </td>
                <td class="px-6 py-4 text-right">
                    {{ $record->class_rank }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection

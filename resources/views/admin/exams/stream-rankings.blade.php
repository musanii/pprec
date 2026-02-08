@extends('layouts.app')

@section('page_title', 'Stream Rankings')

@section('content')
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">
            {{ $exam->name }} — {{ $class->name }} ({{ $stream->name }})
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Stream performance ranking
        </p>
    </div>

    <a href="{{ route('admin.exams.classes.rankings', [$exam, $class]) }}"
       class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm hover:bg-slate-50">
        Back to Class Rankings
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-slate-50 text-xs text-slate-600">
            <tr>
                <th class="px-6 py-3">Position</th>
                <th class="px-6 py-3">Student</th>
                <th class="px-6 py-3 text-right">Total</th>
                <th class="px-6 py-3 text-right">Average</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse($rankings as $row)
                <tr>
                    <td class="px-6 py-4 font-semibold">{{ $row['position'] }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium">{{ $row['student']->user->name }}</div>
                        <div class="text-xs text-slate-500">
                            {{ $row['student']->admission_no }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">{{ $row['total'] }}</td>
                    <td class="px-6 py-4 text-right">{{ $row['average'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                        No results available.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

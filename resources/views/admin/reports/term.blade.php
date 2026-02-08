@extends('layouts.app')

@section('page_title', 'Term Report')

@section('content')
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">
            {{ $term->name }} — Term Report
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            {{ $student->user?->name }} • {{ $student->admission_no }}
        </p>
    </div>

    <a href="{{ route('admin.students.index') }}"
       class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm hover:bg-slate-50">
        Back to Students
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    {{-- Header --}}
    <div class="p-6 border-b border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <div class="text-xs text-slate-500">Student</div>
            <div class="font-medium text-slate-900">{{ $student->user?->name }}</div>
        </div>

        <div>
            <div class="text-xs text-slate-500">Class</div>
            <div class="font-medium text-slate-900">
                {{ $student->activeEnrollment?->schoolClass?->name }}
            </div>
        </div>

        <div>
            <div class="text-xs text-slate-500">Term</div>
            <div class="font-medium text-slate-900">{{ $term->name }}</div>
        </div>
    </div>

    {{-- Results --}}
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-50 text-xs text-slate-600">
                <tr>
                    <th class="px-6 py-3">Subject</th>
                    @foreach($exams as $exam)
                        <th class="px-6 py-3 text-right">{{ $exam->name }}</th>
                    @endforeach
                    <th class="px-6 py-3 text-right">Total</th>
                    <th class="px-6 py-3 text-right">Average</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($subjects as $row)
                    <tr>
                        <td class="px-6 py-4 font-medium text-slate-900">
                            {{ $row['subject']->name }}
                        </td>

                        @foreach($exams as $exam)
                            <td class="px-6 py-4 text-right text-slate-700">
                                {{ $row['exams'][$exam->id]->marks ?? '—' }}
                            </td>
                        @endforeach

                        <td class="px-6 py-4 text-right font-medium">
                            {{ $row['total'] }}
                        </td>

                        <td class="px-6 py-4 text-right">
                            {{ $row['average'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot class="bg-slate-50 border-t">
                <tr>
                    <td class="px-6 py-4 font-semibold">Overall</td>
                    <td colspan="{{ $exams->count() }}"></td>
                    <td class="px-6 py-4 text-right font-semibold">
                        {{ $overallTotal }}
                    </td>
                    <td class="px-6 py-4 text-right font-semibold">
                        {{ $overallAverage }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

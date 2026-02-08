@extends('layouts.app')

@section('page_title', 'Report Card')

@section('content')
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">
            {{ $exam->name }} — Report Card
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            {{ $student->user?->name }} • {{ $student->admission_no }}
        </p>
    </div>

    <a href="{{ route('admin.students.index') }}"
       class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
        Back to Students
    </a>
    <a href="{{ route('admin.students.exams.report.pdf', [$student, $exam]) }}"
   class="inline-flex items-center rounded-xl bg-primary px-4 py-2.5 text-white hover:opacity-90 shadow-sm">
    Download PDF
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
                {{ $student->activeEnrollment?->schoolClass?->name ?? '—' }}
            </div>
        </div>

        <div>
            <div class="text-xs text-slate-500">Exam</div>
            <div class="font-medium text-slate-900">{{ $exam->name }}</div>
        </div>
    </div>

    {{-- Results table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-50 text-slate-600 text-xs">
                <tr>
                    <th class="px-6 py-3 text-left font-medium">Subject</th>
                    <th class="px-6 py-3 text-right font-medium">Marks</th>
                    <th class="px-6 py-3 text-right font-medium">Grade</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($results as $row)
                    <tr>
                        <td class="px-6 py-4 font-medium text-slate-900">
                            {{ $row->subject?->name }}
                        </td>
                        <td class="px-6 py-4 text-right text-slate-700">
                            {{ $row->marks }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="inline-flex px-2 py-1 text-xs rounded-full bg-slate-100 text-slate-700">
                                {{ $row->grade ?? '—' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-slate-500">
                            No results recorded.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Summary --}}
    <div class="p-6 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-3 gap-4 bg-slate-50">
        <div>
            <div class="text-xs text-slate-500">Subjects</div>
            <div class="text-lg font-semibold text-slate-900">
                {{ $results->count() }}
            </div>
        </div>

        <div>
            <div class="text-xs text-slate-500">Total Marks</div>
            <div class="text-lg font-semibold text-slate-900">
                {{ $totalMarks }}
            </div>
        </div>

        <div>
            <div class="text-xs text-slate-500">Average</div>
            <div class="text-lg font-semibold text-slate-900">
                {{ $average ?? '—' }}
            </div>
        </div>
    </div>
</div>
@endsection

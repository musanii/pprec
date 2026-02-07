@extends('layouts.app')

@section('page_title', 'Exam Results')

@section('content')
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">
            {{ $student->user->name }}
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            {{ $exam->name }} • {{ $exam->term->name }}
        </p>
    </div>

    <a href="{{ route('admin.students.index') }}"
       class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm hover:bg-slate-50">
        Back to Students
    </a>
</div>

{{-- Summary --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
        <div class="text-xs text-slate-500">Subjects</div>
        <div class="text-2xl font-semibold text-slate-900 mt-1">
            {{ $results->count() }}
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
        <div class="text-xs text-slate-500">Total Marks</div>
        <div class="text-2xl font-semibold text-slate-900 mt-1">
            {{ $total }}
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
        <div class="text-xs text-slate-500">Average</div>
        <div class="text-2xl font-semibold text-slate-900 mt-1">
            {{ $average ?? '—' }}
        </div>
    </div>
</div>

{{-- Results table --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-slate-50 text-xs text-slate-600">
            <tr>
                <th class="px-6 py-3 text-left">Subject</th>
                <th class="px-6 py-3 text-left">Marks</th>
                <th class="px-6 py-3 text-left">Grade</th>
                <th class="px-6 py-3 text-left">Remarks</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse($results as $row)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 font-medium text-slate-900">
                        {{ $row->subject->name }}
                    </td>
                    <td class="px-6 py-4 text-slate-700">
                        {{ $row->marks }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 text-xs rounded-full border
                            bg-slate-100 text-slate-700 border-slate-200">
                            {{ $row->grade }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-600">
                        {{ $row->remarks }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                        No results available for this exam.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

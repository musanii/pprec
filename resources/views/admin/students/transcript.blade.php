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
                 <th class="px-6 py-3 text-right">Signature</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($records as $record)
            <tr>

           
                <td class="px-6 py-4">
                    {{ $record->exam->term->academicYear->name ?? '-' }}
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
                <td class="px-6 py-4 text-xs text-right text-slate-500 font-mono">
                    {{ Str::limit($record->result_hash, 16) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    

</div><div class="mt-6 p-4 border rounded-xl bg-slate-50 text-xs">
    <div class="font-semibold mb-2">Verification Signature</div>
    <div class="font-mono break-all">
        {{ $record->result_hash }}
    </div>
</div>

<div class="mt-10 grid grid-cols-2 gap-10 text-sm">
    <div>
        <div class="border-t border-slate-300 pt-2">
            Principal Signature
        </div>
    </div>

    <div>
        <div class="border-t border-slate-300 pt-2">
            Date Issued: {{ now()->format('d M Y') }}
        </div>
    </div>
</div>




@endsection

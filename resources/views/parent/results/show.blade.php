@extends('layouts.app')

@section('page_title', $student->user->name . ' – Results')

@section('content')
<div class="space-y-6">

    @forelse($exams as $exam)
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
            <div class="p-5 border-b border-slate-100">
                <div class="font-semibold text-slate-900">{{ $exam->name }}</div>
                <div class="text-xs text-slate-500">{{ $exam->term?->name }}</div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-6 py-3 text-left">Subject</th>
                            <th class="px-6 py-3 text-left">Marks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($exam->marks as $mark)
                            <tr>
                                <td class="px-6 py-3">{{ $mark->subject->name }}</td>
                                <td class="px-6 py-3 font-medium">{{ $mark->marks }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="text-center text-slate-500 py-12">
            No published results yet.
        </div>
    @endforelse

</div>
@endsection

@extends('layouts.app')

@section('page_title', 'Result Verification')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl border shadow-sm p-6">

    <h2 class="text-xl font-semibold mb-4">Result Verification</h2>

    <p><strong>Student:</strong> {{ $record->student->user->name }}</p>
    <p><strong>Exam:</strong> {{ $record->exam->name }}</p>
    <p><strong>Academic Year:</strong> {{ $record->exam->term->academicYear->name }}</p>

    <hr class="my-4">

    <p><strong>Total Marks:</strong> {{ $record->total_marks }}</p>
    <p><strong>Mean Score:</strong> {{ $record->mean_score }}</p>
    <p><strong>Class Rank:</strong> {{ $record->class_rank }}</p>
    <p><strong>Stream Rank:</strong> {{ $record->stream_rank }}</p>

    <div class="mt-4 text-green-600 font-semibold">
        ✓ Verified & Authentic
    </div>

</div>
@endsection

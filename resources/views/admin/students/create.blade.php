@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Add Student</h1>

<form method="POST" action="{{ route('admin.students.store') }}" class="space-y-6 max-w-3xl">
    @csrf

    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-medium mb-4">Student Details</h2>

        <input name="student_name" placeholder="Student Name" class="input w-full mb-3" required />
        <input name="admission_no" placeholder="Admission Number" class="input w-full mb-3" required />

        <select name="gender" class="input w-full">
            <option value="">Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-medium mb-4">Parent Details</h2>

        <input name="parent_name" placeholder="Parent Name" class="input w-full mb-3" required />
        <input name="parent_email" placeholder="Parent Email" class="input w-full mb-3" required />
        <input name="parent_phone" placeholder="Parent Phone" class="input w-full" />
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-medium mb-4">Enrollment</h2>

        <select name="class_id" class="input w-full mb-3" required>
            <option value="">Select Class</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
        </select>

        <select name="stream_id" class="input w-full">
            <option value="">Select Stream</option>
            @foreach($streams as $stream)
                <option value="{{ $stream->id }}">{{ $stream->name }}</option>
            @endforeach
        </select>
    </div>

    <button class="bg-primary text-white px-6 py-2 rounded">
        Save Student
    </button>
</form>
@endsection


@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold">Students</h1>

    <a href="{{ route('admin.students.create') }}"
       class="bg-primary text-white px-4 py-2 rounded">
        + Add Student
    </a>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded shadow p-4 mb-6">
    <form method="GET" action="{{ route('admin.students.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-3">
        <input
            name="q"
            value="{{ $filters['q'] }}"
            placeholder="Search name / admission / parent"
            class="border rounded px-3 py-2 w-full"
        />

        <select name="status" class="border rounded px-3 py-2 w-full">
            <option value="">All Status</option>
            @foreach(['admitted','active','suspended','alumni'] as $s)
                <option value="{{ $s }}" @selected($filters['status'] === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>

        <select name="class_id" class="border rounded px-3 py-2 w-full">
            <option value="">All Classes</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" @selected((int)$filters['class_id'] === $class->id)>
                    {{ $class->name }}
                </option>
            @endforeach
        </select>

        <select name="stream_id" class="border rounded px-3 py-2 w-full">
            <option value="">All Streams</option>
            @foreach($streams as $stream)
                <option value="{{ $stream->id }}" @selected((int)$filters['stream_id'] === $stream->id)>
                    {{ $stream->name }}
                </option>
            @endforeach
        </select>

        <div class="flex gap-2">
            <button class="bg-primary text-white px-4 py-2 rounded w-full">Filter</button>
            <a href="{{ route('admin.students.index') }}"
               class="bg-slate-100 text-slate-700 px-4 py-2 rounded w-full text-center">
                Reset
            </a>
        </div>
    </form>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-50 text-slate-700">
                <tr class="text-left">
                    <th class="px-4 py-3">Student</th>
                    <th class="px-4 py-3">Admission No</th>
                    <th class="px-4 py-3">Class</th>
                    <th class="px-4 py-3">Parent</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Created</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($students as $student)
                    @php
                        $enrollment = $student->activeEnrollment;
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $student->user?->name }}</div>
                            <div class="text-sm text-slate-500">{{ $student->gender ? ucfirst($student->gender) : '' }}</div>
                        </td>

                        <td class="px-4 py-3">{{ $student->admission_no }}</td>

                        <td class="px-4 py-3">
                            @if($enrollment)
                                <div class="font-medium">{{ $enrollment->schoolClass?->name }}</div>
                                <div class="text-sm text-slate-500">
                                    {{ $enrollment->stream?->name ? 'Stream '.$enrollment->stream->name : 'No stream' }}
                                </div>
                            @else
                                <span class="text-slate-500">Not enrolled</span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $student->parent?->user?->name }}</div>
                            <div class="text-sm text-slate-500">{{ $student->parent?->phone }}</div>
                        </td>

                        <td class="px-4 py-3">
                            @php
                                $badge = match($student->status) {
                                    'active' => 'bg-green-50 text-green-700 border-green-200',
                                    'admitted' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'suspended' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                    'alumni' => 'bg-slate-50 text-slate-700 border-slate-200',
                                    default => 'bg-slate-50 text-slate-700 border-slate-200',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 text-xs border rounded {{ $badge }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ $student->created_at?->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-500">
                            No students found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4">
        {{ $students->links() }}
    </div>
</div>
@endsection

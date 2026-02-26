@extends('layouts.app')

@section('page_title','Student Attendance')

@section('content')

<div class="bg-white rounded-2xl border p-6">

 <form method="GET" class="flex flex-wrap items-end gap-4">

   <div class="flex-1 min-w-[150px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">Class</label>
            <select name="class_id" class="w-full rounded-xl border px-3 py-2 text-sm">
                <option value="">Select Class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" @selected($classId == $class->id)>{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-1 min-w-[150px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">Stream</label>
            <select name="stream_id" class="w-full border rounded-xl px-3 py-2 text-sm">
                <option value="">All Streams</option>
                @foreach($streams as $stream)
                    <option value="{{ $stream->id }}" @selected($streamId == $stream->id)>{{ $stream->name }}</option>
                @endforeach
            </select>
        </div>

                <div class="flex gap-2">
           <button class="bg-primary text-white rounded-xl px-4 py-2">
        Filter
    </button>
            <a href="{{ request()->url() }}" class="bg-gray-100 text-gray-600 rounded-xl px-4 py-2 text-sm font-medium border text-center">
                Clear
            </a>
        </div>


</form>

</div>

<div class="mt-8 bg-white rounded-2xl border shadow-sm overflow-hidden">

<table class="min-w-full text-sm">
    <thead class="bg-slate-50 text-xs text-slate-600">
        <tr>
            <th class="px-6 py-3 text-left">Student</th>
            <th class="px-6 py-3 text-right">Present</th>
            <th class="px-6 py-3 text-right">Total</th>
            <th class="px-6 py-3 text-right">%</th>
            <th class="px-6 py-3 text-center">Status</th>
        </tr>
    </thead>
    <tbody class="divide-y">

        @foreach($students as $student)

            @php
                $percentage = $student->total_count > 0
                    ? round(($student->present_count / $student->total_count) * 100,2)
                    : 0;
            @endphp

            <tr>
                <td class="px-6 py-4">
                    {{ $student->user->name }}
                </td>
                <td class="px-6 py-4 text-right">
                    {{ $student->present_count }}
                </td>
                <td class="px-6 py-4 text-right">
                    {{ $student->total_count }}
                </td>
                <td class="px-6 py-4 text-right font-semibold">
                    {{ $percentage }}%
                </td>
                <td class="px-6 py-4 text-center">
                    @if($percentage < 75)
                        <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full">
                            At Risk
                        </span>
                    @else
                        <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                            Good
                        </span>
                    @endif
                </td>
            </tr>

        @endforeach

    </tbody>
</table>

<div class="p-4 border-t">
    {{ $students->links() }}
</div>

</div>

@endsection
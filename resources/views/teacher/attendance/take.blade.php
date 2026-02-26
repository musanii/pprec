@extends('layouts.app')

@section('page_title','Take Attendance')

@section('content')

<div class="bg-white rounded-2xl border shadow-sm">

    <div class="p-6 border-b">
        <h2 class="font-semibold">
            {{ $slot->subject->name }}
            - {{ $slot->schoolClass->name }}
        </h2>
    </div>

    <form method="POST"
          action="{{ route('teacher.attendance.store', $slot) }}">
        @csrf

        <div class="divide-y">

        @foreach($students as $student)

            <div class="p-4 flex justify-between items-center">

                <div>
                    {{ $student->user->name }}
                </div>

                <select name="statuses[{{ $student->id }}]"
                        class="border rounded-lg px-3 py-1 text-sm">

                    @foreach(['present','absent','late','excused'] as $status)
                        <option value="{{ $status }}"
                            @selected(($existing[$student->id] ?? 'present') == $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach

                </select>

            </div>

        @endforeach

        </div>

        <div class="p-6 border-t flex justify-end">
            <button class="px-6 py-2 bg-primary text-white rounded-xl">
                Save Attendance
            </button>
        </div>

    </form>

</div>

@endsection
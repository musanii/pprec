@extends('layouts.app')

@section('page_title','Timetable')

@section('content')

<div class="mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="text-xs font-medium text-slate-600">Class</label>
            <select name="class_id"
                    class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
                <option value="">Select Class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}"
                        @selected($classId == $class->id)>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-xs font-medium text-slate-600">Stream</label>
            <select name="stream_id"
                    class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
                <option value="">All</option>
                @foreach($streams as $stream)
                    <option value="{{ $stream->id }}"
                        @selected($streamId == $stream->id)>
                        {{ $stream->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <button class="rounded-xl bg-primary px-4 py-2.5 text-white">
                Load Timetable
            </button>
        </div>
    </form>
</div>

@if($classId)

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-x-auto">
<div x-data="timetableModal()">
<table class="min-w-full text-sm">
    <thead class="bg-slate-50 text-slate-600 text-xs">
        <tr>
            <th class="px-4 py-3 text-left">Period</th>
            @foreach(['monday','tuesday','wednesday','thursday','friday'] as $day)
                <th class="px-4 py-3 text-center capitalize">
                    {{ $day }}
                </th>
            @endforeach
        </tr>
    </thead>

    <tbody class="divide-y">

    @foreach($periods as $period)
        <tr>
            <td class="px-4 py-3 font-medium bg-slate-50">
                {{ $period->name }}
                <div class="text-xs text-slate-500">
                    {{ \Carbon\Carbon::parse($period->start_time)->format('H:i') }}
                    -
                    {{ \Carbon\Carbon::parse($period->end_time)->format('H:i') }}
                </div>
            </td>

            @foreach(['monday','tuesday','wednesday','thursday','friday'] as $day)

                @php
                    $slot = $slots[$period->id][$day][0] ?? null;
                @endphp

                <td class="px-4 py-3 text-center border-l">

                    @if($slot)
                        <div class="font-medium text-slate-900">
                            {{ $slot->subject->name }}
                        </div>
                        <div class="text-xs text-slate-500">
                            {{ $slot->teacher->user->name }}
                        </div>
                    @else
                        <button @click="openModal({{ $period->id }}, '{{ $day }}')" 
                            class="text-xs text-primary hover:underline">
                            + Assign
                        </button>
                    @endif

                </td>

            @endforeach
        </tr>
    @endforeach

    </tbody>
</table>
    <!-- Hidden Trigger -->
    <template x-if="open">
        <div class="fixed inset-0 bg-black/30 flex items-center justify-center z-50">
            <div class="bg-white w-[420px] rounded-2xl shadow-xl p-6">

                <h2 class="text-lg font-semibold mb-4">
                    Assign Slot
                </h2>

                <form method="POST" action="{{ route('admin.timetable.store') }}">
                    @csrf

                    <input type="hidden" name="academic_year_id" value="{{ $year->id }}">
                    <input type="hidden" name="term_id" value="{{ $term->id }}">
                    <input type="hidden" name="class_id" value="{{ $classId }}">
                    <input type="hidden" name="stream_id" value="{{ $streamId }}">
                    <input type="hidden" name="school_period_id" :value="period">
                    <input type="hidden" name="day_of_week" :value="day">

                    <div class="mb-4">
                        <label class="text-xs text-slate-600">Subject</label>
                        <select name="subject_id"
                                class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="text-xs text-slate-600">Teacher</label>
                        <select name="teacher_id"
                                class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm">
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">
                                    {{ $teacher->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button"
                                @click="closeModal()"
                                class="px-4 py-2 text-sm rounded-xl border">
                            Cancel
                        </button>

                        <button type="submit"
                                class="px-4 py-2 text-sm rounded-xl bg-primary text-white">
                            Assign
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </template>
</div>

</div>
<script>
    function timetableModal(){
        return {
            open:false,
            period:null,
            day:null,

            openModal(periodId, dayName){
                this.period = periodId;
                this.day= dayName;
                this.open=true;
            },
            closeModal()
            {
                this.open = false;
            }
        }
    }
</script>



@endif

@endsection

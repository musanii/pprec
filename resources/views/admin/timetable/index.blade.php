@extends('layouts.app')

@section('page_title','Timetable')

@section('content')

<div class="mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="text-xs font-medium text-slate-600">Class</label>
            <select name="class_id"
                    class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm" onchange="this.form.stream_id.value=''; this.form.submit();">
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
<table class="min-w-full text-sm border border-slate-200">
    <thead class="bg-slate-50 text-slate-600 text-xs">
        <tr>
            <th class="px-4 py-3 text-left">Period</th>
            @foreach(['monday','tuesday','wednesday','thursday','friday'] as $day)
                <th class="px-4 py-3 text-center capitalize font-semibold text-slate-700">
                    {{ ucfirst($day) }}
                </th>
            @endforeach
        </tr>
    </thead>

    <tbody class="divide-y">

    @foreach($periods as $period)
        <tr>
            <td class="px-4 py-3 text-center border border-slate-100">
                {{ $period->name }}
                <div class="text-xs text-slate-500">
                    {{ \Carbon\Carbon::parse($period->start_time)->format('H:i') }}
                    -
                    {{ \Carbon\Carbon::parse($period->end_time)->format('H:i') }}
                </div>
            </td>

           @php
               $days =  ['monday','tuesday','wednesday','thursday','friday'];
           @endphp
           @foreach($days as $day)

                @php
                    $slot = $slots[$period->id][$day][0] ?? null;
                @endphp

                <td class="px-4 py-3 text-center border-l">

                    @if($slot)

                    

<div class="group relative bg-indigo-50 rounded-xl p-2 text-left hover:bg-indigo-100 transition">

    <div class="font-semibold text-indigo-900 text-sm">
        {{ $slot->subject->name }}
    </div>

    <div class="flex items-center gap-2 mt-1">
        <div class="w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-[10px] font-bold">
            {{ strtoupper(substr($slot->teacher->user->name,0,1)) }}
        </div>
        <div class="text-xs text-indigo-700 truncate">
            {{ $slot->teacher->user->name }}
        </div>
    </div>

    {{-- Hover Actions --}}
    <div class="absolute top-1 right-1 hidden group-hover:flex gap-1">
        <button
            @click="editSlot(
            {{$slot->id}},
            {{ $period->id }},
              '{{ $day }}',
              {{ $slot->subject_id }},
               {{ $slot->teacher_id }} 
                )"
            class="text-xs text-slate-600 hover:text-indigo-600">
            <x-heroicon-o-pencil-square class="w-5 h-5" />
        </button>

        <form method="POST"
              action="{{ route('admin.timetable.destroy', $slot) }}">
            @csrf
            @method('DELETE')
            <button class="text-xs text-red-500 hover:text-red-700">
                <x-heroicon-o-trash class="w-5 h-5" />
            </button>
        </form>
    </div>

</div>

@else

@if ($hasStreams && !$streamId)
<span class="text-xs text-slate-300 cursor-not-allowed">
    Select Stream 
</span>
@else
<button @click="openModal({{ $period->id }}, '{{ $day }}')" 
    class="w-full h-full py-4 text-xs text-slate-400 hover:text-indigo-600 hover:bg-slate-50 rounded-xl transition">
    + Assign
</button>
    
@endif



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

                <form method="POST" :action= "editing ? '{{url('admin/timetable')}}/' +slotId : '{{ route('admin.timetable.store') }}'">
                    @csrf
                    <input type="hidden" name="hasStreams" value="{{$hasStreams}}">
                    <template x-if="editing">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <input type="hidden" name="academic_year_id" value="{{ $year->id }}">
                    <input type="hidden" name="term_id" value="{{ $term->id }}">
                    <input type="hidden" name="class_id" value="{{ $classId }}">
                    <input type="hidden" name="stream_id" value="{{ $streamId }}">
                    <input type="hidden" name="school_period_id" :value="period">
                    <input type="hidden" name="day_of_week" :value="day">

                    <div class="mb-4">
                        <label class="text-xs text-slate-600">Subject</label>
                        <select name="subject_id" x-model="subjectId"
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
                        <select name="teacher_id" x-model="teacherId"
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
            slotId:null,
            editing:false,
            subjectId:null,
            teacherId:null,

            editSlot(id,periodId,dayName, subjectId,teacherId){
                this.slotId = id;
                this.period = periodId;
                this.day = dayName;
                this.subjectId=subjectId;
                this.teacherId=teacherId;
                this.editing = true;
                this.open = true;

            },

            openModal(periodId, dayName){
                this.slotId=null;
                this.period = periodId;
                this.day= dayName;
                this.subjectId =null;
                this.teacherId=null;
                this.editing = false;
                this.open=true;

                this.$nextTick(()=>{
                    const form = this.$el.querySelector('form');
                    form.reset();
                })
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

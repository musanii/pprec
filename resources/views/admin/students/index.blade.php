@extends('layouts.app')

@section('page_title', 'Students')

@section('content')
{{-- Page header (outside the card) --}}
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Students</h1>
        <p class="text-sm text-slate-500 mt-1">Manage student records and enrollments</p>
    </div>

    <a href="{{ route('admin.students.create') }}"
       class="inline-flex items-center rounded-xl bg-primary px-4 py-2.5 text-white hover:opacity-90 shadow-sm">
        + Add Student
    </a>
</div>

{{-- Single container = toolbar + table align perfectly --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    {{-- Toolbar --}}
    <div class="p-4 sm:p-5 border-b border-slate-100">
        <form method="GET" action="{{ route('admin.students.index') }}"
              class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            
            {{-- Search --}}
            <div class="md:col-span-4">
                <label class="text-xs font-medium text-slate-600">Search</label>
                <input
                    name="q"
                    value="{{ $filters['q'] }}"
                    placeholder="Name / admission / parent"
                    class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm
                           focus:outline-none focus:ring-2 focus:ring-primary/20"
                />
            </div>

            {{-- Status --}}
            <div class="md:col-span-2">
                <label class="text-xs font-medium text-slate-600">Status</label>
                <select name="status"
                        class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm
                               focus:outline-none focus:ring-2 focus:ring-primary/20">
                    <option value="">All</option>
                    @foreach(['admitted','active','suspended','alumni','archived'] as $s)
                        <option value="{{ $s }}" @selected($filters['status'] === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Class --}}
            <div class="md:col-span-3">
                <label class="text-xs font-medium text-slate-600">Class</label>
                <select name="class_id"
                        class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm
                               focus:outline-none focus:ring-2 focus:ring-primary/20">
                    <option value="">All</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" @selected((int)$filters['class_id'] === $class->id)>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Stream --}}
            <div class="md:col-span-3">
                <label class="text-xs font-medium text-slate-600">Stream</label>
                <select name="stream_id"
                        class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm
                               focus:outline-none focus:ring-2 focus:ring-primary/20">
                    <option value="">All</option>
                    @foreach($streams as $stream)
                        <option value="{{ $stream->id }}" @selected((int)$filters['stream_id'] === $stream->id)>
                            {{ $stream->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Buttons --}}
            <div class="md:col-span-12 flex gap-2 justify-end pt-1">
                <button class="rounded-xl bg-primary px-4 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
                    Filter
                </button>
                <a href="{{ route('admin.students.index') }}"
                   class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-50 text-slate-600 text-xs">
                <tr>
                    <th class="px-6 py-3 text-left font-medium">Student</th>
                    <th class="px-6 py-3 text-left font-medium">Admission No</th>
                    <th class="px-6 py-3 text-left font-medium">Class</th>
                    <th class="px-6 py-3 text-left font-medium">Parent</th>
                    <th class="px-6 py-3 text-left font-medium">Status</th>
                    <th class="px-6 py-3 text-left font-medium">Created</th>
                    <th class="px-6 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($students as $student)
                    @php $enrollment = $student->activeEnrollment; @endphp
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $student->user?->name }}</div>
                            <div class="text-xs text-slate-500">
                                {{ $student->gender ? ucfirst($student->gender) : '' }}
                            </div>
                        </td>

                        <td class="px-6 py-4 text-slate-700">{{ $student->admission_no }}</td>

                        <td class="px-6 py-4">
                            @if($enrollment)
                                <div class="font-medium text-slate-900">{{ $enrollment->schoolClass?->name }}</div>
                                <div class="text-xs text-slate-500">
                                    {{ $enrollment->stream?->name ? 'Stream '.$enrollment->stream->name : 'No stream' }}
                                </div>
                            @else
                                <span class="text-slate-500">Not enrolled</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $student->parent?->user?->name }}</div>
                            <div class="text-xs text-slate-500">{{ $student->parent?->phone }}</div>
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $badge = match($student->status) {
                                    'active' => 'bg-green-50 text-green-700 border-green-200',
                                    'admitted' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'suspended' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                    'alumni' => 'bg-slate-50 text-slate-700 border-slate-200',
                                    'archived' => 'bg-slate-100 text-slate-700 border-slate-200',
                                    default => 'bg-slate-50 text-slate-700 border-slate-200',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 text-xs border rounded-full {{ $badge }}">
                                {{ ucfirst($student->status) }}
                            </span>
                            </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $student->created_at?->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
    <div
        class="inline-block"
        x-data="{
            open:false,
            x:0, y:0, w:0,
            place() {
                const r = this.$refs.btn.getBoundingClientRect();
                this.w = r.width;
                this.x = r.right; // anchor to right edge
                this.y = r.bottom;
            }
        }"
        x-init="
            window.addEventListener('scroll', () => open && place(), true);
            window.addEventListener('resize', () => open && place());
        "
    >
        <button
            type="button"
            x-ref="btn"
            @click="open = !open; if(open) $nextTick(() => place())"
            class="inline-flex items-center justify-center rounded-lg px-2 py-1 text-slate-500 hover:bg-slate-100"
            aria-label="Actions"
        >
            ⋯
        </button>

        <template x-teleport="body">
            <div
                x-show="open"
                x-transition.opacity
                @click.outside="open=false"
                x-cloak
                class="fixed z-[9999]"
                :style="`left:${x}px; top:${y}px; transform: translateX(-100%);`"
            >
                <div class="w-44 rounded-xl border border-slate-200 bg-white shadow-lg overflow-hidden">
                <a href="{{ route('admin.students.edit', $student) }}"
                class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                    Edit
                </a>
                
                


            @if($exams->count())
                <div class="px-2 py-1 text-[11px] uppercase tracking-wide text-slate-400">
                    Exam Results
                </div>

                @foreach($exams as $exam)
                    <a
                        href="{{ route('admin.students.exams.show', [$student, $exam]) }}"
                        class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50"
                    >
                        {{ $exam->name }}
                    </a>

                    <a href="{{ route('admin.students.transcript', $student) }}"
                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                    View Transcript
                    </a>

                    <a href="{{ route('admin.students.exams.report', [$student, $exam]) }}"
                    class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                        View Report Card
                    </a>

                    <a href="{{ route('admin.students.terms.report', [$student, $term]) }}"
                    class="block px-4 py-2.5 text-sm hover:bg-slate-50">
                        {{ $term->name }} Report
                    </a>
                @endforeach

                <div class="h-px bg-slate-100 my-1"></div>
            @endif
            

                <div class="h-px bg-slate-100"></div>

                {{-- Quick status actions --}}
                @php $current = $student->status; @endphp

                @foreach([
                    'active' => 'Mark Active',
                    'suspended' => 'Suspend',
                    'alumni' => 'Mark Alumni',
                    'archived' => 'Archive (Transfer Out)',
                ] as $value => $label)
                    <form method="POST" action="{{ route('admin.students.status', $student) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $value }}">
                    
                        <button
                            type="submit"
                            class="w-full text-left px-4 py-2.5 text-sm hover:bg-slate-50
                                {{ $current === $value ? 'text-slate-400 cursor-not-allowed' : 'text-slate-700' }}"
                            {{ $current === $value ? 'disabled' : '' }}
                        >
                            {{ $label }}
                        </button>
                    </form>
                @endforeach
            </div>

            </div>
        </template>
    </div>
</td>


                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            No students found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="p-4 sm:p-5 border-t border-slate-100 bg-white">
        {{ $students->links() }}
    </div>
</div>

@endsection

@extends('layouts.app')

@section('page_title', 'Edit Student')

@section('content')
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Edit Student</h1>
        <p class="text-sm text-slate-500 mt-1">
            Update details and manage enrollment for {{ $student->user?->name }}.
        </p>
    </div>

    <a href="{{ route('admin.students.show', $student) }}"
       class="hidden sm:inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
        Back to Profile
    </a>
</div>

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4">
        <div class="text-sm font-semibold text-red-800">Please fix the errors below.</div>
        <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1">
            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Edit form --}}
    <form method="POST" action="{{ route('admin.students.update', $student) }}" class="lg:col-span-2 space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100">
                <div class="text-sm font-semibold text-slate-900">Student</div>
                <div class="text-xs text-slate-500 mt-1">Core student record.</div>
            </div>

            <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="text-xs font-medium text-slate-600">Student Name</label>
                    <input name="student_name"
                           value="{{ old('student_name', $student->user?->name) }}"
                           class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm bg-white
                                  focus:outline-none focus:ring-2 focus:ring-primary/20
                                  @error('student_name') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror" />
                    @error('student_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-xs font-medium text-slate-600">Admission Number</label>
                    <input name="admission_no"
                           value="{{ old('admission_no', $student->admission_no) }}"
                           class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm bg-white
                                  focus:outline-none focus:ring-2 focus:ring-primary/20
                                  @error('admission_no') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror" />
                    @error('admission_no') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-xs font-medium text-slate-600">Gender</label>
                    <select name="gender"
                            class="mt-1 w-full rounded-xl border bg-white px-3 py-2.5 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-primary/20
                                   @error('gender') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror">
                        <option value="">Select</option>
                        <option value="male" @selected(old('gender', $student->gender) === 'male')>Male</option>
                        <option value="female" @selected(old('gender', $student->gender) === 'female')>Female</option>
                    </select>
                    @error('gender') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="text-xs font-medium text-slate-600">Status</label>
                    <select name="status"
                            class="mt-1 w-full rounded-xl border bg-white px-3 py-2.5 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-primary/20
                                   @error('status') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror">
                        @foreach(['admitted','active','suspended','alumni'] as $s)
                            <option value="{{ $s }}" @selected(old('status', $student->status) === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    @error('status') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100">
                <div class="text-sm font-semibold text-slate-900">Parent</div>
                <div class="text-xs text-slate-500 mt-1">Contact details.</div>
            </div>

            <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="text-xs font-medium text-slate-600">Parent Name</label>
                    <input name="parent_name"
                           value="{{ old('parent_name', $student->parent?->user?->name) }}"
                           class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm bg-white
                                  focus:outline-none focus:ring-2 focus:ring-primary/20
                                  @error('parent_name') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror" />
                    @error('parent_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-xs font-medium text-slate-600">Phone</label>
                    <input name="parent_phone"
                           value="{{ old('parent_phone', $student->parent?->phone) }}"
                           class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm bg-white
                                  focus:outline-none focus:ring-2 focus:ring-primary/20
                                  @error('parent_phone') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror" />
                    @error('parent_phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="text-xs text-slate-500 flex items-end">
                    Parent email changes can be added later if needed.
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.students.show', $student) }}"
               class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                Cancel
            </a>
            <button class="rounded-xl bg-primary px-5 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
                Save Changes
            </button>
        </div>
    </form>

    {{-- Transfer card --}}
    @php
        $currentClassId = $student->activeEnrollment?->class_id;
        $currentStreamId = $student->activeEnrollment?->stream_id;
    @endphp

    <div
        class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden h-fit"
        x-data="{
            classId: '{{ old('class_id_transfer', $currentClassId) }}',
            streamId: '{{ old('stream_id_transfer', $currentStreamId) }}',
            streamsByClass: @js($streamsByClass),
            get streams() { return this.streamsByClass[this.classId] ?? [] },
            resetStreamIfInvalid() {
                if (!this.streams.find(s => String(s.id) === String(this.streamId))) this.streamId = ''
            }
        }"
        x-init="resetStreamIfInvalid()"
    >
        <div class="p-5 border-b border-slate-100">
            <div class="text-sm font-semibold text-slate-900">Transfer Enrollment</div>
            <div class="text-xs text-slate-500 mt-1">Move the student to a new class/stream.</div>
        </div>

        <form method="POST" action="{{ route('admin.students.transfer', $student) }}" class="p-5 space-y-4">
            @csrf

            <div>
                <label class="text-xs font-medium text-slate-600">Class</label>
                <select name="class_id" x-model="classId" @change="resetStreamIfInvalid()"
                        class="mt-1 w-full rounded-xl border bg-white px-3 py-2.5 text-sm border-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20">
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-xs font-medium text-slate-600">Stream</label>
                <select name="stream_id" x-model="streamId" :disabled="!classId || streams.length === 0"
                        class="mt-1 w-full rounded-xl border bg-white px-3 py-2.5 text-sm border-slate-200 disabled:bg-slate-50 disabled:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20">
                    <option value="" x-text="!classId ? 'Select class first' : (streams.length ? 'Select Stream' : 'No streams available')"></option>
                    <template x-for="s in streams" :key="s.id">
                        <option :value="s.id" x-text="s.name"></option>
                    </template>
                </select>
            </div>

            <div>
                <label class="text-xs font-medium text-slate-600">Reason (optional)</label>
                <input name="reason" value="{{ old('reason') }}"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20"
                       placeholder="e.g. Transfer to Grade 5 Blue" />
            </div>

            <button class="w-full rounded-xl bg-primary px-5 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
                Transfer Student
            </button>

            <p class="text-xs text-slate-500">
                This action creates a new active enrollment (and deactivates the previous one if your service does that).
            </p>
        </form>
    </div>
</div>
@endsection

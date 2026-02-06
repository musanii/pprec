@extends('layouts.app')

@section('page_title', 'Add Student')

@section('content')
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Add Student</h1>
        <p class="text-sm text-slate-500 mt-1">Create a student, link a parent, and enroll them.</p>
    </div>

    <a href="{{ route('admin.students.index') }}"
       class="hidden sm:inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
        Back to Students
    </a>
</div>

{{-- Error summary --}}
@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4">
        <div class="text-sm font-semibold text-red-800">Please fix the highlighted fields below.</div>
        <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.students.store') }}" class="space-y-6" x-data="{ saving:false }" @submit="saving=true">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: Student + Parent --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Student Details --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100">
                    <div class="text-sm font-semibold text-slate-900">Student Details</div>
                    <div class="text-xs text-slate-500 mt-1">Basic student information.</div>
                </div>

                <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="text-xs font-medium text-slate-600">Student Name</label>
                        <input
                            name="student_name"
                            value="{{ old('student_name') }}"
                            placeholder="e.g. Amina Wanjiku"
                            class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm bg-white
                                   focus:outline-none focus:ring-2 focus:ring-primary/20
                                   @error('student_name') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror"
                            
                        />
                        @error('student_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-xs font-medium text-slate-600">Admission Number</label>
                        <input
                            name="admission_no"
                            value="{{ old('admission_no') }}"
                            placeholder="e.g. PR-2026-001"
                            class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm bg-white
                                   focus:outline-none focus:ring-2 focus:ring-primary/20
                                   @error('admission_no') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror"
                            
                        />
                        @error('admission_no')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-xs font-medium text-slate-600">Gender</label>
                        <select
                            name="gender"
                            class="mt-1 w-full rounded-xl border bg-white px-3 py-2.5 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-primary/20
                                   @error('gender') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror"
                        >
                            <option value="">Select</option>
                            <option value="male" @selected(old('gender') === 'male')>Male</option>
                            <option value="female" @selected(old('gender') === 'female')>Female</option>
                        </select>
                        @error('gender')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Parent Details --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100">
                    <div class="text-sm font-semibold text-slate-900">Parent Details</div>
                    <div class="text-xs text-slate-500 mt-1">Contact info + parent portal access.</div>
                </div>

                <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="text-xs font-medium text-slate-600">Parent Name</label>
                        <input
                            name="parent_name"
                            value="{{ old('parent_name') }}"
                            placeholder="e.g. Kevin Musanii"
                            class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm bg-white
                                   focus:outline-none focus:ring-2 focus:ring-primary/20
                                   @error('parent_name') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror"
                            
                        />
                        @error('parent_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-xs font-medium text-slate-600">Parent Email</label>
                        <input
                            type="email"
                            name="parent_email"
                            value="{{ old('parent_email') }}"
                            placeholder="e.g. parent@example.com"
                            class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm bg-white
                                   focus:outline-none focus:ring-2 focus:ring-primary/20
                                   @error('parent_email') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror"
                            
                        />
                        @error('parent_email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-xs font-medium text-slate-600">Parent Phone</label>
                        <input
                            name="parent_phone"
                            value="{{ old('parent_phone') }}"
                            placeholder="e.g. 0712 345 678"
                            class="mt-1 w-full rounded-xl border px-3 py-2.5 text-sm bg-white
                                   focus:outline-none focus:ring-2 focus:ring-primary/20
                                   @error('parent_phone') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror"
                        />
                        @error('parent_phone')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-xs text-slate-500">
                            A temporary password is generated for the parent automatically. We’ll add a “Send invite / reset link” flow next.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Enrollment --}}
        <div class="lg:col-span-1">
            <div
                class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden"
                x-data="{
                    classId: '{{ old('class_id') }}',
                    streamId: '{{ old('stream_id') }}',
                    streamsByClass: @js($streamsByClass),
                    get streams() { return this.streamsByClass[this.classId] ?? [] },
                    resetStreamIfInvalid() {
                        if (!this.streams.find(s => String(s.id) === String(this.streamId))) {
                            this.streamId = ''
                        }
                    }
                }"
                x-init="resetStreamIfInvalid()"
            >
                <div class="p-5 border-b border-slate-100">
                    <div class="text-sm font-semibold text-slate-900">Enrollment</div>
                    <div class="text-xs text-slate-500 mt-1">Assign class and stream.</div>
                </div>

                <div class="p-5 space-y-4">
                    <div>
                        <label class="text-xs font-medium text-slate-600">Class</label>
                        <select
                            name="class_id"
                            
                            x-model="classId"
                            @change="resetStreamIfInvalid()"
                            class="mt-1 w-full rounded-xl border bg-white px-3 py-2.5 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-primary/20
                                   @error('class_id') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror"
                        >
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" @selected((string)old('class_id') === (string)$class->id)>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-xs font-medium text-slate-600">Stream</label>
                        <select
                            name="stream_id"
                            x-model="streamId"
                            :disabled="!classId || streams.length === 0"
                            class="mt-1 w-full rounded-xl border bg-white px-3 py-2.5 text-sm
                                   disabled:bg-slate-50 disabled:text-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-primary/20
                                   @error('stream_id') border-red-300 ring-2 ring-red-100 @else border-slate-200 @enderror"
                        >
                            <option value="" x-text="!classId ? 'Select class first' : (streams.length ? 'Select Stream' : 'No streams available')"></option>

                            <template x-for="s in streams" :key="s.id">
                                <option :value="s.id" x-text="s.name"></option>
                            </template>
                        </select>
                        @error('stream_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                        <div class="text-xs font-medium text-slate-700">Tip</div>
                        <p class="mt-1 text-xs text-slate-500">
                            If a class has no streams, leave Stream empty.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sticky action bar --}}
    <div class="sticky bottom-4">
        <div class="bg-white/90 backdrop-blur rounded-2xl border border-slate-200 shadow-sm px-4 py-3 flex items-center justify-between">
            <a href="{{ route('admin.students.index') }}"
               class="text-sm rounded-xl border border-slate-200 bg-white px-4 py-2 hover:bg-slate-50">
                Cancel
            </a>

            <button
                type="submit"
                class="text-sm rounded-xl bg-primary px-5 py-2 text-white hover:opacity-90 shadow-sm disabled:opacity-60"
                :disabled="saving"
            >
                <span x-show="!saving">Save Student</span>
                <span x-show="saving">Saving...</span>
            </button>
        </div>
    </div>
</form>
@endsection

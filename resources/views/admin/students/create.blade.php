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

   <div class="bg-white p-6 rounded shadow"
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
    <h2 class="font-medium mb-4">Enrollment</h2>

    <select name="class_id"
            class="border rounded px-3 py-2 w-full mb-3"
            required
            x-model="classId"
            @change="resetStreamIfInvalid()"
    >
        <option value="">Select Class</option>
        @foreach($classes as $class)
            <option value="{{ $class->id }}">{{ $class->name }}</option>
        @endforeach
    </select>

    <select name="stream_id"
            class="border rounded px-3 py-2 w-full"
            x-model="streamId"
            :disabled="!classId || streams.length === 0"
    >
        <option value="">
            <span x-text="!classId ? 'Select class first' : (streams.length ? 'Select Stream' : 'No streams available')"></span>
        </option>

        <template x-for="s in streams" :key="s.id">
            <option :value="s.id" x-text="s.name"></option>
        </template>
    </select>

    @error('class_id')
        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
    @enderror
    @error('stream_id')
        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>


    <button class="bg-primary text-white px-6 py-2 rounded">
        Save Student
    </button>
</form>
@endsection


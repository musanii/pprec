@extends('layouts.app')

@section('page_title', 'Edit Teacher')

@section('content')
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Edit Teacher</h1>
        <p class="text-sm text-slate-500 mt-1">
            Update details for {{ $teacher->user?->name }}
        </p>
    </div>

    <a href="{{ route('admin.teachers.index') }}"
       class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm hover:bg-slate-50">
        Back
    </a>
</div>

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4">
        <div class="text-sm font-semibold text-red-800">Please fix the errors below.</div>
        <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" class="max-w-3xl space-y-6">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <div class="text-sm font-semibold text-slate-900">Teacher Details</div>
        </div>

        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="text-xs font-medium text-slate-600">Full Name</label>
                <input name="name" value="{{ old('name', $teacher->user?->name) }}"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm">
            </div>

            <div>
                <label class="text-xs font-medium text-slate-600">Staff No</label>
                <input name="staff_no" value="{{ old('staff_no', $teacher->staff_no) }}"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm">
            </div>

            <div>
                <label class="text-xs font-medium text-slate-600">Phone</label>
                <input name="phone" value="{{ old('phone', $teacher->phone) }}"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm">
            </div>

            <div>
                <label class="text-xs font-medium text-slate-600">Gender</label>
                <select name="gender"
                        class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm">
                    <option value="">Select</option>
                    <option value="male" @selected(old('gender', $teacher->gender) === 'male')>Male</option>
                    <option value="female" @selected(old('gender', $teacher->gender) === 'female')>Female</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" name="is_active" value="1"
                           class="rounded border-slate-300"
                           @checked(old('is_active', $teacher->is_active))>
                    Active
                </label>
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-2">
        <a href="{{ route('admin.teachers.index') }}"
           class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm hover:bg-slate-50">
            Cancel
        </a>
        <button class="rounded-xl bg-primary px-5 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
            Save Changes
        </button>
    </div>
</form>
@endsection

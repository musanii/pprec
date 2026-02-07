@extends('layouts.app')

@section('page_title', 'Add Teacher')

@section('content')
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Add Teacher</h1>
        <p class="text-sm text-slate-500 mt-1">Create a new teacher account</p>
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

<form method="POST" action="{{ route('admin.teachers.store') }}" class="max-w-3xl space-y-6">
    @csrf

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <div class="text-sm font-semibold text-slate-900">Teacher Details</div>
            <div class="text-xs text-slate-500 mt-1">Account and profile information.</div>
        </div>

        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="text-xs font-medium text-slate-600">Full Name</label>
                <input name="name" value="{{ old('name') }}"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary/20"
                       required>
            </div>

            <div class="md:col-span-2">
                <label class="text-xs font-medium text-slate-600">Email</label>
                <input name="email" type="email" value="{{ old('email') }}"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-primary/20"
                       required>
            </div>

            <div>
                <label class="text-xs font-medium text-slate-600">Staff No</label>
                <input name="staff_no" value="{{ old('staff_no') }}"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm"
                       required>
            </div>

            <div>
                <label class="text-xs font-medium text-slate-600">Phone</label>
                <input name="phone" value="{{ old('phone') }}"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm">
            </div>

            <div>
                <label class="text-xs font-medium text-slate-600">Gender</label>
                <select name="gender"
                        class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm">
                    <option value="">Select</option>
                    <option value="male" @selected(old('gender') === 'male')>Male</option>
                    <option value="female" @selected(old('gender') === 'female')>Female</option>
                </select>
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-2">
        <a href="{{ route('admin.teachers.index') }}"
           class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm hover:bg-slate-50">
            Cancel
        </a>
        <button class="rounded-xl bg-primary px-5 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
            Save Teacher
        </button>
    </div>
</form>
@endsection

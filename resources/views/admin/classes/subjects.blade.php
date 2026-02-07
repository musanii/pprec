@extends('layouts.app')

@section('page_title', 'Class Subjects')

@section('content')
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">
            {{ $class->name }} — Subjects
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Assign and manage subjects for this class
        </p>
    </div>

    <a href="{{ route('admin.classes.index') }}"
       class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm hover:bg-slate-50">
        Back
    </a>
</div>

<form method="POST" action="{{ route('admin.classes.subjects.update', $class) }}" class="max-w-4xl">
    @csrf

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <div class="text-sm font-semibold text-slate-900">Available Subjects</div>
            <div class="text-xs text-slate-500 mt-1">
                Tick subjects taught in this class
            </div>
        </div>

        <div class="divide-y">
            @foreach($subjects as $subject)
                @php $isAssigned = isset($assigned[$subject->id]); @endphp

                <div class="flex items-center justify-between p-4 hover:bg-slate-50">
                    <div>
                        <div class="font-medium text-slate-900">
                            {{ $subject->name }}
                        </div>
                        <div class="text-xs text-slate-500">
                            {{ $subject->code }}
                        </div>
                    </div>

                    <div class="flex items-center gap-6">
                        <label class="inline-flex items-center gap-2 text-sm">
                            <input
                                type="checkbox"
                                name="subjects[{{ $subject->id }}][is_compulsory]"
                                value="1"
                                class="rounded border-slate-300"
                                @checked($isAssigned && $assigned[$subject->id]['is_compulsory'])
                            >
                            Compulsory
                        </label>

                        <input
                            type="checkbox"
                            name="subjects[{{ $subject->id }}][enabled]"
                            value="1"
                            class="rounded border-slate-300"
                            @checked($isAssigned)
                        >
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex justify-end mt-5">
        <button
            class="rounded-xl bg-primary px-6 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
            Save Subjects
        </button>
    </div>
</form>
@endsection

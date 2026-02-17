@extends('layouts.app')

@section('page_title', 'Dashboard')

@section('content')
@php
    $activeYear = \App\Models\AcademicYear::where('is_active', true)->first();
    $activeTerm = \App\Models\Term::where('is_active', true)->first();

    $studentsCount = \App\Models\Student::count();
    $activeStudentsCount = \App\Models\Student::where('status', 'active')->count();
    $admittedCount = \App\Models\Student::where('status', 'admitted')->count();

    $recentStudents = \App\Models\Student::with(['user', 'activeEnrollment.schoolClass', 'activeEnrollment.stream'])
        ->latest()->take(6)->get();
@endphp

{{-- Premium header / hero --}}
<div class="mb-6">
    <div class="rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                <div>
                    <div class="text-xs font-semibold tracking-wide uppercase text-slate-500">
                        Piphan Rose Educational Centre
                    </div>
                    <h1 class="mt-2 text-2xl sm:text-3xl font-semibold text-slate-900">
                        Welcome back, {{ auth()->user()->name }} 👋
                    </h1>
                    <p class="mt-2 text-sm text-slate-600 max-w-2xl">
                        Keep track of students, enrollments, academics, finance, inventory and activities — all in one system.
                    </p>

                    <div class="mt-5 flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs text-slate-700">
                            <span class="h-2 w-2 rounded-full bg-primary"></span>
                            System: Operational
                        </span>

                        <span class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1 text-xs text-slate-700">
                            Academic Year: <span class="ml-1 font-medium">{{ $activeYear?->name ?? 'Not set' }}</span>
                        </span>

                        <span class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1 text-xs text-slate-700">
                            Active Term: <span class="ml-1 font-medium">{{ $activeTerm?->name ?? 'Not set' }}</span>
                        </span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.students.create') }}"
                       class="inline-flex items-center justify-center rounded-xl bg-primary px-4 py-2.5 text-white hover:opacity-90 shadow-sm">
                        + Add Student
                    </a>

                    <a href="{{ route('admin.students.index') }}"
                       class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-slate-700 hover:bg-slate-50">
                        View Students
                    </a>
                </div>
            </div>
        </div>

        {{-- subtle decorative footer strip (no overlay) --}}
        <div class="h-2 bg-gradient-to-r from-slate-50 via-white to-slate-50"></div>
    </div>
</div>

{{-- KPI cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
    <div class="rounded-2xl border border-slate-100 bg-white shadow-sm p-5">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs text-slate-500">Total Students</div>
                <div class="mt-2 text-2xl font-semibold text-slate-900">{{ number_format($studentsCount) }}</div>
                <div class="mt-1 text-xs text-slate-500">All records</div>
            </div>
            <div class="rounded-xl bg-slate-50 border border-slate-100 px-3 py-2 text-xs text-slate-600">
                Students
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-100 bg-white shadow-sm p-5">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs text-slate-500">Active Students</div>
                <div class="mt-2 text-2xl font-semibold text-slate-900">{{ number_format($activeStudentsCount) }}</div>
                <div class="mt-1 text-xs text-slate-500">Currently enrolled</div>
            </div>
            <div class="rounded-xl bg-green-50 border border-green-100 px-3 py-2 text-xs text-green-700">
                Active
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-100 bg-white shadow-sm p-5">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs text-slate-500">Admitted</div>
                <div class="mt-2 text-2xl font-semibold text-slate-900">{{ number_format($admittedCount) }}</div>
                <div class="mt-1 text-xs text-slate-500">Pending activation</div>
            </div>
            <div class="rounded-xl bg-blue-50 border border-blue-100 px-3 py-2 text-xs text-blue-700">
                Admitted
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-100 bg-white shadow-sm p-5">
        <div class="flex items-start justify-between">
            <div>
                <div class="text-xs text-slate-500">Finance</div>
                <div class="mt-2 text-2xl font-semibold text-slate-900">—</div>
                <div class="mt-1 text-xs text-slate-500">Module coming next</div>
            </div>
            <div class="rounded-xl bg-slate-50 border border-slate-100 px-3 py-2 text-xs text-slate-600">
                Soon
            </div>
        </div>
    </div>
</div>

{{-- Actions + Recent students --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    {{-- Quick actions --}}
    <div class="rounded-2xl border border-slate-100 bg-white shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-sm font-semibold text-slate-900">Quick Actions</div>
                <div class="text-xs text-slate-500">Shortcuts for admins</div>
            </div>
            <span class="text-[11px] rounded-full border border-slate-200 bg-slate-50 px-2 py-1 text-slate-600">
                Admin
            </span>
        </div>

        <div class="mt-5 space-y-3">
            <a href="{{ route('admin.students.create') }}"
               class="block rounded-2xl border border-slate-200 p-4 hover:bg-slate-50 transition">
                <div class="text-sm font-medium text-slate-900">Enroll New Student</div>
                <div class="mt-1 text-xs text-slate-500">Create parent + student in one flow</div>
            </a>

            <a href="{{ route('admin.students.index') }}"
               class="block rounded-2xl border border-slate-200 p-4 hover:bg-slate-50 transition">
                <div class="text-sm font-medium text-slate-900">Manage Students</div>
                <div class="mt-1 text-xs text-slate-500">Search, filter, update student records</div>
            </a>

             <a href="{{ route('admin.fee-structures.index') }}"
               class="block rounded-2xl border border-slate-200 p-4 hover:bg-slate-50 transition">
                <div class="text-sm font-medium text-slate-900">Manage  Fee Structures</div>
                <div class="mt-1 text-xs text-slate-500">Search, filter, update class fees records</div>
            </a>

            <div class="rounded-2xl border border-slate-200 p-4 bg-slate-50">
           
                <div class="mt-1 text-xs text-slate-500">Finance module coming next</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-red-200 shadow-sm p-6 mt-6">

    <div class="text-sm font-semibold text-red-700 mb-4">
        System Risk Indicators
    </div>

    <div class="grid grid-cols-2 gap-4 text-sm">

        <div>
            <div class="text-slate-500">Unpublished Exams</div>
            <div class="font-semibold text-red-600">
                {{ $unpublishedExams }}
            </div>
        </div>

        <div>
            <div class="text-slate-500">High Debt Students</div>
            <div class="font-semibold text-red-600">
                {{ $riskStudents->count() }}
            </div>
        </div>

    </div>

</div>

    </div>

    {{-- Recent students table --}}
    <div class="xl:col-span-2 rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden">
        <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <div class="text-sm font-semibold text-slate-900">Recent Students</div>
                <div class="text-xs text-slate-500">Latest registrations and enrollments</div>
            </div>

            <a href="{{ route('admin.students.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                View all
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-50 text-slate-600 text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium">Student</th>
                        <th class="px-6 py-3 text-left font-medium">Admission</th>
                        <th class="px-6 py-3 text-left font-medium">Class</th>
                        <th class="px-6 py-3 text-left font-medium">Stream</th>
                        <th class="px-6 py-3 text-left font-medium">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($recentStudents as $student)
                        @php $en = $student->activeEnrollment; @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-xs font-semibold text-slate-600">
                                        {{ strtoupper(substr($student->user?->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-900">{{ $student->user?->name }}</div>
                                        <div class="text-xs text-slate-500">Created {{ $student->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-slate-700">{{ $student->admission_no }}</td>
                            <td class="px-6 py-4 text-slate-700">{{ $en?->schoolClass?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-slate-700">{{ $en?->stream?->name ?? '—' }}</td>

                            <td class="px-6 py-4">
                                @php
                                    $badge = match($student->status) {
                                        'active' => 'bg-green-50 text-green-700 border-green-200',
                                        'admitted' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'suspended' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                        'alumni' => 'bg-slate-50 text-slate-700 border-slate-200',
                                        default => 'bg-slate-50 text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 text-xs border rounded-full {{ $badge }}">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                                No students yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 bg-white text-xs text-slate-500">
            Showing latest {{ $recentStudents->count() }} students
        </div>
    </div>

    
</div>
@endsection

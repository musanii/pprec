@extends('layouts.app')

@section('page_title', 'Teachers')

@section('content')
{{-- Page header --}}
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Teachers</h1>
        <p class="text-sm text-slate-500 mt-1">Manage teaching staff and profiles</p>
    </div>

    <a href="{{ route('admin.teachers.create') }}"
       class="inline-flex items-center rounded-xl bg-primary px-4 py-2.5 text-white hover:opacity-90 shadow-sm">
        + Add Teacher
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-50 text-slate-600 text-xs">
                <tr>
                    <th class="px-6 py-3 text-left font-medium">Teacher</th>
                    <th class="px-6 py-3 text-left font-medium">Staff No</th>
                    <th class="px-6 py-3 text-left font-medium">Phone</th>
                    <th class="px-6 py-3 text-left font-medium">Status</th>
                    <th class="px-6 py-3 text-left font-medium">Created</th>
                    <th class="px-6 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($teachers as $teacher)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">
                                {{ $teacher->user?->name }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ $teacher->user?->email }}
                            </div>
                        </td>

                        <td class="px-6 py-4 text-slate-700">
                            {{ $teacher->staff_no }}
                        </td>

                        <td class="px-6 py-4 text-slate-700">
                            {{ $teacher->phone ?? '—' }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs border rounded-full
                                {{ $teacher->is_active
                                    ? 'bg-green-50 text-green-700 border-green-200'
                                    : 'bg-slate-100 text-slate-700 border-slate-200' }}">
                                {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $teacher->created_at->format('d M Y') }}
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4 text-right">
                            <div
                                class="inline-block"
                                x-data="{ open:false, x:0, y:0 }"
                                x-init="
                                    window.addEventListener('scroll', () => open=false, true);
                                    window.addEventListener('resize', () => open=false);
                                "
                            >
                                <button
                                    type="button"
                                    x-ref="btn"
                                    @click="
                                        open = !open;
                                        const r = $refs.btn.getBoundingClientRect();
                                        x = r.right;
                                        y = r.bottom;
                                    "
                                    class="inline-flex items-center justify-center rounded-lg px-2 py-1 text-slate-500 hover:bg-slate-100">
                                    ⋯
                                </button>

                                <template x-teleport="body">
                                    <div
                                        x-show="open"
                                        x-transition.opacity
                                        @click.outside="open=false"
                                        class="fixed z-[9999]"
                                        :style="`left:${x}px; top:${y}px; transform:translateX(-100%)`"
                                        x-cloak
                                    >
                                        <div class="w-44 rounded-xl border border-slate-200 bg-white shadow-lg overflow-hidden">
                                            <a href="{{ route('admin.teachers.edit', $teacher) }}"
                                               class="block px-4 py-2.5 text-sm hover:bg-slate-50">
                                                Edit
                                            </a>
                                                        <a href="{{ route('admin.teachers.assignments.edit', $teacher) }}"
                                                        class="block px-4 py-2.5 text-sm hover:bg-slate-50">
                                                            Assign Subjects
                                                        </a>

                                            <div class="h-px bg-slate-100"></div>

                                            <form method="POST" action="{{ route('admin.teachers.status', $teacher) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="is_active" value="{{ $teacher->is_active ? 0 : 1 }}">
                                                <button
                                                    type="submit"
                                                    class="w-full text-left px-4 py-2.5 text-sm hover:bg-slate-50">
                                                    {{ $teacher->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            No teachers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="p-4 border-t border-slate-100 bg-white">
        {{ $teachers->links() }}
    </div>
</div>
@endsection

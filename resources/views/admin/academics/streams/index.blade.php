{{-- resources/views/admin/academics/streams/index.blade.php --}}
@extends('layouts.app')

@section('page_title', 'Streams')

@section('content')
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Streams</h1>
        <p class="text-sm text-slate-500 mt-1">Manage streams per class</p>
    </div>

    <a href="{{ route('admin.streams.create') }}"
       class="inline-flex items-center rounded-xl bg-primary px-4 py-2.5 text-white hover:opacity-90 shadow-sm">
        + Add Stream
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    {{-- Toolbar --}}
    <div class="p-4 sm:p-5 border-b border-slate-100">
        <form method="GET" action="{{ route('admin.streams.index') }}"
              class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">

            <div class="md:col-span-5">
                <label class="text-xs font-medium text-slate-600">Class</label>
                <select name="class_id"
                        class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm
                               focus:outline-none focus:ring-2 focus:ring-primary/20">
                    <option value="">All</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" @selected((int)request('class_id') === $class->id)>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-3">
                <label class="text-xs font-medium text-slate-600">Status</label>
                <select name="is_active"
                        class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm
                               focus:outline-none focus:ring-2 focus:ring-primary/20">
                    <option value="">All</option>
                    <option value="1" @selected(request('is_active') === '1')>Active</option>
                    <option value="0" @selected(request('is_active') === '0')>Inactive</option>
                </select>
            </div>

            <div class="md:col-span-4 flex gap-2 justify-end pt-1">
                <button class="rounded-xl bg-primary px-4 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
                    Filter
                </button>
                <a href="{{ route('admin.streams.index') }}"
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
                    <th class="px-6 py-3 text-left font-medium">Stream</th>
                    <th class="px-6 py-3 text-left font-medium">Class</th>
                    <th class="px-6 py-3 text-left font-medium">Status</th>
                    <th class="px-6 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($streams as $stream)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $stream->name }}</div>
                            <div class="text-xs text-slate-500">ID: {{ $stream->id }}</div>
                        </td>

                        <td class="px-6 py-4 text-slate-700">{{ $stream->schoolClass?->name ?? '—' }}</td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs border rounded-full
                                {{ $stream->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-slate-50 text-slate-700 border-slate-200' }}">
                                {{ $stream->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.streams.edit', $stream) }}"
                               class="text-sm text-slate-600 hover:text-slate-900">
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                            No streams found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="p-4 sm:p-5 border-t border-slate-100 bg-white">
        {{ $streams->links() }}
    </div>
</div>
@endsection

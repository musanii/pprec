@extends('layouts.app')

@section('page_title', 'My Results')

@section('content')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-slate-50 text-xs text-slate-600">
            <tr>
                <th class="px-6 py-3 text-left font-medium">Term</th>
                <th class="px-6 py-3 text-right font-medium">Action</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse($terms as $term)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 font-medium text-slate-900">
                        {{ $term->name }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('student.results.show', $term) }}"
                           class="rounded-lg border border-slate-200 px-3 py-2 text-sm hover:bg-slate-50">
                            View Report
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="px-6 py-12 text-center text-slate-500">
                        No results available yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@extends('layouts.app')

@section('page_title', 'My Results')

@section('content')
<div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-slate-50 text-xs text-slate-600">
            <tr>
                <th class="px-6 py-3">Term</th>
                <th class="px-6 py-3 text-right">Action</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @foreach($terms as $term)
                <tr>
                    <td class="px-6 py-4 font-medium">
                        {{ $term->name }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('student.results.show', $term) }}"
                           class="text-sm rounded-lg border px-3 py-2 hover:bg-slate-50">
                            View Report
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@extends('layouts.app')

@section('page_title', 'Promotion Audit Log')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Promotion Audit Log</h1>
    <p class="text-sm text-slate-500 mt-1">
        History of all end-of-year promotion actions.
    </p>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-slate-50 text-xs text-slate-600">
            <tr>
                <th class="px-6 py-3">Date</th>
                <th class="px-6 py-3">Academic Year</th>
                <th class="px-6 py-3">Action</th>
                <th class="px-6 py-3 text-right">Total</th>
                <th class="px-6 py-3 text-right">Promoted</th>
                <th class="px-6 py-3 text-right">Repeated</th>
                <th class="px-6 py-3 text-right">Graduated</th>
                <th class="px-6 py-3">Run By</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @foreach($logs as $log)
                <tr>
                    <td class="px-6 py-4 text-sm">
                        {{ $log->created_at->format('d M Y H:i') }}
                    </td>
                    <td class="px-6 py-4 font-medium">
                        {{ $log->academicYear->name }}
                    </td>
                    <td class="px-6 py-4 capitalize">
                        {{ $log->action }}
                    </td>
                    <td class="px-6 py-4 text-right">{{ $log->total_students }}</td>
                    <td class="px-6 py-4 text-right text-green-700">{{ $log->promoted }}</td>
                    <td class="px-6 py-4 text-right text-yellow-700">{{ $log->repeated }}</td>
                    <td class="px-6 py-4 text-right text-slate-700">{{ $log->graduated }}</td>
                    <td class="px-6 py-4 text-sm">
                        {{ $log->user->name }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="p-4 border-t border-slate-100">
        {{ $logs->links() }}
    </div>
</div>
@endsection

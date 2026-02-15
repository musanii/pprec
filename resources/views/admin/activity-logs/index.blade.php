@extends('layouts.app')

@section('page_title', 'Activity Logs')

@section('content')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-50 text-xs text-slate-600">
                <tr>
                    <th class="px-6 py-3 text-left">Domain</th>
                    <th class="px-6 py-3 text-left">Action</th>
                    <th class="px-6 py-3 text-left">Performed By</th>
                    <th class="px-6 py-3 text-left">Date</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($logs as $log)
                    <tr>
                        <td class="px-6 py-4">{{ ucfirst($log->domain) }}</td>
                        <td class="px-6 py-4">{{ str_replace('_',' ', ucfirst($log->action)) }}</td>
                        <td class="px-6 py-4">
                            {{ $log->performer?->name ?? 'System' }}
                        </td>
                        <td class="px-6 py-4 text-slate-500">
                            {{ $log->created_at->format('d M Y H:i') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t">
        {{ $logs->links() }}
    </div>

</div>

@endsection

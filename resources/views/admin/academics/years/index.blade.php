@extends('layouts.app')

@section('page_title', 'Academic Years')

@section('content')
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Academic Years</h1>
        <p class="text-sm text-slate-500 mt-1">Manage academic year periods and activation</p>
    </div>

    <a href="{{ route('admin.academic-years.create') }}"
       class="inline-flex items-center rounded-xl bg-primary px-4 py-2.5 text-white hover:opacity-90 shadow-sm">
        + Add Year
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-4 sm:p-5 border-b border-slate-100">
        <form method="GET" action="{{ route('admin.academic-years.index') }}"
              class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">

            <div class="md:col-span-6">
                <label class="text-xs font-medium text-slate-600">Search</label>
                <input name="q" value="{{ request('q') }}" placeholder="Year name"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-primary/20" />
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

            <div class="md:col-span-3 flex gap-2 justify-end pt-1">
                <button class="rounded-xl bg-primary px-4 py-2.5 text-sm text-white hover:opacity-90 shadow-sm">
                    Filter
                </button>
                <a href="{{ route('admin.academic-years.index') }}"
                   class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-50 text-slate-600 text-xs">
                <tr>
                    <th class="px-6 py-3 text-left font-medium">Year</th>
                    <th class="px-6 py-3 text-left font-medium">Start</th>
                    <th class="px-6 py-3 text-left font-medium">End</th>
                    <th class="px-6 py-3 text-left font-medium">Status</th>
                    <th class="px-6 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($years as $year)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $year->name }}</div>
                            <div class="text-xs text-slate-500">ID: {{ $year->id }}</div>
                        </td>

                        <td class="px-6 py-4 text-slate-700">{{ \Carbon\Carbon::parse($year->start_date)->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-slate-700">{{ \Carbon\Carbon::parse($year->end_date)->format('d M Y') }}</td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs border rounded-full
                                {{ $year->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-slate-50 text-slate-700 border-slate-200' }}">
                                {{ $year->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="inline-block"
                                 x-data="{ open:false, x:0, y:0, place(){ const r=this.$refs.btn.getBoundingClientRect(); this.x=r.right; this.y=r.bottom; } }"
                                 x-init="window.addEventListener('scroll', ()=> open && place(), true); window.addEventListener('resize', ()=> open && place());">
                                <button type="button" x-ref="btn"
                                        @click="open=!open; if(open) $nextTick(()=>place())"
                                        class="inline-flex items-center justify-center rounded-lg px-2 py-1 text-slate-500 hover:bg-slate-100"
                                        aria-label="Actions">⋯</button>

                                <template x-teleport="body">
                                    <div x-show="open" x-transition.opacity @click.outside="open=false" x-cloak
                                         class="fixed z-[9999]"
                                         :style="`left:${x}px; top:${y}px; transform: translateX(-100%);`">
                                        <div class="w-48 rounded-xl border border-slate-200 bg-white shadow-lg overflow-hidden">
                                            <a href="{{ route('admin.academic-years.edit', $year) }}"
                                               class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                                                Edit
                                            </a>

                                            <div class="h-px bg-slate-100"></div>

                                            <form method="POST" action="{{ route('admin.academic-years.activate', $year) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="_redirect" value="{{ url()->full() }}">
                                                <button type="submit"
                                                        class="w-full text-left px-4 py-2.5 text-sm hover:bg-slate-50
                                                        {{ $year->is_active ? 'text-slate-400 cursor-not-allowed' : 'text-slate-700' }}"
                                                        {{ $year->is_active ? 'disabled' : '' }}>
                                                    Set Active
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
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">No academic years found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 sm:p-5 border-t border-slate-100 bg-white">
        {{ $years->links() }}
    </div>
</div>

@php
    $activeYear = $years->firstWhere('is_active', true);
@endphp

@if($activeYear)
    <div x-data="promotionPreview({{ $activeYear->id }})" class="mt-6 bg-white rounded-2xl border border-yellow-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-yellow-200 bg-yellow-50">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 h-10 w-10 rounded-xl bg-yellow-100 border border-yellow-200 flex items-center justify-center text-yellow-700">
                    ⚠
                </div>
                <div>
                    <div class="text-sm font-semibold text-slate-900">
                        End-of-Year Promotion
                    </div>
                    <div class="text-sm text-slate-600 mt-1">
                        This will close all active enrollments for
                        <span class="font-medium">{{ $activeYear->name }}</span>
                        and create new enrollments for the next academic year.
                    </div>
                </div>
            </div>
        </div>

        <div class="p-5">
            <form
                method="POST"
                action="{{ route('admin.promotions.store', $activeYear) }}"
                onsubmit="return confirm('This action is irreversible. Do you want to proceed?')"
                class="flex flex-col sm:flex-row gap-3 items-start sm:items-end"
            >
                @csrf

                <div class="w-full sm:w-64">
                    <label class="text-xs font-medium text-slate-600">
                        Promotion Action
                    </label>
                    <select
                        name="action"
                        required
                        class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm
                               focus:outline-none focus:ring-2 focus:ring-primary/20"
                    >
                        <option value="promote">Promote to next class</option>
                        <option value="repeat">Repeat same class</option>
                        <option value="graduate">Graduate all students</option>
                    </select>
                </div>

                <div class="flex gap-3">
                <button
                    type="button"
                    @click="preview()"
                    class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50"
                >
                    Preview
                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-primary px-5 py-2.5 text-sm text-white hover:opacity-90 shadow-sm"
                >
                    Process Promotion
                </button>
            </div>

            </form>
            <div x-show="result" class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-4">
                <div class="text-sm font-semibold text-slate-900 mb-2">
                    Promotion Preview
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-sm">
                    <div>Total: <strong x-text="result.total"></strong></div>
                    <div>Promoted: <strong x-text="result.promoted"></strong></div>
                    <div>Repeated: <strong x-text="result.repeated"></strong></div>
                    <div>Graduated: <strong x-text="result.graduated"></strong></div>
                </div>
            </div>

            <p class="mt-3 text-xs text-slate-500">
                Tip: Ensure all exams are published and results finalized before running promotion.
            </p>
        </div>
    </div>
@endif

<script>
function promotionPreview(yearId) {

    console.log('Initializing promotion preview for year ID:', yearId);
    return {
        loading: false,
        result: null,

       preview() {
    this.loading = true;

    fetch(`/admin/academic-years/${yearId}/promotions/preview`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            action: this.$root.querySelector('[name=action]').value
        })
    })
    .then(async response => {
        const data = await response.json();

        if (!response.ok) {
            throw data;
        }

        this.result = data;
    })
    .catch(error => {
        this.result = null;

        // show error nicely
        window.dispatchEvent(new CustomEvent('toast', {
            detail: {
                type: 'error',
                message: Object.values(error.errors ?? {})
                    .flat()
                    .join(', ')
                    || 'Promotion preview failed'
            }
        }));
    })
    .finally(() => this.loading = false);
}

    }
}
</script>

@endsection

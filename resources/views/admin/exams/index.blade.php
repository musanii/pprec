@extends('layouts.app')

@section('page_title', 'Exams')

@section('content')
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Exams</h1>
        <p class="text-sm text-slate-500 mt-1">Manage exams per academic term</p>
    </div>

    <a href="{{ route('admin.exams.create') }}"
       class="inline-flex items-center rounded-xl bg-primary px-4 py-2.5 text-white hover:opacity-90 shadow-sm">
        + Add Exam
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-50 text-slate-600 text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Exam</th>
                    <th class="px-6 py-3 text-left">Term</th>
                    <th class="px-6 py-3 text-left">Dates</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ( $exams as $exam )
                    
                
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium">{{ $exam->name }}</td>
                        <td class="px-6 py-4 text-slate-700">
                            {{ $exam->term->name }}
                            <div class="text-xs text-slate-500">
                                {{ $exam->term->academicYear->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-700">
                            {{ $exam->start_date?->format('d M') ?? '—' }}
                            →
                            {{ $exam->end_date?->format('d M') ?? '—' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-1 text-xs rounded-full border
                                {{ $exam->is_published
                                    ? 'bg-green-50 text-green-700 border-green-200'
                                    : 'bg-slate-100 text-slate-700 border-slate-200' }}">
                                {{ $exam->is_published ? 'Published' : 'Draft' }}
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
                                            <a href="{{ route('admin.exams.edit', $exam) }}"
                                               class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                                                Edit
                                            </a>
                                            @if($exam->is_published)
                                                <a href="{{ route('admin.exams.marks.edit', $exam) }}"
                                                class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                                                    Enter Marks
                                                </a>
                                            @else
                                                <span class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                                                    Draft
                                                </span>
                                            @endif

                                            <div class="h-px bg-slate-100"></div>
                                            
                                            @if(!$exam->is_published)
                                                <form method="POST" action="{{ route('admin.exams.publish', $exam) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button
                                                        type="submit"
                                                        class="w-full text-left px-4 py-2.5 text-sm text-green-700 hover:bg-green-50"
                                                    >
                                                        Publish Results
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.exams.unpublish', $exam) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button
                                                        type="submit"
                                                        class="w-full text-left px-4 py-2.5 text-sm text-red-700 hover:bg-red-50"
                                                    >
                                                        Unlock Results
                                                    </button>
                                                </form>
                                            @endif

                                        </div>
                                    </div>
                                </template>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            No Exams found.
                        </td>
                    </tr>
                @endforelse
               
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t">
        {{ $exams->links() }}
    </div>
</div>
@endsection

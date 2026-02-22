<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
.sidebar-link {
    @apply relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-700 hover:bg-slate-100 transition;
}

.sidebar-link.active {
    @apply bg-slate-100 font-semibold text-slate-900;
}

.sidebar-link svg {
    width: 20px;
    height: 20px;
}
</style>

<body class="bg-slate-50 text-slate-800 antialiased font-sans">

    {{-- Toast Notifications --}}
<div
    x-data="{ show:false, message:'', type:'success' }"
    x-init="
        @if(session('success'))
            message='{{ session('success') }}';
            type='success';
            show=true;
        @elseif(session('error'))
            message='{{ session('error') }}';
            type='error';
            show=true;
        @endif

        setTimeout(()=>show=false,4000);
    "
    x-show="show"
    x-transition
    x-cloak
    class="fixed top-6 right-6 z-50"
>
    <div :class="type==='success' 
        ? 'bg-green-600 text-white' 
        : 'bg-red-600 text-white'"
        class="px-6 py-4 rounded-xl shadow-2xl text-sm font-medium">
        <span x-text="message"></span>
    </div>
</div>
 
<div x-data="{ sidebarOpen:false, sidebarCollapsed:false }" class="min-h-screen">

    {{-- Mobile overlay --}}
    <div
        x-show="sidebarOpen"
        x-transition.opacity
        class="fixed inset-0 bg-black/20 z-40 md:hidden"
        @click="sidebarOpen=false"
        x-cloak
    ></div>

    <div class="min-h-screen flex">

        {{-- Desktop Sidebar --}}
        <aside
            class="hidden md:flex flex-col bg-white border-r border-slate-200 sticky top-0 h-screen transition-all duration-300 overflow-hidden"
            :class="sidebarCollapsed ? 'w-20' : 'w-72'"
        >
            {{-- Brand --}}
            <div class="px-5 py-5 border-b border-slate-100">
                <div class="flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <div class="text-sm font-semibold text-slate-900 truncate"
                             x-show="!sidebarCollapsed" x-transition.opacity>
                            Piphan Rose
                        </div>
                        <div class="text-xs text-slate-500 truncate"
                             x-show="!sidebarCollapsed" x-transition.opacity>
                            School Portal
                        </div>

                        <div class="text-sm font-semibold text-slate-900"
                             x-show="sidebarCollapsed" x-transition.opacity>
                            PR
                        </div>
                    </div>

                    <button
                        type="button"
                        class="rounded-lg border border-slate-200 px-2 py-2 text-slate-600 hover:bg-slate-50"
                        @click="sidebarCollapsed = !sidebarCollapsed"
                        :title="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M6 4a1 1 0 011.707-.707l6 6a1 1 0 010 1.414l-6 6A1 1 0 016 15V4z"
                                  clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-6">

                {{-- ================= ADMIN NAV ================= --}}
                @role('admin')
                  {{-- Main--}}
                <div>
                    <div class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400"
                            x-show="!sidebarCollapsed">
                            Main
                        </div>

                        {{-- Dashboard --}}
                    <a href="{{ route('dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('dashboard')  ? 'active':''}}">
                    <x-icon-home />
                    <span x-show="!sidebarCollapsed"> Dashboard</span>
                    </a>
              </div>
              {{-- People --}}

                <div>
                    <div class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400"
                        x-show="!sidebarCollapsed">
                        People
                    </div>

                    <a href="{{ route('admin.students.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                        <x-icon-users />
                        <span x-show="!sidebarCollapsed">Students</span>
                    </a>

                    <a href="{{ route('admin.teachers.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                        <x-icon-academic-cap />
                        <span x-show="!sidebarCollapsed">Teachers</span>
                    </a>
                </div>
                

                {{-- Academics --}}
              <div>
                        <div class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400"
                            x-show="!sidebarCollapsed">
                            Academics
                        </div>

                        <a href="{{ route('admin.classes.index') }}" class="sidebar-link">
                            <x-icon-rectangle-stack />
                            <span x-show="!sidebarCollapsed">Classes</span>
                        </a>

                        <a href="{{ route('admin.streams.index') }}" class="sidebar-link">
                            <x-icon-squares-2x2 />
                            <span x-show="!sidebarCollapsed">Streams</span>
                        </a>

                        <a href="{{ route('admin.subjects.index') }}" class="sidebar-link">
                            <x-icon-book-open />
                            <span x-show="!sidebarCollapsed">Subjects</span>
                        </a>

                        <a href="{{ route('admin.school-periods.index') }}" class="sidebar-link">
                            <x-icon-clock />
                            <span x-show="!sidebarCollapsed">School Periods</span>
                        </a>

                        <a href="{{ route('admin.timetable.index') }}" class="sidebar-link">
                            <x-icon-calendar-days />
                            <span x-show="!sidebarCollapsed">Timetable</span>
                        </a>
                    </div>

                {{-- Assessment --}}
                    <div>
                        <div class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400"
                            x-show="!sidebarCollapsed">
                            Assessment
                        </div>

                        <a href="{{ route('admin.exams.index') }}" class="sidebar-link">
                            <x-icon-clipboard-document-check />
                            <span x-show="!sidebarCollapsed">Exams</span>
                        </a>

                        <a href="{{ route('admin.analytics.academic') }}" class="sidebar-link">
                            <x-icon-chart-bar />
                            <span x-show="!sidebarCollapsed">Analytics</span>
                        </a>
                    </div>

                {{-- Operations --}}
                <div>
                    <div class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400"
                        x-show="!sidebarCollapsed">
                        Operations
                    </div>

                    <a href="{{ route('admin.promotion-logs.index') }}" class="sidebar-link">
                        <x-icon-arrow-path />
                        <span x-show="!sidebarCollapsed">Promotion Logs</span>
                    </a>

                    <a href="{{ route('admin.activity-logs.index') }}" class="sidebar-link">
                        <x-icon-clipboard-document-list />
                        <span x-show="!sidebarCollapsed">Activity Logs</span>
                    </a>
                </div>

                {{-- Finance --}}
                <div>
                    <div class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400"
                        x-show="!sidebarCollapsed">
                        Finance
                    </div>

                    <a href="{{ route('admin.fee-structures.index') }}" class="sidebar-link">
                        <x-icon-banknotes />
                        <span x-show="!sidebarCollapsed">Fee Structures</span>
                    </a>

                    <a href="{{ route('admin.finance.index') }}" class="sidebar-link">
                        <x-icon-currency-dollar />
                        <span x-show="!sidebarCollapsed">Finance</span>
                    </a>
                </div>
                


          

                @endrole
                {{-- =============== END ADMIN NAV =============== --}}

                {{-- ================= STUDENT NAV ================= --}}
                @role('student')

                <div class="px-3 pb-2 text-[11px] font-medium uppercase tracking-wide text-slate-400"
                     x-show="!sidebarCollapsed" x-transition.opacity>
                    Student
                </div>

                <a href="{{ route('dashboard') }}"
                   class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition">
                    <span class="h-5 w-5 text-slate-500">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity>My Dashboard</span>
                </a>

                <a href="{{ route('student.results') }}"
                   class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition">
                    <span class="h-5 w-5 text-slate-500">
                       <?xml version="1.0" encoding="utf-8"?><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 103.12 122.88" style="enable-background:new 0 0 103.12 122.88" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M72.17,35.82l16.44,0.06c-0.02,4.38-1.78,8.58-4.9,11.65c-0.74,0.73-1.54,1.38-2.4,1.96L72.17,35.82 L72.17,35.82z M1.18,122.01C0.49,121.69,0,121,0,120.18V2c0-1.1,0.89-2,2-2H21.4h79.72c1.1,0,2,0.89,2,2v107.73 c0,0.11-0.01,0.21-0.02,0.31c-0.28,3.93-1.56,6.99-3.86,9.18c-2.3,2.18-5.53,3.4-9.72,3.64c-0.09,0.01-0.17,0.02-0.26,0.02H2.83 C2.15,122.88,1.54,122.53,1.18,122.01L1.18,122.01z M35.5,34.9h5.01c0.27,0,0.48,0.22,0.48,0.48v9.85c0,0.27-0.22,0.48-0.48,0.48 H35.5c-0.27,0-0.48-0.22-0.48-0.48v-9.85C35.02,35.12,35.23,34.9,35.5,34.9L35.5,34.9z M16.85,28.87h5.01 c0.27,0,0.48,0.22,0.48,0.48v15.89c0,0.27-0.22,0.48-0.48,0.48h-5.01c-0.27,0-0.48-0.22-0.48-0.48V29.35 C16.36,29.09,16.58,28.87,16.85,28.87L16.85,28.87L16.85,28.87z M26.18,25.48h5.01c0.27,0,0.48,0.22,0.48,0.48v19.28 c0,0.27-0.22,0.48-0.48,0.48h-5.01c-0.27,0-0.48-0.22-0.48-0.48V25.96C25.69,25.69,25.91,25.48,26.18,25.48L26.18,25.48z M99.13,109.68V3.99H21.4H3.99v114.9h85.26l0.04,0c3.21-0.18,5.61-1.04,7.2-2.55C98.06,114.85,98.93,112.62,99.13,109.68 L99.13,109.68z M16.82,106.64c-1.09,0-1.98-0.89-1.98-2c0-1.1,0.88-1.99,1.98-1.99h70.5c1.09,0,1.98,0.89,1.98,1.99 c0,1.1-0.88,2-1.98,2H16.82L16.82,106.64z M17.14,92.08c-1.09,0-1.98-0.89-1.98-2c0-1.1,0.88-2,1.98-2h70c1.09,0,1.98,0.89,1.98,2 c0,1.1-0.88,2-1.98,2H17.14L17.14,92.08z M16.82,77.52c-1.09,0-1.98-0.89-1.98-2c0-1.1,0.88-1.99,1.98-1.99h30.13 c1.09,0,1.98,0.89,1.98,1.99c0,1.1-0.88,2-1.98,2H16.82L16.82,77.52z M54.64,77.52c-1.09,0-1.98-0.89-1.98-2 c0-1.1,0.88-1.99,1.98-1.99h32.5c1.09,0,1.98,0.89,1.98,1.99c0,1.1-0.88,2-1.98,2H54.64L54.64,77.52z M16.82,64.53 c-1.09,0-1.98-0.89-1.98-2c0-1.1,0.88-2,1.98-2h24.84c1.09,0,1.98,0.89,1.98,2c0,1.1-0.88,2-1.98,2H16.82L16.82,64.53z M16.82,13.91c-1.09,0-1.98-0.89-1.98-2s0.88-2,1.98-2h14.84c1.09,0,1.98,0.89,1.98,2s-0.88,2-1.98,2H16.82L16.82,13.91z M70.49,32.56l-0.88-17.57c-0.02-0.35,0.25-0.64,0.6-0.66c0.1-0.01,0.22-0.01,0.35-0.01c0.11,0,0.23-0.01,0.35-0.01 c4.83-0.05,9.25,1.78,12.56,4.82c3.31,3.05,5.5,7.31,5.84,12.13c0.02,0.35-0.24,0.65-0.58,0.67l-17.58,1.26 c-0.35,0.02-0.65-0.24-0.67-0.58C70.49,32.59,70.49,32.57,70.49,32.56L70.49,32.56z M70.9,15.57l0.82,16.32l16.3-1.16 c-0.46-4.23-2.45-7.96-5.38-10.66c-3.08-2.84-7.21-4.54-11.7-4.49L70.9,15.57L70.9,15.57z M68.52,35.06l8.81,15.26 c-2.68,1.55-5.72,2.36-8.81,2.36c-9.73,0-17.62-7.89-17.62-17.62c0-8.74,6.41-16.17,15.06-17.43L68.52,35.06L68.52,35.06z"/></g></svg>
                    </span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity>My Results</span>
                </a>

                @endrole
                {{-- =============== END STUDENT NAV =============== --}}

                {{-- =============== PARENT NAV ==================== --}}
                @role('parent')
                <a href="{{ route('parent.dashboard') }}"
                class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50">
                    <span class="h-5 w-5 text-slate-500">
                        <!-- Parent SVG icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 486.68"><path d="M10.208 0h108.173c5.615 0 10.207 4.593 10.207 10.208v100.159c0 5.615-4.592 10.208-10.207 10.208H10.208C4.593 120.575 0 115.982 0 110.367V10.208C0 4.593 4.593 0 10.208 0zm387.687 366.105h99.621c7.967 0 14.484 6.517 14.484 14.484v91.607c0 7.967-6.517 14.484-14.484 14.484h-99.621c-7.967 0-14.484-6.517-14.484-14.484v-91.607c0-7.967 6.517-14.484 14.484-14.484zm-191.706 0h99.621c7.967 0 14.484 6.517 14.484 14.484v91.607c0 7.967-6.517 14.484-14.484 14.484h-99.621c-7.967 0-14.483-6.517-14.483-14.484v-91.607c0-7.967 6.516-14.484 14.483-14.484zm-191.705 0h99.621c7.967 0 14.483 6.517 14.483 14.484v91.607c0 7.967-6.516 14.484-14.483 14.484H14.484C6.517 486.68 0 480.163 0 472.196v-91.607c0-7.967 6.517-14.484 14.484-14.484zm379.135-183.052h108.173c5.615 0 10.208 4.593 10.208 10.207v100.16c0 5.614-4.593 10.208-10.208 10.208H393.619c-5.615 0-10.208-4.594-10.208-10.208V193.26c0-5.614 4.593-10.207 10.208-10.207zm-191.706 0h108.173c5.615 0 10.208 4.593 10.208 10.207v100.16c0 5.614-4.593 10.208-10.208 10.208H201.913c-5.614 0-10.207-4.594-10.207-10.208V193.26c0-5.614 4.593-10.207 10.207-10.207zm-191.705 0h108.173c5.615 0 10.207 4.593 10.207 10.207v100.16c0 5.614-4.592 10.208-10.207 10.208H10.208C4.593 303.628 0 299.034 0 293.42V193.26c0-5.614 4.593-10.207 10.208-10.207zM393.619 0h108.173C507.407 0 512 4.593 512 10.208v100.159c0 5.615-4.593 10.208-10.208 10.208H393.619c-5.615 0-10.208-4.593-10.208-10.208V10.208C383.411 4.593 388.004 0 393.619 0zM201.913 0h108.173c5.615 0 10.208 4.593 10.208 10.208v100.159c0 5.615-4.593 10.208-10.208 10.208H201.913c-5.614 0-10.207-4.593-10.207-10.208V10.208C191.706 4.593 196.299 0 201.913 0z"/></svg>
                    </span>
                    <span x-show="!sidebarCollapsed"> Dashboard</span>
                </a>

                <a href="{{ route('parent.finance') }}"
                class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition
                {{ request()->routeIs('parent.finance') ? 'bg-slate-50 text-slate-900 font-medium' : 'text-slate-700' }}">
                    <span class="h-5 w-5 text-slate-500">
                        <?xml version="1.0" encoding="utf-8"?><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 117.34 122.88" style="enable-background:new 0 0 117.34 122.88" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M85.14,14.83L43.26,40.28h11.91l30.92-18.79l4.54-2.76l13.09,21.55h7.62c1.66,0,3.16,0.68,4.25,1.76l0,0 c1.09,1.09,1.77,2.59,1.77,4.24v70.59c0,1.65-0.68,3.15-1.76,4.23v0.01c-1.09,1.09-2.59,1.76-4.25,1.76l-105.33,0 c-1.66,0-3.16-0.67-4.25-1.76v-0.01C0.68,120.02,0,118.52,0,116.88V46.28c0-1.65,0.68-3.16,1.76-4.24 c1.09-1.09,2.59-1.76,4.25-1.76h2.5L73.53,0.77v0C74.36,0.27,75.3,0,76.27,0c0.42,0,0.84,0.05,1.25,0.15 c1.36,0.33,2.54,1.19,3.26,2.39v0l6.63,10.91L85.14,14.83L85.14,14.83L85.14,14.83z M5.89,45.62c-0.23,0.25-0.42,0.53-0.56,0.84 v8.69h106.68v-8.87c0-0.19-0.07-0.36-0.19-0.47h-0.01c-0.12-0.12-0.29-0.2-0.48-0.2H6.01C5.97,45.61,5.93,45.61,5.89,45.62 L5.89,45.62z M15.98,84.71h19.05v7.13H15.98V84.71L15.98,84.71z M15.98,101.59h53.25v6.43H15.98V101.59L15.98,101.59z M86.21,84.71 h19.05v7.13H86.21V84.71L86.21,84.71z M62.8,84.71h19.05v7.13H62.8V84.71L62.8,84.71z M39.39,84.71h19.05v7.13H39.39V84.71 L39.39,84.71z M112.01,75.14H5.33v41.73c0,0.19,0.07,0.36,0.2,0.48l0.01,0c0.13,0.13,0.3,0.2,0.47,0.2l105.33,0 c0.18,0,0.35-0.08,0.48-0.2l0,0c0.13-0.13,0.2-0.3,0.2-0.48v0V75.14L112.01,75.14z"/></g></svg>
                    </span>
                    <span x-show="!sidebarCollapsed">My Child Finance</span>
                </a>
            @endrole


             {{-- =============== Teacher NAV ==================== --}}
                @role('teacher')
                
            @endrole


            </nav>

            {{-- Sidebar footer --}}
            <div class="mt-auto p-4 border-t border-slate-100">
                <div class="text-xs text-slate-500"
                     x-show="!sidebarCollapsed" x-transition.opacity>
                    Signed in as
                </div>
                <div class="text-sm font-medium text-slate-800 truncate"
                     x-show="!sidebarCollapsed" x-transition.opacity>
                    {{ auth()->user()->name }}
                </div>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Topbar --}}
          
<header class="bg-white shadow-sm border-b border-slate-200 sticky top-0 z-30">
    <div class="px-8 py-4 flex items-center justify-between">

        {{-- Left --}}
        <div class="flex items-center gap-6">
            <button type="button"
                class="md:hidden rounded-lg border border-slate-200 px-3 py-2 text-slate-600 hover:bg-slate-100"
                @click="sidebarOpen=true">
                ☰
            </button>

            <div>
                <div class="text-xs text-slate-400 uppercase tracking-wider">
                    Piphan Rose Educational Centre
                </div>
                <div class="text-xl font-semibold text-slate-900">
                    @yield('page_title', 'Dashboard')
                </div>
            </div>
        </div>

        {{-- Right --}}
        <div class="flex items-center gap-6">

            {{-- Messages --}}
            <div x-data="{ open:false }" class="relative">
                <button @click="open=!open"
                    class="relative p-2 rounded-lg hover:bg-slate-100 transition">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M7 8h10M7 12h6m-9 8l4-4h11a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2h3z"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <div x-show="open" @click.away="open=false"
                    class="absolute right-0 mt-3 w-72 bg-white rounded-xl shadow-xl border border-slate-200 p-4 text-sm">
                    <div class="font-semibold mb-2">Messages</div>
                    <p class="text-slate-500 text-xs">No messages yet.</p>
                </div>
            </div>

            {{-- Notifications --}}
            <div x-data="{ open:false }" class="relative">
                <button @click="open=!open"
                    class="relative p-2 rounded-lg hover:bg-slate-100 transition">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0118 14V9a6 6 0 10-12 0v5c0 .53-.21 1.04-.59 1.41L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-blue-500 rounded-full"></span>
                </button>

                <div x-show="open" @click.away="open=false"
                    class="absolute right-0 mt-3 w-72 bg-white rounded-xl shadow-xl border border-slate-200 p-4 text-sm">
                    <div class="font-semibold mb-2">Notifications</div>
                    <p class="text-slate-500 text-xs">No notifications yet.</p>
                </div>
            </div>

            {{-- Profile --}}
            <div x-data="{ open:false }" class="relative">
                <button @click="open=!open"
                    class="flex items-center gap-3 rounded-lg hover:bg-slate-100 px-3 py-2 transition">

                    <div class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center font-semibold">
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    </div>

                    <div class="hidden md:block text-left">
                        <div class="text-sm font-medium text-slate-800">
                            {{ auth()->user()->name }}
                        </div>
                        <div class="text-xs text-slate-400">
                            {{ ucfirst(auth()->user()->roles->first()->name ?? '') }}
                        </div>
                    </div>
                </button>

                <div x-show="open" @click.away="open=false"
                    class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-xl border border-slate-200">

                    <a href="#" class="block px-4 py-3 text-sm hover:bg-slate-50">Profile</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-4 py-3 text-sm hover:bg-slate-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>

            {{-- Content --}}
            <main class="flex-1">
                <div class="px-8 py-8 space-y-6">
                    @yield('content')
                </div>
            </main>

            {{-- Footer --}}
           <footer class="border-t border-slate-200 bg-white mt-10">
    <div class="px-8 py-6 flex justify-between items-center text-sm text-slate-500">
        <div>© {{ date('Y') }} Piphan Rose Educational Centre</div>
        <div class="text-xs">School Management System v1.0</div>
    </div>
</footer>

        </div>
    </div>
</div>

</body>
</html>


<script>
function promotionPreview(yearId) {
    return {
        loading: false,
        result: null,

        preview() {
            this.loading = true;

            fetch(`/admin/academic-years/${yearId}/promotions/preview`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({
                    action: this.$root.querySelector('[name=action]').value
                })
            })
            .then(r => r.json())
            .then(data => {
                this.result = data;
            })
            .finally(() => this.loading = false);
        }
    }
}
</script>






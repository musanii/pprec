<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


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
                       <svg class="h-4 w-4 transition-transform duration-300"
                        :class="sidebarCollapsed ? 'rotate-180' : ''"
                        viewBox="0 0 20 20"
                        fill="currentColor">
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
                    <x-heroicon-o-home class="w-5 h-5" />
                    <span x-show="!sidebarCollapsed"> Dashboard</span>
                    </a>
              </div>
              {{-- People --}}

               <div x-data="{ open: true }" class="mt-4">
                    <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-3 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 transition-colors mb-2 focus:outline-none" 
                        x-show="!sidebarCollapsed">
                        <span>People</span>
                        {{-- Bigger and Bolder Arrow --}}
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open || sidebarCollapsed" x-transition>
                        <a href="{{ route('admin.students.index') }}" class="sidebar-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                            <x-heroicon-o-users class="w-5 h-5" />
                            <span x-show="!sidebarCollapsed">Students</span>
                        </a>
                        <a href="{{ route('admin.teachers.index') }}" class="sidebar-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                            <x-heroicon-o-academic-cap class="w-5 h-5" />
                            <span x-show="!sidebarCollapsed">Teachers</span>
                        </a>
                    </div>
                </div>
                

                {{-- Academics --}}
             <div x-data="{ open: true }" class="mt-4">
            <button @click="open = !open" 
                class="w-full flex items-center justify-between px-3 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 transition-colors mb-2 focus:outline-none" 
                x-show="!sidebarCollapsed">
                <span>Academics</span>
                <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="open || sidebarCollapsed" x-transition>
                <a href="{{ route('admin.classes.index') }}" class="sidebar-link">
                    <x-heroicon-o-rectangle-stack class="w-5 h-5" />
                    <span x-show="!sidebarCollapsed">Classes</span>
                </a>
                <a href="{{ route('admin.streams.index') }}" class="sidebar-link">
                    <x-heroicon-o-squares-2x2 class="w-5 h-5" />
                    <span x-show="!sidebarCollapsed">Streams</span>
                </a>
                <a href="{{ route('admin.subjects.index') }}" class="sidebar-link">
                    <x-heroicon-o-book-open class="w-5 h-5" />
                    <span x-show="!sidebarCollapsed">Subjects</span>
                </a>
                <a href="{{ route('admin.academic-years.index') }}" class="sidebar-link">
                    <x-heroicon-o-calendar class="w-5 h-5" />
                    <span x-show="!sidebarCollapsed">Academic Years</span>
                </a>
                <a href="{{ route('admin.terms.index') }}" class="sidebar-link">
                    <x-heroicon-o-calendar-days class="w-5 h-5" />
                    <span x-show="!sidebarCollapsed">Terms</span>
                </a>
                <a href="{{ route('admin.school-periods.index') }}" class="sidebar-link">
                    <x-heroicon-o-clock class="w-5 h-5" />
                    <span x-show="!sidebarCollapsed">School Periods</span>
                </a>
                <a href="{{ route('admin.timetable.index') }}" class="sidebar-link">
                    <x-heroicon-o-calendar-days class="w-5 h-5" />
                    <span x-show="!sidebarCollapsed">Timetable</span>
                </a>
            </div>
        </div>

                {{-- Assessment --}}
                    <div x-data="{ open: true }" class="mt-4">
            <button @click="open = !open" 
                class="w-full flex items-center justify-between px-3 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 transition-colors mb-2 focus:outline-none" 
                x-show="!sidebarCollapsed">
                <span>Assessmenyt</span>
                <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
                        <div x-show="open || sidebarCollapsed" x-transition>
                            <a href="{{ route('admin.exams.index') }}" class="sidebar-link">
                                <x-heroicon-o-clipboard-document-check class="w-5 h-5"/>
                                <span x-show="!sidebarCollapsed">Exams</span>
                            </a>
                            <a href="{{ route('admin.analytics.academic') }}" class="sidebar-link">
                                <x-heroicon-o-chart-bar class="w-5 h-5"/>
                                <span x-show="!sidebarCollapsed">Analytics</span>
                            </a>
                        </div>
                    </div>

                {{-- Operations --}}
               
               {{-- Finance --}}
              <div x-data="{ open: true }" class="mt-4">
            <button @click="open = !open" 
                class="w-full flex items-center justify-between px-3 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 transition-colors mb-2 focus:outline-none" 
                x-show="!sidebarCollapsed">
                <span>Operations</span>
                <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open || sidebarCollapsed" x-transition>
                <a href="{{ route('admin.promotion-logs.index') }}" class="sidebar-link">
                    <x-heroicon-o-arrow-trending-up class="w-5 h-5" />
                    <span x-show="!sidebarCollapsed">Promotion Logs</span>
                </a>
                <a href="{{ route('admin.activity-logs.index') }}" class="sidebar-link">
                    <x-heroicon-s-arrow-trending-up class="w-5 h-5" />
                    <span x-show="!sidebarCollapsed">Activity Logs</span>
                </a>
            </div>
        </div>

                {{-- Finance --}}
              <div x-data="{ open: true }" class="mt-4">
            <button @click="open = !open" 
                class="w-full flex items-center justify-between px-3 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 transition-colors mb-2 focus:outline-none" 
                x-show="!sidebarCollapsed">
                <span>Finance</span>
                <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open || sidebarCollapsed" x-transition>
                <a href="{{ route('admin.fee-structures.index') }}" class="sidebar-link">
                    <x-heroicon-o-banknotes class="w-5 h-5" />
                    <span x-show="!sidebarCollapsed">Fee Structures</span>
                </a>
                <a href="{{ route('admin.finance.index') }}" class="sidebar-link">
                    <x-heroicon-o-currency-dollar class="w-5 h-5" />
                    <span x-show="!sidebarCollapsed">Finance</span>
                </a>
            </div>
        </div>
                


          

                @endrole
                {{-- =============== END ADMIN NAV =============== --}}

                {{-- ================= STUDENT NAV ================= --}}
                @role('student')

               <div class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400"
                        x-show="!sidebarCollapsed">
                       Student
                    </div>

                 <a href="{{ route('student.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('student.dashboard')  ? 'active':''}}">
                    <x-heroicon-o-home class="w-5 h-5" />
                    <span x-show="!sidebarCollapsed"> Dashboard</span>
                    </a>

                    <a href="{{ route('student.results') }}" class="sidebar-link">
                         <x-heroicon-o-home class="w-5 h-5" />
                        <span x-show="!sidebarCollapsed">My Results</span>
                    </a>

              

                @endrole
                {{-- =============== END STUDENT NAV =============== --}}

                {{-- =============== PARENT NAV ==================== --}}
                @role('parent')
                 <a href="{{ route('parent.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('parent.dashboard')  ? 'active':''}}">
                     <x-heroicon-o-home class="w-5 h-5" />
                    <span x-show="!sidebarCollapsed"> Dashboard</span>
                    </a>

                <a href="{{ route('parent.finance') }}" class="sidebar-link">
                        <x-heroicon-o-home class="w-5 h-5" />
                        <span x-show="!sidebarCollapsed">My Child Finances</span>
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

</body>
</html>









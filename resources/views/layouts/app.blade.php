<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800 antialiased font-sans">
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

        {{-- Desktop Sidebar (in-flow, consistent) --}}
        <aside
            class="hidden md:flex flex-col bg-white border-r border-slate-100 sticky top-0 h-screen transition-all duration-200"
            :class="sidebarCollapsed ? 'w-20' : 'w-72'"
        >
            {{-- Brand --}}
            <div class="px-5 py-5 border-b border-slate-100">
                <div class="flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <div class="text-sm font-semibold text-slate-900 truncate" x-show="!sidebarCollapsed" x-transition.opacity>
                            Piphan Rose
                        </div>
                        <div class="text-xs text-slate-500 truncate" x-show="!sidebarCollapsed" x-transition.opacity>
                            School Portal
                        </div>

                        <div class="text-sm font-semibold text-slate-900" x-show="sidebarCollapsed" x-transition.opacity>
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
                            <path fill-rule="evenodd" d="M6 4a1 1 0 011.707-.707l6 6a1 1 0 010 1.414l-6 6A1 1 0 016 15V4z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="px-3 py-4 space-y-1">
                <div class="px-3 pb-2 text-[11px] font-medium uppercase tracking-wide text-slate-400"
                     x-show="!sidebarCollapsed" x-transition.opacity>
                    Main
                </div>

                <a href="{{ route('dashboard') }}"
                   class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition
                   {{ request()->routeIs('dashboard') ? 'bg-slate-50 text-slate-900 font-medium' : 'text-slate-700' }}">
                    <span class="h-5 w-5 text-slate-500">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5">
                            <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 13h8V3H3v10zm10 8h8V11h-8v10zM3 21h8v-6H3v6zm10-10h8V3h-8v8z"/>
                        </svg>
                    </span>
                    <span class="truncate" x-show="!sidebarCollapsed" x-transition.opacity>Dashboard</span>
                    @if(request()->routeIs('dashboard'))
                        <span class="absolute left-0 top-2 bottom-2 w-1 rounded-r bg-primary"></span>
                    @endif
                </a>

                <a href="{{ route('admin.students.index') }}"
                   class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition
                   {{ request()->routeIs('admin.students.*') ? 'bg-slate-50 text-slate-900 font-medium' : 'text-slate-700' }}">
                    <span class="h-5 w-5 text-slate-500">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5">
                            <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                  d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                            <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                  d="M8.5 11a4 4 0 100-8 4 4 0 000 8z"/>
                            <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                  d="M20 21v-2a4 4 0 00-3-3.87"/>
                            <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                  d="M16.5 3.13a4 4 0 010 7.75"/>
                        </svg>
                    </span>
                    <span class="truncate" x-show="!sidebarCollapsed" x-transition.opacity>Students</span>
                    @if(request()->routeIs('admin.students.*'))
                        <span class="absolute left-0 top-2 bottom-2 w-1 rounded-r bg-primary"></span>
                    @endif
                </a>

                {{-- Coming soon (kept) --}}
                <div class="pt-4">
                    <div class="px-3 pb-2 text-[11px] font-medium uppercase tracking-wide text-slate-400"
                         x-show="!sidebarCollapsed" x-transition.opacity>
                        Coming soon
                    </div>

                    @foreach(['Finance','Academics','Inventory','Activities'] as $label)
                        <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 cursor-not-allowed select-none">
                            <span class="h-5 w-5 text-slate-300">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                          d="M4 7h16M4 12h16M4 17h10"/>
                                </svg>
                            </span>
                            <span class="truncate" x-show="!sidebarCollapsed" x-transition.opacity>{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </nav>

            {{-- Sidebar bottom --}}
            <div class="mt-auto p-4 border-t border-slate-100">
                <div class="text-xs text-slate-500 truncate" x-show="!sidebarCollapsed" x-transition.opacity>Signed in as</div>
                <div class="text-sm font-medium text-slate-800 truncate" x-show="!sidebarCollapsed" x-transition.opacity>
                    {{ auth()->user()->name }}
                </div>
            </div>
        </aside>

        {{-- Mobile Sidebar Drawer (separate; does NOT affect layout) --}}
        <aside
            class="md:hidden fixed top-0 left-0 h-screen w-72 bg-white border-r border-slate-100 z-50"
            x-show="sidebarOpen"
            x-transition:enter="transition transform duration-200 ease-out"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition transform duration-200 ease-in"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            x-cloak
        >
            <div class="px-5 py-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <div class="text-sm font-semibold text-slate-900">Piphan Rose</div>
                    <div class="text-xs text-slate-500">School Portal</div>
                </div>
                <button class="rounded-lg border border-slate-200 px-3 py-2 text-slate-600 hover:bg-slate-50"
                        @click="sidebarOpen=false">
                    Close
                </button>
            </div>

            <nav class="px-3 py-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 text-slate-700">
                    Dashboard
                </a>
                <a href="{{ route('admin.students.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 text-slate-700">
                    Students
                </a>

                <div class="pt-4 px-3 pb-2 text-[11px] font-medium uppercase tracking-wide text-slate-400">
                    Coming soon
                </div>
                @foreach(['Finance','Academics','Inventory','Activities'] as $label)
                    <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 cursor-not-allowed select-none">
                        {{ $label }}
                    </div>
                @endforeach
            </nav>
        </aside>

        {{-- Main Content (no padding-left hacks; always neat) --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Topbar --}}
            <header class="bg-white border-b border-slate-100">
                <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <button type="button"
                                class="md:hidden rounded-lg border border-slate-200 px-3 py-2 text-slate-600 hover:bg-slate-50"
                                @click="sidebarOpen=true">
                            Menu
                        </button>

                        <div>
                            <div class="text-xs text-slate-500">Piphan Rose Educational Centre</div>
                            <div class="text-lg font-semibold text-slate-900">@yield('page_title', 'Dashboard')</div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm rounded-lg border border-slate-200 px-4 py-2 hover:bg-slate-50 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1">
                <div class="max-w-7xl mx-auto p-6">
                    @if(session('success'))
                        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>

            <footer class="border-t border-slate-100 bg-white">
                <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                    <div class="text-sm text-slate-600">
                        © {{ date('Y') }} Piphan Rose Educational Centre. All rights reserved.
                    </div>
                    <div class="text-xs text-slate-500">
                        Built for school operations • v1.0
                    </div>
                </div>
            </footer>
        </div>

    </div>
</div>
</body>
</html>

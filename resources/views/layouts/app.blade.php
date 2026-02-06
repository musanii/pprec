<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800">
<div class="min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-64 hidden md:flex flex-col bg-white border-r border-slate-100">
        <div class="p-6">
            <div class="text-lg font-semibold text-primary">Piphan Rose</div>
            <div class="text-sm text-slate-500">School Portal</div>
        </div>

        <nav class="px-3 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-50
                      {{ request()->routeIs('dashboard') ? 'bg-slate-50 text-primary font-medium' : 'text-slate-700' }}">
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.students.index') }}"
               class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-50
                      {{ request()->routeIs('admin.students.*') ? 'bg-slate-50 text-primary font-medium' : 'text-slate-700' }}">
                <span>Students</span>
            </a>

            {{-- Add more menu items later: Finance, Academics, Inventory, Activities --}}
        </nav>

        <div class="mt-auto p-4 text-sm text-slate-500">
            Logged in as <span class="font-medium text-slate-700">{{ auth()->user()->name }}</span>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1">
        {{-- Topbar --}}
        <header class="bg-white border-b border-slate-100">
            <div class="px-6 py-4 flex items-center justify-between">
                <div class="font-semibold text-slate-800">
                    @yield('page_title', 'Dashboard')
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-slate-600 hover:text-slate-900">Logout</button>
                </form>
            </div>
        </header>

        <main class="p-6">
            @if(session('success'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</div>
</body>
</html>

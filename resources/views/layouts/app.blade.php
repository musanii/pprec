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
            class="hidden md:flex flex-col bg-white border-r border-slate-100 sticky top-0 h-screen transition-all duration-200"
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
            <nav class="px-3 py-4 space-y-1">

                {{-- ================= ADMIN NAV ================= --}}
                @role('admin')

                <div class="px-3 pb-2 text-[11px] font-medium uppercase tracking-wide text-slate-400"
                     x-show="!sidebarCollapsed" x-transition.opacity>
                    Main
                </div>

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition
                   {{ request()->routeIs('dashboard') ? 'bg-slate-50 text-slate-900 font-medium' : 'text-slate-700' }}">
                    <span class="h-5 w-5 text-slate-500">
                       <?xml version="1.0" encoding="utf-8"?><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" 
                       xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 106.53 122.88"
                        style="enable-background:new 0 0 106.53 122.88" xml:space="preserve">
                        <style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g>
                            <path class="st0" d="M42.09,16.99c0.43,0.12,0.91,0.07,1.43-0.13l-0.85-4.86c0.32-1.22,0.81-2.17,1.46-2.87 c0.68-0.73,1.53-1.18,2.54-1.38C48,7.65,48.4,8.63,49.74,9.49c4.08,2.6,7.52,3.48,12.56,3.55l-1.04,4.2 c0.33,0.14,0.73,0.18,1.13,0.11c0.81-0.07,1.3,0,1.42,0.26c0.19,0.38,0.02,1.17-0.55,2.45l-2.75,4.53 c-1.02,1.68-2.06,3.37-3.37,4.59c-1.25,1.17-2.79,1.95-4.9,1.95c-1.94,0-3.42-0.76-4.63-1.86c-1.27-1.16-2.29-2.74-3.27-4.3 l-2.45-3.89l0,0l-0.01-0.02c-0.74-1.11-1.13-2.06-1.15-2.79c-0.01-0.24,0.03-0.45,0.11-0.62c0.07-0.15,0.18-0.27,0.32-0.37 C41.39,17.13,41.69,17.03,42.09,16.99L42.09,16.99z M44.34,35.3l4.38,12.87l2.2-7.64l-1.08-1.18c-0.49-0.71-0.59-1.33-0.32-1.86 c0.58-1.16,1.79-0.94,2.92-0.94c1.18,0,2.64-0.22,3.02,1.26c0.12,0.5-0.03,1.01-0.38,1.55l-1.08,1.18l2.2,7.64l3.96-12.87 c2.86,2.57,11.32,3.09,14.47,4.84c1,0.56,1.89,1.26,2.62,2.22c1.1,1.45,1.77,3.34,1.95,5.75l0.66,10.41 c-0.16,1.7-1.12,2.68-3.02,2.83H52.45H27.66c-1.9-0.14-2.86-1.12-3.02-2.83l0.66-10.41c0.18-2.4,0.86-4.3,1.96-5.75 c0.72-0.96,1.62-1.66,2.62-2.22C33.02,38.39,41.48,37.87,44.34,35.3L44.34,35.3z M58,63.95v11.8h43.17v5.59v3.02v13.8h-8.61v-13.8 H58v12.42h-9.18V84.36H13.96v13.8H5.35v-13.8v-3.02v-5.59h43.47v-11.8H58L58,63.95z M96.87,103.57c5.33,0,9.65,4.32,9.65,9.66 s-4.32,9.65-9.65,9.65c-5.33,0-9.66-4.32-9.66-9.65S91.54,103.57,96.87,103.57L96.87,103.57z M9.65,103.57 c5.33,0,9.66,4.32,9.66,9.66s-4.32,9.65-9.66,9.65S0,118.56,0,113.22S4.32,103.57,9.65,103.57L9.65,103.57z M53.41,103.57 c5.33,0,9.65,4.32,9.65,9.66s-4.32,9.65-9.65,9.65c-5.33,0-9.65-4.32-9.65-9.65S48.08,103.57,53.41,103.57L53.41,103.57z M63.99,15.91l0.15-6.26c-0.18-2.58-1.04-4.52-2.39-5.99c-3.33-3.61-9.56-4.54-14.26-2.84c-0.79,0.29-1.54,0.65-2.22,1.08 c-1.94,1.24-3.51,3.03-4.13,5.27c-0.15,0.53-0.25,1.06-0.3,1.58c-0.1,2.19-0.04,4.81,0.11,6.9c-0.23,0.09-0.45,0.19-0.64,0.32 c-0.39,0.26-0.68,0.61-0.87,1.01c-0.18,0.39-0.26,0.83-0.25,1.31c0.03,1.02,0.5,2.25,1.4,3.6l2.45,3.89 c1.03,1.64,2.12,3.32,3.54,4.62c1.48,1.35,3.28,2.27,5.68,2.28c2.57,0.01,4.44-0.94,5.97-2.37c1.46-1.37,2.56-3.15,3.64-4.92 l2.79-4.59c0.02-0.03,0.03-0.06,0.05-0.09l0,0c0.77-1.75,0.93-2.98,0.53-3.8C64.97,16.41,64.56,16.08,63.99,15.91L63.99,15.91z"/></g></svg>
                    </span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity>Dashboard</span>
                    @if(request()->routeIs('dashboard'))
                        <span class="absolute left-0 top-2 bottom-2 w-1 bg-primary rounded-r"></span>
                    @endif
                </a>

                {{-- Students --}}
               <a href="{{ route('admin.students.index') }}"
                class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition
                {{ request()->routeIs('admin.students.*') ? 'bg-slate-50 text-slate-900 font-medium' : 'text-slate-700' }}">
                    <span class="h-5 w-5 text-slate-500">
                        <?xml version="1.0" encoding="utf-8"?><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 110.37" style="enable-background:new 0 0 122.88 110.37" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M61.92,0c10.42,0,18.86,8.44,18.86,18.86c0,10.42-8.44,18.86-18.86,18.86c-10.42,0-18.86-8.44-18.86-18.86 C43.07,8.44,51.51,0,61.92,0L61.92,0z M30.19,47.55c2.66-3.81,6.29-4.13,11.61-4.75h39.53c6.14,1.12,10.47,2.19,13.42,7.29 l23.21,31.74c2.65,3.62,4.93,5.88,4.92,10.7c-0.01,3.94-1.91,7.56-5.04,9.59c-4.02,2.62-7.09,1.85-11.15,0.43l-15.93-5.56v13.38 H31.64V97.78l-18.5,5.44c-6.04,1.31-10.35-0.93-12.1-5.14c-2.92-6.99,0.82-11.77,4.65-16.93L30.19,47.55L30.19,47.55z M32.19,76.02 V53.35l29.38,9.97l29.74-10.7V76.2c-20.53-4.3-21.39,14.31-8.7,20.31l-21.4,6.71l-20.67-7.25C53.58,89.97,50.92,70.71,32.19,76.02 L32.19,76.02z"/></g></svg>
                            </span>
                    <span x-show="!sidebarCollapsed">Students</span>
                </a>

                {{-- Teachers --}}
                <a href="{{ route('admin.teachers.index') }}"
                   class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition
                   {{ request()->routeIs('admin.teachers.*') ? 'bg-slate-50 text-slate-900 font-medium' : 'text-slate-700' }}">
                    <span class="h-5 w-5 text-slate-500">
                        <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 94.65"><defs><style>.cls-1{fill-rule:evenodd;}</style></defs><title>training</title><path class="cls-1" d="M21.92,0A10.36,10.36,0,1,1,11.57,10.35,10.35,10.35,0,0,1,21.92,0ZM14.61,22.7l3.68,9.65h.39l1.79-6.18-1-1.05c-.72-1.05-.47-2.25.87-2.47a9.91,9.91,0,0,1,1.45,0,8.37,8.37,0,0,1,1.59.06c1.24.28,1.37,1.48.75,2.44l-1,1.05L25,32.35h.38L28.7,22.7a4.52,4.52,0,0,0,.47.37,6.7,6.7,0,0,1,2.71.85,4.73,4.73,0,0,1,3,2l7.9,10.91,5.63,1.08V16.67h-8a1.86,1.86,0,1,1,0-3.72H77.56V7.52a1.87,1.87,0,0,1,3.73,0V13h39.53a1.86,1.86,0,1,1,0,3.72h-7.93V62.73H121a1.86,1.86,0,0,1,0,3.72H81.55V75a2.56,2.56,0,0,0,.26.2l11.62,11a1.85,1.85,0,1,1-2.54,2.68L81.55,80v8a1.87,1.87,0,0,1-3.73,0V79.68l-9.69,9.21a1.84,1.84,0,0,1-2.62-.07,1.82,1.82,0,0,1,.07-2.61l11.62-11h0a1.71,1.71,0,0,1,.62-.39V66.45H40.37a1.86,1.86,0,0,1,0-3.72h8V47.83L39.1,46A4.88,4.88,0,0,1,36,44.1l-3.93-5.45v.14l-.32,15.78,4,25.24,1.51,8.65c.85,5.78-8,9.21-10.19,1.62L21.91,59.66,16.66,90.57c-1,5.59-10.13,5.64-10.19-1.15l5.79-34.65-.44-18.71a7.9,7.9,0,0,0-1.19,2,12.61,12.61,0,0,0-1,4.58L8.83,53.55C8.39,59.25-.1,59.6,0,53.45c.05-2.76.3-5.54.6-8.37.58-5.42.7-8.78,3.79-14.18a18.3,18.3,0,0,1,4.5-5.21,12.14,12.14,0,0,1,4.88-2.32,7.26,7.26,0,0,0,.84-.67ZM52.13,38.26l10.46-11a2.47,2.47,0,1,1,3.58,3.4L56.33,41a4.89,4.89,0,0,1-4.2,7.46V62.73H109.2V16.67H52.13V38.26Z"/></svg>


                    </span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity>Teachers</span>
                    @if(request()->routeIs('admin.teachers.*'))
                        <span class="absolute left-0 top-2 bottom-2 w-1 bg-primary rounded-r"></span>
                    @endif
                </a>
                

                {{-- Academics --}}
                <div class="pt-4">
                    <div class="px-3 pb-2 text-[11px] font-medium uppercase tracking-wide text-slate-400"
                         x-show="!sidebarCollapsed" x-transition.opacity>
                        Academics
                    </div>

                    @foreach([
                        ['admin.classes.index', 'Classes'],
                        ['admin.streams.index', 'Streams'],
                        ['admin.subjects.index', 'Subjects'],
                        ['admin.academic-years.index', 'Academic Years'],
                        ['admin.terms.index', 'Terms'],
                    ] as [$route, $label])
                        <a href="{{ route($route) }}"
                           class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition
                           {{ request()->routeIs(str_replace('.index', '.*', $route)) ? 'bg-slate-50 text-slate-900 font-medium' : 'text-slate-700' }}">
                            <span class="h-5 w-5 text-slate-500">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 19.477 5.754 20 7.5 20s3.332-.523 4.5-1.747M16.5 5c1.152 0 2.26.26 3.375.698M16.5 5c-1.152 0-2.26.26-3.375.698M16.5 5v13M19.875 18.698c1.115-.438 2.223-.698 3.375-.698M19.875 18.698C18.708 19.477 17.122 20 15.375 20s-3.332-.523-4.5-1.747M14.25 4.908c-.806-.437-1.697-.908-2.625-.908s-1.819 .471-2.625 .908M14.25 4.908v13"/>
                                </svg>
                            </span>
                            <span x-show="!sidebarCollapsed" x-transition.opacity>{{ $label }}</span>
                        </a>
                    @endforeach
                </div>

                {{-- Assessment --}}
                <div class="pt-4">
                    <div class="px-3 pb-2 text-[11px] font-medium uppercase tracking-wide text-slate-400"
                         x-show="!sidebarCollapsed" x-transition.opacity>
                        Assessment
                    </div>

                    <a href="{{ route('admin.exams.index') }}"
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition
                       {{ request()->routeIs('admin.exams.*') ? 'bg-slate-50 text-slate-900 font-medium' : 'text-slate-700' }}">
                        <span class="h-5 w-5 text-slate-500">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 97.45 122.88"><title>exam</title><path d="M24.19,50.27H18.65v2.1h6.79V56.8H13.12V39.5H25.3l-.69,4.43h-6v2.32h5.54v4Zm3.62,40.84a2.22,2.22,0,0,1,3.16,0,2.28,2.28,0,0,1,0,3.2l-2.74,2.8L31,99.91a2.24,2.24,0,0,1,0,3.17,2.22,2.22,0,0,1-3.15,0l-2.72-2.78-2.74,2.79a2.22,2.22,0,0,1-3.16,0,2.27,2.27,0,0,1,0-3.2l2.76-2.81-2.76-2.8a2.25,2.25,0,0,1,0-3.18,2.23,2.23,0,0,1,3.15,0l2.72,2.78,2.74-2.79ZM17.29,76a2.73,2.73,0,1,1,4.54-3l1.48,1.63,5.18-6.46a2.72,2.72,0,1,1,4.21,3.46l-7.4,8.94a3.78,3.78,0,0,1-.65.61,2.74,2.74,0,0,1-3.8-.75L17.29,76ZM37.66,5.12V10.2a2.57,2.57,0,0,1-2.32,2.54,2.92,2.92,0,0,1-.9.13H25V23.39H72.44V12.88H63a2.88,2.88,0,0,1-.9-.13,2.57,2.57,0,0,1-2.32-2.54V5.13ZM23.73,28.61A3.92,3.92,0,0,1,21,27.48c-.09-.1-.13-.19-.22-.28a3.92,3.92,0,0,1-.9-2.45V19.58H5.67a.47.47,0,0,0-.4.18.73.73,0,0,0-.19.42v97a.43.43,0,0,0,.19.41.56.56,0,0,0,.4.18H91.78a.56.56,0,0,0,.4-.18.45.45,0,0,0,.19-.41v-97a.68.68,0,0,0-.19-.41.5.5,0,0,0-.4-.18H77.57v5.17a4,4,0,0,1-.9,2.45c-.09.09-.14.18-.23.28a3.9,3.9,0,0,1-2.72,1.13Zm-18,94.27a5.67,5.67,0,0,1-4-1.68,5.62,5.62,0,0,1-1.68-4v-97a5.6,5.6,0,0,1,1.68-4,5.62,5.62,0,0,1,4-1.68H19.92V11.66a3.8,3.8,0,0,1,1.13-2.73,3.88,3.88,0,0,1,2.73-1.14h8.8V4.27a4.19,4.19,0,0,1,1.27-3,4.2,4.2,0,0,1,3-1.27H60.6a4.23,4.23,0,0,1,3,1.27,4.23,4.23,0,0,1,1.27,3V7.8h8.8a3.89,3.89,0,0,1,3.86,3.87v2.81H91.74a5.74,5.74,0,0,1,5.71,5.71v97a5.6,5.6,0,0,1-1.68,4,5.71,5.71,0,0,1-4,1.68ZM77.6,76.27a2.58,2.58,0,1,0,0-5.16H43.25a2.58,2.58,0,0,0,0,5.16Zm0,23.34a2.58,2.58,0,1,0,0-5.16H43.25a2.58,2.58,0,0,0,0,5.16ZM33.73,39.5l1.91,4.62h.28l1.91-4.62h6L40,47.86l3.85,8.94H37.69l-2.08-5h-.25l-2,5H27.44L31.21,48,27.44,39.5ZM50.38,56.8H44.54L49,39.5h8.55l4.49,17.3H56.23l-.64-2.74H51l-.64,2.74Zm2.78-12L52,49.66h2.55l-1.11-4.85Zm15.89,12H63.26l1.06-17.3h7.22l2.16,8.8h.2l2.15-8.8h7.23l1,17.3H78.55l-.34-8.39H78l-2.1,8.39H71.68l-2.13-8.39h-.17l-.33,8.39Z"/></svg>
                        </span>
                        <span x-show="!sidebarCollapsed" x-transition.opacity>Exams</span>
                    </a>
                </div>

                {{-- Operations --}}
                <div class="pt-4">
                    <div class="px-3 pb-2 text-[11px] font-medium uppercase tracking-wide text-slate-400"
                         x-show="!sidebarCollapsed" x-transition.opacity>
                        Operations
                    </div>

                    {{-- <a href="{{ route('admin.promotions.index') }}"
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition">
                        <span class="h-5 w-5 text-slate-500">🔁</span>
                        <span x-show="!sidebarCollapsed" x-transition.opacity>Promotions</span>
                    </a> --}}

                    <a href="{{ route('admin.promotion-logs.index') }}"
                       class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 transition">
                        <span class="h-5 w-5 text-slate-500">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 93.61"><defs><style>.cls-1{fill-rule:evenodd;}</style></defs><title>workflow</title><path class="cls-1" d="M115.64,35.41l3,3a2,2,0,0,1,0,2.87l-2.42,2.42a16.16,16.16,0,0,1,1.5,4h3.13a2,2,0,0,1,2,2V54a2,2,0,0,1-2,2h-3.42a16.06,16.06,0,0,1-1.77,3.88l2.22,2.21a2,2,0,0,1,0,2.87l-3,3A2,2,0,0,1,112,68l-2.42-2.42a15.63,15.63,0,0,1-4,1.5v3.13a2,2,0,0,1-2,2H99.32a2,2,0,0,1-2-2V66.75A16.45,16.45,0,0,1,93.41,65L91.2,67.2a2,2,0,0,1-2.87,0l-3-3a2,2,0,0,1,0-2.87l2.42-2.42a15.77,15.77,0,0,1-1.5-4H83.12a2,2,0,0,1-2-2V48.64a2,2,0,0,1,2-2h3.42a16.06,16.06,0,0,1,1.77-3.88L86.1,40.52a2,2,0,0,1,0-2.87l3-3a2,2,0,0,1,2.87,0l2.42,2.42a15.77,15.77,0,0,1,4-1.5V32.44a2,2,0,0,1,2-2h4.24a2,2,0,0,1,2,2v3.41a16.06,16.06,0,0,1,3.88,1.77l2.21-2.21a2,2,0,0,1,2.86,0ZM44.12,53a2.2,2.2,0,0,1-2-2.36,2.15,2.15,0,0,1,2-2.36H69.19a2.21,2.21,0,0,1,2,2.36,2.16,2.16,0,0,1-2,2.36ZM27.56,46H36a.75.75,0,0,1,.79.79v8.45A.74.74,0,0,1,36,56H27.56a.74.74,0,0,1-.79-.78V46.76a.75.75,0,0,1,.79-.79Zm0,20.85H36a.75.75,0,0,1,.79.79v8.44a.75.75,0,0,1-.79.79H27.56a.75.75,0,0,1-.79-.79V67.61a.75.75,0,0,1,.79-.79Zm16.56,7a2.2,2.2,0,0,1-2-2.35,2.15,2.15,0,0,1,2-2.36h17.1a2.2,2.2,0,0,1,2,2.36,2.15,2.15,0,0,1-2,2.35ZM30,35.17a1.35,1.35,0,0,1-1.81-.23L28,34.78l-2.52-2.59a1.43,1.43,0,0,1,.24-2,1.68,1.68,0,0,1,2.2-.08l1.34,1.42L34.17,27a1.39,1.39,0,0,1,2,.47,1.58,1.58,0,0,1-.16,2.2l-6,5.52Zm14-2c-1.1,0-1.83-1.1-1.83-2.36s.73-2.36,1.83-2.36H73a2.21,2.21,0,0,1,2,2.36,2.16,2.16,0,0,1-2,2.36ZM3.5,70.32c2.93-3.08,4.12-3.47,8.06-4.19V3c-9.19.9-8.13,9.41-8.07,17.32,0,1.06,0,1.62,0,1.88V70.32ZM15,12.09h86.23a2.36,2.36,0,0,1,1.7.71,2.4,2.4,0,0,1,.71,1.7v7H99.19V16H15V67.86h0a1.46,1.46,0,0,1-1.25,1.45C.63,71.34,0,86.9,13.37,89.13H99.19V82.6h4.47v8.6a2.41,2.41,0,0,1-.71,1.7h0a2.4,2.4,0,0,1-1.7.71h-88c-3.6,0-8.59-2.82-10.68-5.8S-.17,81.18,0,76.84V20.36C0,10.69-.1.24,13.37,0h.18A1.47,1.47,0,0,1,15,1.48V12.09ZM102,43a8.34,8.34,0,1,1-8.34,8.34A8.34,8.34,0,0,1,102,43Z"/></svg>
                        </span>
                        <span x-show="!sidebarCollapsed" x-transition.opacity>Promotion Logs</span>
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
                    </span>
                    <span x-show="!sidebarCollapsed">Parent Dashboard</span>
                </a>
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
            <header class="bg-white border-b border-slate-100">
                <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <button type="button"
                                class="md:hidden rounded-lg border border-slate-200 px-3 py-2 text-slate-600 hover:bg-slate-50"
                                @click="sidebarOpen=true">
                            Menu
                        </button>

                        <div>
                            <div class="text-xs text-slate-500">
                                Piphan Rose Educational Centre
                            </div>
                            <div class="text-lg font-semibold text-slate-900">
                                @yield('page_title', 'Dashboard')
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="rounded-lg border border-slate-200 px-4 py-2 text-sm hover:bg-slate-50">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1">
                <div class="max-w-7xl mx-auto p-6">
                    @yield('content')
                </div>
            </main>

            {{-- Footer --}}
            <footer class="border-t border-slate-100 bg-white">
                <div class="max-w-7xl mx-auto px-6 py-4 text-sm text-slate-500">
                    © {{ date('Y') }} Piphan Rose Educational Centre
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



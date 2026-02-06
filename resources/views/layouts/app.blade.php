<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800">
    <div class="min-h-screen flex">
        @include('partials.sidebar')
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>

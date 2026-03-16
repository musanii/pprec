<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>{{ config('app.name') }} | @yield('title')</title>

@vite(['resources/css/app.css','resources/js/app.js'])

<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">

</head>

<body class="bg-brand-secondary font-sans text-gray-700">
    

<div 
    x-data="{ loading: true }"
    x-init="window.addEventListener('load', () => loading = false)"
>

<div 
    x-show="loading"
    class="fixed inset-0 flex items-center justify-center bg-brand-secondary z-50"
>

<div class="flex flex-col items-center space-y-4">

<div class="w-12 h-12 border-4 border-brand-primary border-t-transparent rounded-full animate-spin"></div>

<p class="text-sm text-gray-600">
Loading...
</p>

</div>

</div>

<div x-show="!loading">

@include('website.partials.navbar')

<main>
@yield('content')
</main>

@include('website.partials.footer')

</div>

</div>
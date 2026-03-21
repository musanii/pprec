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

<body x-data="{ loading: true }"
      x-init="window.addEventListener('load', () => loading = false)"
      class="bg-brand-secondary font-sans text-gray-700">

<!-- Loader -->
<div x-show="loading"
     x-transition.opacity
     class="fixed inset-0 flex items-center justify-center bg-brand-secondary z-50">

    <div class="flex flex-col items-center space-y-6">

        <div class="relative flex items-center justify-center">

            <!-- Spinning ring -->
            <div class="w-20 h-20 border-4 border-brand-primary border-t-transparent rounded-full animate-spin"></div>

            <!-- PR initials -->
            <div class="absolute text-brand-primary font-heading text-xl">
                PR
            </div>

        </div>

        <p class="text-gray-500 text-sm tracking-wide">
            Piphan Rose Educational Center
        </p>

    </div>

</div>

<!-- Website -->
<div x-show="!loading">

@include('website.partials.navbar')

<main>
@yield('content')
</main>

@include('website.partials.footer')

</div>

</body>
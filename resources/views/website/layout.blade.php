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

@include('website.partials.navbar')

<main>

@yield('content')

</main>

@include('website.partials.footer')

</body>

</html>
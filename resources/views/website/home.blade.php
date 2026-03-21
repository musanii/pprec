@extends('website.layout')

@section('title','Home')

@section('content')

<section class="relative h-screen flex items-center justify-center text-center text-white">

<!-- Background Image -->
<div class="absolute inset-0">

<img 
src="/assets/images/hero.png"
class="w-full h-full object-cover"
/>

</div>

<!-- Gradient Overlay -->
<div class="absolute inset-0 bg-black/60"></div>

<!-- Hero Content -->
<div class="relative z-10 max-w-3xl px-6">

<h1 class="text-5xl md:text-6xl font-heading mb-6 leading-tight">

Excellence Through Discipline

</h1>

<p class="text-lg md:text-xl mb-10 text-gray-200">

Empowering the next generation through academic excellence,
character development and leadership.

</p>

<div class="flex justify-center gap-4">

<a href="/admissions"
class="bg-brand-primary px-8 py-3 rounded-lg font-semibold hover:opacity-90 transition">

Apply for Admission

</a>

<a href="/about"
class="bg-white text-brand-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">

Learn More

</a>

</div>

</div>

<!-- Scroll Indicator -->
<div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">

<div class="w-6 h-10 border-2 border-white rounded-full flex justify-center">

<div class="w-1 h-3 bg-white mt-2 rounded"></div>

</div>

</div>

</section>

@endsection
@extends('website.layout')

@section('title','Home')

@section('content')

<section class="relative h-screen flex items-center justify-center text-center text-white"
x-data="{ visible:false }"
x-intersect="visible = true"
:class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">

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


<!-- Statistics Section -->
<section
class="bg-white py-24 transition-all duration-1000"
x-data="{ visible:false }"
x-intersect="visible = true"
:class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
>
<div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-12 text-center">

<!-- Students -->

<div 
x-data="counter(500)"
x-init="observe($el)"
>

<h2 class="text-4xl font-heading text-brand-primary">

<span x-text="value"></span>+

</h2>

<p class="mt-2 text-gray-600">
Students
</p>

</div>

<!-- Teachers -->

<div 
x-data="counter(40)"
x-init="observe($el)"
>

<h2 class="text-4xl font-heading text-brand-primary">

<span x-text="value"></span>

</h2>

<p class="mt-2 text-gray-600">
Teachers
</p>

</div>

<!-- Years -->

<div 
x-data="counter(15)"
x-init="observe($el)"
>

<h2 class="text-4xl font-heading text-brand-primary">

<span x-text="value"></span>

</h2>

<p class="mt-2 text-gray-600">
Years of Excellence
</p>

</div>

<!-- Activities -->

<div 
x-data="counter(20)"
x-init="observe($el)"
>

<h2 class="text-4xl font-heading text-brand-primary">

<span x-text="value"></span>+

</h2>

<p class="mt-2 text-gray-600">
Activities
</p>

</div>

</div>

</section>

@endsection
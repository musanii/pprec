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

<!-- Activities Section -->

<section
class="py-24 bg-brand-secondary transition-all duration-1000"
x-data="{ visible:false }"
x-intersect="visible = true"
:class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
>

<div class="max-w-7xl mx-auto px-6">

<!-- Section Header -->
<div class="text-center mb-16">

<h2 class="text-4xl font-heading text-brand-primary mb-4">
Co-Curricular Activities
</h2>

<p class="text-gray-600 max-w-2xl mx-auto">
We nurture talent beyond the classroom through a wide range of activities that build confidence, teamwork and leadership.
</p>

</div>

<!-- Cards Grid -->
<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">

<!-- Debating -->
<div class="relative group overflow-hidden rounded-xl shadow-md">

<img src="/assets/images/activities/debating.png"
class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">

<div class="absolute inset-0 bg-black/50 group-hover:bg-black/60 transition"></div>

<div class="absolute bottom-6 left-6 text-white">

<h3 class="text-xl font-heading mb-1">
Debating
</h3>

<p class="text-sm text-gray-200">
Build confidence and public speaking skills.
</p>

</div>

</div>

<!-- Sports -->
<div class="relative group overflow-hidden rounded-xl shadow-md">

<img src="/assets/images/activities/sports.png"
class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">

<div class="absolute inset-0 bg-black/50 group-hover:bg-black/60 transition"></div>

<div class="absolute bottom-6 left-6 text-white">

<h3 class="text-xl font-heading mb-1">
Sports
</h3>

<p class="text-sm text-gray-200">
Encouraging teamwork and physical excellence.
</p>

</div>

</div>

<!-- Scouting -->
<div class="relative group overflow-hidden rounded-xl shadow-md">

<img src="/assets/images/activities/scouting.png"
class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">

<div class="absolute inset-0 bg-black/50 group-hover:bg-black/60 transition"></div>

<div class="absolute bottom-6 left-6 text-white">

<h3 class="text-xl font-heading mb-1">
Scouting
</h3>

<p class="text-sm text-gray-200">
Leadership, discipline and survival skills.
</p>

</div>

</div>

<!-- Performing Arts -->
<div class="relative group overflow-hidden rounded-xl shadow-md">

<img src="/assets/images/activities/arts.png"
class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">

<div class="absolute inset-0 bg-black/50 group-hover:bg-black/60 transition"></div>

<div class="absolute bottom-6 left-6 text-white">

<h3 class="text-xl font-heading mb-1">
Performing Arts
</h3>

<p class="text-sm text-gray-200">
Creativity through music, dance and drama.
</p>

</div>

</div>

</div>

</div>

</section>


<!-- Why Choose Us -->

<section
class="py-24 bg-white transition-all duration-1000"
x-data="{ visible:false }"
x-intersect="visible = true"
:class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
>

<div class="max-w-7xl mx-auto px-6">

<!-- Header -->
<div class="text-center mb-16">

<h2 class="text-4xl font-heading text-brand-primary mb-4">
Why Choose Piphan Rose
</h2>

<p class="text-gray-600 max-w-2xl mx-auto">
We provide a learning environment that nurtures academic excellence, discipline and holistic growth.
</p>

</div>

<!-- Features Grid -->
<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">

<!-- Feature 1 -->
<div class="text-center group">

<div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center rounded-full bg-brand-primary/10 text-brand-primary text-2xl transition group-hover:bg-brand-primary group-hover:text-white">

📘

</div>

<h3 class="font-heading text-lg mb-2 text-brand-primary">
Qualified Teachers
</h3>

<p class="text-gray-600 text-sm">
Our educators are experienced, passionate and dedicated to student success.
</p>

</div>

<!-- Feature 2 -->
<div class="text-center group">

<div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center rounded-full bg-brand-primary/10 text-brand-primary text-2xl transition group-hover:bg-brand-primary group-hover:text-white">

🏫

</div>

<h3 class="font-heading text-lg mb-2 text-brand-primary">
Modern Facilities
</h3>

<p class="text-gray-600 text-sm">
A safe and well-equipped environment that supports effective learning.
</p>

</div>

<!-- Feature 3 -->
<div class="text-center group">

<div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center rounded-full bg-brand-primary/10 text-brand-primary text-2xl transition group-hover:bg-brand-primary group-hover:text-white">

🎯

</div>

<h3 class="font-heading text-lg mb-2 text-brand-primary">
Holistic Development
</h3>

<p class="text-gray-600 text-sm">
We focus on academics, discipline, leadership and life skills.
</p>

</div>

<!-- Feature 4 -->
<div class="text-center group">

<div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center rounded-full bg-brand-primary/10 text-brand-primary text-2xl transition group-hover:bg-brand-primary group-hover:text-white">

📈

</div>

<h3 class="font-heading text-lg mb-2 text-brand-primary">
Proven Performance
</h3>

<p class="text-gray-600 text-sm">
Consistent academic excellence and outstanding student outcomes.
</p>

</div>

</div>

</div>

</section>

@endsection
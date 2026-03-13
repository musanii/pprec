<header class="bg-white shadow-md">

<div class="max-w-7xl mx-auto px-6">

<div class="flex items-center justify-between h-16">

<a href="/" class="flex items-center space-x-2">

<span class="text-xl font-bold text-blue-700">
Piphan Rose
</span>

</a>

<nav class="hidden md:flex space-x-8">

<a href="/" class="hover:text-blue-700">Home</a>

<a href="/about" class="hover:text-blue-700">About</a>

<a href="/activities" class="hover:text-blue-700">Activities</a>

<a href="/admissions" class="hover:text-blue-700">Admissions</a>

<a href="/news" class="hover:text-blue-700">News</a>

<a href="/contact" class="hover:text-blue-700">Contact</a>

</nav>

<div class="hidden md:block">

<a href="/login"
class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">

Login

</a>

</div>

<button x-data @click="$dispatch('toggle-menu')" class="md:hidden">

<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6">

<path stroke="currentColor" stroke-width="2"
d="M4 6h16M4 12h16M4 18h16"/>

</svg>

</button>

</div>

</div>

</header>
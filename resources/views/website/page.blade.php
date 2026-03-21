@extends('website.layout')

@section('title', $page->title)

@section('content')

<section class="py-24 bg-white">

<div class="max-w-4xl mx-auto px-6">

<h1 class="text-4xl font-heading text-brand-primary mb-6">
{{ $page->title }}
</h1>

<div class="prose max-w-none text-gray-700">

{!! $page->content !!}

</div>

</div>

</section>

@endsection
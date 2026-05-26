@extends('layouts.app')
@section('title', $post->title)

@section('content')
<article class="max-w-3xl mx-auto px-4 py-12">

    {{-- Breadcrumb --}}
    <nav class="text-xs text-gray-400 mb-6 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-primary">Accueil</a>
        <span>/</span>
        <a href="{{ route('posts.index') }}" class="hover:text-primary">Actualités</a>
        <span>/</span>
        <span class="text-gray-600 truncate max-w-xs">{{ $post->title }}</span>
    </nav>

    <span class="text-xs font-bold text-accent uppercase tracking-wide">{{ $post->category }}</span>
    <h1 class="text-3xl md:text-4xl font-black text-gray-900 mt-2 leading-tight">{{ $post->title }}</h1>
    <p class="text-gray-400 text-sm mt-3">Publié le {{ $post->published_at?->format('d M Y') }}</p>

    @if($post->cover_image)
        <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" class="w-full rounded-2xl my-8 shadow">
    @endif

    @if($post->excerpt)
        <p class="text-lg text-gray-600 font-medium border-l-4 border-accent pl-4 mb-8 leading-relaxed">{{ $post->excerpt }}</p>
    @endif

    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
        {!! $post->content !!}
    </div>
</article>

{{-- Articles connexes --}}
@if($related->count())
<section class="bg-gray-50 py-12 px-4 mt-8">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-xl font-bold text-primary mb-6">Lire aussi</h2>
        <div class="grid md:grid-cols-3 gap-5">
            @foreach($related as $r)
            <a href="{{ route('posts.show', $r->slug) }}" class="group bg-white rounded-xl shadow-sm hover:shadow transition overflow-hidden">
                @if($r->cover_image)
                    <img src="{{ asset('storage/' . $r->cover_image) }}" alt="{{ $r->title }}" class="w-full h-36 object-cover">
                @endif
                <div class="p-4">
                    <h3 class="text-sm font-semibold text-gray-800 group-hover:text-primary transition leading-snug">{{ $r->title }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@extends('layouts.app')
@section('title', 'Actualités')
@section('nav_posts', 'active')

@section('content')
<div class="bg-primary text-white py-12 px-4 text-center">
    <h1 class="text-3xl font-black">Actualités</h1>
    <p class="text-white/70 mt-2">Restez informé des nouvelles de l'UFEEL</p>
</div>

<div class="max-w-7xl mx-auto px-4 py-12">

    {{-- Article à la une --}}
    @if($featured)
    <a href="{{ route('posts.show', $featured->slug) }}" class="group block mb-10 bg-white rounded-2xl shadow overflow-hidden md:flex">
        @if($featured->cover_image)
            <img src="{{ asset('storage/' . $featured->cover_image) }}" alt="{{ $featured->title }}" class="w-full md:w-2/5 h-56 md:h-auto object-cover group-hover:opacity-95 transition">
        @endif
        <div class="p-8 flex flex-col justify-center">
            <span class="text-xs font-bold text-accent uppercase tracking-wide">À la une · {{ $featured->category }}</span>
            <h2 class="text-2xl font-bold text-gray-900 mt-2 group-hover:text-primary transition leading-snug">{{ $featured->title }}</h2>
            @if($featured->excerpt)
                <p class="text-gray-500 mt-3 text-sm leading-relaxed">{{ $featured->excerpt }}</p>
            @endif
            <p class="text-gray-400 text-xs mt-4">{{ $featured->published_at?->format('d M Y') }}</p>
        </div>
    </a>
    @endif

    {{-- Grille --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($posts as $post)
        <a href="{{ route('posts.show', $post->slug) }}" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden flex flex-col">
            @if($post->cover_image)
                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" class="w-full h-44 object-cover group-hover:scale-105 transition duration-300">
            @else
                <div class="w-full h-44 bg-primary/10 flex items-center justify-center">
                    <span class="text-primary/20 text-5xl font-black">U</span>
                </div>
            @endif
            <div class="p-5 flex-1 flex flex-col">
                <span class="text-xs font-bold text-accent uppercase">{{ $post->category }}</span>
                <h3 class="font-semibold text-gray-800 mt-1 group-hover:text-primary transition leading-snug">{{ $post->title }}</h3>
                @if($post->excerpt)
                    <p class="text-gray-500 text-xs mt-2 line-clamp-2">{{ $post->excerpt }}</p>
                @endif
                <p class="text-gray-400 text-xs mt-auto pt-3">{{ $post->published_at?->format('d M Y') }}</p>
            </div>
        </a>
        @empty
        <div class="col-span-3 text-center py-16 text-gray-400">Aucune actualité publiée pour le moment.</div>
        @endforelse
    </div>

    <div class="mt-8">{{ $posts->links() }}</div>
</div>
@endsection

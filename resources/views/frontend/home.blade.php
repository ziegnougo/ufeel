@extends('layouts.app')
@section('title', 'Accueil')
@section('nav_home', 'active')

@section('content')

{{-- HERO --}}
<section class="text-white py-24 px-4" style="background: linear-gradient(135deg, #000032 0%, #00005a 60%, #0a0a7a 100%)">
    <div class="max-w-4xl mx-auto text-center">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo UFEEL"
             class="h-28 w-28 rounded-full object-cover border-4 border-white/30 shadow-2xl mx-auto mb-6">
        <p class="text-accent font-semibold text-sm uppercase tracking-widest mb-3">Bienvenue sur la plateforme de l'UFEEL</p>
        <h1 class="text-4xl md:text-5xl font-black leading-tight mb-5">
            Unis pour construire<br>notre avenir ensemble
        </h1>
        <p class="text-white/80 text-lg mb-8 max-w-2xl mx-auto">
            L'Union Fraternelle des Élèves et Étudiants de Lafi vous accompagne dans votre parcours scolaire, universitaire et professionnel.
        </p>
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="{{ route('register') }}" class="bg-accent hover:bg-accent-dark text-white font-bold px-6 py-3 rounded-full transition shadow-lg">
                Rejoindre l'UFEEL
            </a>
            <a href="{{ route('events.index') }}" class="border border-white/40 hover:bg-white/10 text-white font-medium px-6 py-3 rounded-full transition">
                Voir les événements
            </a>
        </div>
    </div>
</section>

{{-- STATS --}}
@if($stats->count())
<section class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        @foreach($stats as $stat)
        <div>
            <p class="text-3xl font-black text-primary">{{ number_format($stat->value) }}</p>
            <p class="text-gray-500 text-sm mt-1">{{ $stat->label }}</p>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- ACTUALITÉS --}}
@if($posts->count())
<section class="max-w-7xl mx-auto px-4 py-16">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold text-primary">Dernières actualités</h2>
        <a href="{{ route('posts.index') }}" class="text-primary-light text-sm hover:underline">Tout voir →</a>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
        @foreach($posts as $post)
        <a href="{{ route('posts.show', $post->slug) }}" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">
            @if($post->cover_image)
                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" class="w-full h-44 object-cover group-hover:scale-105 transition duration-300">
            @else
                <div class="w-full h-44 bg-primary/10 flex items-center justify-center">
                    <span class="text-primary/30 text-4xl font-black">U</span>
                </div>
            @endif
            <div class="p-4">
                <span class="text-xs font-semibold text-accent uppercase">{{ $post->category }}</span>
                <h3 class="font-semibold text-gray-800 mt-1 leading-snug group-hover:text-primary transition">{{ $post->title }}</h3>
                <p class="text-gray-500 text-xs mt-2">{{ $post->published_at?->format('d M Y') }}</p>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- ÉVÉNEMENTS --}}
@if($events->count())
<section class="bg-gray-100 py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-primary">Prochains événements</h2>
            <a href="{{ route('events.index') }}" class="text-primary-light text-sm hover:underline">Tout voir →</a>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($events as $event)
            <a href="{{ route('events.show', $event->slug) }}" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden flex flex-col">
                @if($event->cover_image)
                    <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-40 object-cover">
                @else
                    <div class="w-full h-40 bg-primary flex items-center justify-center">
                        <svg class="w-10 h-10 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                <div class="p-4 flex-1 flex flex-col">
                    <p class="text-xs text-accent font-semibold">{{ $event->starts_at->format('d M Y · H\hi') }}</p>
                    <h3 class="font-semibold text-gray-800 mt-1 group-hover:text-primary transition">{{ $event->title }}</h3>
                    @if($event->location)
                        <p class="text-gray-400 text-xs mt-auto pt-3">📍 {{ $event->location }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- OPPORTUNITÉS --}}
@if($opportunities->count())
<section class="max-w-7xl mx-auto px-4 py-16">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold text-primary">Opportunités</h2>
        <a href="{{ route('opportunities.index') }}" class="text-primary-light text-sm hover:underline">Tout voir →</a>
    </div>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($opportunities as $opp)
        @php $colors = ['stage' => 'blue', 'bourse' => 'green', 'projet' => 'yellow']; $c = $colors[$opp->type] ?? 'gray'; @endphp
        <div class="bg-white rounded-xl p-5 shadow-sm border-t-4 border-{{ $c }}-500">
            <span class="text-xs font-bold text-{{ $c }}-600 uppercase">{{ $opp->type }}</span>
            <h3 class="font-semibold text-gray-800 mt-2 text-sm leading-snug">{{ $opp->title }}</h3>
            @if($opp->organization)
                <p class="text-gray-400 text-xs mt-1">{{ $opp->organization }}</p>
            @endif
            @if($opp->deadline)
                <p class="text-xs text-red-500 mt-3 font-medium">Limite : {{ $opp->deadline->format('d M Y') }}</p>
            @endif
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- REJOINDRE CTA --}}
<section class="bg-primary text-white py-16 px-4 text-center">
    <h2 class="text-3xl font-black mb-4">Prêt à rejoindre la famille UFEEL ?</h2>
    <p class="text-white/70 mb-8 max-w-xl mx-auto">Accédez à des ressources exclusives, des événements, des opportunités et un réseau de membres engagés.</p>
    <a href="{{ route('register') }}" class="bg-accent hover:bg-accent-dark text-white font-bold px-8 py-3 rounded-full transition shadow-lg text-lg">
        S'inscrire maintenant
    </a>
</section>

{{-- PARTENAIRES --}}
@if($partners->count())
<section class="max-w-7xl mx-auto px-4 py-12 text-center">
    <p class="text-gray-400 text-sm font-semibold uppercase tracking-widest mb-8">Nos partenaires</p>
    <div class="flex flex-wrap gap-8 justify-center items-center">
        @foreach($partners as $partner)
        <div class="grayscale hover:grayscale-0 transition opacity-60 hover:opacity-100">
            @if($partner->logo)
                <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="h-10 object-contain">
            @else
                <span class="text-gray-500 font-semibold text-sm">{{ $partner->name }}</span>
            @endif
        </div>
        @endforeach
    </div>
</section>
@endif

@endsection

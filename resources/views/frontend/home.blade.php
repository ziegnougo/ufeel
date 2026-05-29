@extends('layouts.app')
@section('title', 'Accueil')
@section('nav_home', 'active')

@section('content')

{{-- ══════ HERO ══════ --}}
<section class="relative overflow-hidden min-h-[88vh] flex items-center"
         style="background: linear-gradient(135deg,#000032 0%,#000050 45%,#1a3c8f 100%)">
    {{-- Grille décorative --}}
    <div class="absolute inset-0" style="background-image:radial-gradient(circle at 1px 1px,rgba(255,255,255,.04) 1px,transparent 0);background-size:40px 40px"></div>
    {{-- Cercle déco --}}
    <div class="absolute -top-32 -right-32 w-[600px] h-[600px] rounded-full opacity-10"
         style="background:radial-gradient(circle,#F5A800,transparent 70%)"></div>

    <div class="relative w-full px-6 xl:px-10 2xl:px-16 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center max-w-screen-2xl mx-auto">

            {{-- Texte gauche --}}
            <div>
                <span class="inline-flex items-center gap-2 bg-gold/15 text-gold text-xs font-bold tracking-widest uppercase px-4 py-2 rounded-full mb-8 border border-gold/20">
                    ✦ Plateforme officielle UFEEL
                </span>
                <h1 class="text-5xl xl:text-6xl 2xl:text-7xl font-black text-white leading-[1.1] mb-6">
                    Unis pour<br>
                    <span class="text-gold">construire</span><br>
                    notre avenir
                </h1>
                <p class="text-white/65 text-xl leading-relaxed mb-10 max-w-xl">
                    L'Union Fraternelle des Élèves et Étudiants de Lafi — ta communauté pour réussir ensemble en Côte d'Ivoire.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="btn btn-gold text-base shadow-2xl">
                        ✨ Rejoindre l'UFEEL
                    </a>
                    <a href="{{ route('events.index') }}" class="btn btn-ghost text-base">
                        📅 Voir les événements
                    </a>
                </div>

                {{-- Stats inline --}}
                @if($stats->count())
                <div class="flex flex-wrap gap-8 mt-14 pt-10 border-t border-white/10">
                    @foreach($stats as $stat)
                    <div>
                        <p class="text-3xl xl:text-4xl font-black text-gold">{{ number_format($stat->value) }}+</p>
                        <p class="text-white/50 text-sm mt-0.5">{{ $stat->label }}</p>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Logo droit --}}
            <div class="flex justify-center lg:justify-end">
                <div class="relative">
                    <div class="absolute inset-0 rounded-full blur-3xl opacity-30 scale-110"
                         style="background:radial-gradient(circle,#F5A800,transparent 70%)"></div>
                    <img src="{{ asset('images/logo.jpg') }}" alt="UFEEL"
                         class="relative w-72 h-72 xl:w-96 xl:h-96 2xl:w-[440px] 2xl:h-[440px] rounded-full object-cover shadow-2xl"
                         style="box-shadow:0 0 0 4px rgba(245,168,0,.3),0 0 0 12px rgba(245,168,0,.08),0 40px 80px rgba(0,0,50,.5)">
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════ ACTUALITÉS ══════ --}}
@if($posts->count())
<section class="w-full px-6 xl:px-10 2xl:px-16 py-20">
    <div class="max-w-screen-2xl mx-auto">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="sec-eyebrow">Blog & Actualités</p>
                <h2 class="sec-title">Dernières nouvelles</h2>
            </div>
            <a href="{{ route('posts.index') }}" class="btn btn-navy text-sm py-2.5 px-6 hidden sm:inline-flex">
                Tout voir →
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($posts->take(4) as $post)
            <a href="{{ route('posts.show', $post->slug) }}" class="card group flex flex-col">
                @if($post->image)
                    <img src="{{ Storage::url($post->image) }}" alt="" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 flex items-center justify-center text-5xl"
                         style="background:linear-gradient(135deg,#000032,#1a3c8f)">📰</div>
                @endif
                <div class="p-5 flex-1 flex flex-col">
                    <span class="badge bg-gold/10 text-gold mb-3">{{ ucfirst($post->category ?? 'Actualité') }}</span>
                    <h3 class="font-bold text-navy text-base leading-snug group-hover:text-gold transition mb-2 flex-1">{{ $post->title }}</h3>
                    @if($post->excerpt)
                        <p class="text-gray-500 text-sm line-clamp-2 mb-3">{{ $post->excerpt }}</p>
                    @endif
                    <p class="text-gray-400 text-xs">{{ $post->published_at?->diffForHumans() }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════ ÉVÉNEMENTS ══════ --}}
@if($events->count())
<section class="py-20" style="background:#f1f5f9">
    <div class="w-full px-6 xl:px-10 2xl:px-16">
        <div class="max-w-screen-2xl mx-auto">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <p class="sec-eyebrow">Agenda</p>
                    <h2 class="sec-title">Prochains événements</h2>
                </div>
                <a href="{{ route('events.index') }}" class="btn btn-navy text-sm py-2.5 px-6 hidden sm:inline-flex">
                    Tout voir →
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($events->take(4) as $event)
                <a href="{{ route('events.show', $event->slug) }}" class="card group">
                    <div class="relative">
                        @if($event->image)
                            <img src="{{ Storage::url($event->image) }}" alt="" class="w-full h-44 object-cover">
                        @else
                            <div class="w-full h-44 flex items-center justify-center text-5xl"
                                 style="background:linear-gradient(135deg,#000032,#1a3c8f)">📅</div>
                        @endif
                        <div class="absolute top-3 left-3 bg-gold text-navy rounded-xl px-3 py-1.5 text-center leading-none shadow-lg">
                            <p class="text-xl font-black">{{ $event->start_date->format('d') }}</p>
                            <p class="text-[10px] font-bold uppercase">{{ $event->start_date->translatedFormat('M') }}</p>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-navy text-base leading-snug group-hover:text-gold transition mb-1">{{ $event->title }}</h3>
                        @if($event->location)
                            <p class="text-gray-400 text-sm">📍 {{ $event->location }}</p>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- ══════ OPPORTUNITÉS ══════ --}}
@if($opportunities->count())
<section class="w-full px-6 xl:px-10 2xl:px-16 py-20">
    <div class="max-w-screen-2xl mx-auto">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="sec-eyebrow">Carrière & Formation</p>
                <h2 class="sec-title">Opportunités</h2>
            </div>
            <a href="{{ route('opportunities.index') }}" class="btn btn-navy text-sm py-2.5 px-6 hidden sm:inline-flex">
                Tout voir →
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-5">
            @foreach($opportunities->take(5) as $opp)
            <a href="{{ route('opportunities.index') }}" class="card group p-6 flex flex-col gap-4">
                <div class="h-14 w-14 rounded-2xl bg-navy/5 flex items-center justify-center text-3xl">
                    {{ $opp->type === 'stage' ? '💼' : ($opp->type === 'bourse' ? '🎓' : ($opp->type === 'emploi' ? '🏢' : '🌟')) }}
                </div>
                <div>
                    <span class="badge bg-navy/8 text-navy mb-2">{{ ucfirst($opp->type) }}</span>
                    <h3 class="font-bold text-navy text-sm leading-snug group-hover:text-gold transition">{{ $opp->title }}</h3>
                    @if($opp->deadline)
                        <p class="text-gray-400 text-xs mt-2">⏰ {{ $opp->deadline->format('d/m/Y') }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════ CTA BANNER ══════ --}}
<section class="relative overflow-hidden py-24 px-6"
         style="background:linear-gradient(135deg,#000032 0%,#1a3c8f 100%)">
    <div class="absolute inset-0" style="background-image:radial-gradient(circle at 1px 1px,rgba(255,255,255,.03) 1px,transparent 0);background-size:40px 40px"></div>
    <div class="relative max-w-screen-2xl mx-auto flex flex-col lg:flex-row items-center justify-between gap-10">
        <div class="flex items-center gap-6">
            <img src="{{ asset('images/logo.jpg') }}" alt=""
                 class="h-24 w-24 rounded-full object-cover ring-4 ring-gold/40 shadow-2xl shrink-0">
            <div>
                <h2 class="text-3xl xl:text-4xl font-black text-white mb-2">
                    Rejoins la famille <span class="text-gold">UFEEL</span>
                </h2>
                <p class="text-white/60 text-lg">Une communauté soudée pour construire l'avenir ensemble.</p>
            </div>
        </div>
        <a href="{{ route('register') }}" class="btn btn-gold text-base shadow-2xl shrink-0">
            ✨ S'inscrire maintenant — c'est gratuit
        </a>
    </div>
</section>

@endsection

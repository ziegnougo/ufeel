@extends('layouts.app')
@section('title', $event->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">

    <nav class="text-xs text-gray-400 mb-6 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-primary">Accueil</a>
        <span>/</span>
        <a href="{{ route('events.index') }}" class="hover:text-primary">Événements</a>
        <span>/</span>
        <span class="text-gray-600 truncate max-w-xs">{{ $event->title }}</span>
    </nav>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        @if($event->cover_image)
            <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-72 object-cover">
        @endif

        <div class="p-8">
            <h1 class="text-3xl font-black text-gray-900 leading-tight">{{ $event->title }}</h1>

            {{-- Infos clés --}}
            <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-gray-50 rounded-xl p-4 text-center">
                    <p class="text-xs text-gray-400 mb-1">Date</p>
                    <p class="font-semibold text-sm text-primary">{{ $event->starts_at->format('d M Y') }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 text-center">
                    <p class="text-xs text-gray-400 mb-1">Heure</p>
                    <p class="font-semibold text-sm text-primary">{{ $event->starts_at->format('H\hi') }}</p>
                </div>
                @if($event->location)
                <div class="bg-gray-50 rounded-xl p-4 text-center">
                    <p class="text-xs text-gray-400 mb-1">Lieu</p>
                    <p class="font-semibold text-sm text-primary">{{ $event->location }}</p>
                </div>
                @endif
                @if($event->max_participants)
                <div class="bg-gray-50 rounded-xl p-4 text-center">
                    <p class="text-xs text-gray-400 mb-1">Places</p>
                    <p class="font-semibold text-sm @if($event->isFull()) text-red-500 @else text-green-600 @endif">
                        @if($event->isFull()) Complet @else {{ $event->max_participants }} places @endif
                    </p>
                </div>
                @endif
            </div>

            @if($event->excerpt)
                <p class="mt-6 text-lg text-gray-600 font-medium border-l-4 border-accent pl-4 leading-relaxed">{{ $event->excerpt }}</p>
            @endif

            @if($event->content)
                <div class="mt-6 prose prose-lg max-w-none text-gray-700 leading-relaxed">
                    {!! $event->content !!}
                </div>
            @endif

            @if($event->isUpcoming() && !$event->isFull())
                <div class="mt-8 text-center">
                    @auth
                        <p class="text-gray-500 text-sm">Contactez-nous pour vous inscrire à cet événement.</p>
                    @else
                        <a href="{{ route('register') }}" class="inline-block bg-accent hover:bg-accent-dark text-white font-bold px-8 py-3 rounded-full transition">
                            Rejoindre l'UFEEL pour participer
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

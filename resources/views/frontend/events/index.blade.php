@extends('layouts.app')
@section('title', 'Événements')
@section('nav_events', 'active')

@section('content')
<div class="bg-primary text-white py-12 px-4 text-center">
    <h1 class="text-3xl font-black">Événements</h1>
    <p class="text-white/70 mt-2">Participez à nos activités et rencontres</p>
</div>

<div class="max-w-7xl mx-auto px-4 py-12">

    <h2 class="text-xl font-bold text-primary mb-6">Prochains événements</h2>

    @if($upcoming->count())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        @foreach($upcoming as $event)
        <a href="{{ route('events.show', $event->slug) }}" class="group bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden flex flex-col">
            @if($event->cover_image)
                <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-44 object-cover group-hover:scale-105 transition duration-300">
            @else
                <div class="w-full h-44 bg-primary flex items-center justify-center">
                    <svg class="w-12 h-12 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
            <div class="p-5 flex-1 flex flex-col">
                <p class="text-xs font-bold text-accent">{{ $event->starts_at->format('d M Y · H\hi') }}</p>
                <h3 class="font-semibold text-gray-800 mt-2 group-hover:text-primary transition leading-snug">{{ $event->title }}</h3>
                @if($event->excerpt)
                    <p class="text-gray-500 text-xs mt-2 line-clamp-2">{{ $event->excerpt }}</p>
                @endif
                <div class="mt-auto pt-3 flex items-center gap-3 text-xs text-gray-400">
                    @if($event->location) <span>📍 {{ $event->location }}</span> @endif
                    @if($event->max_participants)
                        <span>👥 {{ $event->registrations_count ?? 0 }}/{{ $event->max_participants }}</span>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="mb-12">{{ $upcoming->links() }}</div>
    @else
    <div class="text-center py-16 text-gray-400 mb-12">Aucun événement prévu pour le moment.</div>
    @endif

    {{-- Événements passés --}}
    @if($past->count())
    <h2 class="text-xl font-bold text-gray-500 mb-4">Événements passés</h2>
    <div class="grid md:grid-cols-3 gap-4">
        @foreach($past as $event)
        <a href="{{ route('events.show', $event->slug) }}" class="bg-gray-100 rounded-xl p-4 hover:bg-gray-200 transition">
            <p class="text-xs text-gray-500">{{ $event->starts_at->format('d M Y') }}</p>
            <p class="font-medium text-gray-700 mt-1 text-sm">{{ $event->title }}</p>
        </a>
        @endforeach
    </div>
    @endif
</div>
@endsection

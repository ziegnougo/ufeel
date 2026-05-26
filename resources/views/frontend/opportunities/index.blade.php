@extends('layouts.app')
@section('title', 'Opportunités')
@section('nav_opps', 'active')

@section('content')
<div class="bg-primary text-white py-12 px-4 text-center">
    <h1 class="text-3xl font-black">Opportunités</h1>
    <p class="text-white/70 mt-2">Stages, bourses et projets pour les membres UFEEL</p>
</div>

<div class="max-w-7xl mx-auto px-4 py-12">

    {{-- Filtres --}}
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('opportunities.index') }}" class="filter-btn {{ !request('type') ? 'active' : '' }}">Tout</a>
        <a href="{{ route('opportunities.index', ['type' => 'stage']) }}" class="filter-btn {{ request('type') == 'stage' ? 'active' : '' }}">Stages</a>
        <a href="{{ route('opportunities.index', ['type' => 'bourse']) }}" class="filter-btn {{ request('type') == 'bourse' ? 'active' : '' }}">Bourses</a>
        <a href="{{ route('opportunities.index', ['type' => 'projet']) }}" class="filter-btn {{ request('type') == 'projet' ? 'active' : '' }}">Projets</a>
    </div>

    @php $typeColors = ['stage' => 'blue', 'bourse' => 'green', 'projet' => 'yellow']; @endphp

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($opportunities as $opp)
        @php $c = $typeColors[$opp->type] ?? 'gray'; @endphp
        <div class="bg-white rounded-xl shadow-sm border-t-4 border-{{ $c }}-500 p-6 flex flex-col">
            <div class="flex items-start justify-between gap-2">
                <span class="text-xs font-bold text-{{ $c }}-600 uppercase bg-{{ $c }}-50 px-2 py-0.5 rounded">{{ $opp->type }}</span>
                @if($opp->deadline)
                    <span class="text-xs text-red-500 font-medium whitespace-nowrap">{{ $opp->deadline->format('d M Y') }}</span>
                @endif
            </div>
            <h3 class="font-bold text-gray-900 mt-3 leading-snug">{{ $opp->title }}</h3>
            @if($opp->organization)
                <p class="text-gray-500 text-xs mt-1">{{ $opp->organization }}</p>
            @endif
            @if($opp->location)
                <p class="text-gray-400 text-xs mt-1">📍 {{ $opp->location }}</p>
            @endif
            @if($opp->description)
                <p class="text-gray-600 text-sm mt-3 line-clamp-3 flex-1">{{ $opp->description }}</p>
            @endif
            @if($opp->external_url)
                <a href="{{ $opp->external_url }}" target="_blank" rel="noopener"
                    class="mt-4 inline-block text-center bg-primary hover:bg-primary-dark text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                    Postuler →
                </a>
            @endif
        </div>
        @empty
        <div class="col-span-3 text-center py-16 text-gray-400">Aucune opportunité disponible en ce moment.</div>
        @endforelse
    </div>

    <div class="mt-8">{{ $opportunities->links() }}</div>
</div>

<style>
    .filter-btn { @apply px-4 py-1.5 rounded-full border border-gray-200 text-sm text-gray-600 hover:border-primary hover:text-primary transition; }
    .filter-btn.active { @apply bg-primary text-white border-primary; }
</style>
@endsection

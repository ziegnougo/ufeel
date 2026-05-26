@extends('layouts.app')
@section('title', 'Ressources')
@section('nav_resources', 'active')

@section('content')
<div class="bg-primary text-white py-12 px-4 text-center">
    <h1 class="text-3xl font-black">Ressources</h1>
    <p class="text-white/70 mt-2">Documents, cours et outils mis à disposition des membres</p>
</div>

<div class="max-w-7xl mx-auto px-4 py-12">

    @if(!auth()->check())
        <div class="bg-amber-50 border border-amber-200 rounded-xl px-6 py-4 mb-8 flex items-center gap-4">
            <span class="text-amber-500 text-2xl">🔒</span>
            <div>
                <p class="font-semibold text-amber-800 text-sm">Certaines ressources sont réservées aux membres UFEEL</p>
                <p class="text-amber-600 text-xs mt-0.5">
                    <a href="{{ route('login') }}" class="underline">Connectez-vous</a> ou
                    <a href="{{ route('register') }}" class="underline">rejoignez l'UFEEL</a> pour y accéder.
                </p>
            </div>
        </div>
    @endif

    @php
        $categoryLabels = [
            'bibliotheque'  => ['label' => 'Bibliothèque',          'icon' => '📚'],
            'cours'         => ['label' => 'Cours & Formations',     'icon' => '🎓'],
            'sujets'        => ['label' => 'Sujets Examens',         'icon' => '📝'],
            'orientation'   => ['label' => 'Orientation & Conseils', 'icon' => '🧭'],
            'outils'        => ['label' => 'Outils & Modèles',       'icon' => '🛠️'],
        ];
    @endphp

    @forelse($resources as $type => $items)
    @php $meta = $categoryLabels[$type] ?? ['label' => ucfirst($type), 'icon' => '📄']; @endphp
    <div class="mb-10">
        <h2 class="text-lg font-bold text-primary mb-4 flex items-center gap-2">
            <span>{{ $meta['icon'] }}</span> {{ $meta['label'] }}
            <span class="text-xs font-normal text-gray-400">({{ $items->count() }})</span>
        </h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($items as $resource)
            <div class="bg-white rounded-xl shadow-sm p-5 flex gap-4 items-start">
                @if($resource->thumbnail)
                    <img src="{{ asset('storage/' . $resource->thumbnail) }}" class="w-14 h-14 rounded-lg object-cover flex-shrink-0">
                @else
                    <div class="w-14 h-14 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 text-2xl">
                        {{ $meta['icon'] }}
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-gray-800 text-sm leading-snug truncate">{{ $resource->title }}</h3>
                    @if($resource->description)
                        <p class="text-gray-500 text-xs mt-1 line-clamp-2">{{ $resource->description }}</p>
                    @endif
                    @if($resource->getDownloadUrl())
                        <a href="{{ $resource->file_url ? asset('storage/' . $resource->file_url) : $resource->external_url }}"
                            target="_blank" rel="noopener"
                            class="inline-flex items-center gap-1 mt-2 text-xs font-semibold text-primary hover:underline">
                            ↓ Télécharger
                        </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="text-center py-16 text-gray-400">Aucune ressource disponible pour le moment.</div>
    @endforelse
</div>
@endsection

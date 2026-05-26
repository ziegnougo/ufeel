@extends('layouts.app')
@section('title', 'Mon espace')

@section('content')
<div class="bg-primary text-white py-10 px-4">
    <div class="max-w-5xl mx-auto flex items-center gap-4">
        @if($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-white/40">
        @else
            <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-2xl font-black">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif
        <div>
            <h1 class="text-2xl font-black">{{ $user->name }}</h1>
            @if($member)
                <p class="text-white/70 text-sm">{{ $member->member_number }}</p>
            @endif
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-10 space-y-8">

    @if(!$member)
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-yellow-800 text-sm">
            Votre profil membre n'est pas encore créé. Contactez l'administration.
        </div>
    @else

    {{-- Statut / Carte --}}
    <div class="grid md:grid-cols-3 gap-5">

        {{-- Statut --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Statut</p>
            @php
                $statusColors = ['pending' => 'yellow', 'active' => 'green', 'inactive' => 'gray', 'suspended' => 'red'];
                $statusLabels = ['pending' => 'En attente', 'active' => 'Actif', 'inactive' => 'Inactif', 'suspended' => 'Suspendu'];
                $c = $statusColors[$member->status] ?? 'gray';
            @endphp
            <span class="inline-block bg-{{ $c }}-100 text-{{ $c }}-700 font-bold text-sm px-3 py-1 rounded-full">
                {{ $statusLabels[$member->status] ?? $member->status }}
            </span>
            @if($member->status === 'pending')
                <p class="text-xs text-gray-400 mt-3">Votre dossier est en cours d'examen. Vous serez notifié par email.</p>
            @endif
        </div>

        {{-- Cotisation --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Cotisation {{ now()->year }}</p>
            @if($member->hasPaidCurrentYear())
                <span class="inline-block bg-green-100 text-green-700 font-bold text-sm px-3 py-1 rounded-full">✓ À jour</span>
                <p class="text-xs text-gray-400 mt-2">Merci pour votre cotisation !</p>
            @elseif($member->isActive())
                <span class="inline-block bg-red-100 text-red-600 font-bold text-sm px-3 py-1 rounded-full">Non payée</span>
                <form method="POST" action="{{ route('subscription.initiate') }}" class="mt-3">
                    @csrf
                    <button type="submit"
                        class="w-full bg-accent hover:bg-accent-dark text-white text-sm font-bold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Payer 2 000 XOF
                    </button>
                </form>
                <p class="text-xs text-gray-400 mt-2 text-center">Paiement sécurisé via CinetPay</p>
            @else
                <span class="inline-block bg-gray-100 text-gray-400 text-sm px-3 py-1 rounded-full">En attente d'activation</span>
            @endif
        </div>

        {{-- Carte membre --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Carte membre</p>
            @if($member->card && $member->card->isValid())
                <span class="inline-block bg-blue-100 text-blue-700 font-bold text-sm px-3 py-1 rounded-full">Valide</span>
                <p class="text-xs text-gray-400 mt-2">Expire le {{ $member->card->expires_at->format('d M Y') }}</p>
                <a href="{{ route('member.card.pdf', $member) }}" target="_blank"
                    class="mt-3 inline-flex items-center gap-1 text-xs text-primary font-semibold hover:underline">
                    ↓ Télécharger PDF
                </a>
            @elseif($member->status === 'active')
                <span class="inline-block bg-gray-100 text-gray-500 text-sm px-3 py-1 rounded-full">Non générée</span>
                <p class="text-xs text-gray-400 mt-2">Contactez l'administration.</p>
            @else
                <span class="inline-block bg-gray-100 text-gray-400 text-sm px-3 py-1 rounded-full">Indisponible</span>
            @endif
        </div>
    </div>

    {{-- Infos profil --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="font-bold text-gray-700 mb-5">Mon profil</h2>
        <div class="grid md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-gray-400 text-xs">Nom</span>
                <p class="font-medium text-gray-800">{{ $user->name }}</p>
            </div>
            <div>
                <span class="text-gray-400 text-xs">Email</span>
                <p class="font-medium text-gray-800">{{ $user->email }}</p>
            </div>
            @if($user->phone)
            <div>
                <span class="text-gray-400 text-xs">Téléphone</span>
                <p class="font-medium text-gray-800">{{ $user->phone }}</p>
            </div>
            @endif
            @if($member->school_or_university)
            <div>
                <span class="text-gray-400 text-xs">École / Université</span>
                <p class="font-medium text-gray-800">{{ $member->school_or_university }}</p>
            </div>
            @endif
            @if($member->city)
            <div>
                <span class="text-gray-400 text-xs">Ville</span>
                <p class="font-medium text-gray-800">{{ $member->city }}</p>
            </div>
            @endif
            @if($member->level)
            <div>
                <span class="text-gray-400 text-xs">Niveau</span>
                <p class="font-medium text-gray-800">{{ ucfirst($member->level) }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Historique cotisations --}}
    @if($member->subscriptions->count())
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="font-bold text-gray-700 mb-4">Historique des cotisations</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-xs text-gray-400 border-b">
                        <th class="text-left pb-2">Année</th>
                        <th class="text-left pb-2">Montant</th>
                        <th class="text-left pb-2">Statut</th>
                        <th class="text-left pb-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($member->subscriptions as $sub)
                    <tr class="border-b border-gray-50 hover:bg-gray-50">
                        <td class="py-2.5 font-medium">{{ $sub->year }}</td>
                        <td class="py-2.5">{{ number_format($sub->amount) }} {{ $sub->currency }}</td>
                        <td class="py-2.5">
                            <span class="px-2 py-0.5 rounded text-xs font-semibold
                                {{ $sub->isPaid() ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $sub->isPaid() ? 'Payée' : 'En attente' }}
                            </span>
                        </td>
                        <td class="py-2.5 text-gray-400">{{ $sub->paid_at?->format('d M Y') ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @endif {{-- end if member --}}
</div>
@endsection

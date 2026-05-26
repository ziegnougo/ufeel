<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'UFEEL') — Union Fraternelle des Élèves et Étudiants de Lafi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#1B4B8A', light: '#2563EB', dark: '#0F2D5A' },
                        accent:  { DEFAULT: '#F59E0B', dark: '#D97706' },
                    }
                }
            }
        }
    </script>
    @stack('head')
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

{{-- NAV --}}
<nav class="bg-primary shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="text-white font-black text-xl tracking-wide">UFEEL</span>
                <span class="hidden sm:block text-white/60 text-xs font-light leading-tight">Union Fraternelle<br>des Élèves et Étudiants</span>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}" class="nav-link @yield('nav_home')">Accueil</a>
                <a href="{{ route('posts.index') }}" class="nav-link @yield('nav_posts')">Actualités</a>
                <a href="{{ route('events.index') }}" class="nav-link @yield('nav_events')">Événements</a>
                <a href="{{ route('opportunities.index') }}" class="nav-link @yield('nav_opps')">Opportunités</a>
                <a href="{{ route('resources.index') }}" class="nav-link @yield('nav_resources')">Ressources</a>
            </div>

            {{-- Auth --}}
            <div class="hidden md:flex items-center gap-2">
                @guest
                    <a href="{{ route('login') }}" class="text-white/80 hover:text-white text-sm px-3 py-1.5">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-accent hover:bg-accent-dark text-white text-sm font-semibold px-4 py-1.5 rounded-full transition">Rejoindre</a>
                @endguest
                @auth
                    <a href="{{ route('membre.dashboard') }}" class="text-white/80 hover:text-white text-sm px-3 py-1.5">Mon espace</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="text-white/60 hover:text-white text-xs px-2 py-1">Déconnexion</button>
                    </form>
                @endauth
            </div>

            {{-- Mobile burger --}}
            <button id="menu-btn" class="md:hidden text-white p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden md:hidden bg-primary-dark border-t border-white/10">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('home') }}" class="mobile-link">Accueil</a>
            <a href="{{ route('posts.index') }}" class="mobile-link">Actualités</a>
            <a href="{{ route('events.index') }}" class="mobile-link">Événements</a>
            <a href="{{ route('opportunities.index') }}" class="mobile-link">Opportunités</a>
            <a href="{{ route('resources.index') }}" class="mobile-link">Ressources</a>
            @guest
                <hr class="border-white/10 my-2">
                <a href="{{ route('login') }}" class="mobile-link">Connexion</a>
                <a href="{{ route('register') }}" class="mobile-link font-semibold text-accent">Rejoindre UFEEL</a>
            @endguest
            @auth
                <hr class="border-white/10 my-2">
                <a href="{{ route('membre.dashboard') }}" class="mobile-link">Mon espace</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="mobile-link w-full text-left text-white/60">Déconnexion</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

{{-- Flash messages --}}
@if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-6 py-3 text-sm">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-6 py-3 text-sm">
        {{ session('error') }}
    </div>
@endif

{{-- CONTENT --}}
<main class="flex-1">
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="bg-primary-dark text-white/70 mt-16">
    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <p class="text-white font-bold text-lg mb-2">UFEEL</p>
            <p class="text-sm leading-relaxed">Union Fraternelle des Élèves et Étudiants de Lafi. Ensemble, construisons notre avenir.</p>
        </div>
        <div>
            <p class="text-white font-semibold mb-3">Liens rapides</p>
            <ul class="space-y-1 text-sm">
                <li><a href="{{ route('posts.index') }}" class="hover:text-white transition">Actualités</a></li>
                <li><a href="{{ route('events.index') }}" class="hover:text-white transition">Événements</a></li>
                <li><a href="{{ route('opportunities.index') }}" class="hover:text-white transition">Opportunités</a></li>
                <li><a href="{{ route('resources.index') }}" class="hover:text-white transition">Ressources</a></li>
            </ul>
        </div>
        <div>
            <p class="text-white font-semibold mb-3">Contact</p>
            <p class="text-sm">contact@ufeel.ci</p>
            <div class="mt-3 flex gap-3">
                <a href="#" class="hover:text-white transition text-sm">Facebook</a>
                <a href="#" class="hover:text-white transition text-sm">Instagram</a>
                <a href="#" class="hover:text-white transition text-sm">Twitter</a>
            </div>
        </div>
    </div>
    <div class="border-t border-white/10 text-center py-4 text-xs text-white/40">
        © {{ date('Y') }} UFEEL — Tous droits réservés
    </div>
</footer>

<style>
    .nav-link { @apply text-white/80 hover:text-white hover:bg-white/10 px-3 py-2 rounded text-sm font-medium transition; }
    .nav-link.active { @apply text-white bg-white/10; }
    .mobile-link { @apply block text-white/80 hover:text-white px-2 py-2 text-sm; }
</style>
<script>
    document.getElementById('menu-btn').addEventListener('click', () => {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>
@stack('scripts')
</body>
</html>

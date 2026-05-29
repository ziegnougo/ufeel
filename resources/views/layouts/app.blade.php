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
<nav class="sticky top-0 z-50 shadow-md" style="background-color: #F5A800;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center h-14 gap-2">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0 mr-4">
                <img src="{{ asset('images/logo.jpg') }}" alt="UFEEL" class="h-9 w-9 rounded-full object-cover border-2 border-[#000032]">
                <span class="text-[#000032] font-black text-lg tracking-wide">UFEEL</span>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center flex-1 gap-1">
                <a href="{{ route('home') }}" class="nav-link @yield('nav_home')">
                    <span>🏠</span> Accueil
                </a>
                <a href="{{ route('posts.index') }}" class="nav-link @yield('nav_posts')">
                    <span>📰</span> Actualités
                </a>
                <a href="{{ route('events.index') }}" class="nav-link @yield('nav_events')">
                    <span>📅</span> Événements
                </a>
                <a href="{{ route('opportunities.index') }}" class="nav-link @yield('nav_opps')">
                    <span>🎯</span> Opportunités
                </a>
                <a href="{{ route('resources.index') }}" class="nav-link @yield('nav_resources')">
                    <span>📚</span> Ressources
                </a>
                @auth
                    <a href="{{ route('membre.dashboard') }}" class="nav-link @yield('nav_dashboard')">
                        <span>👤</span> Mon espace
                    </a>
                @endauth
            </div>

            {{-- Auth buttons --}}
            <div class="hidden md:flex items-center gap-2 ml-auto shrink-0">
                @guest
                    <a href="{{ route('login') }}" class="text-[#000032] font-semibold text-sm px-3 py-1.5 hover:underline transition">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-[#000032] hover:bg-[#00005a] text-white text-sm font-bold px-5 py-2 rounded-full transition shadow flex items-center gap-1">
                        💬 Rejoindre UFEEL
                    </a>
                @endguest
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="bg-[#000032] hover:bg-[#00005a] text-white text-sm font-semibold px-4 py-1.5 rounded-full transition">
                            Déconnexion
                        </button>
                    </form>
                @endauth
            </div>

            {{-- Mobile burger --}}
            <button id="menu-btn" class="md:hidden text-[#000032] p-2 ml-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden md:hidden border-t border-[#000032]/20" style="background-color: #F5A800;">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('home') }}" class="mobile-link">🏠 Accueil</a>
            <a href="{{ route('posts.index') }}" class="mobile-link">📰 Actualités</a>
            <a href="{{ route('events.index') }}" class="mobile-link">📅 Événements</a>
            <a href="{{ route('opportunities.index') }}" class="mobile-link">🎯 Opportunités</a>
            <a href="{{ route('resources.index') }}" class="mobile-link">📚 Ressources</a>
            @guest
                <hr class="border-[#000032]/20 my-2">
                <a href="{{ route('login') }}" class="mobile-link">Connexion</a>
                <a href="{{ route('register') }}" class="mobile-link font-bold">💬 Rejoindre UFEEL</a>
            @endguest
            @auth
                <a href="{{ route('membre.dashboard') }}" class="mobile-link">👤 Mon espace</a>
                <hr class="border-[#000032]/20 my-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="mobile-link w-full text-left">Déconnexion</button>
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
<footer class="bg-[#000032] text-white/70 mt-16">
    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="UFEEL" class="h-12 w-12 rounded-full object-cover border-2 border-white/20">
                <p class="text-white font-bold text-lg">UFEEL</p>
            </div>
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
    .nav-link {
        display: inline-flex; align-items: center; gap: 5px;
        color: #000032; font-size: 0.875rem; font-weight: 600;
        padding: 6px 12px; border-radius: 6px;
        border-bottom: 3px solid transparent;
        transition: all 0.15s;
        text-decoration: none;
    }
    .nav-link:hover { background: rgba(0,0,50,0.1); border-bottom-color: #000032; }
    .nav-link.active { background: rgba(0,0,50,0.12); border-bottom-color: #000032; font-weight: 700; }
    .mobile-link { display: block; color: #000032; font-size: 0.9rem; font-weight: 600; padding: 8px 8px; border-radius: 6px; }
    .mobile-link:hover { background: rgba(0,0,50,0.1); }
</style>
<script>
    document.getElementById('menu-btn').addEventListener('click', () => {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>
@stack('scripts')
</body>
</html>

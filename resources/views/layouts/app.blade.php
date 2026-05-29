<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'UFEEL') — Union Fraternelle des Élèves et Étudiants de Lafi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter','sans-serif'] },
                    colors: {
                        navy:  { DEFAULT:'#000032', 50:'#e8e8ff', 100:'#c5c5f5', 600:'#000050', 700:'#000040', 800:'#000038', 900:'#000032' },
                        gold:  { DEFAULT:'#F5A800', light:'#ffc740', dark:'#d4900a' },
                    },
                    screens: {
                        'xs': '480px',
                        'sm': '640px',
                        'md': '768px',
                        'lg': '1024px',
                        'xl': '1280px',
                        '2xl': '1536px',
                    }
                }
            }
        }
    </script>
    @stack('head')
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }

        /* ── Navbar ── */
        .nav-link {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; border-radius: 8px;
            font-size: .9rem; font-weight: 600; color: #374151;
            white-space: nowrap; transition: .15s; text-decoration: none;
        }
        .nav-link:hover  { background: #f1f5f9; color: #000032; }
        .nav-link.active { background: #000032; color: #fff; }

        /* ── Cards ── */
        .card {
            background: #fff; border-radius: 16px; overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,50,.06), 0 4px 20px rgba(0,0,50,.06);
            transition: transform .2s, box-shadow .2s;
        }
        .card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,50,.12); }

        /* ── Buttons ── */
        .btn  { display:inline-flex; align-items:center; gap:8px; padding:12px 28px; border-radius:999px; font-weight:700; font-size:.95rem; transition:.2s; text-decoration:none; cursor:pointer; border:none; }
        .btn-navy { background:#000032; color:#fff; }
        .btn-navy:hover { background:#00005a; transform:translateY(-1px); box-shadow:0 6px 20px rgba(0,0,50,.3); }
        .btn-gold  { background:#F5A800; color:#000032; }
        .btn-gold:hover  { background:#d4900a; transform:translateY(-1px); box-shadow:0 6px 20px rgba(245,168,0,.35); }
        .btn-ghost { background:rgba(255,255,255,.12); color:#fff; border:2px solid rgba(255,255,255,.3); }
        .btn-ghost:hover { background:rgba(255,255,255,.2); border-color:#fff; }

        /* ── Section header ── */
        .sec-eyebrow { font-size:.75rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:#F5A800; margin-bottom:6px; }
        .sec-title   { font-size:2rem; font-weight:900; color:#000032; line-height:1.2; }
        @media(min-width:1024px){ .sec-title { font-size:2.4rem; } }

        /* ── Badge ── */
        .badge { display:inline-block; padding:3px 10px; border-radius:999px; font-size:.72rem; font-weight:700; }

        /* ── Mobile nav ── */
        .mob-link { display:flex; align-items:center; gap:8px; padding:11px 12px; border-radius:10px; font-weight:600; color:#1f2937; font-size:.95rem; text-decoration:none; transition:.15s; }
        .mob-link:hover  { background:#f1f5f9; }
        .mob-link.active { background:#000032; color:#fff; }
    </style>
</head>
<body>

{{-- ══════════════════════════ NAVBAR ══════════════════════════ --}}
<header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-gray-200 shadow-sm" style="height:68px;">
    <div class="w-full h-full px-6 xl:px-10 2xl:px-16 flex items-center gap-6">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0 mr-4">
            <img src="{{ asset('images/logo.jpg') }}" alt="UFEEL"
                 class="h-11 w-11 rounded-full object-cover ring-2 ring-gold shadow-sm">
            <div>
                <div class="font-black text-navy text-xl leading-none tracking-wide">UFEEL</div>
                <div class="text-[10px] text-gray-400 font-medium hidden sm:block">Unité · Fraternité · Solidarité</div>
            </div>
        </a>

        {{-- Desktop nav --}}
        <nav class="hidden lg:flex items-center gap-1 flex-1">
            <a href="{{ route('home') }}"                 class="nav-link @yield('nav_home')">🏠 Accueil</a>
            <a href="{{ route('posts.index') }}"          class="nav-link @yield('nav_posts')">📰 Actualités</a>
            <a href="{{ route('events.index') }}"         class="nav-link @yield('nav_events')">📅 Événements</a>
            <a href="{{ route('opportunities.index') }}"  class="nav-link @yield('nav_opps')">🎯 Opportunités</a>
            <a href="{{ route('resources.index') }}"      class="nav-link @yield('nav_resources')">📚 Ressources</a>
        </nav>

        {{-- Auth --}}
        <div class="hidden lg:flex items-center gap-3 ml-auto shrink-0">
            @guest
                <a href="{{ route('login') }}"
                   class="text-gray-600 hover:text-navy font-semibold text-sm px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                    Connexion
                </a>
                <a href="{{ route('register') }}" class="btn btn-navy text-sm py-2.5 px-6">
                    ✨ Rejoindre UFEEL
                </a>
            @endguest
            @auth
                <a href="{{ route('membre.dashboard') }}"
                   class="text-gray-600 hover:text-navy font-semibold text-sm px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                    👤 Mon espace
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="text-gray-400 hover:text-red-500 text-sm px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                        Déconnexion
                    </button>
                </form>
            @endauth
        </div>

        {{-- Burger --}}
        <button id="menu-btn" class="lg:hidden ml-auto p-2 rounded-lg text-navy hover:bg-gray-100 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Mobile dropdown --}}
    <div id="mobile-menu" class="hidden lg:hidden absolute w-full bg-white border-t border-gray-100 shadow-xl px-4 py-3 space-y-1 z-50">
        <a href="{{ route('home') }}"                class="mob-link @yield('nav_home')">🏠 Accueil</a>
        <a href="{{ route('posts.index') }}"          class="mob-link @yield('nav_posts')">📰 Actualités</a>
        <a href="{{ route('events.index') }}"         class="mob-link @yield('nav_events')">📅 Événements</a>
        <a href="{{ route('opportunities.index') }}"  class="mob-link @yield('nav_opps')">🎯 Opportunités</a>
        <a href="{{ route('resources.index') }}"      class="mob-link @yield('nav_resources')">📚 Ressources</a>
        @guest
            <div class="pt-2 border-t border-gray-100 flex gap-2">
                <a href="{{ route('login') }}" class="flex-1 text-center py-2.5 rounded-xl border border-gray-200 text-sm font-semibold">Connexion</a>
                <a href="{{ route('register') }}" class="flex-1 text-center py-2.5 rounded-xl bg-navy text-white text-sm font-bold">Rejoindre</a>
            </div>
        @endguest
        @auth
            <div class="pt-2 border-t border-gray-100">
                <a href="{{ route('membre.dashboard') }}" class="mob-link">👤 Mon espace</a>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button class="mob-link w-full text-left text-red-500">⬅ Déconnexion</button>
                </form>
            </div>
        @endauth
    </div>
</header>

{{-- Flash --}}
@if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-8 py-3 text-sm">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-8 py-3 text-sm">❌ {{ session('error') }}</div>
@endif

<main class="flex-1 min-h-screen">
    @yield('content')
</main>

{{-- ══════════════════════════ FOOTER ══════════════════════════ --}}
<footer class="bg-[#000032] text-white/75 mt-24">
    <div class="w-full px-6 xl:px-10 2xl:px-16 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            {{-- Brand --}}
            <div class="lg:col-span-2">
                <div class="flex items-center gap-4 mb-5">
                    <img src="{{ asset('images/logo.jpg') }}" alt="UFEEL"
                         class="h-16 w-16 rounded-full object-cover ring-2 ring-gold/40">
                    <div>
                        <p class="text-white font-black text-2xl leading-none">UFEEL</p>
                        <p class="text-gold text-xs font-bold tracking-widest mt-1">UNITÉ · FRATERNITÉ · SOLIDARITÉ</p>
                    </div>
                </div>
                <p class="text-sm leading-relaxed text-white/55 max-w-md">
                    L'Union Fraternelle des Élèves et Étudiants de Lafi accompagne chaque jeune dans son parcours scolaire, universitaire et professionnel à Lafi, Côte d'Ivoire.
                </p>
            </div>
            {{-- Navigation --}}
            <div>
                <p class="text-white font-bold text-xs uppercase tracking-widest mb-5">Navigation</p>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('posts.index') }}"         class="hover:text-gold transition">📰 Actualités</a></li>
                    <li><a href="{{ route('events.index') }}"        class="hover:text-gold transition">📅 Événements</a></li>
                    <li><a href="{{ route('opportunities.index') }}" class="hover:text-gold transition">🎯 Opportunités</a></li>
                    <li><a href="{{ route('resources.index') }}"     class="hover:text-gold transition">📚 Ressources</a></li>
                </ul>
            </div>
            {{-- Contact --}}
            <div>
                <p class="text-white font-bold text-xs uppercase tracking-widest mb-5">Contact</p>
                <p class="text-sm mb-2">📧 contact@ufeel.ci</p>
                <p class="text-sm mb-5 text-white/50">📍 Lafi, Côte d'Ivoire</p>
                <div class="flex flex-wrap gap-2">
                    <a href="#" class="bg-white/10 hover:bg-gold hover:text-navy text-xs font-bold px-4 py-2 rounded-full transition">Facebook</a>
                    <a href="#" class="bg-white/10 hover:bg-gold hover:text-navy text-xs font-bold px-4 py-2 rounded-full transition">Instagram</a>
                </div>
            </div>
        </div>
    </div>
    <div class="border-t border-white/10 px-6 py-5 flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-white/30">
        <span>© {{ date('Y') }} UFEEL — Tous droits réservés</span>
        <span>Développé avec ❤️ pour la jeunesse de Lafi</span>
    </div>
</footer>

<script>
    document.getElementById('menu-btn').addEventListener('click',()=>{
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>
@stack('scripts')
</body>
</html>

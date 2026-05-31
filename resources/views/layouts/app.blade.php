<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'UFEEL') — Union Fraternelle des Élèves et Étudiants de Lafi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @stack('head')
    <style>
        /* ============================================================
           RESET & BASE
        ============================================================ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', 'Segoe UI', -apple-system, sans-serif;
            background: #f8fafc;
            color: #1f2937;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        img { display: block; max-width: 100%; }
        a { color: inherit; text-decoration: none; }
        button { font-family: inherit; }

        /* ============================================================
           VARIABLES
        ============================================================ */
        :root {
            --navy:     #000032;
            --navy-mid: #000050;
            --gold:     #F5A800;
            --gold-dk:  #d4900a;
            --bg:       #f8fafc;
            --bg-gray:  #f1f5f9;
            --border:   #e2e8f0;
            --text:     #1f2937;
            --muted:    #64748b;
            --light:    #94a3b8;
        }

        /* ============================================================
           LAYOUT WRAPPER
        ============================================================ */
        .wrap {
            width: 100%;
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 24px;
        }
        @media (min-width: 1280px) { .wrap { padding: 0 56px; } }
        @media (min-width: 1536px) { .wrap { max-width: 1600px; padding: 0 96px; } }

        /* ============================================================
           NAVBAR
        ============================================================ */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            height: 68px;
            background: rgba(255,255,255,.97);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 1px 8px rgba(0,0,50,.07);
        }
        .navbar-row {
            height: 100%;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 24px;
        }
        @media (min-width: 1280px) { .navbar-row { padding: 0 56px; gap: 12px; } }

        /* Brand */
        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            flex-shrink: 0;
            margin-right: 12px;
        }
        .brand-logo {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--gold);
            box-shadow: 0 2px 8px rgba(245,168,0,.2);
        }
        .brand-name {
            font-weight: 900;
            font-size: 1.15rem;
            color: var(--navy);
            letter-spacing: -.01em;
            line-height: 1;
        }
        .brand-sub {
            display: none;
            font-size: .62rem;
            color: var(--light);
            font-weight: 500;
            margin-top: 2px;
        }
        @media (min-width: 640px) { .brand-sub { display: block; } }

        /* Desktop nav */
        .desktop-nav {
            display: none;
            align-items: center;
            gap: 2px;
            flex: 1;
        }
        @media (min-width: 1024px) { .desktop-nav { display: flex; } }

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 13px;
            border-radius: 8px;
            font-size: .875rem;
            font-weight: 600;
            color: #374151;
            text-decoration: none;
            transition: background .15s, color .15s;
            white-space: nowrap;
        }
        .nav-link:hover { background: var(--bg-gray); color: var(--navy); }
        .nav-link.active { background: var(--navy); color: #fff; }

        /* Auth zone */
        .nav-auth {
            display: none;
            align-items: center;
            gap: 8px;
            margin-left: auto;
            flex-shrink: 0;
        }
        @media (min-width: 1024px) { .nav-auth { display: flex; } }

        .link-plain {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: .875rem;
            font-weight: 600;
            color: #4b5563;
            text-decoration: none;
            background: none;
            border: none;
            cursor: pointer;
            transition: background .15s, color .15s;
            font-family: inherit;
        }
        .link-plain:hover { background: var(--bg-gray); color: var(--navy); }

        /* Burger */
        .burger {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
            padding: 8px;
            background: none;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            color: var(--navy);
        }
        .burger:hover { background: var(--bg-gray); }
        @media (min-width: 1024px) { .burger { display: none; } }

        /* Mobile menu */
        .mobile-menu {
            display: none;
            position: absolute;
            top: 68px;
            left: 0;
            right: 0;
            background: #fff;
            border-top: 1px solid var(--bg-gray);
            box-shadow: 0 8px 32px rgba(0,0,50,.12);
            padding: 12px 16px 16px;
            z-index: 99;
        }
        .mobile-menu.open { display: block; }

        .mob-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 10px;
            font-weight: 600;
            color: #1f2937;
            font-size: .9rem;
            text-decoration: none;
            transition: background .15s;
            background: none;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: left;
            font-family: inherit;
        }
        .mob-link:hover { background: var(--bg-gray); }
        .mob-link.active { background: var(--navy); color: #fff; }

        .mob-auth {
            display: flex;
            gap: 8px;
            padding-top: 12px;
            margin-top: 8px;
            border-top: 1px solid var(--bg-gray);
        }
        .mob-auth-btn {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-radius: 10px;
            font-weight: 700;
            font-size: .875rem;
            text-decoration: none;
            display: block;
        }
        .mob-auth-login  { border: 1px solid var(--border); color: #374151; }
        .mob-auth-join   { background: var(--navy); color: #fff; }

        /* ============================================================
           BUTTONS
        ============================================================ */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 999px;
            font-weight: 700;
            font-size: .9rem;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: transform .15s, box-shadow .15s, background .15s;
            white-space: nowrap;
            font-family: inherit;
            line-height: 1.4;
        }
        .btn:hover { transform: translateY(-1px); }
        .btn-sm  { padding: 7px 18px; font-size: .8rem; }
        .btn-lg  { padding: 14px 32px; font-size: 1rem; }

        .btn-navy { background: var(--navy); color: #fff; }
        .btn-navy:hover  { background: #00005a; box-shadow: 0 6px 20px rgba(0,0,50,.3); }

        .btn-gold { background: var(--gold); color: var(--navy); }
        .btn-gold:hover  { background: var(--gold-dk); box-shadow: 0 6px 20px rgba(245,168,0,.35); }

        .btn-ghost {
            background: rgba(255,255,255,.12);
            color: #fff;
            border: 2px solid rgba(255,255,255,.3);
        }
        .btn-ghost:hover { background: rgba(255,255,255,.22); border-color: #fff; }

        /* ============================================================
           CARDS
        ============================================================ */
        .card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,50,.06), 0 4px 16px rgba(0,0,50,.06);
            transition: transform .2s, box-shadow .2s;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
        }
        .card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,50,.13); }

        .card-img { width: 100%; height: 192px; object-fit: cover; display: block; }
        .card-img-ph {
            width: 100%; height: 192px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.8rem;
            background: linear-gradient(135deg, #000032, #1a3c8f);
        }
        .card-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }

        /* ============================================================
           BADGE
        ============================================================ */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: .7rem;
            font-weight: 700;
        }
        .badge-gold  { background: rgba(245,168,0,.12); color: #92680a; }
        .badge-navy  { background: rgba(0,0,50,.08); color: var(--navy); }

        /* ============================================================
           SECTION LABELS
        ============================================================ */
        .sec-eyebrow {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 6px;
        }
        .sec-title {
            font-size: 1.85rem;
            font-weight: 900;
            color: var(--navy);
            line-height: 1.2;
        }
        @media (min-width: 1024px) { .sec-title { font-size: 2.25rem; } }

        .sec-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 36px;
            flex-wrap: wrap;
        }

        /* ============================================================
           GRIDS
        ============================================================ */
        .grid-4 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }
        @media (min-width: 640px)  { .grid-4 { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .grid-4 { grid-template-columns: repeat(3, 1fr); } }
        @media (min-width: 1280px) { .grid-4 { grid-template-columns: repeat(4, 1fr); } }

        .grid-5 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }
        @media (min-width: 640px)  { .grid-5 { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .grid-5 { grid-template-columns: repeat(3, 1fr); } }
        @media (min-width: 1280px) { .grid-5 { grid-template-columns: repeat(4, 1fr); } }
        @media (min-width: 1536px) { .grid-5 { grid-template-columns: repeat(5, 1fr); } }

        /* ============================================================
           FLASH MESSAGES
        ============================================================ */
        .flash-ok  { background:#ecfdf5; border-left:4px solid #10b981; color:#065f46; padding:12px 32px; font-size:.875rem; }
        .flash-err { background:#fef2f2; border-left:4px solid #ef4444; color:#991b1b; padding:12px 32px; font-size:.875rem; }

        /* ============================================================
           FOOTER
        ============================================================ */
        .footer {
            background: var(--navy);
            color: rgba(255,255,255,.65);
            margin-top: 80px;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 40px;
            padding: 64px 24px;
        }
        @media (min-width: 768px)  { .footer-grid { grid-template-columns: 1fr 1fr; padding: 64px 40px; } }
        @media (min-width: 1024px) { .footer-grid { grid-template-columns: 2fr 1fr 1fr; padding: 64px 56px; } }
        @media (min-width: 1280px) { .footer-grid { padding: 64px 96px; } }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,.08);
            padding: 18px 24px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            font-size: .72rem;
            color: rgba(255,255,255,.28);
        }
        @media (min-width: 640px)  { .footer-bottom { flex-direction: row; justify-content: space-between; align-items: center; } }
        @media (min-width: 1280px) { .footer-bottom { padding: 18px 96px; } }

        .footer-link { color: rgba(255,255,255,.65); text-decoration: none; transition: color .15s; display: block; margin-bottom: 12px; font-size: .875rem; }
        .footer-link:hover { color: var(--gold); }

        .footer-logo { width: 56px; height: 56px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(245,168,0,.35); }

        .social-btn {
            display: inline-flex;
            padding: 6px 16px;
            border-radius: 999px;
            background: rgba(255,255,255,.1);
            font-size: .75rem;
            font-weight: 700;
            color: rgba(255,255,255,.8);
            text-decoration: none;
            transition: background .15s, color .15s;
        }
        .social-btn:hover { background: var(--gold); color: var(--navy); }
    </style>
</head>
<body>

{{-- ══════════════════════════ NAVBAR ══════════════════════════ --}}
<header class="navbar">
    <div class="navbar-row">

        {{-- Brand --}}
        <a href="{{ route('home') }}" class="brand">
            <img src="{{ asset('images/logo.jpg') }}" alt="UFEEL" class="brand-logo">
            <div>
                <div class="brand-name">UFEEL</div>
                <div class="brand-sub">Unité · Fraternité · Solidarité</div>
            </div>
        </a>

        {{-- Desktop nav --}}
        <nav class="desktop-nav">
            <a href="{{ route('home') }}"                class="nav-link @yield('nav_home')">🏠 Accueil</a>
            <a href="{{ route('posts.index') }}"         class="nav-link @yield('nav_posts')">📰 Actualités</a>
            <a href="{{ route('events.index') }}"        class="nav-link @yield('nav_events')">📅 Événements</a>
            <a href="{{ route('opportunities.index') }}" class="nav-link @yield('nav_opps')">🎯 Opportunités</a>
            <a href="{{ route('resources.index') }}"     class="nav-link @yield('nav_resources')">📚 Ressources</a>
        </nav>

        {{-- Auth --}}
        <div class="nav-auth">
            @guest
                <a href="{{ route('login') }}" class="link-plain">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-navy btn-sm">✨ Rejoindre</a>
            @endguest
            @auth
                <a href="{{ route('membre.dashboard') }}" class="link-plain">👤 Mon espace</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button class="link-plain" style="color:#ef4444;">Déconnexion</button>
                </form>
            @endauth
        </div>

        {{-- Burger --}}
        <button class="burger" id="menu-btn" aria-label="Menu">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Mobile menu --}}
    <div class="mobile-menu" id="mobile-menu">
        <a href="{{ route('home') }}"                class="mob-link @yield('nav_home')">🏠 Accueil</a>
        <a href="{{ route('posts.index') }}"         class="mob-link @yield('nav_posts')">📰 Actualités</a>
        <a href="{{ route('events.index') }}"        class="mob-link @yield('nav_events')">📅 Événements</a>
        <a href="{{ route('opportunities.index') }}" class="mob-link @yield('nav_opps')">🎯 Opportunités</a>
        <a href="{{ route('resources.index') }}"     class="mob-link @yield('nav_resources')">📚 Ressources</a>
        @guest
            <div class="mob-auth">
                <a href="{{ route('login') }}"    class="mob-auth-btn mob-auth-login">Connexion</a>
                <a href="{{ route('register') }}" class="mob-auth-btn mob-auth-join">Rejoindre</a>
            </div>
        @endguest
        @auth
            <div style="padding-top:12px;margin-top:8px;border-top:1px solid #f1f5f9;">
                <a href="{{ route('membre.dashboard') }}" class="mob-link">👤 Mon espace</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="mob-link" style="color:#ef4444;">⬅ Déconnexion</button>
                </form>
            </div>
        @endauth
    </div>
</header>

{{-- Flash --}}
@if(session('success'))
    <div class="flash-ok">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="flash-err">❌ {{ session('error') }}</div>
@endif

<main>
    @yield('content')
</main>

{{-- ══════════════════════════ FOOTER ══════════════════════════ --}}
<footer class="footer">
    <div class="footer-grid">
        {{-- Brand --}}
        <div>
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px;">
                <img src="{{ asset('images/logo.jpg') }}" alt="UFEEL" class="footer-logo">
                <div>
                    <p style="color:#fff;font-weight:900;font-size:1.4rem;line-height:1;">UFEEL</p>
                    <p style="color:var(--gold);font-size:.65rem;font-weight:700;letter-spacing:.1em;margin-top:4px;">UNITÉ · FRATERNITÉ · SOLIDARITÉ</p>
                </div>
            </div>
            <p style="font-size:.875rem;line-height:1.75;color:rgba(255,255,255,.45);max-width:340px;">
                L'Union Fraternelle des Élèves et Étudiants de Lafi accompagne chaque jeune dans son parcours scolaire, universitaire et professionnel à Lafi, Côte d'Ivoire.
            </p>
        </div>

        {{-- Navigation --}}
        <div>
            <p style="color:#fff;font-weight:700;font-size:.68rem;text-transform:uppercase;letter-spacing:.1em;margin-bottom:20px;">Navigation</p>
            <a href="{{ route('posts.index') }}"         class="footer-link">📰 Actualités</a>
            <a href="{{ route('events.index') }}"        class="footer-link">📅 Événements</a>
            <a href="{{ route('opportunities.index') }}" class="footer-link">🎯 Opportunités</a>
            <a href="{{ route('resources.index') }}"     class="footer-link">📚 Ressources</a>
        </div>

        {{-- Contact --}}
        <div>
            <p style="color:#fff;font-weight:700;font-size:.68rem;text-transform:uppercase;letter-spacing:.1em;margin-bottom:20px;">Contact</p>
            <p style="font-size:.875rem;margin-bottom:8px;">📧 contact@ufeel.ci</p>
            <p style="font-size:.875rem;margin-bottom:20px;color:rgba(255,255,255,.35);">📍 Lafi, Côte d'Ivoire</p>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <a href="#" class="social-btn">Facebook</a>
                <a href="#" class="social-btn">Instagram</a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <span>© {{ date('Y') }} UFEEL — Tous droits réservés</span>
        <span>Développé avec ❤️ pour la jeunesse de Lafi</span>
    </div>
</footer>

<script>
    document.getElementById('menu-btn').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('open');
    });
</script>
@stack('scripts')
</body>
</html>

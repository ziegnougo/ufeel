@extends('layouts.app')
@section('title', 'Accueil')
@section('nav_home', 'active')

@push('head')
<style>
    /* ── Hero ── */
    .hero {
        background: linear-gradient(135deg, #000032 0%, #000050 50%, #1a3c8f 100%);
        min-height: 90vh;
        display: flex;
        align-items: center;
        overflow: hidden;
        position: relative;
        padding: 80px 24px;
    }
    @media (min-width: 1280px) { .hero { padding: 80px 56px; } }
    @media (min-width: 1536px) { .hero { padding: 80px 96px; } }

    .hero-dots {
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,.04) 1px, transparent 0);
        background-size: 40px 40px;
        pointer-events: none;
    }
    .hero-glow {
        position: absolute;
        top: -120px;
        right: -120px;
        width: 560px;
        height: 560px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(245,168,0,.18), transparent 65%);
        pointer-events: none;
    }

    .hero-inner {
        position: relative;
        width: 100%;
        max-width: 1440px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr;
        gap: 56px;
        align-items: center;
    }
    @media (min-width: 1024px) {
        .hero-inner { grid-template-columns: 1.1fr 0.9fr; }
    }
    @media (min-width: 1536px) {
        .hero-inner { max-width: 1600px; }
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(245,168,0,.15);
        color: #F5A800;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 999px;
        border: 1px solid rgba(245,168,0,.25);
        margin-bottom: 28px;
    }

    .hero-title {
        color: #ffffff;
        font-size: clamp(2.4rem, 4.5vw, 5rem);
        font-weight: 900;
        line-height: 1.06;
        margin-bottom: 22px;
        letter-spacing: -.02em;
    }
    .hero-title-gold { color: #F5A800; }

    .hero-desc {
        color: rgba(255,255,255,.62);
        font-size: 1.1rem;
        line-height: 1.75;
        max-width: 500px;
        margin-bottom: 36px;
    }

    .hero-btns {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 52px;
    }

    .hero-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 36px;
        padding-top: 32px;
        border-top: 1px solid rgba(255,255,255,.1);
    }
    .hero-stat-val {
        font-size: 2.2rem;
        font-weight: 900;
        color: #F5A800;
        line-height: 1;
    }
    .hero-stat-lbl {
        font-size: .78rem;
        color: rgba(255,255,255,.45);
        margin-top: 4px;
    }

    /* Logo côté droit */
    .hero-right {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    @media (min-width: 1024px) { .hero-right { justify-content: flex-end; } }

    .hero-logo-wrap {
        position: relative;
        display: inline-block;
    }
    .hero-logo-wrap::before {
        content: '';
        position: absolute;
        inset: -30px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(245,168,0,.22), transparent 65%);
        filter: blur(28px);
        pointer-events: none;
    }
    .hero-logo {
        position: relative;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow:
            0 0 0 4px rgba(245,168,0,.35),
            0 0 0 14px rgba(245,168,0,.08),
            0 32px 64px rgba(0,0,50,.55);
    }
    @media (min-width: 1280px) { .hero-logo { width: 340px; height: 340px; } }
    @media (min-width: 1536px) { .hero-logo { width: 400px; height: 400px; } }

    /* ── Sections ── */
    .section-white { padding: 80px 24px; background: #fff; }
    .section-gray  { padding: 80px 24px; background: #f1f5f9; }
    @media (min-width: 1280px) { .section-white, .section-gray { padding: 80px 56px; } }
    @media (min-width: 1536px) { .section-white, .section-gray { padding: 80px 96px; } }

    .section-inner {
        max-width: 1440px;
        margin: 0 auto;
    }
    @media (min-width: 1536px) { .section-inner { max-width: 1600px; } }

    /* ── Event date badge ── */
    .ev-date-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #F5A800;
        color: #000032;
        border-radius: 10px;
        padding: 6px 10px;
        line-height: 1;
        text-align: center;
        box-shadow: 0 4px 12px rgba(245,168,0,.35);
        z-index: 1;
    }
    .ev-date-d { font-size: 1.15rem; font-weight: 900; }
    .ev-date-m { font-size: .5rem; font-weight: 700; text-transform: uppercase; margin-top: 2px; }

    /* ── Opportunity card ── */
    .opp-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 1px 4px rgba(0,0,50,.06), 0 4px 16px rgba(0,0,50,.06);
        transition: transform .2s, box-shadow .2s;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .opp-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,50,.13); }

    .opp-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: rgba(0,0,50,.05);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
    }

    /* ── CTA Banner ── */
    .cta-section {
        background: linear-gradient(135deg, #000032 0%, #1a3c8f 100%);
        padding: 80px 24px;
        position: relative;
        overflow: hidden;
    }
    @media (min-width: 1280px) { .cta-section { padding: 80px 56px; } }
    @media (min-width: 1536px) { .cta-section { padding: 80px 96px; } }

    .cta-dots {
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,.03) 1px, transparent 0);
        background-size: 40px 40px;
        pointer-events: none;
    }
    .cta-inner {
        position: relative;
        max-width: 1440px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 32px;
        text-align: center;
    }
    @media (min-width: 1024px) {
        .cta-inner { flex-direction: row; justify-content: space-between; text-align: left; gap: 48px; }
    }
    .cta-logo {
        width: 76px;
        height: 76px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(245,168,0,.4);
        box-shadow: 0 8px 32px rgba(0,0,50,.45);
        flex-shrink: 0;
    }
    .cta-title {
        font-size: clamp(1.6rem, 2.5vw, 2.4rem);
        font-weight: 900;
        color: #fff;
        line-height: 1.2;
        margin-bottom: 8px;
    }
    .cta-title span { color: #F5A800; }
    .cta-sub { color: rgba(255,255,255,.58); font-size: 1rem; }
</style>
@endpush

@section('content')

{{-- ══════ HERO ══════ --}}
<section class="hero">
    <div class="hero-dots"></div>
    <div class="hero-glow"></div>

    <div class="hero-inner">

        {{-- Texte gauche --}}
        <div>
            <div class="hero-badge">✦ Plateforme officielle UFEEL</div>

            <h1 class="hero-title">
                Unis pour<br>
                <span class="hero-title-gold">construire</span><br>
                notre avenir
            </h1>

            <p class="hero-desc">
                L'Union Fraternelle des Élèves et Étudiants de Lafi — ta communauté pour réussir ensemble en Côte d'Ivoire.
            </p>

            <div class="hero-btns">
                <a href="{{ route('register') }}" class="btn btn-gold btn-lg">✨ Rejoindre l'UFEEL</a>
                <a href="{{ route('events.index') }}" class="btn btn-ghost btn-lg">📅 Voir les événements</a>
            </div>

            @if($stats->count())
            <div class="hero-stats">
                @foreach($stats as $stat)
                <div>
                    <p class="hero-stat-val">{{ number_format($stat->value) }}+</p>
                    <p class="hero-stat-lbl">{{ $stat->label }}</p>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Logo droit --}}
        <div class="hero-right">
            <div class="hero-logo-wrap">
                <img src="{{ asset('images/logo.jpg') }}" alt="UFEEL" class="hero-logo">
            </div>
        </div>

    </div>
</section>

{{-- ══════ ACTUALITÉS ══════ --}}
@if($posts->count())
<section class="section-white">
    <div class="section-inner">
        <div class="sec-header">
            <div>
                <p class="sec-eyebrow">Blog & Actualités</p>
                <h2 class="sec-title">Dernières nouvelles</h2>
            </div>
            <a href="{{ route('posts.index') }}" class="btn btn-navy btn-sm">Tout voir →</a>
        </div>
        <div class="grid-4">
            @foreach($posts->take(4) as $post)
            <a href="{{ route('posts.show', $post->slug) }}" class="card">
                @if($post->cover_image)
                    <img src="{{ Storage::url($post->cover_image) }}" alt="" class="card-img">
                @else
                    <div class="card-img-ph">📰</div>
                @endif
                <div class="card-body">
                    <span class="badge badge-gold" style="margin-bottom:10px;">{{ ucfirst($post->category ?? 'Actualité') }}</span>
                    <h3 style="font-weight:700;color:#000032;font-size:.93rem;line-height:1.45;flex:1;margin-bottom:8px;">{{ $post->title }}</h3>
                    @if($post->excerpt)
                        <p style="color:#64748b;font-size:.8rem;margin-bottom:8px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $post->excerpt }}</p>
                    @endif
                    <p style="color:#94a3b8;font-size:.75rem;">{{ $post->published_at?->diffForHumans() }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════ ÉVÉNEMENTS ══════ --}}
@if($events->count())
<section class="section-gray">
    <div class="section-inner">
        <div class="sec-header">
            <div>
                <p class="sec-eyebrow">Agenda</p>
                <h2 class="sec-title">Prochains événements</h2>
            </div>
            <a href="{{ route('events.index') }}" class="btn btn-navy btn-sm">Tout voir →</a>
        </div>
        <div class="grid-4">
            @foreach($events->take(4) as $event)
            <a href="{{ route('events.show', $event->slug) }}" class="card">
                <div style="position:relative;">
                    @if($event->cover_image)
                        <img src="{{ Storage::url($event->cover_image) }}" alt="" style="width:100%;height:176px;object-fit:cover;display:block;">
                    @else
                        <div style="width:100%;height:176px;display:flex;align-items:center;justify-content:center;font-size:2.5rem;background:linear-gradient(135deg,#000032,#1a3c8f);">📅</div>
                    @endif
                    <div class="ev-date-badge">
                        <div class="ev-date-d">{{ $event->starts_at->format('d') }}</div>
                        <div class="ev-date-m">{{ $event->starts_at->translatedFormat('M') }}</div>
                    </div>
                </div>
                <div class="card-body">
                    <h3 style="font-weight:700;color:#000032;font-size:.93rem;line-height:1.45;margin-bottom:4px;">{{ $event->title }}</h3>
                    @if($event->location)
                        <p style="color:#94a3b8;font-size:.8rem;">📍 {{ $event->location }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════ OPPORTUNITÉS ══════ --}}
@if($opportunities->count())
<section class="section-white">
    <div class="section-inner">
        <div class="sec-header">
            <div>
                <p class="sec-eyebrow">Carrière & Formation</p>
                <h2 class="sec-title">Opportunités</h2>
            </div>
            <a href="{{ route('opportunities.index') }}" class="btn btn-navy btn-sm">Tout voir →</a>
        </div>
        <div class="grid-5">
            @foreach($opportunities->take(5) as $opp)
            <a href="{{ route('opportunities.index') }}" class="opp-card">
                <div class="opp-icon">
                    {{ $opp->type === 'stage' ? '💼' : ($opp->type === 'bourse' ? '🎓' : ($opp->type === 'emploi' ? '🏢' : '🌟')) }}
                </div>
                <div>
                    <span class="badge badge-navy" style="margin-bottom:8px;">{{ ucfirst($opp->type) }}</span>
                    <h3 style="font-weight:700;color:#000032;font-size:.875rem;line-height:1.45;">{{ $opp->title }}</h3>
                    @if($opp->deadline)
                        <p style="color:#94a3b8;font-size:.75rem;margin-top:8px;">⏰ {{ $opp->deadline->format('d/m/Y') }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════ CTA BANNER ══════ --}}
<section class="cta-section">
    <div class="cta-dots"></div>
    <div class="cta-inner">
        <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;justify-content:center;">
            <img src="{{ asset('images/logo.jpg') }}" alt="" class="cta-logo">
            <div>
                <h2 class="cta-title">Rejoins la famille <span>UFEEL</span></h2>
                <p class="cta-sub">Une communauté soudée pour construire l'avenir ensemble.</p>
            </div>
        </div>
        <a href="{{ route('register') }}" class="btn btn-gold btn-lg" style="flex-shrink:0;">
            ✨ S'inscrire — c'est gratuit
        </a>
    </div>
</section>

@endsection

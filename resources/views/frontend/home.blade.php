@extends('layouts.app')
@section('title', 'Accueil')
@section('nav_home', 'active')

@push('head')
<style>
    /* ══════════════════════════════════════════════
       MODERNE INSTITUTIONNEL — Page d'accueil
       Palette : navy #04043C / or #F5A800 / blanc
    ══════════════════════════════════════════════ */
    :root {
        --ink:       #04043C;
        --ink-soft:  #10125A;
        --gold:      #F5A800;
        --paper:     #ffffff;
        --mist:      #f6f7fb;
        --line:      #e6e8f0;
    }

    /* ── Conteneur sections ── */
    .sect { padding: 88px 24px; }
    .sect--mist { background: var(--mist); }
    .sect-in { max-width: 1180px; margin: 0 auto; }
    @media (min-width: 768px) { .sect { padding: 96px 40px; } }

    /* ── HERO ── */
    .hero {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(1100px 520px at 82% -10%, rgba(52,72,190,.45), transparent 60%),
            radial-gradient(900px 480px at -8% 110%, rgba(9,12,84,.9), transparent 55%),
            linear-gradient(150deg, #030335 0%, #04043C 55%, #0A1160 100%);
        padding: 72px 24px 88px;
    }
    @media (min-width: 768px) { .hero { padding: 88px 40px 104px; } }
    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,.035) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.035) 1px, transparent 1px);
        background-size: 56px 56px;
        mask-image: radial-gradient(720px 480px at 30% 20%, #000 30%, transparent 75%);
        pointer-events: none;
    }
    .hero-in {
        position: relative;
        max-width: 1180px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr;
        gap: 56px;
        align-items: center;
    }
    @media (min-width: 1024px) { .hero-in { grid-template-columns: 1.15fr .85fr; gap: 72px; } }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: var(--gold);
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .16em;
        text-transform: uppercase;
        margin-bottom: 24px;
    }
    .hero-eyebrow::before {
        content: '';
        width: 34px;
        height: 2px;
        background: var(--gold);
    }

    .hero-title {
        color: #fff;
        font-size: clamp(2.3rem, 4.6vw, 4rem);
        font-weight: 800;
        line-height: 1.08;
        letter-spacing: -.025em;
        margin-bottom: 20px;
    }
    .hero-title em {
        font-style: normal;
        color: var(--gold);
    }

    .hero-desc {
        color: rgba(255,255,255,.66);
        font-size: 1.05rem;
        line-height: 1.8;
        max-width: 480px;
        margin-bottom: 36px;
    }

    .hero-cta { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 56px; }
    .btn-solid {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--gold); color: var(--ink);
        font-weight: 700; font-size: .95rem;
        padding: 15px 30px; border-radius: 10px;
        box-shadow: 0 10px 30px rgba(245,168,0,.28);
        transition: transform .15s, box-shadow .15s;
    }
    .btn-solid:hover { transform: translateY(-2px); box-shadow: 0 14px 36px rgba(245,168,0,.4); }
    .btn-line {
        display: inline-flex; align-items: center; gap: 8px;
        color: #fff; font-weight: 600; font-size: .95rem;
        padding: 15px 30px; border-radius: 10px;
        border: 1px solid rgba(255,255,255,.28);
        transition: border-color .15s, background .15s;
    }
    .btn-line:hover { border-color: rgba(255,255,255,.6); background: rgba(255,255,255,.06); }

    .hero-stats {
        display: flex;
        flex-wrap: wrap;
        border-top: 1px solid rgba(255,255,255,.12);
        padding-top: 30px;
        gap: 0 48px;
    }
    .stat-num {
        font-size: 1.9rem; font-weight: 800; color: var(--gold);
        line-height: 1; letter-spacing: -.02em;
    }
    .stat-lbl {
        font-size: .74rem; font-weight: 500;
        color: rgba(255,255,255,.5); margin-top: 7px;
    }

    /* Logo sur pastille claire */
    .hero-visual { display: flex; justify-content: center; }
    .hero-plate {
        position: relative;
        width: min(340px, 78vw);
        aspect-ratio: 1;
        background: #fff;
        border-radius: 32px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 40px 80px rgba(0,0,20,.45), 0 0 0 1px rgba(255,255,255,.14);
        transform: rotate(-1.2deg);
    }
    .hero-plate::after {
        content: '';
        position: absolute;
        inset: 14px;
        border: 1.5px solid var(--line);
        border-radius: 22px;
        pointer-events: none;
    }
    .hero-plate img {
        width: 62%;
        height: 62%;
        object-fit: contain;
        border-radius: 50%;
    }
    .hero-plate-tag {
        position: absolute;
        bottom: -18px;
        left: 50%;
        transform: translateX(-50%) rotate(1.2deg);
        background: var(--ink);
        color: #fff;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        padding: 9px 20px;
        border-radius: 999px;
        border: 1px solid rgba(245,168,0,.5);
        box-shadow: 0 12px 28px rgba(0,0,20,.4);
        white-space: nowrap;
    }

    /* ── En-têtes de section ── */
    .head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 44px;
    }
    .eyebrow {
        display: inline-flex; align-items: center; gap: 10px;
        color: var(--gold);
        font-size: .72rem; font-weight: 700;
        letter-spacing: .16em; text-transform: uppercase;
        margin-bottom: 10px;
    }
    .eyebrow::before { content: ''; width: 26px; height: 2px; background: var(--gold); }
    .head h2 {
        font-size: clamp(1.6rem, 2.6vw, 2.15rem);
        font-weight: 800;
        color: var(--ink);
        letter-spacing: -.02em;
        line-height: 1.15;
    }
    .more-link {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: .85rem; font-weight: 700; color: var(--ink);
        padding: 10px 20px;
        border: 1.5px solid var(--line);
        border-radius: 999px;
        background: #fff;
        transition: border-color .15s, background .15s;
        white-space: nowrap;
    }
    .more-link:hover { border-color: var(--gold); background: rgba(245,168,0,.07); }
    .sect--mist .more-link { background: transparent; }
    .sect--mist .more-link:hover { background: #fff; }

    /* ── Cartes génériques ── */
    .grid { display: grid; grid-template-columns: 1fr; gap: 22px; }
    @media (min-width: 640px)  { .grid { grid-template-columns: repeat(2, 1fr); } }
    @media (min-width: 1024px) { .grid-3 { grid-template-columns: repeat(3, 1fr); }
                                 .grid-4 { grid-template-columns: repeat(4, 1fr); } }

    .tile {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 16px;
        overflow: hidden;
        display: flex; flex-direction: column;
        transition: transform .2s, box-shadow .2s, border-color .2s;
    }
    .tile:hover {
        transform: translateY(-4px);
        border-color: transparent;
        box-shadow: 0 18px 44px rgba(4,4,60,.12);
    }

    .tile-img { position: relative; }
    .tile-img img { width: 100%; height: 176px; object-fit: cover; }
    .tile-img-ph {
        width: 100%; height: 176px;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.6rem;
        background: linear-gradient(145deg, #04043C 0%, #131A66 100%);
        position: relative;
    }
    .tile-img-ph::before {
        content: '';
        position: absolute; inset: 0;
        background: radial-gradient(300px 180px at 80% 0%, rgba(245,168,0,.14), transparent 65%);
    }
    .tile-body { padding: 20px 22px; flex: 1; display: flex; flex-direction: column; }

    .chip {
        align-self: flex-start;
        font-size: .66rem; font-weight: 700;
        letter-spacing: .08em; text-transform: uppercase;
        padding: 4px 12px; border-radius: 999px;
        background: rgba(245,168,0,.12); color: #9A6B00;
        margin-bottom: 12px;
    }
    .chip--navy { background: rgba(4,4,60,.07); color: var(--ink); }
    .tile h3 {
        font-size: .95rem; font-weight: 700; color: var(--ink);
        line-height: 1.45; margin-bottom: 6px;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .tile .excerpt {
        color: #6b7280; font-size: .8rem; line-height: 1.6; margin-bottom: 12px;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .tile .meta {
        margin-top: auto;
        color: #9aa1b2; font-size: .74rem; font-weight: 500;
        display: flex; align-items: center; gap: 6px;
    }

    /* Pastille date événement */
    .date-tag {
        position: absolute; top: 14px; left: 14px;
        background: var(--gold); color: var(--ink);
        border-radius: 12px; padding: 8px 12px;
        text-align: center; line-height: 1;
        box-shadow: 0 8px 20px rgba(245,168,0,.4);
    }
    .date-tag b   { display: block; font-size: 1.15rem; font-weight: 800; }
    .date-tag span{ display: block; font-size: .56rem; font-weight: 700; text-transform: uppercase; margin-top: 3px; letter-spacing: .08em; }

    /* ── Partenaires ── */
    .partners-band {
        border-top: 1px solid var(--line);
        padding: 56px 24px;
        background: #fff;
    }
    .partners-in { max-width: 1180px; margin: 0 auto; }
    .partners-lbl {
        text-align: center;
        font-size: .7rem; font-weight: 700;
        letter-spacing: .18em; text-transform: uppercase;
        color: #9aa1b2;
        margin-bottom: 30px;
    }
    .partners-row {
        display: flex; flex-wrap: wrap;
        justify-content: center; align-items: center;
        gap: 14px;
    }
    .partner-pill {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 22px;
        border: 1px solid var(--line);
        border-radius: 999px;
        background: var(--mist);
        font-size: .82rem; font-weight: 600; color: #4b5263;
    }
    .partner-pill::before { content: ''; width: 8px; height: 8px; border-radius: 50%; background: var(--gold); }

    /* ── CTA ── */
    .cta {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(700px 320px at 50% 0%, rgba(245,168,0,.12), transparent 70%),
            linear-gradient(140deg, #030335, #04043C 60%, #0A1160);
        padding: 96px 24px;
        text-align: center;
    }
    .cta::before {
        content: '';
        position: absolute; top: 0; left: 50%;
        transform: translateX(-50%);
        width: min(560px, 80%); height: 3px;
        background: linear-gradient(90deg, transparent, var(--gold), transparent);
    }
    .cta-in { position: relative; max-width: 640px; margin: 0 auto; }
    .cta-eyebrow {
        color: var(--gold);
        font-size: .72rem; font-weight: 700;
        letter-spacing: .18em; text-transform: uppercase;
        margin-bottom: 18px;
    }
    .cta h2 {
        color: #fff;
        font-size: clamp(1.7rem, 3vw, 2.5rem);
        font-weight: 800;
        letter-spacing: -.02em;
        line-height: 1.15;
        margin-bottom: 14px;
    }
    .cta p { color: rgba(255,255,255,.6); font-size: 1rem; line-height: 1.75; margin-bottom: 36px; }

    @media (max-width: 400px) {
        .hero-plate-tag { font-size: .58rem; padding: 8px 14px; }
    }
</style>
@endpush

@section('content')

{{-- ══════════════ HERO ══════════════ --}}
<section class="hero">
    <div class="hero-in">

        <div>
            <p class="hero-eyebrow">Plateforme officielle UFEEL</p>

            <h1 class="hero-title">
                Unis pour <em>construire</em> notre avenir
            </h1>

            <p class="hero-desc">
                L'Union Fraternelle des Élèves et Étudiants de Lafi — ta communauté pour réussir ensemble en Côte d'Ivoire.
            </p>

            <div class="hero-cta">
                <a href="{{ route('register') }}" class="btn-solid">Rejoindre l'UFEEL</a>
                <a href="{{ route('events.index') }}" class="btn-line">Voir les événements</a>
            </div>

            @if($stats->count())
            <div class="hero-stats">
                @foreach($stats as $stat)
                <div>
                    <p class="stat-num">{{ number_format($stat->value) }}+</p>
                    <p class="stat-lbl">{{ $stat->label }}</p>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="hero-visual">
            <div class="hero-plate">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo UFEEL">
                <span class="hero-plate-tag">Unité · Fraternité · Solidarité</span>
            </div>
        </div>

    </div>
</section>

{{-- ══════════════ ACTUALITÉS ══════════════ --}}
@if($posts->count())
<section class="sect">
    <div class="sect-in">
        <div class="head">
            <div>
                <p class="eyebrow">Blog &amp; Actualités</p>
                <h2>Dernières nouvelles</h2>
            </div>
            <a href="{{ route('posts.index') }}" class="more-link">Tout voir <span aria-hidden="true">→</span></a>
        </div>

        <div class="grid grid-4">
            @foreach($posts->take(4) as $post)
            <a href="{{ route('posts.show', $post->slug) }}" class="tile">
                <div class="tile-img">
                    @if($post->cover_image)
                        <img src="{{ Storage::url($post->cover_image) }}" alt="">
                    @else
                        <div class="tile-img-ph">📰</div>
                    @endif
                </div>
                <div class="tile-body">
                    <span class="chip">{{ ucfirst($post->category ?? 'Actualité') }}</span>
                    <h3>{{ $post->title }}</h3>
                    @if($post->excerpt)
                        <p class="excerpt">{{ $post->excerpt }}</p>
                    @endif
                    <p class="meta">{{ $post->published_at?->diffForHumans() }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════ ÉVÉNEMENTS ══════════════ --}}
@if($events->count())
<section class="sect sect--mist">
    <div class="sect-in">
        <div class="head">
            <div>
                <p class="eyebrow">Agenda</p>
                <h2>Prochains événements</h2>
            </div>
            <a href="{{ route('events.index') }}" class="more-link">Tout voir <span aria-hidden="true">→</span></a>
        </div>

        <div class="grid grid-4">
            @foreach($events->take(4) as $event)
            <a href="{{ route('events.show', $event->slug) }}" class="tile">
                <div class="tile-img">
                    @if($event->cover_image)
                        <img src="{{ Storage::url($event->cover_image) }}" alt="">
                    @else
                        <div class="tile-img-ph">📅</div>
                    @endif
                    <div class="date-tag">
                        <b>{{ $event->starts_at->format('d') }}</b>
                        <span>{{ $event->starts_at->translatedFormat('M') }}</span>
                    </div>
                </div>
                <div class="tile-body">
                    <h3>{{ $event->title }}</h3>
                    @if($event->location)
                        <p class="meta">📍 {{ $event->location }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════ OPPORTUNITÉS ══════════════ --}}
@if($opportunities->count())
<section class="sect">
    <div class="sect-in">
        <div class="head">
            <div>
                <p class="eyebrow">Carrière &amp; Formation</p>
                <h2>Opportunités du moment</h2>
            </div>
            <a href="{{ route('opportunities.index') }}" class="more-link">Tout voir <span aria-hidden="true">→</span></a>
        </div>

        <div class="grid grid-4">
            @foreach($opportunities->take(4) as $opp)
            <a href="{{ route('opportunities.index') }}" class="tile">
                <div class="tile-body">
                    <span class="chip chip--navy">{{ ucfirst($opp->type) }}</span>
                    <h3>{{ $opp->title }}</h3>
                    @if($opp->organization)
                        <p class="excerpt">{{ $opp->organization }}</p>
                    @endif
                    @if($opp->deadline)
                        <p class="meta">⏰ Clôture le {{ $opp->deadline->format('d/m/Y') }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════ PARTENAIRES ══════════════ --}}
@if($partners->count())
<section class="partners-band">
    <div class="partners-in">
        <p class="partners-lbl">Ils accompagnent l'UFEEL</p>
        <div class="partners-row">
            @foreach($partners as $partner)
            <span class="partner-pill">{{ $partner->name }}</span>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════ CTA ══════════════ --}}
<section class="cta">
    <div class="cta-in">
        <p class="cta-eyebrow">Rejoins la famille UFEEL</p>
        <h2>Une communauté soudée pour construire l'avenir ensemble.</h2>
        <p>Inscris-toi en quelques minutes : actualités, événements, opportunités et ressources, réservés aux membres.</p>
        <a href="{{ route('register') }}" class="btn-solid">S'inscrire — c'est gratuit</a>
    </div>
</section>

@endsection

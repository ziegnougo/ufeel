<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            width: 85.6mm;
            height: 54mm;
            font-family: 'DejaVu Sans', sans-serif;
            background: #fff;
            overflow: hidden;
        }

        .card {
            width: 85.6mm;
            height: 54mm;
            position: relative;
            background: linear-gradient(135deg, #1a3a5c 0%, #0d6efd 100%);
            color: #fff;
        }

        .card-header {
            background: rgba(0,0,0,0.25);
            padding: 3mm 4mm;
            display: flex;
            align-items: center;
            gap: 2mm;
        }

        .org-name {
            font-size: 7pt;
            font-weight: bold;
            letter-spacing: 0.5pt;
            text-transform: uppercase;
        }

        .org-sub {
            font-size: 5pt;
            opacity: 0.85;
        }

        .card-body {
            padding: 2mm 4mm;
            display: flex;
            gap: 3mm;
            align-items: flex-start;
        }

        .avatar {
            width: 16mm;
            height: 16mm;
            border-radius: 2mm;
            border: 0.5mm solid rgba(255,255,255,0.5);
            background: rgba(255,255,255,0.2);
            flex-shrink: 0;
            overflow: hidden;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14pt;
            font-weight: bold;
            color: rgba(255,255,255,0.8);
        }

        .info { flex: 1; }

        .member-name {
            font-size: 9pt;
            font-weight: bold;
            margin-bottom: 1mm;
        }

        .member-detail {
            font-size: 6.5pt;
            opacity: 0.9;
            margin-bottom: 0.5mm;
        }

        .card-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.3);
            padding: 1.5mm 4mm;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-number {
            font-size: 6pt;
            letter-spacing: 0.5pt;
            font-family: 'DejaVu Sans Mono', monospace;
        }

        .validity {
            font-size: 5.5pt;
            opacity: 0.85;
        }

        .qr-wrap {
            position: absolute;
            right: 3mm;
            top: 12mm;
        }

        .qr-wrap img {
            width: 14mm;
            height: 14mm;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="card-header">
        <div>
            <div class="org-name">UFEEL</div>
            <div class="org-sub">Union Fraternelle des Élèves et Étudiants de Lafi</div>
        </div>
    </div>

    <div class="card-body">
        <div class="avatar">
            @if($member->user->avatar)
                <img src="{{ public_path('storage/' . $member->user->avatar) }}" alt="">
            @else
                <div class="avatar-placeholder">
                    {{ strtoupper(substr($member->user->name, 0, 1)) }}
                </div>
            @endif
        </div>

        <div class="info">
            <div class="member-name">{{ $member->user->name }}</div>
            @if($member->school_or_university)
                <div class="member-detail">{{ $member->school_or_university }}</div>
            @endif
            @if($member->city)
                <div class="member-detail">{{ $member->city }}</div>
            @endif
            <div class="member-detail" style="margin-top:1mm; font-size:5.5pt; opacity:0.7;">
                {{ ucfirst($member->level) }}
            </div>
        </div>
    </div>

    @if($member->card)
    <div class="qr-wrap">
        <img src="data:image/png;base64,{{ base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(53)->generate(url('/membre/verifier/' . $member->card->qr_code_token))) }}" alt="QR">
    </div>
    @endif

    <div class="card-footer">
        <span class="card-number">{{ $member->member_number }}</span>
        @if($member->card)
            <span class="validity">Valable jusqu'au {{ $member->card->expires_at->format('d/m/Y') }}</span>
        @endif
    </div>
</div>
</body>
</html>

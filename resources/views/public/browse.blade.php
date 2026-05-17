<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Scholarships — ScholarConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #F4F6F9;
            margin: 0;
        }

        .navbar {
            background: #fff;
            padding: 0.8rem 5%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .brand-name {
            font-weight: 700;
            font-size: 1.2rem;
            color: #0F1C33;
        }

        .brand-sub {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .nav-link-item {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-link-item:hover {
            color: #F5A623;
        }

        .nav-link-item.active {
            color: #F5A623;
            font-weight: 600;
        }

        .btn-register {
            background: #F5A623;
            color: #fff !important;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            font-weight: 600 !important;
        }

        .btn-register:hover {
            background: #d48f1c;
        }

        .page-hero {
            background: #1B2A47;
            padding: 2.5rem 0;
            margin-bottom: 2rem;
        }

        .page-hero h1 {
            color: #fff;
            font-weight: 700;
            font-size: 1.8rem;
        }

        .page-hero p {
            color: #B0BEC5;
            font-size: 0.9rem;
        }

        .scholarship-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .scholarship-title {
            font-weight: 600;
            color: #1B2A47;
            font-size: 0.92rem;
            line-height: 1.4;
            margin-bottom: 0.5rem;
        }

        .scholarship-desc {
            color: #6c757d;
            font-size: 0.82rem;
            line-height: 1.5;
            flex-grow: 1;
            margin-bottom: 0.5rem;
        }

        .scholarship-meta {
            font-size: 0.8rem;
            color: #444;
            margin-bottom: 0.2rem;
        }

        .scholarship-amount {
            font-size: 0.8rem;
            color: #444;
            margin-bottom: 0.75rem;
        }

        .scholarship-amount span {
            color: #F5A623;
            font-weight: 600;
        }

        .badge-provider-pill {
            color: #fff;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-block;
        }

        .badge-deadline-pill {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .deadline-soon {
            background: #FEE2E2;
            color: #DC2626;
        }

        .deadline-ok {
            background: #FEF3C7;
            color: #D97706;
        }

        .deadline-far {
            background: #D1FAE5;
            color: #059669;
        }

        .btn-view {
            background: #1B2A47;
            color: #fff;
            text-align: center;
            padding: 0.55rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.83rem;
            font-weight: 500;
            display: block;
            margin-top: auto;
            transition: background 0.2s;
        }

        .btn-view:hover {
            background: #0F1C33;
            color: #fff;
        }

        .login-prompt {
            background: #FEF3C7;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.83rem;
            color: #D97706;
            margin-bottom: 1.5rem;
        }

        footer {
            background: #1B2A47;
            color: #B0BEC5;
            text-align: center;
            padding: 1.5rem;
            font-size: 0.82rem;
            margin-top: 3rem;
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar d-flex justify-content-between align-items-center">
        <a href="{{ route('home') }}" style="text-decoration:none;" class="d-flex align-items-center gap-2">
            <i class="bi bi-mortarboard-fill" style="font-size:1.8rem; color:#F5A623;"></i>
            <div>
                <div class="brand-name">ScholarConnect</div>
                <div class="brand-sub">Camarines Norte</div>
            </div>
        </a>
        <div class="d-none d-md-flex gap-4 align-items-center">
            <a href="{{ route('browse') }}" class="nav-link-item active">Browse</a>
            <a href="{{ route('about') }}" class="nav-link-item">About</a>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <a href="{{ route('login') }}"
                style="text-decoration:none; color:#0F1C33; font-weight:600; font-size:0.95rem;">Login</a>
            <a href="{{ route('register') }}" class="btn-register" style="text-decoration:none;">Register</a>
        </div>
    </nav>

    {{-- HERO --}}
    <div class="page-hero">
        <div class="container">
            <h1>Browse Scholarships</h1>
            <p>Explore scholarship opportunities available for students in Camarines Norte</p>
            <form method="GET" action="{{ route('browse') }}" class="d-flex gap-2 mt-3">
                <input type="text" name="search" class="form-control"
                    style="max-width:400px; border-radius:8px; border:none;" placeholder="Search by name or provider..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn"
                    style="background:#F5A623; color:#0F1C33; font-weight:600; border-radius:8px; padding: 0.5rem 1.2rem;">
                    <i class="bi bi-search"></i> Search
                </button>
            </form>
        </div>
    </div>

    <div class="container pb-5">

        {{-- LOGIN PROMPT --}}
        <div class="login-prompt">
            <i class="bi bi-info-circle-fill"></i>
            <a href="{{ route('login') }}" style="color:#D97706; font-weight:600;">Login</a> or
            <a href="{{ route('register') }}" style="color:#D97706; font-weight:600;">Register</a>
            to bookmark scholarships and get personalized matches!
        </div>

        {{-- SCHOLARSHIPS GRID --}}
        <div class="row g-3">
            @forelse($scholarships as $scholarship)
                @php
                    $providerColors = [
                        'ched' => '#7C3AED',
                        'dost_sei' => '#7C3AED',
                        'lgu' => '#059669',
                        'private' => '#D97706',
                    ];
                    $providerKey = strtolower($scholarship->provider);
                    $providerColor = $providerColors[$providerKey] ?? '#1B2A47';
                    $providerLabel = strtoupper(str_replace('_sei', '', $scholarship->provider));
                    $daysLeft = (int) \Carbon\Carbon::now()
                        ->startOfDay()
                        ->diffInDays(\Carbon\Carbon::parse($scholarship->deadline)->startOfDay(), false);
                    $deadlineClass =
                        $daysLeft <= 7 ? 'deadline-soon' : ($daysLeft <= 30 ? 'deadline-ok' : 'deadline-far');
                    $deadlineIcon = $daysLeft <= 7 ? 'bi-exclamation-circle-fill' : 'bi-clock';
                @endphp
                <div class="col-md-4">
                    <div class="scholarship-card">
                        <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
                            <div class="d-flex gap-2">
                                <span class="badge-provider-pill"
                                    style="background:{{ $providerColor }};">{{ $providerLabel }}</span>
                                <span class="badge-deadline-pill {{ $deadlineClass }}">
                                    <i class="bi {{ $deadlineIcon }}"></i> {{ $daysLeft }}d left
                                </span>
                            </div>
                        </div>
                        <div class="scholarship-title">{{ $scholarship->title }}</div>
                        <div class="scholarship-desc">{{ Str::limit($scholarship->description, 100) }}</div>
                        <div class="scholarship-meta">
                            <i class="bi bi-mortarboard-fill" style="color:#F5A623;"></i>
                            GWA Required:
                            {{ $scholarship->minimum_gwa ? $scholarship->minimum_gwa * 100 . '%' : 'Open to all' }}
                        </div>
                        <div class="scholarship-amount">
                            <i class="bi bi-cash-stack" style="color:#F5A623;"></i>
                            Amount:
                            <span>{{ $scholarship->benefits ? Str::limit($scholarship->benefits, 40) : 'See details' }}</span>
                        </div>
                        {{-- View Details → redirect to login if guest --}}
                        <a href="{{ route('login') }}" class="btn-view">
                            View Details — Login Required
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    <i class="bi bi-search" style="font-size:2rem;"></i>
                    <p class="mt-2">No scholarships found.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4">{{ $scholarships->withQueryString()->links() }}</div>
    </div>

    <footer>
        © 2026 ScholarConnect — Camarines Norte. Supporting SDG 4: Quality Education.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

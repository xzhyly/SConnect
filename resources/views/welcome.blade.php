<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarConnect</title>
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><polygon points='50,18 85,35 50,52 15,35' fill='%23F5A623'/><rect x='43' y='52' width='14' height='22' rx='4' fill='%23F5A623'/><ellipse cx='50' cy='74' rx='12' ry='6' fill='%23F5A623'/><rect x='82' y='35' width='5' height='18' rx='2.5' fill='%23F5A623'/><circle cx='84.5' cy='55' r='4' fill='%23F5A623'/></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #F4F6F9;
            margin: 0;
        }

        /* NAVBAR */
        .navbar {
            background: #fff;
            padding: 0.8rem 5%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            position: sticky;
            top: 0;
            z-index: 100;
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

        .btn-login-nav {
            text-decoration: none;
            color: #0F1C33;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .btn-register-nav {
            background: #F5A623;
            color: #fff !important;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-register-nav:hover {
            background: #d48f1c;
        }

        /* HERO */
        .hero-section {
            background: linear-gradient(135deg, #1B2A47 0%, #0F1C33 100%);
            padding: 5rem 0 4rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(245, 166, 35, 0.05) 0%, transparent 60%);
            pointer-events: none;
        }

        .hero-title {
            font-size: 2.8rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .hero-title span {
            color: #F5A623;
        }

        .hero-subtitle {
            color: #B0BEC5;
            font-size: 1rem;
            max-width: 550px;
            margin: 0 auto 2rem;
            line-height: 1.7;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            background: #F5A623;
            color: #0F1C33;
            font-weight: 700;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            font-size: 0.95rem;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-hero-primary:hover {
            background: #d48f1c;
            color: #0F1C33;
        }

        .btn-hero-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            font-size: 0.95rem;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-hero-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        /* STATS */
        .stats-section {
            background: #fff;
            padding: 2.5rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .stat-item {
            text-align: center;
            padding: 0.5rem 1rem;
        }

        .stat-num {
            font-size: 2rem;
            font-weight: 700;
            color: #1B2A47;
        }

        .stat-num span {
            color: #F5A623;
        }

        .stat-lbl {
            font-size: 0.82rem;
            color: #6c757d;
        }

        .stat-divider {
            width: 1px;
            background: #F0F2F5;
        }

        /* FEATURES */
        .features-section {
            padding: 4rem 0;
        }

        .section-heading {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .section-heading h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1B2A47;
        }

        .section-heading p {
            color: #6c757d;
            font-size: 0.88rem;
        }

        .feature-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.75rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            height: 100%;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .feature-icon-box {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: #FEF3C7;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .feature-icon-box i {
            font-size: 1.4rem;
            color: #F5A623;
        }

        .feature-card h5 {
            font-weight: 700;
            color: #1B2A47;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .feature-card p {
            color: #6c757d;
            font-size: 0.83rem;
            line-height: 1.6;
            margin: 0;
        }

        /* FEATURED SCHOLARSHIPS */
        .scholarships-section {
            padding: 4rem 0;
            background: #fff;
        }

        .scholarship-card {
            background: #F4F6F9;
            border-radius: 12px;
            padding: 1.25rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: 0.2s;
        }

        .scholarship-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
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
            margin-bottom: 0.75rem;
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
            transition: 0.2s;
        }

        .btn-view:hover {
            background: #0F1C33;
            color: #fff;
        }

        /* CTA */
        .cta-section {
            padding: 4rem 0;
            text-align: center;
        }

        .cta-box {
            background: #1B2A47;
            border-radius: 20px;
            padding: 3rem 2rem;
        }

        .cta-box h2 {
            color: #fff;
            font-weight: 700;
            font-size: 1.6rem;
            margin-bottom: 0.75rem;
        }

        .cta-box p {
            color: #B0BEC5;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        /* FOOTER */
        footer {
            background: #0F1C33;
            color: #B0BEC5;
            text-align: center;
            padding: 1.5rem;
            font-size: 0.82rem;
        }

        footer a {
            color: #F5A623;
            text-decoration: none;
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
            <a href="{{ route('browse') }}" class="nav-link-item">Browse</a>
            <a href="{{ route('about') }}" class="nav-link-item">About</a>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <a href="{{ route('login') }}" class="btn-login-nav">Login</a>
            <a href="{{ route('register') }}" class="btn-register-nav">Register</a>
        </div>
    </nav>

    {{-- HERO --}}
    <div class="hero-section">
        <div class="container" style="position:relative; z-index:1;">
            <h1 class="hero-title">
                Find Scholarships in<br>
                <span>Camarines Norte</span><br>
                All in One Place
            </h1>
            <p class="hero-subtitle">
                Connect with educational opportunities tailored for students across all 12 municipalities of Camarines
                Norte.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('browse') }}" class="btn-hero-primary">
                    <i class="bi bi-search"></i> Browse Scholarships
                </a>
                <a href="{{ route('register') }}" class="btn-hero-secondary">
                    <i class="bi bi-person-plus"></i> Create Free Account
                </a>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-section">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center flex-wrap gap-4">
                <div class="stat-item">
                    <div class="stat-num">
                        {{ \App\Models\Scholarship::where('is_active', true)->where('deadline', '>=', now())->count() }}<span>+</span>
                    </div>
                    <div class="stat-lbl">Active Scholarships</div>
                </div>
                <div class="stat-divider d-none d-md-block" style="height:50px;"></div>
                <div class="stat-item">
                    <div class="stat-num">12</div>
                    <div class="stat-lbl">Municipalities Covered</div>
                </div>
                <div class="stat-divider d-none d-md-block" style="height:50px;"></div>
                <div class="stat-item">
                    <div class="stat-num">{{ \App\Models\User::where('is_admin', false)->count() }}<span>+</span></div>
                    <div class="stat-lbl">Students Registered</div>
                </div>
                <div class="stat-divider d-none d-md-block" style="height:50px;"></div>
                <div class="stat-item">
                    <div class="stat-num">3</div>
                    <div class="stat-lbl">Data Sources</div>
                </div>
            </div>
        </div>
    </div>

    {{-- FEATURES --}}
    <div class="features-section">
        <div class="container">
            <div class="section-heading">
                <h2>Everything You Need to Find a Scholarship</h2>
                <p>ScholarConnect makes it easy to discover, track, and apply for scholarships in Camarines Norte.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon-box"><i class="bi bi-sliders"></i></div>
                        <h5>Smart Matching</h5>
                        <p>Get scholarship recommendations based on your GWA, course, year level, and municipality.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon-box"><i class="bi bi-bell-fill"></i></div>
                        <h5>Deadline Alerts</h5>
                        <p>Never miss an application deadline with personalized notifications and reminders.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon-box"><i class="bi bi-bookmark-fill"></i></div>
                        <h5>Bookmark System</h5>
                        <p>Save scholarships you're interested in and access them anytime from your dashboard.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon-box"><i class="bi bi-arrow-repeat"></i></div>
                        <h5>Live Data Sync</h5>
                        <p>Scholarship data synced directly from CHED, DOST-SEI, and LGU sources automatically.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FEATURED SCHOLARSHIPS --}}
    @php
        $featured = \App\Models\Scholarship::where('is_active', true)
            ->where('deadline', '>=', now())
            ->orderBy('deadline', 'asc')
            ->limit(3)
            ->get();
    @endphp

    @if ($featured->count() > 0)
        <div class="scholarships-section">
            <div class="container">
                <div class="section-heading">
                    <h2>Featured Scholarship Opportunities</h2>
                    <p>Explore top scholarship programs available for students in Camarines Norte</p>
                </div>
                <div class="row g-3">
                    @foreach ($featured as $scholarship)
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
                                <div class="d-flex gap-2 mb-2 flex-wrap">
                                    <span class="badge-provider-pill"
                                        style="background:{{ $providerColor }};">{{ $providerLabel }}</span>
                                    <span class="badge-deadline-pill {{ $deadlineClass }}">
                                        <i class="bi {{ $deadlineIcon }}"></i> {{ $daysLeft }}d left
                                    </span>
                                </div>
                                <div class="scholarship-title">{{ $scholarship->title }}</div>
                                <div class="scholarship-desc">{{ Str::limit($scholarship->description, 100) }}</div>
                                <div class="scholarship-meta">
                                    <i class="bi bi-mortarboard-fill" style="color:#F5A623;"></i>
                                    GWA Required:
                                    {{ $scholarship->minimum_gwa ? number_format($scholarship->minimum_gwa, 2) : 'Open to all' }}
                                </div>
                                <div class="scholarship-amount">
                                    <i class="bi bi-cash-stack" style="color:#F5A623;"></i>
                                    Amount:
                                    <span>{{ $scholarship->benefits ? Str::limit($scholarship->benefits, 40) : 'See details' }}</span>
                                </div>
                                <a href="{{ route('login') }}" class="btn-view">View Details</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('browse') }}" class="btn-hero-primary" style="display:inline-flex;">
                        <i class="bi bi-grid"></i> Browse All Scholarships
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- CTA --}}
    <div class="cta-section">
        <div class="container">
            <div class="cta-box">
                <h2>Ready to Find Your Scholarship?</h2>
                <p>Join students from all 12 municipalities of Camarines Norte who are discovering educational
                    opportunities through ScholarConnect.</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('register') }}" class="btn-hero-primary">
                        <i class="bi bi-person-plus"></i> Get Started Free
                    </a>
                    <a href="{{ route('browse') }}" class="btn-hero-secondary">
                        <i class="bi bi-search"></i> Browse First
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        © 2026 ScholarConnect · Camarines Norte · Supporting <a href="{{ route('about') }}">SDG 4: Quality
            Education</a>.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

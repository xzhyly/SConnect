<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarConnect | About</title>
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><polygon points='50,18 85,35 50,52 15,35' fill='%23F5A623'/><rect x='43' y='52' width='14' height='22' rx='4' fill='%23F5A623'/><ellipse cx='50' cy='74' rx='12' ry='6' fill='%23F5A623'/><rect x='82' y='35' width='5' height='18' rx='2.5' fill='%23F5A623'/><circle cx='84.5' cy='55' r='4' fill='%23F5A623'/></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --brand-dark: #1B2A47;
            --brand-amber: #F5A623;
            --brand-amber-dark: #d48f1c;
            --brand-amber-light: #FEF3C7;
            --brand-amber-subtle: #FFFBF0;
            --text-muted: #6c757d;
            --bg-page: #F4F6F9;
            --card-radius: 16px;
            --shadow-sm: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-page);
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: #fff;
            padding: 0.8rem 5%;
            box-shadow: var(--shadow-sm);
        }

        .brand-name {
            font-weight: 700;
            font-size: 1.2rem;
            color: #0F1C33;
        }

        .brand-sub {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .nav-link-item {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-link-item:hover,
        .nav-link-item.active {
            color: var(--brand-amber);
        }

        .btn-register {
            background: var(--brand-amber);
            color: #fff !important;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            font-weight: 600 !important;
            text-decoration: none;
            transition: background 0.2s;
        }

        .btn-register:hover {
            background: var(--brand-amber-dark);
        }

        /* ── HERO ── */
        .page-hero {
            background: var(--brand-dark);
            padding: 3rem 0;
            margin-bottom: 2.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .page-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 70% 50%, rgba(245, 166, 35, 0.12) 0%, transparent 65%);
            pointer-events: none;
        }

        .page-hero h1 {
            color: #fff;
            font-weight: 700;
            font-size: 2rem;
        }

        .page-hero p {
            color: #B0BEC5;
            font-size: 0.95rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* ── CARDS ── */
        .section-card {
            background: #fff;
            border-radius: var(--card-radius);
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
        }

        .section-card-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--brand-dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-card-title i {
            color: var(--brand-amber);
            font-size: 1.25rem;
        }

        .section-card p {
            color: var(--text-muted);
            font-size: 0.88rem;
            line-height: 1.75;
            margin: 0 0 0.75rem;
        }

        .section-card p:last-child {
            margin-bottom: 0;
        }

        /* ── FEATURES ── */
        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 1.1rem;
        }

        .feature-item:last-child {
            margin-bottom: 0;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--brand-amber-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-icon i {
            color: var(--brand-amber);
            font-size: 1.1rem;
        }

        .feature-text strong {
            font-size: 0.88rem;
            color: var(--brand-dark);
            display: block;
            margin-bottom: 2px;
        }

        .feature-text span {
            font-size: 0.82rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* ── SDG INLINE BADGE ── */
        .sdg-inline-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--bg-page);
            border-left: 3px solid var(--brand-amber);
            border-radius: 8px;
            padding: 0.6rem 1rem;
            margin-bottom: 1rem;
        }

        .sdg-inline-badge span {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--brand-dark);
            letter-spacing: 0.01em;
        }

        .sdg-wheel {
            width: 32px;
            height: 32px;
            flex-shrink: 0;
        }

        /* ── STATS ── */
        .stat-mini {
            text-align: center;
            padding: 1.25rem 0.75rem;
            background: var(--bg-page);
            border-radius: 12px;
        }

        .stat-mini .num {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--brand-dark);
            line-height: 1;
        }

        .stat-mini .lbl {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* ── DATA SOURCES ── */
        .source-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 0.8rem 1rem;
            border-radius: 10px;
            background: var(--bg-page);
            margin-bottom: 0.6rem;
            transition: background 0.15s;
        }

        .source-row:last-child {
            margin-bottom: 0;
        }

        .source-dot {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
        }

        .source-text {
            flex: 1;
            min-width: 0;
        }

        .source-text strong {
            font-size: 0.85rem;
            color: var(--brand-dark);
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .source-text span {
            font-size: 0.78rem;
            color: var(--text-muted);
            line-height: 1.45;
            display: block;
            margin-top: 2px;
        }

        .source-badge-tag {
            display: inline-block;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 10px;
        }

        /* ── CONTACT ── */
        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 0;
            border-bottom: 1px solid #F0F2F5;
            font-size: 0.84rem;
            color: #444;
        }

        .contact-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .contact-item:first-child {
            padding-top: 0;
        }

        .contact-item i {
            color: var(--brand-amber);
            font-size: 1.05rem;
            width: 20px;
            flex-shrink: 0;
        }

        /* ── FOOTER ── */
        footer {
            background: var(--brand-dark);
            color: #B0BEC5;
            text-align: center;
            padding: 1.5rem;
            font-size: 0.82rem;
            margin-top: auto;
        }

        /* ── GMAIL AVATAR COLOR MATCH ── */
        .gmail-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #EA4335;
            /* Gmail red → matched to cscholar65@gmail.com avatar */
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar d-flex justify-content-between align-items-center">
        <a href="{{ route('home') }}" style="text-decoration:none;" class="d-flex align-items-center gap-2">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polygon points="12,2 22,8 12,14 2,8" fill="#F5A623" />
                <polyline points="6,11 6,17 12,20 18,17 18,11" stroke="#F5A623" stroke-width="2" stroke-linejoin="round"
                    fill="none" />
                <line x1="22" y1="8" x2="22" y2="14" stroke="#F5A623" stroke-width="2"
                    stroke-linecap="round" />
            </svg>
            <div>
                <div class="brand-name">ScholarConnect</div>
                <div class="brand-sub">Camarines Norte</div>
            </div>
        </a>
        <div class="d-none d-md-flex gap-4 align-items-center">
            <a href="{{ route('browse') }}" class="nav-link-item">Browse</a>
            <a href="{{ route('about') }}" class="nav-link-item active">About</a>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <a href="{{ route('login') }}"
                style="text-decoration:none; color:#0F1C33; font-weight:600; font-size:0.95rem;">Login</a>
            <a href="{{ route('register') }}" class="btn-register">Register</a>
        </div>
    </nav>

    {{-- HERO --}}
    <div class="page-hero">
        <div class="container">
            <h1>About ScholarConnect</h1>
            <p>A scholarship aggregator built for students in Camarines Norte — find, filter, and get notified about
                funding opportunities from government and private sources all in one place.</p>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row g-4">

            {{-- ═══════════ LEFT COLUMN ═══════════ --}}
            <div class="col-lg-8">

                {{-- What is ScholarConnect --}}
                <div class="section-card">
                    <div class="section-card-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#F5A623"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="8" stroke="white"
                                stroke-width="2" stroke-linecap="round" />
                            <line x1="12" y1="12" x2="12" y2="16" stroke="white"
                                stroke-width="2" stroke-linecap="round" />
                        </svg> What is ScholarConnect?
                    </div>
                    <p>ScholarConnect is a scholarship finder and alert system built for students in Camarines Norte.
                        It aggregates listings from CHED, DOST-SEI, and LGU programs across all 12 municipalities,
                        alongside scholarships added by administrators from private organizations and foundations.</p>
                    <p>Register an account, get matched to scholarships based on your GWA, course, and year level,
                        save opportunities to your dashboard, and receive email alerts before application deadlines.</p>
                </div>

                {{-- Key Features --}}
                <div class="section-card">
                    <div class="section-card-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#F5A623"
                            xmlns="http://www.w3.org/2000/svg">
                            <polygon
                                points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26" />
                        </svg> Key Features
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <line x1="4" y1="6" x2="20" y2="6" stroke="#F5A623"
                                    stroke-width="2" stroke-linecap="round" />
                                <line x1="4" y1="12" x2="14" y2="12" stroke="#F5A623"
                                    stroke-width="2" stroke-linecap="round" />
                                <line x1="4" y1="18" x2="17" y2="18" stroke="#F5A623"
                                    stroke-width="2" stroke-linecap="round" />
                                <circle cx="19" cy="6" r="2" fill="#F5A623" />
                                <circle cx="17" cy="12" r="2" fill="#F5A623" />
                                <circle cx="20" cy="18" r="2" fill="#F5A623" />
                            </svg>
                        </div>
                        <div class="feature-text">
                            <strong>Smart Matching</strong>
                            <span>Only shows scholarships you qualify for — filtered by GWA, course, year level, and
                                municipality.</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="#F5A623"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke="#F5A623" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                        </div>
                        <div class="feature-text">
                            <strong>Deadline Alerts</strong>
                            <span>Email notifications sent before deadlines close, and right after you register for any
                                currently active matches.</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z" fill="#F5A623"
                                    stroke="#F5A623" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="feature-text">
                            <strong>Bookmarks</strong>
                            <span>Save scholarships to your dashboard and revisit them anytime.</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <polyline points="1 4 1 10 7 10" stroke="#F5A623" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <polyline points="23 20 23 14 17 14" stroke="#F5A623" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10M23 14l-4.64 4.36A9 9 0 0 1 3.51 15"
                                    stroke="#F5A623" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="feature-text">
                            <strong>Auto Sync + Manual Entry</strong>
                            <span>Government sources sync automatically. Admins can also add scholarships from private
                                organizations directly.</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" fill="#F5A623" stroke="#F5A623"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <polyline points="9 12 11 14 15 10" stroke="white" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="feature-text">
                            <strong>Admin Management</strong>
                            <span>Administrators can add, edit, and manage scholarship listings from any provider —
                                including private companies and foundations — alongside the synced government
                                data.</span>
                        </div>
                    </div>
                </div>

                {{-- SDG 4 --}}
                <div class="section-card">
                    <div class="section-card-title" style="margin-bottom:0.75rem;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F5A623"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" />
                            <path
                                d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                        </svg> SDG 4 — Quality Education
                    </div>
                    <div class="sdg-inline-badge">
                        <svg class="sdg-wheel" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <circle cx="20" cy="20" r="19" fill="#1B2A47" />
                            <g stroke="#1B2A47" stroke-width="0.6">
                                <path d="M20 20 L20 1 A19 19 0 0 1 35.6 9.5 Z" fill="#C5192D" />
                                <path d="M20 20 L35.6 9.5 A19 19 0 0 1 38.7 20 Z" fill="#DDA63A" />
                                <path d="M20 20 L38.7 20 A19 19 0 0 1 35.6 30.5 Z" fill="#4C9F38" />
                                <path d="M20 20 L35.6 30.5 A19 19 0 0 1 26.2 38.1 Z" fill="#C5192D" />
                                <path d="M20 20 L26.2 38.1 A19 19 0 0 1 13.8 38.1 Z" fill="#FF3A21" />
                                <path d="M20 20 L13.8 38.1 A19 19 0 0 1 4.4 30.5 Z" fill="#26BDE2" />
                                <path d="M20 20 L4.4 30.5 A19 19 0 0 1 1.3 20 Z" fill="#FCC30B" />
                                <path d="M20 20 L1.3 20 A19 19 0 0 1 4.4 9.5 Z" fill="#A21942" />
                                <path d="M20 20 L4.4 9.5 A19 19 0 0 1 13.8 1.9 Z" fill="#FD9D24" />
                                <path d="M20 20 L13.8 1.9 A19 19 0 0 1 20 1 Z" fill="#F5A623" opacity="0.9" />
                            </g>
                            <circle cx="20" cy="20" r="7" fill="#fff" />
                            <text x="20" y="24.5" text-anchor="middle" font-size="9" font-weight="700"
                                fill="#1B2A47" font-family="Poppins, sans-serif">4</text>
                        </svg>
                        <span>United Nations Sustainable Development Goal</span>
                    </div>
                    <p>ScholarConnect is aligned with SDG 4, which calls for inclusive and equitable quality education
                        and lifelong learning opportunities for all. Access to scholarship information is a critical
                        step toward that goal.</p>
                    <p>By centralizing scholarship listings from government and private sources across all 12
                        municipalities of Camarines Norte, this platform helps bridge the information gap that prevents
                        many qualified students from finding and applying for available funding.</p>
                </div>

            </div>

            {{-- ═══════════ RIGHT COLUMN ═══════════ --}}
            <div class="col-lg-4">

                {{-- Stats --}}
                <div class="section-card">
                    <div class="section-card-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F5A623"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            xmlns="http://www.w3.org/2000/svg">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                            <polyline points="17 6 23 6 23 12" />
                        </svg> By the Numbers
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="stat-mini">
                                <div class="num">
                                    {{ \App\Models\Scholarship::where('is_active', true)->where('deadline', '>=', now())->count() }}
                                </div>
                                <div class="lbl">Active Scholarships</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-mini">
                                <div class="num">12</div>
                                <div class="lbl">Municipalities</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-mini">
                                <div class="num">{{ \App\Models\User::where('is_admin', false)->count() }}</div>
                                <div class="lbl">Students Registered</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-mini">
                                <div class="num">
                                    {{ \App\Models\Scholarship::distinct('provider')->count('provider') }}</div>
                                <div class="lbl">Data Sources</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Data Sources — dynamic from DB --}}
                <div class="section-card">
                    <div class="section-card-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F5A623"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            xmlns="http://www.w3.org/2000/svg">
                            <ellipse cx="12" cy="5" rx="9" ry="3" />
                            <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3" />
                            <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5" />
                        </svg> Data Sources
                    </div>
                    @php
                        $sourceConfig = [
                            'ched' => [
                                'icon' => 'bi-building',
                                'color' => '#7C3AED',
                                'bg' => '#EDE9FE',
                                'label' => 'CHED',
                                'tag' => null,
                                'desc' => 'Commission on Higher Education scholarship programs',
                            ],
                            'dost_sei' => [
                                'icon' => 'bi-flask',
                                'color' => '#0284C7',
                                'bg' => '#E0F2FE',
                                'label' => 'DOST-SEI',
                                'tag' => null,
                                'desc' => 'Science and technology merit scholarships',
                            ],
                            'lgu' => [
                                'icon' => 'bi-geo-alt-fill',
                                'color' => '#059669',
                                'bg' => '#D1FAE5',
                                'label' => 'LGU Programs',
                                'tag' => null,
                                'desc' => 'Local government scholarships from all 12 municipalities',
                            ],
                            'manual' => [
                                'icon' => 'bi-pencil-fill',
                                'color' => '#D97706',
                                'bg' => '#FEF3C7',
                                'label' => 'Admin-Added',
                                'tag' => 'Manual',
                                'desc' =>
                                    'Scholarships from private organizations & foundations, added by administrators',
                            ],
                            'private' => [
                                'icon' => 'bi-briefcase-fill',
                                'color' => '#D97706',
                                'bg' => '#FEF3C7',
                                'label' => 'Private Orgs',
                                'tag' => 'Manual',
                                'desc' => 'Corporate and private organization scholarship programs',
                            ],
                        ];
                        $activeSources = \App\Models\Scholarship::select('provider')->distinct()->pluck('provider');
                    @endphp

                    @php
                        $sourceIcons = [
                            'ched' =>
                                '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 21h18M3 10h18M12 3L3 10h18L12 3z" stroke="#7C3AED" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><rect x="7" y="10" width="3" height="7" rx="0.5" fill="#7C3AED"/><rect x="14" y="10" width="3" height="7" rx="0.5" fill="#7C3AED"/></svg>',
                            'dost_sei' =>
                                '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="3" fill="#0284C7"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3M4.93 4.93l2.12 2.12M16.95 16.95l2.12 2.12M4.93 19.07l2.12-2.12M16.95 7.05l2.12-2.12" stroke="#0284C7" stroke-width="2" stroke-linecap="round"/></svg>',
                            'lgu' =>
                                '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" fill="#059669"/><circle cx="12" cy="9" r="2.5" fill="white"/></svg>',
                            'manual' =>
                                '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke="#D97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" stroke="#D97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                            'private' =>
                                '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="7" width="20" height="14" rx="2" stroke="#D97706" stroke-width="2"/><path d="M16 7V5a4 4 0 0 0-8 0v2" stroke="#D97706" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="14" r="2" fill="#D97706"/></svg>',
                            'default' =>
                                '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="3" width="7" height="7" rx="1" fill="#1B2A47"/><rect x="14" y="3" width="7" height="7" rx="1" fill="#1B2A47"/><rect x="3" y="14" width="7" height="7" rx="1" fill="#1B2A47"/><rect x="14" y="14" width="7" height="7" rx="1" fill="#1B2A47"/></svg>',
                        ];
                    @endphp

                    @forelse($activeSources as $source)
                        @php
                            $key = strtolower($source);
                            $cfg = $sourceConfig[$key] ?? [
                                'icon' => 'default',
                                'color' => '#1B2A47',
                                'bg' => '#F0F2F5',
                                'label' => strtoupper(str_replace(['_', '-'], ' ', $source)),
                                'tag' => null,
                                'desc' => 'Scholarship data source',
                            ];
                            $iconSvg = $sourceIcons[$key] ?? $sourceIcons['default'];
                        @endphp
                        <div class="source-row">
                            <div class="source-dot" style="background:{{ $cfg['bg'] }};">
                                {!! $iconSvg !!}
                            </div>
                            <div class="source-text">
                                <strong>
                                    {{ $cfg['label'] }}
                                    @if ($cfg['tag'])
                                        <span class="source-badge-tag"
                                            style="background:{{ $cfg['bg'] }};color:{{ $cfg['color'] }};">{{ $cfg['tag'] }}</span>
                                    @endif
                                </strong>
                                <span>{{ $cfg['desc'] }}</span>
                            </div>
                        </div>
                    @empty
                        {{-- Placeholder preview before any sync has run --}}
                        @foreach (['ched', 'dost_sei', 'lgu'] as $previewKey)
                            @php
                                $cfg = $sourceConfig[$previewKey];
                                $iconSvg = $sourceIcons[$previewKey] ?? $sourceIcons['default'];
                            @endphp
                            <div class="source-row" style="opacity:0.45;">
                                <div class="source-dot" style="background:{{ $cfg['bg'] }};">
                                    {!! $iconSvg !!}
                                </div>
                                <div class="source-text">
                                    <strong>{{ $cfg['label'] }}</strong>
                                    <span>{{ $cfg['desc'] }}</span>
                                </div>
                            </div>
                        @endforeach

                    @endforelse
                </div>

                {{-- Contact --}}
                <div class="section-card">
                    <div class="section-card-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#F5A623"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 2-8 5-8-5h16zm0 12H4V8l8 5 8-5v10z" />
                        </svg> Contact
                    </div>
                    <div class="contact-item">
                        {{-- Gmail avatar color-matched (red like cscholar65@gmail.com) --}}
                        <span class="gmail-avatar" style="font-size:0.75rem;">SC</span>
                        <div>
                            <div style="font-size:0.83rem;font-weight:600;color:#1B2A47;">Scholar Connect</div>
                            <div style="font-size:0.78rem;color:var(--text-muted);">cscholar65@gmail.com</div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#F5A623"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" />
                        </svg>
                        (054) 123-4567
                    </div>
                    <div class="contact-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#F5A623"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                        </svg>
                        Camarines Norte State College, F. Pimentel Ave., Daet, Camarines Norte
                    </div>
                </div>

            </div>
        </div>
    </div>

    <footer>
        © 2026 ScholarConnect — Camarines Norte. Supporting <strong style="color:var(--brand-amber);">SDG 4: Quality
            Education</strong>.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

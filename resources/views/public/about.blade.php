<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About — ScholarConnect</title>
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

        .nav-link-item:hover,
        .nav-link-item.active {
            color: #F5A623;
        }

        .btn-register {
            background: #F5A623;
            color: #fff !important;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            font-weight: 600 !important;
            text-decoration: none;
        }

        .btn-register:hover {
            background: #d48f1c;
        }

        .page-hero {
            background: #1B2A47;
            padding: 3rem 0;
            margin-bottom: 2.5rem;
            text-align: center;
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

        .section-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
        }

        .section-card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1B2A47;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-card-title i {
            color: #F5A623;
            font-size: 1.3rem;
        }

        .section-card p {
            color: #6c757d;
            font-size: 0.88rem;
            line-height: 1.7;
            margin: 0;
        }

        .sdg-badge {
            background: #1B2A47;
            color: #F5A623;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 6px 16px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 1.1rem;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #FEF3C7;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-icon i {
            color: #F5A623;
            font-size: 1.1rem;
        }

        .feature-text strong {
            font-size: 0.88rem;
            color: #1B2A47;
            display: block;
            margin-bottom: 2px;
        }

        .feature-text span {
            font-size: 0.82rem;
            color: #6c757d;
            line-height: 1.5;
        }

        .stat-mini {
            text-align: center;
            padding: 1.25rem;
            background: #F4F6F9;
            border-radius: 12px;
        }

        .stat-mini .num {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1B2A47;
        }

        .stat-mini .lbl {
            font-size: 0.78rem;
            color: #6c757d;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 0;
            border-bottom: 1px solid #F0F2F5;
            font-size: 0.85rem;
            color: #444;
        }

        .contact-item:last-child {
            border-bottom: none;
        }

        .contact-item i {
            color: #F5A623;
            font-size: 1.1rem;
            width: 20px;
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
            <p>A localized scholarship aggregator built to connect Camarines Norte students with educational funding
                opportunities.</p>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row g-4">

            {{-- LEFT COLUMN --}}
            <div class="col-lg-8">

                {{-- What is ScholarConnect --}}
                <div class="section-card">
                    <div class="section-card-title">
                        <i class="bi bi-info-circle-fill"></i> What is ScholarConnect?
                    </div>
                    <p>ScholarConnect is a web-based scholarship aggregation and alert system designed specifically for
                        students of Camarines Norte. It automatically collects scholarship data from government agencies
                        such as CHED and DOST-SEI, as well as local government units (LGUs) across all 12 municipalities
                        of the province.</p>
                    <br>
                    <p>Students can create a profile, browse scholarships matched to their academic program and
                        municipality, bookmark opportunities, and receive deadline alerts — all in one place.</p>
                </div>

                {{-- Features --}}
                <div class="section-card">
                    <div class="section-card-title">
                        <i class="bi bi-stars"></i> Key Features
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="bi bi-sliders"></i></div>
                        <div class="feature-text">
                            <strong>Smart Matching</strong>
                            <span>Scholarships are automatically filtered based on your GWA, academic program, year
                                level, and municipality.</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="bi bi-bell-fill"></i></div>
                        <div class="feature-text">
                            <strong>Deadline Alerts</strong>
                            <span>Get notified when application deadlines are approaching so you never miss an
                                opportunity.</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="bi bi-bookmark-fill"></i></div>
                        <div class="feature-text">
                            <strong>Bookmark System</strong>
                            <span>Save scholarships you're interested in and access them anytime from your personal
                                dashboard.</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="bi bi-arrow-repeat"></i></div>
                        <div class="feature-text">
                            <strong>Live Data Sync</strong>
                            <span>Scholarship data is synced directly from CHED, DOST-SEI, and LGU sources to ensure
                                accuracy and timeliness.</span>
                        </div>
                    </div>
                </div>

                {{-- SDG 4 --}}
                <div class="section-card">
                    <div class="sdg-badge">🎯 SDG 4 — Quality Education</div>
                    <div class="section-card-title">
                        <i class="bi bi-globe-americas"></i> Our SDG Commitment
                    </div>
                    <p>ScholarConnect directly supports the United Nations Sustainable Development Goal 4 — ensuring
                        inclusive and equitable quality education and promoting lifelong learning opportunities for all.
                    </p>
                    <br>
                    <p>By making scholarship information accessible, centralized, and personalized for students across
                        all 12 municipalities of Camarines Norte, ScholarConnect reduces the information gap that often
                        prevents deserving students from applying to available funding opportunities.</p>
                </div>

            </div>

            {{-- RIGHT COLUMN --}}
            <div class="col-lg-4">

                {{-- Stats --}}
                <div class="section-card">
                    <div class="section-card-title">
                        <i class="bi bi-graph-up-arrow"></i> By the Numbers
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
                                <div class="num">3</div>
                                <div class="lbl">Data Sources</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Data Sources --}}
                <div class="section-card">
                    <div class="section-card-title">
                        <i class="bi bi-database-fill"></i> Data Sources
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon" style="background:#EDE9FE;"><i class="bi bi-building"
                                style="color:#7C3AED;"></i></div>
                        <div class="feature-text">
                            <strong>CHED</strong>
                            <span>Commission on Higher Education scholarship programs</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon" style="background:#EDE9FE;"><i class="bi bi-flask"
                                style="color:#7C3AED;"></i></div>
                        <div class="feature-text">
                            <strong>DOST-SEI</strong>
                            <span>Science and technology merit scholarships</span>
                        </div>
                    </div>
                    <div class="feature-item" style="margin-bottom:0;">
                        <div class="feature-icon" style="background:#D1FAE5;"><i class="bi bi-geo-alt-fill"
                                style="color:#059669;"></i></div>
                        <div class="feature-text">
                            <strong>LGU Programs</strong>
                            <span>Local government scholarships from all 12 municipalities</span>
                        </div>
                    </div>
                </div>

                {{-- Contact --}}
                <div class="section-card">
                    <div class="section-card-title">
                        <i class="bi bi-envelope-fill"></i> Contact
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-envelope-fill"></i>
                        scholarconnect@camarinesnorte.gov.ph
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-telephone-fill"></i>
                        (054) 123-4567
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-geo-alt-fill"></i>
                        Camarines Norte State College, F. Pimentel Ave., Daet, Camarines Norte
                    </div>
                </div>

            </div>
        </div>
    </div>

    <footer>
        © 2026 ScholarConnect — Camarines Norte. Supporting SDG 4: Quality Education.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>s

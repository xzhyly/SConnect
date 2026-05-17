<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarConnect — System Architecture</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600&family=IBM+Plex+Sans:wght@300;400;600;700&display=swap');

        :root {
            --navy: #1B2A47;
            --dark: #0F1C33;
            --darker: #090f1e;
            --amber: #F5A623;
            --amber-d: #c07c0a;
            --white: #FFFFFF;
            --muted: #8a9fc0;
            --border: #2a3f66;
            --green: #2ecc8a;
            --blue: #4d9de0;
            --coral: #e05c5c;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--dark);
            color: var(--white);
            font-family: 'IBM Plex Sans', sans-serif;
            min-height: 100vh;
            padding: 0;
        }

        /* ── Print styles ── */
        @media print {
            body {
                background: #fff;
                color: #111;
            }

            .no-print {
                display: none !important;
            }

            .page {
                box-shadow: none;
                margin: 0;
                border-radius: 0;
                background: #fff;
            }

            .header {
                background: var(--navy) !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            svg .box-fill {
                fill: #e8ecf4 !important;
            }
        }

        /* ── Layout ── */
        .page {
            max-width: 1100px;
            margin: 0 auto;
            background: var(--navy);
            border-radius: 12px;
            overflow: hidden;
        }

        /* ── Header ── */
        .header {
            background: var(--darker);
            border-bottom: 2px solid var(--amber);
            padding: 28px 40px 22px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
        }

        .header-left h1 {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--white);
        }

        .header-left h1 span {
            color: var(--amber);
        }

        .header-left p {
            font-size: 12px;
            color: var(--muted);
            margin-top: 4px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .sdg-badge {
            background: var(--amber);
            color: var(--darker);
            font-size: 11px;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 20px;
            letter-spacing: 0.5px;
            white-space: nowrap;
            align-self: center;
        }

        /* ── Main diagram area ── */
        .diagram-wrap {
            padding: 32px 40px 24px;
        }

        /* ── SVG diagram ── */
        svg {
            width: 100%;
            height: auto;
            display: block;
        }

        /* ── Legend ── */
        .legend {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            padding: 0 40px 20px;
            border-top: 1px solid var(--border);
            margin-top: 4px;
            padding-top: 16px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: var(--muted);
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* ── Team footer ── */
        .footer {
            background: var(--darker);
            border-top: 1px solid var(--border);
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .team {
            display: flex;
            gap: 28px;
            flex-wrap: wrap;
        }

        .member {
            font-size: 12px;
        }

        .member strong {
            color: var(--amber);
            font-weight: 600;
            display: block;
            font-size: 13px;
        }

        .member span {
            color: var(--muted);
        }

        .school {
            font-size: 11px;
            color: var(--muted);
            text-align: right;
            line-height: 1.6;
        }

        .school strong {
            color: var(--white);
            display: block;
            font-size: 12px;
        }

        /* ── Print button ── */
        .print-btn {
            position: fixed;
            bottom: 28px;
            right: 28px;
            background: var(--amber);
            color: var(--darker);
            border: none;
            padding: 10px 22px;
            border-radius: 8px;
            font-family: 'IBM Plex Sans', sans-serif;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(245, 166, 35, 0.35);
            transition: background 0.15s, transform 0.1s;
        }

        .print-btn:hover {
            background: var(--amber-d);
            transform: translateY(-1px);
        }

        .print-btn:active {
            transform: scale(0.97);
        }
    </style>
</head>

<body>

    <div class="page">

        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>Scholar<span>Connect</span></h1>
                <p>IT 111 Final Project &nbsp;·&nbsp; BSIT 2A &nbsp;·&nbsp; System Architecture Diagram</p>
            </div>
            <div class="sdg-badge">SDG 4 — Quality Education</div>
        </div>

        <!-- Diagram -->
        <div class="diagram-wrap">
            <svg viewBox="0 0 1020 580" xmlns="http://www.w3.org/2000/svg" role="img"
                aria-label="ScholarConnect system architecture showing data flow from mock APIs through middleware to database, notification service, and student dashboard">
                <title>ScholarConnect System Architecture</title>
                <desc>Full data flow: Mock API servers (CHED, DOST-SEI, LGU) send JSON responses via HTTP GET to
                    ScholarConnectMiddleware, which normalizes data and stores it in MySQL via Eloquent ORM.
                    NotificationService matches scholarships to student profiles and sends email via SMTP to Mailtrap.
                    Students access their matched scholarships through the Blade dashboard. Sync can also be triggered
                    manually by an admin via SyncController.</desc>

                <defs>
                    <!-- Arrow markers -->
                    <marker id="arr-white" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="6"
                        markerHeight="6" orient="auto-start-reverse">
                        <path d="M2 1L8 5L2 9" fill="none" stroke="#8a9fc0" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </marker>
                    <marker id="arr-amber" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="6"
                        markerHeight="6" orient="auto-start-reverse">
                        <path d="M2 1L8 5L2 9" fill="none" stroke="#F5A623" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </marker>
                    <marker id="arr-green" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="6"
                        markerHeight="6" orient="auto-start-reverse">
                        <path d="M2 1L8 5L2 9" fill="none" stroke="#2ecc8a" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </marker>
                    <marker id="arr-blue" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="6"
                        markerHeight="6" orient="auto-start-reverse">
                        <path d="M2 1L8 5L2 9" fill="none" stroke="#4d9de0" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </marker>
                    <marker id="arr-coral" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="6"
                        markerHeight="6" orient="auto-start-reverse">
                        <path d="M2 1L8 5L2 9" fill="none" stroke="#e05c5c" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </marker>
                </defs>

                <!-- ════════════════════════════════
                 DOCKER NETWORK container border
            ════════════════════════════════ -->
                <rect x="10" y="10" width="1000" height="560" rx="16" fill="none" stroke="#2a3f66"
                    stroke-width="1.5" stroke-dasharray="8 5" />
                <text x="26" y="30" font-family="'IBM Plex Mono', monospace" font-size="11" fill="#2a3f66"
                    font-weight="600">docker network: scholarconnect_default</text>

                <!-- ════════════════════════════════
                 MOCK API SERVERS  (left column)
            ════════════════════════════════ -->
                <!-- Container box -->
                <rect x="32" y="50" width="190" height="320" rx="10" fill="#0F1C33" stroke="#2a3f66"
                    stroke-width="1" />
                <text x="127" y="72" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="11"
                    fill="#8a9fc0" font-weight="600" letter-spacing="0.5">MOCK API SERVER :8080</text>

                <!-- CHED box -->
                <rect x="52" y="86" width="150" height="76" rx="8" fill="#152238" stroke="#2a3f66"
                    stroke-width="0.8" />
                <rect x="52" y="86" width="4" height="76" rx="2" fill="#4d9de0" />
                <text x="136" y="109" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="13"
                    font-weight="600" fill="#FFFFFF">CHED</text>
                <text x="136" y="126" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="11"
                    fill="#8a9fc0">6 scholarships</text>
                <text x="136" y="142" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#4d9de0">ched_scholarships.json</text>

                <!-- DOST-SEI box -->
                <rect x="52" y="176" width="150" height="76" rx="8" fill="#152238" stroke="#2a3f66"
                    stroke-width="0.8" />
                <rect x="52" y="176" width="4" height="76" rx="2" fill="#2ecc8a" />
                <text x="136" y="199" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="13"
                    font-weight="600" fill="#FFFFFF">DOST-SEI</text>
                <text x="136" y="216" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="11"
                    fill="#8a9fc0">5 scholarships</text>
                <text x="136" y="232" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#2ecc8a">dost_scholarships.json</text>

                <!-- LGU box -->
                <rect x="52" y="266" width="150" height="76" rx="8" fill="#152238" stroke="#2a3f66"
                    stroke-width="0.8" />
                <rect x="52" y="266" width="4" height="76" rx="2" fill="#F5A623" />
                <text x="136" y="289" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="13"
                    font-weight="600" fill="#FFFFFF">LGU (12 Municipalities)</text>
                <text x="136" y="306" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="11"
                    fill="#8a9fc0">12 scholarships</text>
                <text x="136" y="322" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#F5A623">lgu_scholarships.json</text>

                <!-- PHP server label -->
                <text x="127" y="360" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#2a3f66">php -S 0.0.0.0:8080 server.php</text>

                <!-- ════════════════════════════════
                 HTTP GET arrows  →  Middleware
            ════════════════════════════════ -->
                <!-- CHED arrow -->
                <line x1="202" y1="124" x2="300" y2="200" stroke="#4d9de0"
                    stroke-width="1.2" marker-end="url(#arr-blue)" />
                <!-- DOST arrow -->
                <line x1="202" y1="214" x2="300" y2="224" stroke="#2ecc8a"
                    stroke-width="1.2" marker-end="url(#arr-green)" />
                <!-- LGU arrow -->
                <line x1="202" y1="304" x2="300" y2="248" stroke="#F5A623"
                    stroke-width="1.2" marker-end="url(#arr-amber)" />

                <!-- HTTP GET labels -->
                <text x="240" y="188" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#4d9de0">HTTP GET</text>
                <text x="250" y="208" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#2ecc8a">HTTP GET</text>
                <text x="242" y="268" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#F5A623">HTTP GET</text>

                <!-- JSON response labels (return path, dashed) -->
                <line x1="300" y1="232" x2="202" y2="214" stroke="#8a9fc0"
                    stroke-width="0.8" stroke-dasharray="4 3" />
                <text x="245" y="228" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="9"
                    fill="#2a3f66">JSON</text>

                <!-- ════════════════════════════════
                 MIDDLEWARE  (center-left)
            ════════════════════════════════ -->
                <rect x="300" y="140" width="200" height="170" rx="10" fill="#152238" stroke="#F5A623"
                    stroke-width="1.5" />
                <rect x="300" y="140" width="200" height="34" rx="10" fill="#F5A623" />
                <rect x="300" y="160" width="200" height="14" fill="#F5A623" />
                <text x="400" y="161" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="12"
                    font-weight="700" fill="#0F1C33">ScholarConnectMiddleware</text>

                <text x="315" y="197" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#8a9fc0">· fetch()
                    from 3 sources</text>
                <text x="315" y="213" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#8a9fc0">·
                    normalize JSON structure</text>
                <text x="315" y="229" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#8a9fc0">·
                    per-source try/catch</text>
                <text x="315" y="245" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#8a9fc0">·
                    graceful fallback</text>
                <text x="315" y="265" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#F5A623">ScholarConnectMiddleware.php</text>
                <text x="315" y="279" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#2a3f66">by
                    Minguez</text>
                <text x="315" y="295" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#2a3f66">syncAll()
                    · fetch()</text>

                <!-- ════════════════════════════════
                 SYNC CONTROLLER  (admin trigger)
            ════════════════════════════════ -->
                <rect x="300" y="430" width="200" height="90" rx="10" fill="#152238" stroke="#2a3f66"
                    stroke-width="1" />
                <rect x="300" y="430" width="200" height="30" rx="10" fill="#2a3f66" />
                <rect x="300" y="446" width="200" height="14" fill="#2a3f66" />
                <text x="400" y="449" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="12"
                    font-weight="600" fill="#FFFFFF">SyncController</text>
                <text x="315" y="476" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#8a9fc0">· HTTP
                    POST /admin/sync</text>
                <text x="315" y="492" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#8a9fc0">· returns
                    JSON response</text>
                <text x="315" y="508" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#2a3f66">SyncController.php · run()</text>

                <!-- Admin → SyncController arrow -->
                <line x1="400" y1="430" x2="400" y2="400" stroke="#8a9fc0"
                    stroke-width="1" stroke-dasharray="4 3" marker-end="url(#arr-white)" />
                <text x="410" y="418" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#8a9fc0">Admin
                    click</text>

                <!-- Admin UI box (small) -->
                <rect x="340" y="372" width="120" height="28" rx="6" fill="#0F1C33" stroke="#2a3f66"
                    stroke-width="0.8" />
                <text x="400" y="390" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="11"
                    fill="#8a9fc0">Admin Dashboard</text>

                <!-- SyncController → Middleware dashed -->
                <line x1="400" y1="430" x2="400" y2="310" stroke="#8a9fc0"
                    stroke-width="0.8" stroke-dasharray="3 3" />

                <!-- ════════════════════════════════
                 ELOQUENT / MySQL  (center)
            ════════════════════════════════ -->
                <!-- Arrow: Middleware → DB -->
                <line x1="500" y1="210" x2="580" y2="210" stroke="#8a9fc0"
                    stroke-width="1.2" marker-end="url(#arr-white)" />
                <text x="536" y="203" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#8a9fc0">Eloquent</text>
                <text x="536" y="220" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#2a3f66">updateOrCreate()</text>

                <!-- MySQL container -->
                <rect x="580" y="140" width="180" height="170" rx="10" fill="#152238" stroke="#2a3f66"
                    stroke-width="1" />
                <rect x="580" y="140" width="180" height="34" rx="10" fill="#1a3055" />
                <rect x="580" y="160" width="180" height="14" fill="#1a3055" />
                <text x="670" y="161" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="12"
                    font-weight="600" fill="#FFFFFF">MySQL 8.0</text>

                <!-- Tables -->
                <rect x="596" y="184" width="148" height="22" rx="4" fill="#0F1C33" stroke="#2a3f66"
                    stroke-width="0.5" />
                <text x="670" y="199" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#8a9fc0">scholarships</text>

                <rect x="596" y="212" width="148" height="22" rx="4" fill="#0F1C33" stroke="#2a3f66"
                    stroke-width="0.5" />
                <text x="670" y="227" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#8a9fc0">users (students)</text>

                <rect x="596" y="240" width="148" height="22" rx="4" fill="#0F1C33" stroke="#2a3f66"
                    stroke-width="0.5" />
                <text x="670" y="255" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#8a9fc0">notifications</text>

                <rect x="596" y="268" width="148" height="22" rx="4" fill="#0F1C33" stroke="#2a3f66"
                    stroke-width="0.5" />
                <text x="670" y="283" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#8a9fc0">jobs (queue)</text>

                <text x="596" y="305" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#2a3f66">Villafranca — schema/models</text>

                <!-- ════════════════════════════════
                 NOTIFICATION SERVICE  (below DB)
            ════════════════════════════════ -->
                <!-- Arrow: DB → NotificationService -->
                <line x1="670" y1="310" x2="670" y2="370" stroke="#8a9fc0"
                    stroke-width="1.2" marker-end="url(#arr-white)" />
                <text x="683" y="343" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#8a9fc0">studentMatches()</text>

                <rect x="580" y="370" width="180" height="120" rx="10" fill="#152238" stroke="#2a3f66"
                    stroke-width="1" />
                <rect x="580" y="370" width="180" height="30" rx="10" fill="#1a3055" />
                <rect x="580" y="386" width="180" height="14" fill="#1a3055" />
                <text x="670" y="389" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="12"
                    font-weight="600" fill="#FFFFFF">NotificationService</text>
                <text x="596" y="415" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#8a9fc0">· match
                    by course</text>
                <text x="596" y="431" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#8a9fc0">· match
                    by year level</text>
                <text x="596" y="447" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#8a9fc0">·
                    duplicate check</text>
                <text x="596" y="463" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#8a9fc0">·
                    dispatchAlerts()</text>
                <text x="596" y="479" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#2a3f66">NotificationService.php</text>

                <!-- ════════════════════════════════
                 MAILTRAP  (right, bottom)
            ════════════════════════════════ -->
                <!-- Arrow: NotificationService → Mailtrap -->
                <line x1="760" y1="430" x2="840" y2="430" stroke="#e05c5c"
                    stroke-width="1.2" marker-end="url(#arr-coral)" />
                <text x="796" y="422" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#e05c5c">SMTP</text>
                <text x="796" y="442" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#2a3f66">Mail::to()->send()</text>

                <rect x="840" y="390" width="150" height="90" rx="10" fill="#152238" stroke="#2a3f66"
                    stroke-width="1" />
                <rect x="840" y="390" width="150" height="30" rx="10" fill="#2c1a1a" />
                <rect x="840" y="406" width="150" height="14" fill="#2c1a1a" />
                <text x="915" y="409" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="12"
                    font-weight="600" fill="#e05c5c">Mailtrap</text>
                <text x="855" y="436" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#8a9fc0">MAIL_HOST=</text>
                <text x="855" y="450" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#8a9fc0">smtp.mailtrap.io</text>
                <text x="855" y="468" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#2a3f66">Scholarship alert email</text>

                <!-- ════════════════════════════════
                 STUDENT EMAIL (inbox icon area)
            ════════════════════════════════ -->
                <line x1="915" y1="390" x2="915" y2="330" stroke="#e05c5c"
                    stroke-width="1" stroke-dasharray="4 3" marker-end="url(#arr-coral)" />
                <rect x="855" y="290" width="120" height="38" rx="8" fill="#0F1C33" stroke="#e05c5c"
                    stroke-width="0.8" />
                <text x="915" y="307" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="11"
                    fill="#e05c5c">Student Email</text>
                <text x="915" y="321" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#8a9fc0">Scholarship alert</text>

                <!-- ════════════════════════════════
                 BLADE VIEWS / STUDENT DASHBOARD (right)
            ════════════════════════════════ -->
                <!-- Arrow: DB → Blade -->
                <line x1="760" y1="210" x2="840" y2="210" stroke="#8a9fc0"
                    stroke-width="1.2" marker-end="url(#arr-white)" />
                <text x="796" y="202" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#8a9fc0">Eloquent</text>

                <rect x="840" y="140" width="150" height="130" rx="10" fill="#152238" stroke="#2a3f66"
                    stroke-width="1" />
                <rect x="840" y="140" width="150" height="30" rx="10" fill="#1a2e1a" />
                <rect x="840" y="156" width="150" height="14" fill="#1a2e1a" />
                <text x="915" y="159" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="12"
                    font-weight="600" fill="#2ecc8a">Blade Views</text>
                <text x="855" y="187" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#8a9fc0">· Student
                    dashboard</text>
                <text x="855" y="203" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#8a9fc0">· Browse
                    scholarships</text>
                <text x="855" y="219" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#8a9fc0">· Admin
                    dashboard</text>
                <text x="855" y="235" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#8a9fc0">·
                    Notifications list</text>
                <text x="855" y="255" font-family="'IBM Plex Mono',monospace" font-size="10" fill="#2a3f66">Lagrosa ·
                    Abiera</text>

                <!-- Student → Views arrow (student browsing) -->
                <line x1="915" y1="270" x2="915" y2="290" stroke="#8a9fc0"
                    stroke-width="0.8" stroke-dasharray="3 3" />
                <line x1="915" y1="270" x2="980" y2="270" stroke="#8a9fc0"
                    stroke-width="1" marker-end="url(#arr-white)" />
                <rect x="980" y="254" width="24" height="24" rx="12" fill="#1a3055" stroke="#8a9fc0"
                    stroke-width="0.8" />
                <text x="992" y="270" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="13"
                    fill="#8a9fc0" dominant-baseline="central">👤</text>
                <text x="992" y="292" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="9"
                    fill="#2a3f66">student</text>

                <!-- Queue worker label -->
                <rect x="32" y="400" width="190" height="44" rx="8" fill="#0F1C33" stroke="#2a3f66"
                    stroke-width="0.8" />
                <text x="127" y="418" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="11"
                    fill="#8a9fc0">Queue Worker</text>
                <text x="127" y="434" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#2a3f66">php artisan queue:work</text>

                <!-- Queue worker → NotificationService -->
                <line x1="222" y1="422" x2="580" y2="430" stroke="#2a3f66"
                    stroke-width="0.8" stroke-dasharray="4 3" />

                <!-- entrypoint label -->
                <rect x="32" y="460" width="190" height="44" rx="8" fill="#0F1C33" stroke="#2a3f66"
                    stroke-width="0.8" />
                <text x="127" y="478" text-anchor="middle" font-family="'IBM Plex Sans',sans-serif" font-size="11"
                    fill="#8a9fc0">entrypoint.sh</text>
                <text x="127" y="494" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="10"
                    fill="#2a3f66">composer · key · migrate · seed</text>

                <!-- localhost:8000 label -->
                <rect x="32" y="520" width="190" height="30" rx="6" fill="#F5A623" stroke="none" />
                <text x="127" y="539" text-anchor="middle" font-family="'IBM Plex Mono',monospace" font-size="11"
                    font-weight="700" fill="#0F1C33">localhost:8000</text>

            </svg>
        </div>

        <!-- Legend -->
        <div class="legend">
            <div class="legend-item">
                <div class="legend-dot" style="background:#4d9de0"></div>
                CHED data flow
            </div>
            <div class="legend-item">
                <div class="legend-dot" style="background:#2ecc8a"></div>
                DOST-SEI data flow
            </div>
            <div class="legend-item">
                <div class="legend-dot" style="background:#F5A623"></div>
                LGU data flow / key components
            </div>
            <div class="legend-item">
                <div class="legend-dot" style="background:#e05c5c"></div>
                Email (SMTP)
            </div>
            <div class="legend-item">
                <div class="legend-dot" style="background:#8a9fc0"></div>
                Internal Laravel / Eloquent
            </div>
            <div class="legend-item">
                <div class="legend-dot" style="background:#2a3f66"></div>
                Background / supporting services
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="team">
                <div class="member">
                    <strong>Minguez</strong>
                    <span>Lead Architect<br>ScholarConnectMiddleware</span>
                </div>
                <div class="member">
                    <strong>Villafranca</strong>
                    <span>Backend Developer<br>Schema · Models · Logic</span>
                </div>
                <div class="member">
                    <strong>Lagrosa</strong>
                    <span>Frontend Developer<br>Student UI · Browse</span>
                </div>
                <div class="member">
                    <strong>Abiera</strong>
                    <span>Frontend Developer<br>Admin Dashboard · Charts</span>
                </div>
            </div>
            <div class="school">
                <strong>Camarines Norte State College</strong>
                IT 111 · BSIT 2A · {{ date('Y') }}
            </div>
        </div>

    </div>

    <!-- Print button (hidden on print) -->
    <button class="print-btn no-print" onclick="window.print()">⎙ Print / Save as PDF</button>

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy-primary: #1B2A47;
            --navy-dark: #0F1C33;
            --amber: #F5A623;
            --amber-hover: #d48f1c;
            --text-muted: #B0BEC5;
            --bg-main: #F4F6F9;
            --sidebar-width: 240px;
        }

        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            background: var(--bg-main);
        }

        /* ── Layout wrapper ── */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
            min-width: 0;
            /* ← add this */
            overflow-x: hidden;
            /* ← add this */
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--navy-dark);
            display: flex;
            flex-direction: column;
            padding: 1.5rem 1rem;
            flex-shrink: 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: hidden;
            overflow-x: hidden;
            z-index: 100;
        }

        .sidebar-brand {
            color: var(--amber);
            font-size: 1.1rem;
            font-weight: 700;
            text-decoration: none;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            /* ← allows badge to wrap */
            gap: 6px;
            padding: 0 0.5rem;
        }

        .sidebar .nav-link {
            color: var(--text-muted);
            padding: 0.6rem 1rem;
            border-radius: 8px;
            margin-bottom: 4px;
            transition: all 0.2s;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
        }

        .sidebar .nav-link.active {
            background: var(--amber);
            color: var(--navy-dark);
            font-weight: 600;
        }

        .sidebar-avatar {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.06);
            margin-bottom: 0.75rem;
        }

        .avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--amber);
            color: var(--navy-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .avatar-name {
            color: #fff;
            font-size: 0.82rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 130px;
        }

        .avatar-role {
            color: var(--text-muted);
            font-size: 0.72rem;
        }

        .logout-btn {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: var(--text-muted);
            width: 100%;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s;
            font-size: 0.85rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .logout-btn:hover {
            border-color: var(--amber);
            color: var(--amber);
        }

        /* ── Main content ── */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
            width: calc(100% - var(--sidebar-width));
        }

        /* ── Shared utilities ── */
        .btn-amber {
            background: var(--amber);
            color: var(--navy-dark);
            font-weight: 600;
            border: none;
        }

        .btn-amber:hover {
            background: var(--amber-hover);
            color: var(--navy-dark);
        }

        .section-title {
            color: var(--navy-dark);
            font-weight: 700;
            font-size: 1.2rem;
        }

        .admin-badge {
            display: inline-block;
            background: rgba(245, 166, 35, 0.15);
            color: var(--amber);
            font-size: 0.62rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            padding: 2px 6px;
            border-radius: 20px;
            margin-left: 0;
            /* ← removed, gap handles spacing */
            border: 1px solid rgba(245, 166, 35, 0.3);
            white-space: nowrap;
            /* ← badge text won't break mid-word */
            flex-shrink: 0;
            /* ← badge won't get squished */
        }
    </style>
</head>

<body>
    <div class="admin-wrapper">

        {{-- ── Sidebar ── --}}
        <aside class="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <i class="bi bi-mortarboard-fill"></i> ScholarConnect
                <span class="admin-badge">Admin</span>
            </a>

            <nav class="nav flex-column flex-grow-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('admin.scholarships') }}"
                    class="nav-link {{ request()->routeIs('admin.scholarships*') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark"></i> Scholarships
                </a>
                <a href="{{ route('admin.sync') }}"
                    class="nav-link {{ request()->routeIs('admin.sync') ? 'active' : '' }}">
                    <i class="bi bi-arrow-repeat"></i> Sync Now
                </a>
                <a href="{{ route('admin.sync-logs') }}"
                    class="nav-link {{ request()->routeIs('admin.sync-logs') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> Sync Logs
                </a>
            </nav>

            <div class="mt-auto pt-3">
                <div class="sidebar-avatar">
                    <div class="avatar-circle">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="avatar-name">
                            {{ explode(' ', auth()->user()->name)[0] }}
                        </div>
                        <div class="avatar-role">Administrator</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- ── Page content ── --}}
        <main class="main-content">
            @yield('content')
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>

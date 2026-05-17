<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} — Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy-primary: #1B2A47;
            --navy-dark: #0F1C33;
            --amber: #F5A623;
            --amber-hover: #d48f1c;
        }

        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        body {
            background: #F4F6F9;
            min-height: 100vh;
            display: flex;
            margin: 0;
        }

        /* Left Panel */
        .left-panel {
            width: 45%;
            background: var(--navy-dark);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 300px;
            height: 300px;
            background: rgba(245, 166, 35, 0.06);
            border-radius: 50%;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 220px;
            height: 220px;
            background: rgba(245, 166, 35, 0.05);
            border-radius: 50%;
        }

        .brand-logo {
            color: var(--amber);
            font-size: 1.4rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 2.5rem;
        }

        .left-panel h2 {
            color: #fff;
            font-weight: 700;
            font-size: 1.6rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .left-panel p {
            color: #B0BEC5;
            text-align: center;
            font-size: 0.88rem;
            line-height: 1.7;
            max-width: 280px;
        }

        .admin-badge-panel {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(245, 166, 35, 0.12);
            border: 1px solid rgba(245, 166, 35, 0.25);
            color: var(--amber);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 20px;
            margin-bottom: 2rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        /* Right Panel */
        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
        }

        .login-card h4 {
            color: var(--navy-dark);
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .login-card .subtitle {
            color: #B0BEC5;
            font-size: 0.83rem;
            margin-bottom: 2rem;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--navy-dark);
            margin-bottom: 0.4rem;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            font-size: 0.88rem;
            padding: 0.6rem 0.9rem;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: var(--amber);
            box-shadow: 0 0 0 3px rgba(245, 166, 35, 0.12);
        }

        .btn-amber {
            background: var(--amber);
            color: var(--navy-dark);
            font-weight: 700;
            border: none;
            border-radius: 8px;
            padding: 0.7rem;
            font-size: 0.95rem;
            width: 100%;
            transition: background 0.2s;
        }

        .btn-amber:hover {
            background: var(--amber-hover);
            color: var(--navy-dark);
        }

        .back-link {
            color: #B0BEC5;
            font-size: 0.78rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 1.25rem;
            justify-content: center;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--navy-dark);
        }

        @media (max-width: 768px) {
            .left-panel {
                display: none;
            }

            body {
                justify-content: center;
                align-items: center;
            }
        }
    </style>
</head>

<body>

    {{-- Left Panel --}}
    <div class="left-panel">
        <div class="brand-logo">
            <i class="bi bi-mortarboard-fill"></i> ScholarConnect
        </div>
        <div class="admin-badge-panel">
            <i class="bi bi-shield-lock-fill"></i> Admin Portal
        </div>
        <h2>Welcome Back,<br>Administrator</h2>
        <p>Manage scholarships, sync data from API sources, and monitor student alerts — all in one place.</p>
    </div>

    {{-- Right Panel --}}
    <div class="right-panel">
        <div class="login-card">
            <h4>Admin Sign In</h4>
            <div class="subtitle">Enter your admin credentials to continue.</div>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger py-2 mb-3" style="font-size:0.82rem;border-radius:8px;">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="admin@scholarconnect.test" required autofocus>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-amber">
                    <i class="bi bi-shield-lock me-1"></i> Sign In as Admin
                </button>
            </form>

            <a href="{{ route('login') }}" class="back-link">
                <i class="bi bi-arrow-left"></i> Back to Student Login
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

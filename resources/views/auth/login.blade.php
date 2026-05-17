<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarConnect - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --navy-primary: #1B2A47;
            --navy-dark: #0F1C33;
            --amber: #F5A623;
            --amber-hover: #d48f1c;
            --bg-main: #F4F6F9;
            --input-bg: #F0F2F5;
        }

        body {
            margin: 0;
            background-color: var(--bg-main);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar {
            background-color: #ffffff;
            padding: 0.8rem 5%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        .brand-container {
            display: flex;
            align-items: center;
        }

        .brand-icon {
            font-size: 1.8rem;
            color: var(--amber);
            margin-right: 10px;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .brand-name {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--navy-dark);
        }

        .brand-sub {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-links a:hover {
            color: var(--amber);
        }

        .btn-register {
            background-color: var(--amber);
            color: white !important;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            font-weight: 600 !important;
            transition: 0.2s;
        }

        .btn-register:hover {
            background-color: var(--amber-hover);
        }

        /* Main Content */
        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        /* Card */
        .login-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            display: flex;
            width: 100%;
            max-width: 900px;
            overflow: hidden;
        }

        /* Card Left */
        .card-left {
            background-color: var(--navy-primary);
            width: 50%;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            color: white;
        }

        .card-left .image-wrapper {
            width: 100%;
            height: 220px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .card-left .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-left h3 {
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 0.8rem;
        }

        .card-left p {
            font-size: 0.9rem;
            font-weight: 300;
            line-height: 1.5;
            padding: 0 1rem;
            color: #B0BEC5;
        }

        /* Card Right */
        .card-right {
            width: 50%;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card-right h2 {
            font-weight: 600;
            color: var(--navy-dark);
            font-size: 1.6rem;
            margin-bottom: 0.3rem;
        }

        .card-right .subtitle {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        /* Form */
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.4rem;
        }

        .form-control {
            background-color: var(--input-bg);
            border: none;
            border-radius: 8px;
            padding: 0.8rem 1rem;
            font-size: 0.9rem;
        }

        .form-control:focus {
            background-color: #e2e6ea;
            box-shadow: none;
            border: none;
        }

        .forgot-password {
            display: block;
            text-align: right;
            color: var(--amber);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: -0.5rem;
            margin-bottom: 1.5rem;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn-login {
            background-color: var(--navy-dark);
            color: white;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            padding: 0.8rem;
            width: 100%;
            font-size: 1rem;
            transition: 0.2s;
        }

        .btn-login:hover {
            background-color: var(--navy-primary);
            color: white;
        }

        .register-link {
            text-align: center;
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 1.5rem;
        }

        .register-link a {
            color: var(--amber);
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
            }

            .card-left,
            .card-right {
                width: 100%;
            }

            .card-right {
                padding: 2rem;
            }

            .nav-links {
                display: none;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar d-flex justify-content-between align-items-center">
        <div class="brand-container">
            <i class="bi bi-mortarboard-fill brand-icon"></i>
            <div class="brand-text">
                <span class="brand-name">ScholarConnect</span>
                <span class="brand-sub">Camarines Norte</span>
            </div>
        </div>

        <div class="nav-links d-none d-md-flex">
            <a href="{{ route('browse') }}">Browse</a>
            <a href="{{ route('about') }}">About</a>
        </div>

        <div class="nav-links">
            <a href="{{ route('login') }}" style="color: var(--navy-dark); font-weight: 600;">Login</a>
            <a href="{{ route('register') }}" class="btn-register">Register</a>
        </div>
    </nav>

    <div class="main-container">
        <div class="login-card">

            <div class="card-left">
                <div class="image-wrapper">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                        alt="Student Studying">
                </div>
                <h3>Welcome Back!</h3>
                <p>Access your personalized scholarship recommendations and track your applications</p>
            </div>

            <div class="card-right">
                <h2>Login to Your Account</h2>
                <p class="subtitle">Enter your credentials to access your dashboard</p>

                @if ($errors->any())
                    <div class="alert alert-danger mb-3" style="border-radius:8px; font-size:0.825rem;">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger mb-3" style="border-radius:8px; font-size:0.825rem;">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="juan.delacruz@email.com" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Enter your password" required>
                    </div>

                    <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>

                    <button type="submit" class="btn-login">Login</button>

                    <div class="register-link">
                        Don't have an account? <a href="{{ route('register') }}">Register here</a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

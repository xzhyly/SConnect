<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'ScholarConnect') }} - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
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

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background-color: var(--bg-main);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Navbar ── */
        .top-navbar {
            background-color: #ffffff;
            padding: 0.8rem 5%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            position: relative;
        }

        .brand-container {
            display: flex;
            align-items: center;
            text-decoration: none;
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

        .btn-nav-login {
            color: #333;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
        }

        .btn-nav-register {
            background-color: var(--amber);
            color: white !important;
            padding: 0.45rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-nav-register:hover {
            background-color: var(--amber-hover);
            color: white;
        }

        /* ── Main ── */
        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 2.5rem 1rem 300px 1rem;
        }

        /* ── Card ── */
        .register-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            display: flex;
            width: 100%;
            max-width: 1100px;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        /* ── Left Panel ── */
        .card-left {
            background-color: var(--navy-primary);
            width: 45%;
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            color: white;
            justify-content: center;
        }

        .card-left .image-wrapper {
            width: 100%;
            height: 280px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .card-left .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 30%;
        }

        .card-left h3 {
            font-weight: 600;
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
        }

        .card-left p {
            font-size: 0.85rem;
            font-weight: 300;
            line-height: 1.6;
            padding: 0 1rem;
            color: #B0BEC5;
            margin-bottom: 0;
        }

        /* ── Right Panel ── */
        .card-right {
            width: 55%;
            padding: 2rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card-right h2 {
            font-weight: 700;
            color: var(--navy-dark);
            font-size: 1.6rem;
            margin-bottom: 0.2rem;
        }

        .card-right .subtitle {
            color: #6c757d;
            font-size: 0.85rem;
            margin-bottom: 1.2rem;
        }

        /* ── Form Elements ── */
        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #444;
            margin-bottom: 0.25rem;
        }

        .form-control {
            background-color: var(--input-bg);
            border: 1.5px solid transparent;
            border-radius: 8px;
            padding: 0.55rem 0.8rem;
            font-size: 0.85rem;
            color: #495057;
            box-shadow: none;
            transition: border-color 0.2s;
            font-family: 'Poppins', sans-serif;
            min-height: 42px;
        }

        .form-control:focus {
            background-color: #e8eaed;
            border-color: var(--amber);
            box-shadow: none;
            outline: none;
        }

        /* ── Tom Select Overrides ── */
        .ts-wrapper .ts-control {
            background-color: var(--input-bg);
            border: 1.5px solid transparent;
            border-radius: 8px;
            padding: 0.55rem 0.8rem;
            font-size: 0.85rem;
            font-family: 'Poppins', sans-serif;
            color: #495057;
            box-shadow: none;
            min-height: 42px;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .ts-wrapper.focus .ts-control {
            background-color: #e8eaed;
            border-color: var(--amber);
            box-shadow: none;
        }

        .ts-dropdown {
            border-radius: 8px;
            font-size: 0.85rem;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
            margin-top: 4px;
        }

        .ts-dropdown .ts-dropdown-content {
            max-height: 280px !important;
            overflow-y: auto !important;
        }

        .ts-dropdown .active {
            background-color: rgba(245, 166, 35, 0.15) !important;
            color: var(--navy-dark) !important;
        }

        .ts-wrapper .ts-control .placeholder {
            color: #adb5bd;
            font-size: 0.85rem;
        }

        /* ── Submit Button ── */
        .btn-register-submit {
            background-color: var(--amber);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 0.7rem;
            width: 100%;
            font-size: 0.95rem;
            transition: 0.2s;
            margin-top: 0.8rem;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
        }

        .btn-register-submit:hover {
            background-color: var(--amber-hover);
        }

        /* ── Login Link ── */
        .login-link {
            text-align: center;
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 1rem;
        }

        .login-link a {
            color: var(--amber);
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* ── Alert ── */
        .alert-custom {
            border-radius: 8px;
            font-size: 0.8rem;
            background-color: #fee2e2;
            border: none;
            color: #991b1b;
            padding: 0.5rem 0.75rem;
            margin-bottom: 0.75rem;
        }

        @media (max-width: 768px) {
            .register-card {
                flex-direction: column;
            }

            .card-left,
            .card-right {
                width: 100%;
            }

            .card-right {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>

    <nav class="top-navbar">
        <a href="{{ route('login') }}" class="brand-container">
            <i class="bi bi-mortarboard-fill brand-icon"></i>
            <div class="brand-text">
                <span class="brand-name">ScholarConnect</span>
                <span class="brand-sub">Camarines Norte</span>
            </div>
        </a>
        <div class="nav-links d-none d-md-flex">
            <a href="{{ route('browse') }}">Browse</a>
            <a href="#">About</a>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <a href="{{ route('login') }}" class="btn-nav-login">Login</a>
            <a href="{{ route('register') }}" class="btn-nav-register">Register</a>
        </div>
    </nav>

    <div class="main-container">
        <div class="register-card">

            <div class="card-left">
                <div class="image-wrapper">
                    <img src="{{ asset('images/graduation.jpg') }}" alt="Students Graduating">
                </div>
                <h3>Start Your Journey</h3>
                <p>Register now to discover scholarships that match your profile and academic goals</p>
            </div>

            <div class="card-right">
                <h2>Create Your Account</h2>
                <p class="subtitle">Join ScholarConnect and find opportunities in Camarines Norte</p>

                @if ($errors->any())
                    <div class="alert-custom">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-2">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control"
                            placeholder="Juan Dela Cruz" value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="mb-2">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="juan.delacruz@email.com" value="{{ old('email') }}" required>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="••••••••" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control" placeholder="••••••••" required>
                        </div>
                    </div>

                    {{-- Municipality + Barangay --}}
                    <div class="row mb-2 align-items-start">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <label for="municipality" class="form-label">Municipality</label>
                            <select id="municipality" name="municipality" class="form-select" required>
                                <option value="Basud" {{ old('municipality') == 'Basud' ? 'selected' : '' }}>Basud</option>
                                <option value="Capalonga" {{ old('municipality') == 'Capalonga' ? 'selected' : '' }}>
                                    Capalonga</option>
                                <option value="Daet" {{ old('municipality') == 'Daet' ? 'selected' : '' }}>Daet</option>
                                <option value="Jose Panganiban"
                                    {{ old('municipality') == 'Jose Panganiban' ? 'selected' : '' }}>Jose Panganiban</option>
                                <option value="Labo" {{ old('municipality') == 'Labo' ? 'selected' : '' }}>Labo</option>
                                <option value="Mercedes" {{ old('municipality') == 'Mercedes' ? 'selected' : '' }}>Mercedes
                                </option>
                                <option value="Paracale" {{ old('municipality') == 'Paracale' ? 'selected' : '' }}>Paracale
                                </option>
                                <option value="San Lorenzo Ruiz"
                                    {{ old('municipality') == 'San Lorenzo Ruiz' ? 'selected' : '' }}>San Lorenzo Ruiz
                                </option>
                                <option value="San Vicente" {{ old('municipality') == 'San Vicente' ? 'selected' : '' }}>San
                                    Vicente</option>
                                <option value="Santa Elena" {{ old('municipality') == 'Santa Elena' ? 'selected' : '' }}>
                                    Santa Elena</option>
                                <option value="Talisay" {{ old('municipality') == 'Talisay' ? 'selected' : '' }}>Talisay
                                </option>
                                <option value="Vinzons" {{ old('municipality') == 'Vinzons' ? 'selected' : '' }}>Vinzons
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="barangay" class="form-label">Barangay</label>
                            <select id="barangay" name="barangay" class="form-select" required>
                            </select>
                        </div>
                    </div>

                    {{-- Academic Program --}}
                    <div class="mb-2">
                        <label for="course" class="form-label">Academic Program</label>
                        <select id="course" name="course" class="form-select" required>
                            <option value="" disabled selected>Select program</option>
                            <optgroup label="Engineering & Technology">
                                <option value="BSIT" {{ old('course') == 'BSIT' ? 'selected' : '' }}>BS Information
                                    Technology</option>
                                <option value="BSCS" {{ old('course') == 'BSCS' ? 'selected' : '' }}>BS Computer Science
                                </option>
                                <option value="BSCE" {{ old('course') == 'BSCE' ? 'selected' : '' }}>BS Civil Engineering
                                </option>
                                <option value="BSEE" {{ old('course') == 'BSEE' ? 'selected' : '' }}>BS Electrical
                                    Engineering</option>
                                <option value="BSME" {{ old('course') == 'BSME' ? 'selected' : '' }}>BS Mechanical
                                    Engineering</option>
                                <option value="BSCpE" {{ old('course') == 'BSCpE' ? 'selected' : '' }}>BS Computer
                                    Engineering</option>
                                <option value="BSECE" {{ old('course') == 'BSECE' ? 'selected' : '' }}>BS Electronics
                                    Engineering</option>
                                <option value="BSIE" {{ old('course') == 'BSIE' ? 'selected' : '' }}>BS Industrial
                                    Engineering</option>
                                <option value="BSAE" {{ old('course') == 'BSAE' ? 'selected' : '' }}>BS Agricultural
                                    Engineering</option>
                            </optgroup>
                            <optgroup label="Business & Accountancy">
                                <option value="BSBA" {{ old('course') == 'BSBA' ? 'selected' : '' }}>BS Business
                                    Administration</option>
                                <option value="BSA" {{ old('course') == 'BSA' ? 'selected' : '' }}>BS Accountancy
                                </option>
                                <option value="BSMA" {{ old('course') == 'BSMA' ? 'selected' : '' }}>BS Management
                                    Accounting</option>
                                <option value="BSFM" {{ old('course') == 'BSFM' ? 'selected' : '' }}>BS Financial
                                    Management</option>
                                <option value="BSEntrep" {{ old('course') == 'BSEntrep' ? 'selected' : '' }}>BS
                                    Entrepreneurship</option>
                                <option value="BSHM" {{ old('course') == 'BSHM' ? 'selected' : '' }}>BS Hospitality
                                    Management</option>
                                <option value="BSTM" {{ old('course') == 'BSTM' ? 'selected' : '' }}>BS Tourism Management
                                </option>
                                <option value="BSOA" {{ old('course') == 'BSOA' ? 'selected' : '' }}>BS Office
                                    Administration</option>
                            </optgroup>
                            <optgroup label="Education">
                                <option value="BEED" {{ old('course') == 'BEED' ? 'selected' : '' }}>BS Elementary
                                    Education</option>
                                <option value="BSED-English" {{ old('course') == 'BSED-English' ? 'selected' : '' }}>BS
                                    Secondary Education - English</option>
                                <option value="BSED-Math" {{ old('course') == 'BSED-Math' ? 'selected' : '' }}>BS Secondary
                                    Education - Math</option>
                                <option value="BSED-Science" {{ old('course') == 'BSED-Science' ? 'selected' : '' }}>BS
                                    Secondary Education - Science</option>
                                <option value="BSED-Filipino" {{ old('course') == 'BSED-Filipino' ? 'selected' : '' }}>BS
                                    Secondary Education - Filipino</option>
                                <option value="BSED-Socstud" {{ old('course') == 'BSED-Socstud' ? 'selected' : '' }}>BS
                                    Secondary Education - Social Studies</option>
                                <option value="BSED-TLE" {{ old('course') == 'BSED-TLE' ? 'selected' : '' }}>BS Secondary
                                    Education - TLE</option>
                                <option value="BSPE" {{ old('course') == 'BSPE' ? 'selected' : '' }}>BS Physical Education
                                </option>
                            </optgroup>
                            <optgroup label="Health Sciences">
                                <option value="BSN" {{ old('course') == 'BSN' ? 'selected' : '' }}>BS Nursing</option>
                                <option value="BSMT" {{ old('course') == 'BSMT' ? 'selected' : '' }}>BS Medical Technology
                                </option>
                                <option value="BSPT" {{ old('course') == 'BSPT' ? 'selected' : '' }}>BS Physical Therapy
                                </option>
                                <option value="BSPHAR" {{ old('course') == 'BSPHAR' ? 'selected' : '' }}>BS Pharmacy
                                </option>
                                <option value="BSND" {{ old('course') == 'BSND' ? 'selected' : '' }}>BS Nutrition &
                                    Dietetics</option>
                                <option value="BSMID" {{ old('course') == 'BSMID' ? 'selected' : '' }}>BS Midwifery
                                </option>
                                <option value="BSRAD" {{ old('course') == 'BSRAD' ? 'selected' : '' }}>BS Radiologic
                                    Technology</option>
                            </optgroup>
                            <optgroup label="Agriculture & Environment">
                                <option value="BSAg" {{ old('course') == 'BSAg' ? 'selected' : '' }}>BS Agriculture
                                </option>
                                <option value="BSF" {{ old('course') == 'BSF' ? 'selected' : '' }}>BS Forestry</option>
                                <option value="BSFISH" {{ old('course') == 'BSFISH' ? 'selected' : '' }}>BS Fisheries
                                </option>
                                <option value="BSENR" {{ old('course') == 'BSENR' ? 'selected' : '' }}>BS Environmental
                                    Science</option>
                                <option value="BSABN" {{ old('course') == 'BSABN' ? 'selected' : '' }}>BS Animal Science
                                </option>
                            </optgroup>
                            <optgroup label="Arts & Social Sciences">
                                <option value="ABCOM" {{ old('course') == 'ABCOM' ? 'selected' : '' }}>AB Communication
                                </option>
                                <option value="ABPOL" {{ old('course') == 'ABPOL' ? 'selected' : '' }}>AB Political Science
                                </option>
                                <option value="ABSOC" {{ old('course') == 'ABSOC' ? 'selected' : '' }}>AB Sociology
                                </option>
                                <option value="ABPSYCH" {{ old('course') == 'ABPSYCH' ? 'selected' : '' }}>AB Psychology
                                </option>
                                <option value="BSSW" {{ old('course') == 'BSSW' ? 'selected' : '' }}>BS Social Work
                                </option>
                                <option value="BSPSY" {{ old('course') == 'BSPSY' ? 'selected' : '' }}>BS Psychology
                                </option>
                            </optgroup>
                            <optgroup label="Law & Criminology">
                                <option value="BSCRIM" {{ old('course') == 'BSCRIM' ? 'selected' : '' }}>BS Criminology
                                </option>
                                <option value="JD" {{ old('course') == 'JD' ? 'selected' : '' }}>Juris Doctor (Law)
                                </option>
                            </optgroup>
                            <optgroup label="Maritime">
                                <option value="BSMARE" {{ old('course') == 'BSMARE' ? 'selected' : '' }}>BS Marine
                                    Engineering</option>
                                <option value="BSMART" {{ old('course') == 'BSMART' ? 'selected' : '' }}>BS Marine
                                    Transportation</option>
                            </optgroup>
                            <optgroup label="Architecture & Fine Arts">
                                <option value="BSARCH" {{ old('course') == 'BSARCH' ? 'selected' : '' }}>BS Architecture
                                </option>
                                <option value="BSFA" {{ old('course') == 'BSFA' ? 'selected' : '' }}>BS Fine Arts</option>
                                <option value="BSID" {{ old('course') == 'BSID' ? 'selected' : '' }}>BS Interior Design
                                </option>
                            </optgroup>
                            <optgroup label="Technical & Vocational">
                                <option value="BTVTED" {{ old('course') == 'BTVTED' ? 'selected' : '' }}>BS
                                    Technical-Vocational Teacher Education</option>
                                <option value="BSND-Tech" {{ old('course') == 'BSND-Tech' ? 'selected' : '' }}>Associate in
                                    Computer Technology</option>
                            </optgroup>
                        </select>
                    </div>

                    {{-- Academic Level + GWA --}}
                    <div class="row mb-2 align-items-start">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <label for="year_level" class="form-label">Academic Level</label>
                            <select id="year_level" name="year_level" class="form-select" required>
                                <option value="1" {{ old('year_level') == '1' ? 'selected' : '' }}>1st Year</option>
                                <option value="2" {{ old('year_level') == '2' ? 'selected' : '' }}>2nd Year</option>
                                <option value="3" {{ old('year_level') == '3' ? 'selected' : '' }}>3rd Year</option>
                                <option value="4" {{ old('year_level') == '4' ? 'selected' : '' }}>4th Year</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="gwa" class="form-label">Current GWA</label>
                            <input type="number" id="gwa" name="gwa" class="form-control"
                                placeholder="e.g. 1.75" value="{{ old('gwa') }}" min="1.00" max="5.00"
                                step="0.01" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-register-submit">Register</button>

                    <div class="login-link">
                        Already have an account? <a href="{{ route('login') }}">Log in here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; font-family: 'Poppins', sans-serif;">
                <div class="modal-body text-center p-5">
                    <div style="font-size: 4rem; color: #22c55e; margin-bottom: 1rem;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h4 style="font-weight: 700; color: var(--navy-dark); margin-bottom: 0.5rem;">Account Created!</h4>
                    <p style="color: #6c757d; font-size: 0.9rem; margin-bottom: 2rem;">
                        Your account has been created successfully. Please log in to continue.
                    </p>
                    <a href="{{ route('login') }}" class="btn-register-submit"
                        style="display: block; text-decoration: none; text-align: center;">
                        Go to Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <script>
        const barangays = {
            "Basud": ["Angas", "Bactas", "Binatagan", "Caayunan", "Guinatungan", "Hinampacan", "Langa", "Laniton",
                "Lumbang Caliente", "Lumbang Gabing", "Mabilo I", "Mabilo II", "Nakalaya", "Northern Poblacion",
                "Pag-Asa", "Patrol", "Plaridel", "Poblacion", "Salvacion", "San Antonio", "San Francisco",
                "San Isidro", "San Lorenzo", "San Roque", "Santa Cruz", "Santo Tomas", "Southern Poblacion",
                "Taba-Taba", "Taguilid"
            ],
            "Capalonga": ["Alayao", "Bia", "Biong", "Bolo", "Bugtong", "Cabugao", "Capalonga Poblacion", "Gahonon",
                "Gibong", "Itok", "Lucbanan", "Lugui", "Mabini", "Magsaysay", "Masalong", "Napaod", "Ortega",
                "San Antonio", "San Isidro", "San Ramon", "Santa Cruz", "Villa Aurora"
            ],
            "Daet": ["Alawihao", "Awitan", "Bagasbas", "Barangay I (Pob.)", "Barangay II (Pob.)", "Barangay III (Pob.)",
                "Barangay IV (Pob.)", "Barangay V (Pob.)", "Barangay VI (Pob.)", "Barangay VII (Pob.)",
                "Barangay VIII (Pob.)", "Camambugan", "Cobangbang (Caridad)", "Dogongan", "Galaxy", "Gubat",
                "Lag-on", "Magang", "Mambalite", "Mancruz (Mancrus)", "Pamorangon", "San Isidro", "Tagongtong",
                "Tamba", "Tungkos"
            ],
            "Jose Panganiban": ["Bagong Bayan", "Calero", "Dahican", "Dayhagan", "Guadalupe", "Larap", "Lubayat",
                "Mabini", "Magais I", "Magais II", "Mamburao", "Man-ogob", "Marcella", "Masalongsalong",
                "Mataas Na Bayan", "Nakalaya", "New Cagayan", "Osmeña", "Pag-asa", "Parang", "Plaridel",
                "Poblacion I", "Poblacion II", "Poblacion III", "Santa Cruz", "Santa Rosa Norte", "Santa Rosa Sur"
            ],
            "Labo": ["Anahaw", "Angas", "Apoloog", "Awitan", "Baay", "Bagacay", "Bagong Silang I", "Bagong Silang II",
                "Bagong Silang III", "Bahao", "Balayan", "Baleban", "Bayabas", "Cabatuan", "Cabusay", "Calabasa",
                "Calagbangan", "Calangcawan Norte", "Calangcawan Sur", "Canapawan", "Catabaguangan", "Catarauan",
                "Crossing Labo", "Dalas", "Gumamela", "Guisican", "Kalamunding", "La Purisima", "Laguinbanua Este",
                "Laguinbanua Oeste", "Logmao", "Lormal", "Lugui", "Mabilo I", "Mabilo II", "Malasugui", "Malagakit",
                "Malapit", "Mate", "Mbibini", "Napaod", "Pinya", "Ramos", "San Antonio", "San Francisco",
                "San Jose", "San Isidro", "Talobatib", "Tulay Na Lupa", "Union", "Villasocorro", "Wakas"
            ],
            "Mercedes": ["Apud", "Base", "Bulala", "Caayunan", "Dahican", "Dinagaan", "Fatima (Pob.)", "Gabon",
                "Hinampacan", "Huyonhuyon", "Imelda", "Labu-o", "Lagha", "Lanipga", "Magang", "Minalabac", "Napaod",
                "Pag-Asa", "Panganiban", "Pinagkamaligan", "Poblacion I", "Poblacion II", "Salingogon", "San Roque",
                "Tanawan", "Tigbinan"
            ],
            "Paracale": ["Awitan", "Bagumbayan", "Biong", "Boto", "Capalonga", "Catalotoan", "Dalnac", "Gahonon",
                "Guitol", "Jose Panganiban (Pob.)", "Labnig", "La Purisima (Pob.)", "Langga", "Lucbanan", "Mabilo",
                "Magsaysay", "Malacbang", "Malagakit", "Mampurog", "Manlimonsito", "Mataas Na Bayan", "Napaod",
                "Oro", "Paracale Poblacion", "Taffal", "Tobgon"
            ],
            "San Lorenzo Ruiz": ["Bagong Sikat", "Comadaycaday", "Comadogcadog", "Cotmon", "Doña Petra", "Huyonhuyon",
                "Landa", "Laniton", "Maagang", "Salvacion", "San Lorenzo Ruiz Poblacion", "Santa Cruz"
            ],
            "San Vicente": ["Aldezar", "Awo", "Batalay", "Del Pilar", "Hapitan", "Kaluklukan", "Magsaysay", "Salvacion",
                "San Vicente Poblacion"
            ],
            "Santa Elena": ["Angcogan", "Bahan", "Buhangin", "Bulhao", "Calagbagang", "Catalotoan", "Don Tomas",
                "Guitol", "Kabuluan", "Kagtalaba", "Maulawin", "Patag Ibaba", "Patag Iraya", "Plaridel",
                "Salvacion (Pob.)", "San Rafael", "Santa Elena Poblacion", "Tabugon", "Villa Docto"
            ],
            "Talisay": ["Banga", "Cataguintingan", "Dacu", "Del Carmen (Pob.)", "Dominorog", "Gatbo", "Hapitan",
                "Mabilo", "Nagsabaran", "Pag-Asa", "Panagatan", "Salvacion", "Sagrada", "San Roque",
                "Talisay Poblacion"
            ],
            "Vinzons": ["Aldezar", "Almiñe", "Alnay", "Alulo", "Awitan", "Baban", "Bagumbayan", "Benguet", "Bulala",
                "Bulawan", "Caawigan", "Caayunan", "Calabasa", "Calagbangan", "Calangcawan", "Capalonga",
                "Casalugan", "Dagang", "Dayhagan", "Del Pilar", "Eco", "Guitol", "Huyonhuyon", "Imelda", "Lahan",
                "Lanipga", "Mabini", "Mananap", "Maot", "Masalong", "Mataas Na Bayan", "Napaod", "Palanas",
                "Pinagkamaligan", "Poblacion I", "Poblacion II", "Salvacion", "San Isidro", "San Jose",
                "San Lorenzo", "San Roque", "Santa Cruz", "Tanauan", "Tigbinan", "Tulay Na Lupa", "Tulatula Norte",
                "Tulatula Sur", "Villa Aurora", "Vinzon", "Wawa"
            ]
        };

        document.addEventListener('DOMContentLoaded', function() {

            // Course — MAY search (maraming options)
            new TomSelect("#course", {
                create: false,
                maxOptions: null,
                placeholder: 'Select program'
            });

            // Year level — WALANG search (4 options lang)
            new TomSelect("#year_level", {
                create: false,
                controlInput: null,
                maxOptions: null,
                placeholder: 'Select level'
            });

            // Municipality — WALANG search
            let munSelect = new TomSelect("#municipality", {
                create: false,
                controlInput: null,
                maxOptions: null,
                placeholder: 'Select municipality'
            });

            // Barangay — dynamic, WALANG search
            let barSelect = new TomSelect("#barangay", {
                create: false,
                controlInput: null,
                maxOptions: null,
                placeholder: 'Select barangay',
                valueField: 'id',
                labelField: 'title',
                searchField: 'title',
                options: []
            });

            // On municipality change — populate barangays
            munSelect.on('change', function(val) {
                barSelect.clearOptions();
                barSelect.clear();
                if (val && barangays[val]) {
                    const options = barangays[val].map(b => ({
                        id: b,
                        title: b
                    }));
                    barSelect.addOptions(options);
                    const oldBarangay = "{{ old('barangay') }}";
                    if (oldBarangay && barangays[val].includes(oldBarangay)) {
                        barSelect.setValue(oldBarangay);
                    }
                }
            });

            // On page load — restore old value if validation error
            const initialMun = munSelect.getValue();
            if (initialMun && barangays[initialMun]) {
                const options = barangays[initialMun].map(b => ({
                    id: b,
                    title: b
                }));
                barSelect.addOptions(options);
                const oldBarangay = "{{ old('barangay') }}";
                if (oldBarangay && barangays[initialMun].includes(oldBarangay)) {
                    barSelect.setValue(oldBarangay);
                }
            }
        });
        // Auto-show success modal
        @if (session('success'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            setTimeout(function() {
                window.location.href = "{{ route('login') }}";
            }, 3000);
        @endif
    </script>

</body>

</html>

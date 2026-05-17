@extends('layouts.student')

@section('content')
    <style>
        .profile-header {
            margin-bottom: 1.5rem;
        }

        .profile-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1B2A47;
        }

        .profile-subtitle {
            color: #6c757d;
            font-size: 0.85rem;
            margin-top: 0.2rem;
        }

        .profile-section {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            margin-bottom: 1.25rem;
        }

        .section-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: #F5A623;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #F0F2F5;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #1B2A47;
            margin-bottom: 0.35rem;
        }

        .form-control {
            border: 1.5px solid #E5E7EB;
            border-radius: 8px;
            font-size: 0.88rem;
            padding: 0.55rem 0.85rem;
            color: #1B2A47;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: #F5A623;
            box-shadow: 0 0 0 3px rgba(245, 166, 35, 0.12);
            outline: none;
        }

        .form-control:disabled {
            background: #F4F6F9;
            color: #9CA3AF;
            cursor: not-allowed;
        }

        .form-control.is-invalid {
            border-color: #DC2626;
        }

        .avatar-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #F5A623;
            color: #0F1C33;
            font-size: 1.6rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .avatar-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .avatar-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1B2A47;
        }

        .avatar-email {
            font-size: 0.83rem;
            color: #6c757d;
        }

        .notif-toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 0;
        }

        .notif-toggle-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notif-toggle-left i {
            font-size: 1.2rem;
            color: #F5A623;
        }

        .notif-toggle-text {
            font-size: 0.88rem;
            font-weight: 500;
            color: #1B2A47;
        }

        .notif-toggle-sub {
            font-size: 0.78rem;
            color: #6c757d;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 26px;
            flex-shrink: 0;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #dee2e6;
            border-radius: 26px;
            transition: 0.3s;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background: #fff;
            border-radius: 50%;
            transition: 0.3s;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
        }

        input:checked+.toggle-slider {
            background: #F5A623;
        }

        input:checked+.toggle-slider:before {
            transform: translateX(22px);
        }

        .btn-save {
            background: #F5A623;
            color: #0F1C33;
            font-weight: 700;
            font-size: 0.92rem;
            padding: 0.65rem 2rem;
            border-radius: 10px;
            border: none;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-save:hover {
            background: #d48f1c;
        }

        .btn-cancel {
            background: #F4F6F9;
            color: #6c757d;
            font-weight: 600;
            font-size: 0.92rem;
            padding: 0.65rem 1.5rem;
            border-radius: 10px;
            border: none;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-cancel:hover {
            background: #E5E7EB;
            color: #1B2A47;
        }

        .alert-success-custom {
            background: #D1FAE5;
            color: #059669;
            border-radius: 10px;
            padding: 0.85rem 1.2rem;
            font-size: 0.88rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
            border: none;
        }
    </style>

    {{-- SUCCESS ALERT --}}
    @if (session('success'))
        <div class="alert-success-custom">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- HEADER --}}
    <div class="profile-header">
        <div class="profile-title">Profile Settings</div>
        <div class="profile-subtitle">Manage your personal information and preferences</div>
    </div>

    <form method="POST" action="{{ route('student.profile.update') }}">
        @csrf
        @method('PUT')

        {{-- AVATAR + NAME --}}
        <div class="profile-section">
            <div class="avatar-info">
                <div class="avatar-circle">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div>
                    <div class="avatar-name">{{ $user->name }}</div>
                    <div class="avatar-email">{{ $user->email }}</div>
                </div>
            </div>

            <div class="section-label"><i class="bi bi-person-fill"></i> Personal Information</div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="name">Full Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                    <small class="text-muted" style="font-size:0.75rem;">Email cannot be changed</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="municipality">Municipality</label>
                    <select class="form-control @error('municipality') is-invalid @enderror" id="municipality"
                        name="municipality" required>
                        <option value="">Select municipality</option>
                        @foreach (['Basud', 'Capalonga', 'Daet', 'Jose Panganiban', 'Labo', 'Mercedes', 'Paracale', 'San Lorenzo Ruiz', 'San Vicente', 'Santa Elena', 'Talisay', 'Vinzons'] as $muni)
                            <option value="{{ $muni }}"
                                {{ old('municipality', $user->municipality) == $muni ? 'selected' : '' }}>
                                {{ $muni }}
                            </option>
                        @endforeach
                    </select>
                    @error('municipality')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ACADEMIC INFO --}}
        <div class="profile-section">
            <div class="section-label"><i class="bi bi-mortarboard-fill"></i> Academic Information</div>
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label" for="course">Academic Program</label>
                    <select class="form-control @error('course') is-invalid @enderror" id="course" name="course"
                        required>
                        <option value="">Select program</option>
                        @foreach ([
            'BSIT' => 'BS Information Technology',
            'BSCS' => 'BS Computer Science',
            'BSCE' => 'BS Civil Engineering',
            'BSEd' => 'BS Education',
            'BSBA' => 'BS Business Administration',
            'BSN' => 'BS Nursing',
            'BSEE' => 'BS Electrical Engineering',
            'BSME' => 'BS Mechanical Engineering',
            'BSA' => 'BS Accountancy',
            'BSHM' => 'BS Hospitality Management',
            'BSTM' => 'BS Tourism Management',
            'BSAG' => 'BS Agriculture',
            'AB' => 'AB Political Science',
        ] as $code => $label)
                            <option value="{{ $code }}"
                                {{ old('course', $user->course) == $code ? 'selected' : '' }}>
                                {{ $code }} — {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('course')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="year_level">Year Level</label>
                    <select class="form-control @error('year_level') is-invalid @enderror" id="year_level" name="year_level"
                        required>
                        @foreach ([1 => '1st Year', 2 => '2nd Year', 3 => '3rd Year', 4 => '4th Year', 5 => '5th Year'] as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('year_level', $user->year_level) == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('year_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="gwa">Current GWA</label>
                    <input type="number" step="0.01" class="form-control @error('gwa') is-invalid @enderror"
                        id="gwa" name="gwa" min="1.00" max="5.00" value="{{ old('gwa', $user->gwa) }}"
                        placeholder="e.g. 1.75" required>
                    <small class="text-muted" style="font-size:0.75rem;">Scale: 1.00 (highest) – 5.00 (lowest)</small>
                    @error('gwa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- PASSWORD --}}
        <div class="profile-section">
            <div class="section-label"><i class="bi bi-shield-lock-fill"></i> Change Password</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="password">New Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" placeholder="Leave blank to keep current">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="password_confirmation">Confirm New Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        placeholder="Leave blank to keep current">
                </div>
            </div>
        </div>

        {{-- NOTIFICATIONS --}}
        <div class="profile-section">
            <div class="section-label"><i class="bi bi-bell-fill"></i> Notification Preferences</div>
            <div class="notif-toggle-row">
                <div class="notif-toggle-left">
                    <i class="bi bi-envelope-fill"></i>
                    <div>
                        <div class="notif-toggle-text">Email Notifications</div>
                        <div class="notif-toggle-sub">Receive deadline reminders and new scholarship alerts</div>
                    </div>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" name="email_notifications" id="email_notifications"
                        {{ old('email_notifications', $user->email_notifications) ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn-save">
                <i class="bi bi-check2"></i> Save Changes
            </button>
            <a href="{{ route('student.dashboard') }}" class="btn-cancel">Cancel</a>
        </div>

    </form>
@endsection

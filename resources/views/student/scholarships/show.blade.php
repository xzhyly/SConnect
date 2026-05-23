@extends('layouts.student')

@section('content')

    <style>
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #6c757d;
            text-decoration: none;
            font-size: 0.88rem;
            margin-bottom: 1.5rem;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #1B2A47;
        }

        .hero-banner {
            background: #1B2A47;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .hero-title {
            color: #fff;
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            line-height: 1.3;
        }

        .badge-provider-pill {
            color: #fff;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
        }

        .badge-deadline-pill {
            font-size: 0.78rem;
            font-weight: 600;
            padding: 4px 12px;
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

        .btn-apply {
            background: #F5A623;
            color: #0F1C33;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 0.65rem 1.4rem;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: none;
            white-space: nowrap;
            transition: background 0.2s;
            flex-shrink: 0;
        }

        .btn-apply:hover {
            background: #d48f1c;
            color: #0F1C33;
        }

        .toggle-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.1rem 1.4rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .toggle-card-left {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.9rem;
            font-weight: 500;
            color: #1B2A47;
        }

        .toggle-card-left i {
            font-size: 1.2rem;
            color: #B0BEC5;
            transition: color 0.2s;
        }

        .toggle-card-left i.icon-active {
            color: #F5A623;
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

        .info-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            margin-bottom: 1.25rem;
        }

        .info-card-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1B2A47;
            margin-bottom: 1rem;
        }

        .check-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 0.5rem;
            font-size: 0.88rem;
            color: #333;
        }

        .check-item i {
            color: #F5A623;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .info-label {
            font-size: 0.78rem;
            color: #6c757d;
            margin-bottom: 0.4rem;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 700;
            color: #1B2A47;
        }

        .tag-pill {
            display: inline-block;
            background: #F0F2F5;
            color: #1B2A47;
            font-size: 0.78rem;
            font-weight: 500;
            padding: 3px 10px;
            border-radius: 20px;
            margin: 2px;
        }

        .related-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1B2A47;
            margin-bottom: 1rem;
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

        .btn-view-details {
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

        .btn-view-details:hover {
            background: #0F1C33;
            color: #fff;
        }
    </style>

    {{-- Back link --}}
    <a href="{{ route('student.scholarships') }}" class="back-link">
        <i class="bi bi-arrow-left"></i> Back to Browse
    </a>

    @php
        $deadline = \Carbon\Carbon::parse($scholarship->deadline)->startOfDay();
        $today = \Carbon\Carbon::now()->startOfDay();
        $daysLeft = max((int) $today->diffInDays($deadline, false), 0);
        $deadlineClass = $daysLeft <= 7 ? 'deadline-soon' : ($daysLeft <= 30 ? 'deadline-ok' : 'deadline-far');
        $deadlineIcon = $daysLeft <= 7 ? 'bi-exclamation-circle-fill' : 'bi-clock';

        $providerColors = ['ched' => '#7C3AED', 'dost_sei' => '#7C3AED', 'lgu' => '#059669', 'private' => '#D97706'];
        $providerKey = strtolower($scholarship->provider);
        $providerColor = $providerColors[$providerKey] ?? '#1B2A47';
        $providerLabel = strtoupper(str_replace('_sei', '', $scholarship->provider));
    @endphp

    {{-- HERO BANNER --}}
    <div class="hero-banner">
        <div>
            <div class="hero-title">{{ $scholarship->title }}</div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="badge-provider-pill" style="background:{{ $providerColor }};">
                    {{ $providerLabel }}
                </span>
                <span class="badge-deadline-pill {{ $deadlineClass }}">
                    <i class="bi {{ $deadlineIcon }}"></i>
                    {{ \Carbon\Carbon::parse($scholarship->deadline)->format('F j, Y') }}
                    &nbsp;·&nbsp; {{ $daysLeft }}d left
                </span>
            </div>
        </div>
        @if ($scholarship->application_link)
            <a href="{{ $scholarship->application_link }}" target="_blank" class="btn-apply">
                Apply Now <i class="bi bi-box-arrow-up-right"></i>
            </a>
        @endif
    </div>

    {{-- TOGGLE CARDS --}}
    <div class="row g-3 mb-4">

        {{-- BOOKMARK TOGGLE --}}
        <div class="col-md-6">
            <div class="toggle-card">
                <div class="toggle-card-left">
                    <i class="bi {{ $isBookmarked ? 'bi-bookmark-fill icon-active' : 'bi-bookmark' }}"
                        id="bookmark-icon"></i>
                    <span id="bookmark-label">{{ $isBookmarked ? 'Bookmarked' : 'Bookmark this scholarship' }}</span>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="bookmark-toggle" {{ $isBookmarked ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>

        {{-- ALERT TOGGLE --}}
        <div class="col-md-6">
            <div class="toggle-card">
                <div class="toggle-card-left">
                    <i class="bi bi-bell" id="alert-icon"></i>
                    <span id="alert-label">Enable deadline alerts</span>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="alert-toggle">
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>

    </div>

    {{-- BENEFITS --}}
    @if ($scholarship->benefits)
        <div class="info-card">
            <div class="info-card-title">Benefits</div>
            @foreach (explode("\n", $scholarship->benefits) as $benefit)
                @if (trim($benefit))
                    <div class="check-item">
                        <i class="bi bi-check2"></i>
                        <span>{{ trim($benefit) }}</span>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    {{-- ELIGIBILITY REQUIREMENTS --}}
    @if ($scholarship->description)
        <div class="info-card">
            <div class="info-card-title">Eligibility Requirements</div>
            @foreach (explode("\n", $scholarship->description) as $line)
                @if (trim($line))
                    <div class="check-item">
                        <i class="bi bi-check2"></i>
                        <span>{{ trim($line) }}</span>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    {{-- ADDITIONAL INFORMATION --}}
    <div class="info-card">
        <div class="info-card-title">Additional Information</div>
        <div class="info-grid">
            <div>
                <div class="info-label">Eligible Courses</div>
                <div>
                    @if ($scholarship->required_course)
                        <span class="tag-pill">{{ $scholarship->required_course }}</span>
                    @else
                        <span class="tag-pill">All undergraduate programs</span>
                    @endif
                </div>
                <div class="info-label mt-3">Minimum GWA</div>
                <div class="info-value">
                    {{ $scholarship->minimum_gwa ? $scholarship->minimum_gwa . ' or better' : 'Open to all' }}
                    @php $qualifies = !$scholarship->minimum_gwa || auth()->user()->gwa <= $scholarship->minimum_gwa; @endphp
                    @if ($qualifies)
                        <span
                            style="background:#D1FAE5; color:#065F46; font-size:0.72rem; font-weight:600; padding:2px 9px; border-radius:12px; margin-left:6px; vertical-align:middle;">
                            ✓ You qualify
                        </span>
                    @else
                        <span
                            style="background:#F3F4F6; color:#6B7280; font-size:0.72rem; font-weight:600; padding:2px 9px; border-radius:12px; margin-left:6px; vertical-align:middle;">
                            Requires higher GWA
                        </span>
                    @endif
                </div>
            </div>
            <div>
                <div class="info-label">Municipality Coverage</div>
                <div>
                    @if ($scholarship->municipality)
                        @php $munis = explode(',', $scholarship->municipality); @endphp
                        @foreach (array_slice($munis, 0, 4) as $muni)
                            <span class="tag-pill">{{ trim($muni) }}</span>
                        @endforeach
                        @if (count($munis) > 4)
                            <span class="tag-pill">+{{ count($munis) - 4 }} more</span>
                        @endif
                    @else
                        <span class="tag-pill">All municipalities</span>
                    @endif
                </div>
                <div class="info-label mt-3">Year Level</div>
                <div class="info-value">
                    @php
                        $yearLabels = ['1' => '1st Year', '2' => '2nd Year', '3' => '3rd Year', '4' => '4th Year'];
                    @endphp
                    @if ($scholarship->year_level)
                        <span
                            class="tag-pill">{{ $yearLabels[$scholarship->year_level] ?? $scholarship->year_level }}</span>
                    @else
                        <span class="tag-pill">All year levels</span>
                    @endif
                </div>
                <div class="info-label mt-3">Available Slots</div>
                <div class="info-value">{{ $scholarship->slots ?? 'Open' }}</div>
            </div>
        </div>
    </div>

    {{-- RELATED SCHOLARSHIPS --}}
    @php
        $related = \App\Models\Scholarship::where('is_active', true)
            ->where('deadline', '>=', now())
            ->where('provider', $scholarship->provider)
            ->where('id', '!=', $scholarship->id)
            ->limit(3)
            ->get();
    @endphp

    @if ($related->count() > 0)
        <div class="related-title">Related Scholarships</div>
        <div class="row g-3 mb-4">
            @foreach ($related as $rel)
                @php
                    $rDaysLeft = max(
                        (int) \Carbon\Carbon::now()
                            ->startOfDay()
                            ->diffInDays(\Carbon\Carbon::parse($rel->deadline)->startOfDay(), false),
                        0,
                    );
                    $rDeadlineClass =
                        $rDaysLeft <= 7 ? 'deadline-soon' : ($rDaysLeft <= 30 ? 'deadline-ok' : 'deadline-far');
                    $rDeadlineIcon = $rDaysLeft <= 7 ? 'bi-exclamation-circle-fill' : 'bi-clock';
                    $rProviderColor = $providerColors[strtolower($rel->provider)] ?? '#1B2A47';
                    $rProviderLabel = strtoupper(str_replace('_sei', '', $rel->provider));
                @endphp
                <div class="col-md-4">
                    <div class="scholarship-card">
                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                            <span class="badge-provider-pill"
                                style="background:{{ $rProviderColor }}; font-size:0.72rem; padding:3px 10px;">
                                {{ $rProviderLabel }}
                            </span>
                            <span class="badge-deadline-pill {{ $rDeadlineClass }}">
                                <i class="bi {{ $rDeadlineIcon }}"></i>
                                {{ \Carbon\Carbon::parse($rel->deadline)->format('M j, Y') }} · {{ $rDaysLeft }}d left
                            </span>
                        </div>
                        <div class="scholarship-title">{{ $rel->title }}</div>
                        <div class="scholarship-desc">{{ Str::limit($rel->description, 90) }}</div>
                        <div class="scholarship-meta">
                            <i class="bi bi-mortarboard-fill" style="color:#F5A623;"></i>
                            GWA Required: {{ $rel->minimum_gwa ?? 'Open to all' }}
                        </div>
                        <div class="scholarship-amount">
                            <i class="bi bi-cash-stack" style="color:#F5A623;"></i>
                            Amount: <span>{{ $rel->benefits ?? 'See details' }}</span>
                        </div>
                        <a href="{{ route('student.scholarships.show', $rel->id) }}" class="btn-view-details">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @push('scripts')
        <script>
            const scholarshipId = {{ $scholarship->id }};
            const csrfToken = '{{ csrf_token() }}';

            const bookmarkToggle = document.getElementById('bookmark-toggle');
            const bookmarkIcon = document.getElementById('bookmark-icon');
            const bookmarkLabel = document.getElementById('bookmark-label');

            bookmarkToggle.addEventListener('change', function() {
                const isChecked = this.checked;
                bookmarkToggle.disabled = true;

                fetch(`/student/bookmarks/${scholarshipId}/toggle`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        credentials: 'same-origin'
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.bookmarked) {
                            bookmarkIcon.className = 'bi bi-bookmark-fill icon-active';
                            bookmarkLabel.textContent = 'Bookmarked';
                        } else {
                            bookmarkIcon.className = 'bi bi-bookmark';
                            bookmarkLabel.textContent = 'Bookmark this scholarship';
                        }
                    })
                    .catch(() => {
                        bookmarkToggle.checked = !isChecked;
                    })
                    .finally(() => {
                        bookmarkToggle.disabled = false;
                    });
            });

            const alertToggle = document.getElementById('alert-toggle');
            const alertEnabled = {{ auth()->user()->email_notifications ? 'true' : 'false' }};

            alertToggle.checked = alertEnabled;
            if (alertEnabled) {
                document.getElementById('alert-icon').className = 'bi bi-bell-fill icon-active';
                document.getElementById('alert-label').textContent = 'Alerts enabled';
            }

            alertToggle.addEventListener('change', function() {
                const alertIcon = document.getElementById('alert-icon');
                const alertLabel = document.getElementById('alert-label');
                alertToggle.disabled = true;

                fetch('/student/notifications/toggle-alerts', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        credentials: 'same-origin'
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.enabled) {
                            alertIcon.className = 'bi bi-bell-fill icon-active';
                            alertLabel.textContent = 'Alerts enabled';
                        } else {
                            alertIcon.className = 'bi bi-bell';
                            alertLabel.textContent = 'Enable deadline alerts';
                        }
                    })
                    .catch(() => {
                        alertToggle.checked = !alertToggle.checked;
                    })
                    .finally(() => {
                        alertToggle.disabled = false;
                    });
            });
        </script>
    @endpush

@endsection

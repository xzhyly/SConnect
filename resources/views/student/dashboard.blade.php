@extends('layouts.student')

@section('content')
    {{-- Welcome Banner --}}
    <div class="welcome-banner mb-4">
        <div>
            <h2 class="mb-1">Welcome back, {{ auth()->user()->name }}!</h2>
            <p class="mb-0">Here are scholarships matched for you based on your profile.</p>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="stat-card">
                <div>
                    <div class="stat-label">Scholarships Available</div>
                    <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="stat-card">
                <div>
                    <div class="stat-label">Bookmarked</div>
                    <div class="stat-value bookmarked-count">{{ $stats['bookmarked'] ?? 0 }}</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-bookmark"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div>
                    <div class="stat-label">Matched for You</div>
                    <div class="stat-value">{{ $stats['matched'] ?? 0 }}</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-bell"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Recommended Scholarships --}}
    <h5 class="section-title mb-3">Recommended for You</h5>
    <div class="row mb-4">
        @forelse($scholarships as $scholarship)
            <div class="col-md-4 mb-3">
                <div class="scholarship-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="scholarship-title">{{ $scholarship->title }}</h6>
                        @php $isDashBookmarked = in_array($scholarship->id, $bookmarkedIds ?? []); @endphp
                        <button class="btn-bookmark-icon" id="bm-btn-{{ $scholarship->id }}"
                            onclick="toggleBookmarkCard({{ $scholarship->id }}, this)"
                            style="background:none; border:none; padding:2px 4px; cursor:pointer; line-height:1;">
                            <i class="bi {{ $isDashBookmarked ? 'bi-bookmark-fill' : 'bi-bookmark' }}"
                                id="bm-icon-{{ $scholarship->id }}"
                                style="color: {{ $isDashBookmarked ? '#F5A623' : '#B0BEC5' }}; font-size:1rem;"></i>
                        </button>
                    </div>

                    {{-- Provider + Deadline badges --}}
                    <div class="d-flex gap-2 mb-3">
                        @php
                            $providerColors = [
                                'ched' => '#7C3AED',
                                'dost_sei' => '#7C3AED',
                                'lgu' => '#059669',
                                'private' => '#D97706',
                            ];
                            $providerKey = strtolower($scholarship->provider);
                            $color = $providerColors[$providerKey] ?? '#1B2A47';
                            $providerLabel = strtoupper(str_replace('_sei', '', $scholarship->provider));
                        @endphp
                        <span class="badge-provider-pill" style="background: {{ $color }};">
                            {{ $providerLabel }}
                        </span>
                        @if ($scholarship->deadline)
                            @php
                                $daysLeft = (int) \Carbon\Carbon::now()
                                    ->startOfDay()
                                    ->diffInDays(\Carbon\Carbon::parse($scholarship->deadline)->startOfDay(), false);
                            @endphp
                            <span class="badge-deadline-pill">
                                <i class="bi bi-clock"></i>
                                {{ $daysLeft >= 0 ? $daysLeft . 'd left' : abs($daysLeft) . 'd ago' }}
                            </span>
                        @endif
                    </div>

                    <p class="scholarship-desc">{{ Str::limit($scholarship->description, 100) }}</p>

                    <div class="scholarship-meta">
                        <span>GWA Required:
                            <strong>{{ $scholarship->minimum_gwa ? ($scholarship->minimum_gwa * 100) / 5 . '%' : 'Any' }}</strong></span>
                    </div>
                    @if ($scholarship->amount)
                        <div class="scholarship-amount">
                            Amount: <span>{{ $scholarship->amount }}</span>
                        </div>
                    @endif

                    <a href="{{ route('student.scholarships.show', $scholarship->id) }}" class="btn-view-details">View
                        Details</a>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">No matching scholarships found for your profile.</p>
            </div>
        @endforelse
    </div>

    {{-- Upcoming Deadlines --}}
    @if (isset($upcomingDeadlines) && $upcomingDeadlines->count() > 0)
        <div class="deadlines-section mb-4">
            <h5 class="section-title mb-1">Upcoming Deadlines</h5>
            <p class="text-muted mb-3" style="font-size: 0.85rem;">Don't miss these application deadlines</p>
            @foreach ($upcomingDeadlines as $item)
                @php
                    $daysLeft = (int) \Carbon\Carbon::now()
                        ->startOfDay()
                        ->diffInDays(\Carbon\Carbon::parse($item->deadline)->startOfDay(), false);
                @endphp
                <div class="deadline-row">
                    <div>
                        <div class="deadline-title">{{ $item->title }}</div>
                        <div class="deadline-provider">{{ $item->provider }}</div>
                    </div>
                    <span class="badge-deadline-pill">
                        <i class="bi bi-clock"></i>
                        {{ $daysLeft >= 0 ? $daysLeft . 'd left' : abs($daysLeft) . 'd ago' }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif

    <style>
        .welcome-banner {
            background: var(--navy-primary, #1B2A47);
            color: #fff;
            border-radius: 12px;
            padding: 2rem 2.5rem;
        }

        .welcome-banner h2 {
            font-weight: 700;
            font-size: 1.6rem;
        }

        .welcome-banner p {
            color: #B0BEC5;
            font-size: 0.9rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.82rem;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1B2A47;
        }

        .stat-icon {
            font-size: 1.8rem;
            color: #F5A623;
            opacity: 0.85;
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
            font-size: 0.95rem;
            margin-bottom: 0;
            line-height: 1.4;
        }

        .bookmark-icon {
            color: #B0BEC5;
            font-size: 1rem;
            cursor: pointer;
            flex-shrink: 0;
        }

        .badge-provider-pill {
            color: #fff;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .badge-deadline-pill {
            background: #FEE2E2;
            color: #DC2626;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .scholarship-desc {
            color: #6c757d;
            font-size: 0.82rem;
            line-height: 1.5;
            flex-grow: 1;
        }

        .scholarship-meta {
            font-size: 0.8rem;
            color: #444;
            margin-bottom: 0.25rem;
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
            padding: 0.6rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            display: block;
            margin-top: auto;
            transition: 0.2s;
        }

        .btn-view-details:hover {
            background: #0F1C33;
            color: #fff;
        }

        .deadlines-section {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .deadline-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.85rem 1rem;
            border-radius: 8px;
            background: #F8F9FA;
            margin-bottom: 0.5rem;
        }

        .deadline-title {
            font-weight: 600;
            font-size: 0.88rem;
            color: #1B2A47;
        }

        .deadline-provider {
            font-size: 0.78rem;
            color: #6c757d;
        }
    </style>
    @push('scripts')
        <script>
            const csrfToken = '{{ csrf_token() }}';

            function toggleBookmarkCard(id, btn) {
                btn.disabled = true;
                fetch(`/student/bookmarks/${id}/toggle`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        credentials: 'same-origin'
                    })
                    .then(r => r.json())
                    .then(data => {
                        const icon = document.getElementById(`bm-icon-${id}`);
                        if (data.bookmarked) {
                            icon.className = 'bi bi-bookmark-fill';
                            icon.style.color = '#F5A623';
                        } else {
                            icon.className = 'bi bi-bookmark';
                            icon.style.color = '#B0BEC5';
                        }
                        const statEl = document.querySelector('.bookmarked-count');
                        if (statEl) {
                            statEl.textContent = parseInt(statEl.textContent) + (data.bookmarked ? 1 : -1);
                        }
                    })
                    .catch(() => {})
                    .finally(() => {
                        btn.disabled = false;
                    });
            }
        </script>
    @endpush
@endsection

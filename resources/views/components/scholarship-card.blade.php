@php
    $providerColors = [
        'ched' => '#7C3AED',
        'dost_sei' => '#7C3AED',
        'lgu' => '#059669',
        'private' => '#D97706',
    ];
    $providerKey = strtolower($scholarship->provider);
    $providerColor = $providerColors[$providerKey] ?? '#1B2A47';
    $providerLabel = strtoupper(str_replace('_sei', '', $scholarship->provider));

    $deadline = \Carbon\Carbon::parse($scholarship->deadline)->startOfDay();
    $today = \Carbon\Carbon::now()->startOfDay();
    $daysLeft = max((int) $today->diffInDays($deadline, false), 0);
    $deadlineClass = $daysLeft <= 7 ? 'deadline-soon' : ($daysLeft <= 30 ? 'deadline-ok' : 'deadline-far');
    $deadlineIcon = $daysLeft <= 7 ? 'bi-exclamation-circle-fill' : 'bi-clock';

    // Check if bookmarked — works on both bookmarks page and browse page
    $isCardBookmarked = isset($bookmarkedIds)
        ? in_array($scholarship->id, $bookmarkedIds)
        : auth()->user()->bookmarks()->where('scholarship_id', $scholarship->id)->exists();
@endphp

<div class="scholarship-card" id="card-{{ $scholarship->id }}">

    {{-- TOP ROW: pills + bookmark icon --}}
    <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span
                style="background:{{ $providerColor }}; color:#fff; font-size:0.72rem; font-weight:600; padding:3px 10px; border-radius:20px;">
                {{ $providerLabel }}
            </span>
            <span class="badge-deadline-pill {{ $deadlineClass }}">
                <i class="bi {{ $deadlineIcon }}"></i>
                {{ $daysLeft }}d left
            </span>
        </div>

        {{-- BOOKMARK ICON BUTTON --}}
        <button class="btn-bookmark-icon" id="bm-btn-{{ $scholarship->id }}"
            onclick="toggleBookmarkCard({{ $scholarship->id }}, this)"
            title="{{ $isCardBookmarked ? 'Remove bookmark' : 'Bookmark' }}">
            <i class="bi {{ $isCardBookmarked ? 'bi-bookmark-fill' : 'bi-bookmark' }}"
                id="bm-icon-{{ $scholarship->id }}"
                style="color: {{ $isCardBookmarked ? '#F5A623' : '#B0BEC5' }}; font-size: 1.1rem;"></i>
        </button>
    </div>

    <div class="scholarship-title">{{ $scholarship->title }}</div>
    <div class="scholarship-desc">{{ Str::limit($scholarship->description, 100) }}</div>

    <div class="scholarship-meta">
        <i class="bi bi-mortarboard-fill" style="color:#F5A623;"></i>
        GWA Required: {{ $scholarship->minimum_gwa ? $scholarship->minimum_gwa * 100 . '%' : 'Open to all' }}
    </div>
    <div class="scholarship-amount">
        <i class="bi bi-cash-stack" style="color:#F5A623;"></i>
        Amount: <span>{{ $scholarship->benefits ? Str::limit($scholarship->benefits, 40) : 'See details' }}</span>
    </div>

    <a href="{{ route('student.scholarships.show', $scholarship->id) }}" class="btn-view-details">
        View Details
    </a>
</div>

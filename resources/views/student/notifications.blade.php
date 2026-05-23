@extends('layouts.student')

@section('content')
    <style>
        .notif-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .notif-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1B2A47;
        }

        .unread-badge {
            background: #FEF3C7;
            color: #D97706;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .mark-all-btn {
            font-size: 0.8rem;
            color: #6c757d;
            background: none;
            border: 1px solid #dee2e6;
            padding: 4px 12px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .mark-all-btn:hover {
            background: #f8f9fa;
            color: #1B2A47;
        }

        .filter-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            background: #fff;
            border-radius: 12px;
            padding: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 0.45rem 1.1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #6c757d;
            cursor: pointer;
            border: none;
            background: none;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .filter-tab.active {
            background: #1B2A47;
            color: #fff;
            font-weight: 600;
        }

        .filter-tab:hover:not(.active) {
            background: #F4F6F9;
            color: #1B2A47;
        }

        .tab-count {
            background: rgba(255, 255, 255, 0.25);
            border-radius: 10px;
            padding: 1px 7px;
            font-size: 0.75rem;
        }

        .filter-tab:not(.active) .tab-count {
            background: #e9ecef;
            color: #6c757d;
        }

        .notif-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.1rem 1.4rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            border-left: 4px solid transparent;
            transition: border-color 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }

        .notif-card.unread {
            border-left-color: #F5A623;
            background: #FFFDF7;
        }

        .notif-card.type-deadline {
            border-left-color: #DC2626;
            background: #FFF5F5;
        }

        .notif-card.type-deadline.unread {
            border-left-color: #DC2626;
        }

        .notif-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .notif-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
        }

        .notif-icon.deadline {
            background: #FEE2E2;
            color: #DC2626;
        }

        .notif-icon.new-scholarship {
            background: #D1FAE5;
            color: #059669;
        }

        .notif-icon.update {
            background: #DBEAFE;
            color: #2563EB;
        }

        .notif-icon.reminder {
            background: #FEF3C7;
            color: #D97706;
        }

        .notif-body {
            flex: 1;
            min-width: 0;
        }

        .notif-scholarship {
            font-weight: 600;
            color: #1B2A47;
            font-size: 0.92rem;
            margin-bottom: 0.2rem;
        }

        .notif-unread-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #F5A623;
            margin-right: 6px;
            vertical-align: middle;
        }

        .notif-message {
            color: #6c757d;
            font-size: 0.83rem;
            margin-bottom: 0.3rem;
            line-height: 1.4;
        }

        .notif-meta {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            flex-wrap: wrap;
        }

        .notif-time {
            font-size: 0.75rem;
            color: #B0BEC5;
        }

        .notif-tag {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 10px;
        }

        .notif-tag.tag-ched {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .notif-tag.tag-dost {
            background: #D1FAE5;
            color: #065F46;
        }

        .notif-tag.tag-lgu {
            background: #FEF3C7;
            color: #92400E;
        }

        .notif-tag.tag-manual {
            background: #EDE9FE;
            color: #5B21B6;
        }

        .notif-tag.tag-other {
            background: #F3F4F6;
            color: #374151;
        }

        .notif-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.4rem;
            flex-shrink: 0;
        }

        .badge-new {
            background: #FEF3C7;
            color: #D97706;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .badge-deadline-soon {
            background: #FEE2E2;
            color: #DC2626;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .section-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #9CA3AF;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 0.5rem 0 0.5rem 0.2rem;
            margin-bottom: 0.25rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            color: #B0BEC5;
            margin-bottom: 1rem;
            display: block;
        }
    </style>

    @php
        $unreadCount = $notifications->where('is_read', false)->count();
        $allCount = $notifications->total();

        // Deadlines tab: all notifications where scholarship has a deadline set
        $deadlineCount = $notifications
            ->filter(function ($n) {
                return $n->scholarship && $n->scholarship->deadline;
            })
            ->count();

        // New Scholarships tab: scholarship created within last 7 days
        $newScholCount = $notifications
            ->filter(function ($n) {
                return $n->scholarship && $n->scholarship->created_at->diffInDays(now()) <= 7;
            })
            ->count();
    @endphp

    {{-- HEADER --}}
    <div class="notif-header">
        <div class="notif-title">Notifications</div>
        <div class="header-actions">
            @if ($unreadCount > 0)
                <button class="mark-all-btn" onclick="markAllRead()">
                    <i class="bi bi-check2-all me-1"></i>Mark all as read
                </button>
                <span class="unread-badge">{{ $unreadCount }} unread</span>
            @endif
        </div>
    </div>

    {{-- FILTER TABS --}}
    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterNotifs('all', this)">
            All <span class="tab-count">{{ $allCount }}</span>
        </button>
        <button class="filter-tab" onclick="filterNotifs('unread', this)">
            Unread <span class="tab-count" id="tab-unread-count">{{ $unreadCount }}</span>
        </button>
        <button class="filter-tab" onclick="filterNotifs('deadline', this)">
            <i class="bi bi-calendar-x"></i> Deadlines <span class="tab-count">{{ $deadlineCount }}</span>
        </button>
        <button class="filter-tab" onclick="filterNotifs('new_scholarship', this)">
            <i class="bi bi-star"></i> New Scholarships <span class="tab-count">{{ $newScholCount }}</span>
        </button>
    </div>

    {{-- NOTIFICATIONS LIST --}}
    <div id="notif-list">
        @forelse($notifications as $notification)
            @php
                $scholarship = $notification->scholarship;

                // Determine icon type
                $hasDeadline = $scholarship && $scholarship->deadline;
                $isExpired = $hasDeadline && $scholarship->deadline->isPast();
                $isDeadlineSoon =
                    $hasDeadline &&
                    $scholarship->deadline->isFuture() &&
                    $scholarship->deadline->diffInDays(now()) <= 30;

                $isNewSchol = $scholarship && $scholarship->created_at->diffInDays(now()) <= 7;

                $type = $notification->type ?? 'new_scholarship';
                if ($hasDeadline) {
                    $type = 'deadline';
                }

                $iconClass = match ($type) {
                    'deadline' => 'deadline',
                    'new_scholarship' => 'new-scholarship',
                    'update' => 'update',
                    default => 'reminder',
                };

                $iconName = match ($type) {
                    'deadline' => 'bi-calendar-x-fill',
                    'new_scholarship' => 'bi-star-fill',
                    'update' => 'bi-info-circle-fill',
                    default => 'bi-bell-fill',
                };

                // Provider tag
                $provider = strtolower($scholarship->provider ?? '');
                $tagClass = match (true) {
                    str_contains($provider, 'ched') => 'tag-ched',
                    str_contains($provider, 'dost') => 'tag-dost',
                    str_contains($provider, 'lgu') ||
                        str_contains($provider, 'municipal') ||
                        str_contains($provider, 'provincial')
                        => 'tag-lgu',
                    $scholarship->source_type === 'manual' => 'tag-manual',
                    default => 'tag-other',
                };

                $tagLabel = match (true) {
                    str_contains($provider, 'ched') => 'CHED',
                    str_contains($provider, 'dost') => 'DOST',
                    str_contains($provider, 'lgu') ||
                        str_contains($provider, 'municipal') ||
                        str_contains($provider, 'provincial')
                        => 'LGU',
                    $scholarship->source_type === 'manual' => 'Manual',
                    default => ucfirst($scholarship->provider ?? 'Other'),
                };

                // Message
                if ($isExpired) {
                    $deadlineDate = $scholarship->deadline->format('M d, Y');
                    $message = "Deadline was on {$deadlineDate}. This scholarship may no longer be available.";
                } elseif ($isDeadlineSoon) {
                    $daysLeft = (int) now()->diffInDays($scholarship->deadline);
                    $deadlineDate = $scholarship->deadline->format('M d, Y');
                    $message =
                        "Deadline on {$deadlineDate} ({$daysLeft} day" .
                        ($daysLeft == 1 ? '' : 's') .
                        " left). Don't miss your chance!";
                } elseif ($hasDeadline) {
                    $deadlineDate = $scholarship->deadline->format('M d, Y');
                    $message = "Apply before {$deadlineDate}. Check if you're eligible.";
                } elseif ($isNewSchol) {
                    $message = "New scholarship available! Check if you're eligible and apply before the deadline.";
                } else {
                    $message = 'A scholarship matching your profile is available. View details to apply.';
                }

                // data-* attributes for JS filtering
                $dataAttrs = 'data-type="' . $type . '"';
                $dataAttrs .= ' data-unread="' . ($notification->is_read ? '0' : '1') . '"';
                $dataAttrs .= ' data-deadline="' . ($hasDeadline ? '1' : '0') . '"';
                $dataAttrs .= ' data-newschol="' . ($isNewSchol ? '1' : '0') . '"';
            @endphp

            <div class="notif-card {{ !$notification->is_read ? 'unread' : '' }} {{ $isDeadlineSoon ? 'type-deadline' : '' }}"
                id="notif-{{ $notification->id }}" {!! $dataAttrs !!}
                onclick="markRead({{ $notification->id }}, this)">

                <div class="notif-icon {{ $iconClass }}">
                    <i class="bi {{ $iconName }}"></i>
                </div>

                <div class="notif-body">
                    <div class="notif-scholarship">
                        @if (!$notification->is_read)
                            <span class="notif-unread-dot"></span>
                        @endif
                        {{ $scholarship->title ?? 'ScholarConnect' }}
                    </div>
                    <div class="notif-message">{{ $message }}</div>
                    <div class="notif-meta">
                        <span class="notif-time">{{ $notification->created_at->diffForHumans() }}</span>
                        @if ($scholarship)
                            <span class="notif-tag {{ $tagClass }}">{{ $tagLabel }}</span>
                            @if ($scholarship->minimum_gwa)
                                <span class="notif-tag tag-other">GWA {{ $scholarship->minimum_gwa }}</span>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="notif-right">
                    @if ($isExpired)
                        <span class="badge-deadline-soon" style="background:#F3F4F6;color:#6B7280;"
                            id="badge-{{ $notification->id }}">
                            <i class="bi bi-calendar-x me-1"></i>Expired
                        </span>
                    @elseif($isDeadlineSoon)
                        <span class="badge-deadline-soon" id="badge-{{ $notification->id }}">
                            <i class="bi bi-exclamation-circle-fill me-1"></i>Deadline Soon
                        </span>
                    @elseif(!$notification->is_read)
                        <span class="badge-new" id="badge-{{ $notification->id }}">New</span>
                    @endif
                </div>
            </div>

        @empty
            <div class="empty-state">
                <i class="bi bi-bell-slash"></i>
                <p class="fw-semibold">No notifications yet</p>
                <p class="small">We'll notify you about deadlines and new scholarships matching your profile.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-3">{{ $notifications->withQueryString()->links() }}</div>

    @push('scripts')
        <script>
            const csrfToken = '{{ csrf_token() }}';

            function filterNotifs(type, btn) {
                document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                btn.classList.add('active');

                document.querySelectorAll('.notif-card').forEach(card => {
                    const isUnread = card.dataset.unread === '1';
                    const isDeadline = card.dataset.deadline === '1';
                    const isNew = card.dataset.newschol === '1';

                    let show = false;
                    if (type === 'all') show = true;
                    else if (type === 'unread') show = isUnread;
                    else if (type === 'deadline') show = isDeadline;
                    else if (type === 'new_scholarship') show = isNew;

                    card.style.display = show ? '' : 'none';
                });

                // Show empty state if nothing visible
                const visible = [...document.querySelectorAll('.notif-card')].filter(c => c.style.display !== 'none');
                const emptyEl = document.querySelector('.empty-state');
                if (emptyEl) emptyEl.style.display = visible.length === 0 ? '' : 'none';
            }

            function markRead(id, card) {
                if (!card.classList.contains('unread')) return;

                fetch(`/student/notifications/${id}/read`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        credentials: 'same-origin'
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            card.classList.remove('unread');
                            card.dataset.unread = '0';

                            // Remove unread dot inside title
                            const dot = card.querySelector('.notif-unread-dot');
                            if (dot) dot.remove();

                            // Replace "New" badge but keep "Deadline Soon" badge
                            const badge = document.getElementById(`badge-${id}`);
                            if (badge && badge.classList.contains('badge-new')) badge.remove();

                            // Update unread count in tab
                            const countEl = document.getElementById('tab-unread-count');
                            if (countEl) {
                                const current = parseInt(countEl.textContent) || 0;
                                countEl.textContent = Math.max(0, current - 1);
                            }

                            // Update top badge
                            const topBadge = document.querySelector('.unread-badge');
                            if (topBadge) {
                                const cur = parseInt(topBadge.textContent) || 0;
                                const newCount = Math.max(0, cur - 1);
                                topBadge.textContent = `${newCount} unread`;
                                if (newCount === 0) topBadge.remove();
                            }
                        }
                    });
            }

            function markAllRead() {
                fetch('/student/notifications/read-all', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        credentials: 'same-origin'
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelectorAll('.notif-card.unread').forEach(card => {
                                card.classList.remove('unread');
                                card.dataset.unread = '0';
                                const dot = card.querySelector('.notif-unread-dot');
                                if (dot) dot.remove();
                                const badge = card.querySelector('.badge-new');
                                if (badge) badge.remove();
                            });

                            const countEl = document.getElementById('tab-unread-count');
                            if (countEl) countEl.textContent = '0';

                            const topBadge = document.querySelector('.unread-badge');
                            if (topBadge) topBadge.remove();

                            const markAllBtn = document.querySelector('.mark-all-btn');
                            if (markAllBtn) markAllBtn.remove();
                        }
                    });
            }
        </script>
    @endpush
@endsection

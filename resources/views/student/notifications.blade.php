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

        .notif-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .notif-icon {
            width: 38px;
            height: 38px;
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

        .notif-message {
            color: #6c757d;
            font-size: 0.83rem;
            margin-bottom: 0.3rem;
            line-height: 1.4;
        }

        .notif-time {
            font-size: 0.75rem;
            color: #B0BEC5;
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
            font-size: 0.72rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
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
    @endphp

    {{-- HEADER --}}
    <div class="notif-header">
        <div class="notif-title">Notifications</div>
        @if ($unreadCount > 0)
            <span class="unread-badge">{{ $unreadCount }} unread</span>
        @endif
    </div>

    {{-- FILTER TABS --}}
    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterNotifs('all', this)">
            All ({{ $allCount }})
        </button>
        <button class="filter-tab" onclick="filterNotifs('unread', this)">
            Unread ({{ $unreadCount }})
        </button>
        <button class="filter-tab" onclick="filterNotifs('deadline', this)">
            Deadlines
        </button>
        <button class="filter-tab" onclick="filterNotifs('new_scholarship', this)">
            New Scholarships
        </button>
    </div>

    {{-- NOTIFICATIONS LIST --}}
    <div id="notif-list">
        @forelse($notifications as $notification)
            @php
                $type = $notification->type ?? 'reminder';
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
            @endphp

            <div class="notif-card {{ !$notification->is_read ? 'unread' : '' }}" id="notif-{{ $notification->id }}"
                data-type="{{ $type }}" onclick="markRead({{ $notification->id }}, this)">

                <div class="notif-icon {{ $iconClass }}">
                    <i class="bi {{ $iconName }}"></i>
                </div>

                <div class="notif-body">
                    <div class="notif-scholarship">
                        {{ $notification->scholarship->title ?? 'ScholarConnect' }}
                    </div>
                    <div class="notif-message">{{ $notification->message }}</div>
                    <div class="notif-time">{{ $notification->created_at->diffForHumans() }}</div>
                </div>

                <div class="notif-right">
                    @if (!$notification->is_read)
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
                // Update active tab
                document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                btn.classList.add('active');

                // Filter cards
                document.querySelectorAll('.notif-card').forEach(card => {
                    if (type === 'all') {
                        card.style.display = '';
                    } else if (type === 'unread') {
                        card.style.display = card.classList.contains('unread') ? '' : 'none';
                    } else {
                        card.style.display = card.dataset.type === type ? '' : 'none';
                    }
                });
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
                            const badge = document.getElementById(`badge-${id}`);
                            if (badge) badge.remove();
                        }
                    });
            }
        </script>
    @endpush
@endsection

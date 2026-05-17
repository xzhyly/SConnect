@extends('layouts.student')

@section('content')
    <style>
        .scholarship-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: opacity 0.4s, transform 0.4s;
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

        .badge-deadline-pill {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 3px 10px;
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

        .btn-bookmark-icon {
            background: none;
            border: none;
            padding: 4px 6px;
            cursor: pointer;
            border-radius: 6px;
            transition: background 0.15s;
            line-height: 1;
        }

        .btn-bookmark-icon:hover {
            background: #f0f2f5;
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

    <h2 class="fw-bold mb-4" style="color:#1B2A47;">My Bookmarks</h2>

    <div class="row g-3" id="bookmarks-grid">
        @forelse($bookmarks as $bookmark)
            <div class="col-md-4" id="col-{{ $bookmark->scholarship->id }}">
                @include('components.scholarship-card', [
                    'scholarship' => $bookmark->scholarship,
                    'bookmarkedIds' => [$bookmark->scholarship->id],
                ])
            </div>
        @empty
            <div class="col-12" id="empty-state">
                <div class="empty-state">
                    <i class="bi bi-bookmark-x"></i>
                    <p class="fw-semibold">No bookmarks yet</p>
                    <a href="{{ route('student.scholarships') }}" class="btn btn-sm"
                        style="background:#1B2A47;color:#fff;border-radius:8px;">Browse Scholarships</a>
                </div>
            </div>
        @endforelse
    </div>

    {{ $bookmarks->withQueryString()->links() }}

    @push('scripts')
        <script>
            const csrfToken = '{{ csrf_token() }}';
            const isBookmarksPage = true;

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
                            // On bookmarks page — fade out and remove the card
                            if (typeof isBookmarksPage !== 'undefined' && isBookmarksPage) {
                                const col = document.getElementById(`col-${id}`);
                                if (col) {
                                    col.style.opacity = '0';
                                    col.style.transform = 'scale(0.95)';
                                    setTimeout(() => {
                                        col.remove();
                                        // Show empty state if no more cards
                                        const grid = document.getElementById('bookmarks-grid');
                                        if (grid && grid.querySelectorAll('.col-md-4').length === 0) {
                                            grid.innerHTML = `
                                <div class="col-12">
                                    <div class="empty-state">
                                        <i class="bi bi-bookmark-x"></i>
                                        <p class="fw-semibold">No bookmarks yet</p>
                                        <a href="/student/scholarships" class="btn btn-sm" style="background:#1B2A47;color:#fff;border-radius:8px;">Browse Scholarships</a>
                                    </div>
                                </div>`;
                                        }
                                    }, 400);
                                }
                            } else {
                                icon.className = 'bi bi-bookmark';
                                icon.style.color = '#B0BEC5';
                            }
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

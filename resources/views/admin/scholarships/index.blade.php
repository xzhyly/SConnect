@extends('layouts.admin')

@section('content')

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="section-title mb-0">Scholarships</h4>
            <small class="text-muted">Manage all scholarships synced from API sources or added manually.</small>
        </div>
        <div class="d-flex gap-2">
            {{-- R2: Prominent Add Scholarship button --}}
            <a href="{{ route('admin.scholarships.create') }}" class="btn btn-success px-4">
                <i class="bi bi-plus-lg me-1"></i> Add Scholarship
            </a>
            <a href="{{ route('admin.sync') }}" class="btn btn-amber px-4">
                <i class="bi bi-arrow-repeat me-1"></i> Sync Now
            </a>
        </div>
    </div>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert"
            style="border-radius:10px;font-size:0.85rem;">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"
            style="border-radius:10px;font-size:0.85rem;">
            <i class="bi bi-exclamation-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-sm-3">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius:12px;">
                <div style="font-size:1.8rem;font-weight:700;color:#1B2A47;">{{ $stats['total'] }}</div>
                <div class="text-muted" style="font-size:0.75rem;">Total</div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius:12px;">
                <div style="font-size:1.8rem;font-weight:700;color:#059669;">{{ $stats['active'] }}</div>
                <div class="text-muted" style="font-size:0.75rem;">Active</div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius:12px;">
                <div style="font-size:1.8rem;font-weight:700;color:#DC2626;">{{ $stats['inactive'] }}</div>
                <div class="text-muted" style="font-size:0.75rem;">Inactive</div>
            </div>
        </div>
        {{-- R2: Manual entries stat --}}
        <div class="col-6 col-sm-3">
            <div class="card border-0 shadow-sm text-center p-3" style="border-radius:12px;">
                <div style="font-size:1.8rem;font-weight:700;color:#059669;">{{ $stats['manual'] }}</div>
                <div class="text-muted" style="font-size:0.75rem;">Manual / Others</div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius:12px;">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.scholarships') }}" class="row g-2 align-items-end">
                <div class="col-12 col-sm-3">
                    <label class="form-label mb-1"
                        style="font-size:0.75rem;font-weight:600;color:#B0BEC5;text-transform:uppercase;">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control form-control-sm" placeholder="Search title..."
                        style="border-radius:8px;font-size:0.84rem;">
                </div>
                <div class="col-6 col-sm-2">
                    <label class="form-label mb-1"
                        style="font-size:0.75rem;font-weight:600;color:#B0BEC5;text-transform:uppercase;">Provider</label>
                    <select name="provider" class="form-select form-select-sm" style="border-radius:8px;font-size:0.84rem;">
                        <option value="">All Providers</option>
                        <option value="ched" {{ request('provider') === 'ched' ? 'selected' : '' }}>CHED</option>
                        <option value="dost_sei" {{ request('provider') === 'dost_sei' ? 'selected' : '' }}>DOST</option>
                        <option value="lgu" {{ request('provider') === 'lgu' ? 'selected' : '' }}>LGU</option>
                        <option value="manual" {{ request('provider') === 'manual' ? 'selected' : '' }}>Manual</option>
                    </select>
                </div>
                {{-- R2: Filter by source type --}}
                <div class="col-6 col-sm-2">
                    <label class="form-label mb-1"
                        style="font-size:0.75rem;font-weight:600;color:#B0BEC5;text-transform:uppercase;">Source</label>
                    <select name="source_type" class="form-select form-select-sm"
                        style="border-radius:8px;font-size:0.84rem;">
                        <option value="">All Sources</option>
                        <option value="api" {{ request('source_type') === 'api' ? 'selected' : '' }}>API Synced</option>
                        <option value="manual" {{ request('source_type') === 'manual' ? 'selected' : '' }}>Manual</option>
                    </select>
                </div>
                <div class="col-6 col-sm-2">
                    <label class="form-label mb-1"
                        style="font-size:0.75rem;font-weight:600;color:#B0BEC5;text-transform:uppercase;">Status</label>
                    <select name="status" class="form-select form-select-sm" style="border-radius:8px;font-size:0.84rem;">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-12 col-sm-3 d-flex gap-2">
                    <button type="submit" class="btn btn-amber btn-sm flex-grow-1" style="border-radius:8px;">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    @if (request()->hasAny(['search', 'provider', 'status', 'source_type']))
                        <a href="{{ route('admin.scholarships') }}" class="btn btn-sm btn-outline-secondary"
                            style="border-radius:8px;">
                            <i class="bi bi-x"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm" style="border-radius:12px;">
        <div class="card-body p-0">
            @if ($scholarships->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-journal-x d-block mb-2" style="font-size:2.5rem;"></i>
                    <div style="font-size:0.85rem;">No scholarships found.</div>
                    <div class="d-flex justify-content-center gap-2 mt-3">
                        <a href="{{ route('admin.scholarships.create') }}" class="btn btn-success btn-sm px-4"
                            style="border-radius:8px;">
                            <i class="bi bi-plus-lg me-1"></i> Add Manually
                        </a>
                        <a href="{{ route('admin.sync') }}" class="btn btn-amber btn-sm px-4"
                            style="border-radius:8px;">
                            <i class="bi bi-arrow-repeat me-1"></i> Sync Now
                        </a>
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size:0.83rem;">
                        <thead>
                            <tr
                                style="color:#B0BEC5;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.04em;background:#F4F6F9;">
                                <th class="px-4 py-3 border-0">Title</th>
                                <th class="py-3 border-0">Provider</th>
                                <th class="py-3 border-0">Deadline</th>
                                <th class="py-3 border-0">Municipality</th>
                                <th class="py-3 border-0 text-center">Status</th>
                                <th class="py-3 border-0 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($scholarships as $scholarship)
                                @php
                                    $isManual = $scholarship->source_type === 'manual';

                                    $providerColors = [
                                        'ched' => ['bg' => 'rgba(124,58,237,0.1)', 'color' => '#7C3AED'],
                                        'dost_sei' => ['bg' => 'rgba(124,58,237,0.1)', 'color' => '#7C3AED'],
                                        'lgu' => ['bg' => 'rgba(5,150,105,0.1)', 'color' => '#059669'],
                                        'private' => ['bg' => 'rgba(217,119,6,0.1)', 'color' => '#D97706'],
                                        'manual' => ['bg' => 'rgba(22,163,74,0.12)', 'color' => '#16A34A'],
                                    ];
                                    $pc = $providerColors[$scholarship->provider] ?? [
                                        'bg' => 'rgba(176,190,197,0.15)',
                                        'color' => '#B0BEC5',
                                    ];

                                    $isExpired =
                                        $scholarship->deadline &&
                                        \Carbon\Carbon::parse($scholarship->deadline)->startOfDay()->isPast();
                                @endphp
                                <tr id="row-{{ $scholarship->id }}">
                                    {{-- Title --}}
                                    <td class="px-4 py-3">
                                        <div
                                            style="font-weight:600;color:#1B2A47;max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                            {{ $scholarship->title }}
                                        </div>
                                        <div class="d-flex align-items-center gap-2 mt-1">
                                            @if ($scholarship->minimum_gwa)
                                                <small class="text-muted">Min GWA: {{ $scholarship->minimum_gwa }}</small>
                                            @endif
                                            {{-- R2: Manual badge --}}
                                            @if ($isManual)
                                                <span class="badge rounded-pill px-2"
                                                    style="background:rgba(22,163,74,0.12);color:#16A34A;font-size:0.65rem;font-weight:700;border:1px solid rgba(22,163,74,0.25);">
                                                    <i class="bi bi-pencil-fill me-1"
                                                        style="font-size:0.55rem;"></i>Manual
                                                </span>
                                            @endif
                                        </div>
                                        @if ($isManual && $scholarship->organization_name)
                                            <small class="text-muted" style="font-size:0.74rem;">
                                                <i class="bi bi-building me-1"></i>{{ $scholarship->organization_name }}
                                            </small>
                                        @endif
                                    </td>

                                    {{-- Provider --}}
                                    <td>
                                        <span class="badge rounded-pill px-3 py-1"
                                            style="background:{{ $pc['bg'] }};color:{{ $pc['color'] }};font-size:0.72rem;font-weight:700;">
                                            {{ strtoupper($scholarship->provider) }}
                                        </span>
                                    </td>

                                    {{-- Deadline --}}
                                    <td>
                                        @if ($scholarship->deadline)
                                            <span
                                                style="color:{{ $isExpired ? '#DC2626' : '#1B2A47' }};font-weight:{{ $isExpired ? '600' : '400' }};">
                                                {{ \Carbon\Carbon::parse($scholarship->deadline)->format('M d, Y') }}
                                            </span>
                                            @if ($isExpired)
                                                <span class="badge ms-1"
                                                    style="background:rgba(220,38,38,0.1);color:#DC2626;font-size:0.65rem;">Expired</span>
                                            @endif
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    {{-- Municipality --}}
                                    <td>
                                        <span class="text-muted" style="font-size:0.8rem;">
                                            {{ $scholarship->municipality ?? 'All' }}
                                        </span>
                                    </td>

                                    {{-- Status --}}
                                    <td class="text-center">
                                        <span id="badge-{{ $scholarship->id }}" class="badge rounded-pill px-3 py-1"
                                            style="font-size:0.72rem;font-weight:600;
                                            background:{{ $scholarship->is_active ? 'rgba(5,150,105,0.1)' : 'rgba(176,190,197,0.2)' }};
                                            color:{{ $scholarship->is_active ? '#059669' : '#B0BEC5' }};">
                                            {{ $scholarship->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            {{-- Toggle Active/Inactive --}}
                                            <button class="btn btn-sm toggle-btn" data-id="{{ $scholarship->id }}"
                                                data-active="{{ $scholarship->is_active ? '1' : '0' }}"
                                                style="border-radius:8px;font-size:0.75rem;font-weight:600;
                                                {{ $scholarship->is_active
                                                    ? 'background:rgba(220,38,38,0.08);color:#DC2626;border:1px solid rgba(220,38,38,0.2);'
                                                    : 'background:rgba(5,150,105,0.08);color:#059669;border:1px solid rgba(5,150,105,0.2);' }}">
                                                <i
                                                    class="bi {{ $scholarship->is_active ? 'bi-eye-slash' : 'bi-eye' }} me-1"></i>
                                                {{ $scholarship->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>

                                            {{-- R2: Edit & Delete only for manual entries --}}
                                            @if ($isManual)
                                                <a href="{{ route('admin.scholarships.edit', $scholarship->id) }}"
                                                    class="btn btn-sm"
                                                    style="border-radius:8px;font-size:0.75rem;background:rgba(59,130,246,0.08);color:#3B82F6;border:1px solid rgba(59,130,246,0.2);">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.scholarships.destroy', $scholarship->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Delete this scholarship?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm"
                                                        style="border-radius:8px;font-size:0.75rem;background:rgba(220,38,38,0.08);color:#DC2626;border:1px solid rgba(220,38,38,0.2);">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($scholarships->hasPages())
                    <div class="px-4 py-3 border-top">
                        {{ $scholarships->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.toggle-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const button = this;

                button.disabled = true;
                button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

                fetch(`/admin/scholarships/${id}/toggle`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.success) throw new Error('Toggle failed');

                        const nowActive = data.is_active;

                        const badge = document.getElementById(`badge-${id}`);
                        badge.textContent = nowActive ? 'Active' : 'Inactive';
                        badge.style.background = nowActive ? 'rgba(5,150,105,0.1)' :
                            'rgba(176,190,197,0.2)';
                        badge.style.color = nowActive ? '#059669' : '#B0BEC5';

                        button.dataset.active = nowActive ? '1' : '0';
                        button.innerHTML =
                            `<i class="bi ${nowActive ? 'bi-eye-slash' : 'bi-eye'} me-1"></i>${nowActive ? 'Deactivate' : 'Activate'}`;
                        button.style.background = nowActive ? 'rgba(220,38,38,0.08)' :
                            'rgba(5,150,105,0.08)';
                        button.style.color = nowActive ? '#DC2626' : '#059669';
                        button.style.border = nowActive ? '1px solid rgba(220,38,38,0.2)' :
                            '1px solid rgba(5,150,105,0.2)';
                        button.disabled = false;
                    })
                    .catch(() => {
                        button.disabled = false;
                        button.innerHTML = 'Error — Retry';
                    });
            });
        });
    </script>
@endpush

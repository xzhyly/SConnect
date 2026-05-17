@extends('layouts.admin')

@section('content')

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="section-title mb-0">Admin Dashboard</h4>
            <small class="text-muted">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}. Here's what's
                happening.</small>
        </div>
        <a href="{{ route('admin.sync') }}" class="btn btn-amber px-4">
            <i class="bi bi-arrow-repeat me-1"></i> Sync Now
        </a>
    </div>

    {{-- KPI Cards Row --}}
    <div class="row g-3 mb-4">

        {{-- Total Active Scholarships --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:52px;height:52px;background:rgba(124,58,237,0.1);">
                        <i class="bi bi-journal-bookmark-fill fs-4" style="color:#7C3AED;"></i>
                    </div>
                    <div>
                        <div class="fw-700 fs-4 lh-1 mb-1" style="color:#1B2A47;font-weight:700;">
                            {{ $stats['active_scholarships'] }}
                        </div>
                        <div class="text-muted" style="font-size:0.78rem;">Active Scholarships</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Students --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:52px;height:52px;background:rgba(5,150,105,0.1);">
                        <i class="bi bi-people-fill fs-4" style="color:#059669;"></i>
                    </div>
                    <div>
                        <div class="fw-700 fs-4 lh-1 mb-1" style="color:#1B2A47;font-weight:700;">
                            {{ $stats['total_students'] }}
                        </div>
                        <div class="text-muted" style="font-size:0.78rem;">Students Registered</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Syncs --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:52px;height:52px;background:rgba(245,166,35,0.12);">
                        <i class="bi bi-arrow-repeat fs-4" style="color:#F5A623;"></i>
                    </div>
                    <div>
                        <div class="fw-700 fs-4 lh-1 mb-1" style="color:#1B2A47;font-weight:700;">
                            {{ $stats['total_syncs'] }}
                        </div>
                        <div class="text-muted" style="font-size:0.78rem;">Total Syncs Run</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Last Sync Status --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:52px;height:52px;background:rgba(15,28,51,0.08);">
                        <i class="bi bi-clock-history fs-4" style="color:#1B2A47;"></i>
                    </div>
                    <div>
                        @if ($stats['last_sync'])
                            <div class="fw-700 lh-1 mb-1" style="color:#1B2A47;font-weight:700;font-size:0.95rem;">
                                {{ $stats['last_sync']->created_at->diffForHumans() }}
                            </div>
                            <div class="text-muted" style="font-size:0.78rem;">
                                Last Sync —
                                @if ($stats['last_sync']->status === 'success')
                                    <span style="color:#059669;">Success</span>
                                @else
                                    <span style="color:#DC2626;">Failed</span>
                                @endif
                            </div>
                        @else
                            <div class="fw-700 lh-1 mb-1" style="color:#B0BEC5;font-weight:700;font-size:0.95rem;">Never
                            </div>
                            <div class="text-muted" style="font-size:0.78rem;">No syncs yet</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Chart + Recent Students Row --}}
    <div class="row g-3 mb-4">

        {{-- Chart.js Bar Chart --}}
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="section-title mb-0" style="font-size:0.95rem;">
                            <i class="bi bi-bar-chart-fill me-2" style="color:#F5A623;"></i>
                            Scholarships by Provider
                        </h6>
                        <small class="text-muted">All sources</small>
                    </div>
                    <canvas id="providerChart" height="220"></canvas>
                </div>
            </div>
        </div>

        {{-- Recent Students --}}
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="section-title mb-0" style="font-size:0.95rem;">
                            <i class="bi bi-person-plus-fill me-2" style="color:#059669;"></i>
                            Recently Registered
                        </h6>
                        <small class="text-muted">Last 5 students</small>
                    </div>

                    @forelse($recentStudents as $student)
                        <div class="d-flex align-items-center gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="avatar-circle flex-shrink-0"
                                style="width:34px;height:34px;font-size:0.8rem;background:#1B2A47;color:#F5A623;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;">
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <div
                                    style="font-size:0.83rem;font-weight:600;color:#1B2A47;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $student->name }}
                                </div>
                                <div class="text-muted" style="font-size:0.72rem;">
                                    Joined {{ $student->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted" style="font-size:0.85rem;">
                            <i class="bi bi-people d-block mb-2 fs-3"></i>
                            No students registered yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    {{-- Recent Sync Logs --}}
    <div class="card border-0 shadow-sm" style="border-radius:12px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="section-title mb-0" style="font-size:0.95rem;">
                    <i class="bi bi-clock-history me-2" style="color:#1B2A47;"></i>
                    Recent Sync Logs
                </h6>
                <a href="{{ route('admin.sync-logs') }}" class="btn btn-sm btn-outline-secondary"
                    style="font-size:0.78rem;border-radius:8px;">
                    View All <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            @if ($recentSyncLogs->isEmpty())
                <div class="text-center py-4 text-muted" style="font-size:0.85rem;">
                    <i class="bi bi-arrow-repeat d-block mb-2 fs-3"></i>
                    No sync logs yet. Run your first sync!
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size:0.84rem;">
                        <thead>
                            <tr style="color:#B0BEC5;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.04em;">
                                <th class="border-0 pb-2">Source</th>
                                <th class="border-0 pb-2">Status</th>
                                <th class="border-0 pb-2 text-center">Fetched</th>
                                <th class="border-0 pb-2 text-center">Created</th>
                                <th class="border-0 pb-2 text-center">Updated</th>
                                <th class="border-0 pb-2">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentSyncLogs as $log)
                                <tr>
                                    <td>
                                        @php
                                            $sourceColors = [
                                                'ched' => ['bg' => 'rgba(124,58,237,0.1)', 'color' => '#7C3AED'],
                                                'dost' => ['bg' => 'rgba(124,58,237,0.1)', 'color' => '#7C3AED'],
                                                'dost_sei' => ['bg' => 'rgba(124,58,237,0.1)', 'color' => '#7C3AED'],
                                                'lgu' => ['bg' => 'rgba(5,150,105,0.1)', 'color' => '#059669'],
                                                'private' => ['bg' => 'rgba(217,119,6,0.1)', 'color' => '#D97706'],
                                            ];
                                            $sc = $sourceColors[strtolower($log->source)] ?? [
                                                'bg' => 'rgba(176,190,197,0.15)',
                                                'color' => '#B0BEC5',
                                            ];
                                        @endphp
                                        <span class="badge rounded-pill px-3 py-1 fw-600"
                                            style="background:{{ $sc['bg'] }};color:{{ $sc['color'] }};font-size:0.75rem;font-weight:600;">
                                            {{ strtoupper($log->source) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($log->status === 'success')
                                            <span class="badge rounded-pill px-3 py-1"
                                                style="background:rgba(5,150,105,0.1);color:#059669;font-size:0.75rem;font-weight:600;">
                                                <i class="bi bi-check-circle-fill me-1"></i> Success
                                            </span>
                                        @else
                                            <span class="badge rounded-pill px-3 py-1"
                                                style="background:rgba(220,38,38,0.1);color:#DC2626;font-size:0.75rem;font-weight:600;">
                                                <i class="bi bi-x-circle-fill me-1"></i> Failed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center fw-600" style="color:#1B2A47;">
                                        {{ $log->records_fetched ?? 0 }}</td>
                                    <td class="text-center fw-600" style="color:#059669;">
                                        {{ $log->records_created ?? 0 }}</td>
                                    <td class="text-center fw-600" style="color:#F5A623;">
                                        {{ $log->records_updated ?? 0 }}</td>
                                    <td class="text-muted" style="font-size:0.78rem;">
                                        {{ $log->created_at->format('M d, Y') }}<br>
                                        <span style="font-size:0.7rem;">{{ $log->created_at->format('h:i A') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Data from controller
        const providerData = @json($scholarshipsByProvider);

        // Provider color map
        const colorMap = {
            'ched': {
                bg: 'rgba(124,58,237,0.85)',
                border: '#7C3AED'
            },
            'dost_sei': {
                bg: 'rgba(124,58,237,0.85)',
                border: '#7C3AED'
            },
            'dost': {
                bg: 'rgba(124,58,237,0.85)',
                border: '#7C3AED'
            },
            'lgu': {
                bg: 'rgba(5,150,105,0.85)',
                border: '#059669'
            },
            'private': {
                bg: 'rgba(217,119,6,0.85)',
                border: '#D97706'
            },
        };

        const labels = providerData.map(p => p.provider.toUpperCase());
        const counts = providerData.map(p => p.count);
        const bgColors = providerData.map(p => (colorMap[p.provider] || {
            bg: 'rgba(176,190,197,0.7)'
        }).bg);
        const borderColors = providerData.map(p => (colorMap[p.provider] || {
            border: '#B0BEC5'
        }).border);

        const ctx = document.getElementById('providerChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Scholarships',
                    data: counts,
                    backgroundColor: bgColors,
                    borderColor: borderColors,
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.parsed.y} scholarship${ctx.parsed.y !== 1 ? 's' : ''}`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: '#B0BEC5',
                            font: {
                                family: 'Poppins',
                                size: 11
                            }
                        },
                        grid: {
                            color: 'rgba(176,190,197,0.2)'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#1B2A47',
                            font: {
                                family: 'Poppins',
                                size: 12,
                                weight: '600'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endpush

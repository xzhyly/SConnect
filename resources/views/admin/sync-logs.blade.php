@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="section-title mb-0">Sync Logs</h4>
            <small class="text-muted">Full history of all scholarship data sync operations.</small>
        </div>
        <a href="{{ route('admin.sync') }}" class="btn btn-amber px-4">
            <i class="bi bi-arrow-repeat me-2"></i> Sync Now
        </a>
    </div>

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-body p-3 text-center">
                    <div style="font-size:1.6rem;font-weight:700;color:#1B2A47;">{{ $totalSyncs }}</div>
                    <div class="text-muted" style="font-size:0.78rem;">Total Syncs</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-body p-3 text-center">
                    <div style="font-size:1.6rem;font-weight:700;color:#059669;">{{ $successfulSyncs }}</div>
                    <div class="text-muted" style="font-size:0.78rem;">Successful</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-body p-3 text-center">
                    <div style="font-size:1.6rem;font-weight:700;color:#DC2626;">{{ $failedSyncs }}</div>
                    <div class="text-muted" style="font-size:0.78rem;">Failed</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-body p-3 text-center">
                    <div style="font-size:1.6rem;font-weight:700;color:#7C3AED;">{{ $totalFetched }}</div>
                    <div class="text-muted" style="font-size:0.78rem;">Total Fetched</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Logs Table --}}
    <div class="card border-0 shadow-sm" style="border-radius:14px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0" style="font-size:0.85rem;">
                    <thead>
                        <tr style="background:#F4F6F9;border-bottom:1px solid #E5E7EB;">
                            <th class="px-4 py-3 fw-600" style="color:#6B7280;">Source</th>
                            <th class="px-4 py-3 fw-600" style="color:#6B7280;">Status</th>
                            <th class="px-4 py-3 fw-600" style="color:#6B7280;">Fetched</th>
                            <th class="px-4 py-3 fw-600" style="color:#6B7280;">Created</th>
                            <th class="px-4 py-3 fw-600" style="color:#6B7280;">Updated</th>
                            <th class="px-4 py-3 fw-600" style="color:#6B7280;">Message</th>
                            <th class="px-4 py-3 fw-600" style="color:#6B7280;">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr style="border-bottom:1px solid #F3F4F6;">
                                <td class="px-4 py-3">
                                    @php
                                        $colors = [
                                            'ched' => '#7C3AED',
                                            'dost_sei' => '#7C3AED',
                                            'lgu' => '#059669',
                                            'private' => '#D97706',
                                        ];
                                        $color = $colors[$log->source] ?? '#6B7280';
                                    @endphp
                                    <span class="badge rounded-pill px-3 py-1"
                                        style="background:{{ $color }}20;color:{{ $color }};font-size:0.75rem;font-weight:600;">
                                        {{ strtoupper($log->source) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($log->status === 'success')
                                        <span class="badge rounded-pill px-3 py-1"
                                            style="background:#D1FAE5;color:#065F46;font-size:0.75rem;">
                                            <i class="bi bi-check-circle-fill me-1"></i> Success
                                        </span>
                                    @else
                                        <span class="badge rounded-pill px-3 py-1"
                                            style="background:#FEE2E2;color:#991B1B;font-size:0.75rem;">
                                            <i class="bi bi-x-circle-fill me-1"></i> Failed
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 fw-600" style="color:#1B2A47;">
                                    {{ $log->records_fetched }}
                                </td>
                                <td class="px-4 py-3" style="color:#059669;font-weight:600;">
                                    {{ $log->records_created }}
                                </td>
                                <td class="px-4 py-3" style="color:#D97706;font-weight:600;">
                                    {{ $log->records_updated }}
                                </td>
                                <td class="px-4 py-3 text-muted" style="font-size:0.78rem;max-width:220px;">
                                    @if ($log->status === 'failed' && $log->error_message)
                                        <span style="color:#DC2626;">{{ Str::limit($log->error_message, 60) }}</span>
                                    @else
                                        Fetched {{ $log->records_fetched }}, created {{ $log->records_created }}, updated
                                        {{ $log->records_updated }}.
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-muted" style="font-size:0.78rem;white-space:nowrap;">
                                    {{ $log->created_at->format('M d, Y h:i A') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-clock-history"
                                        style="font-size:2rem;display:block;margin-bottom:0.5rem;"></i>
                                    No sync logs yet. Run a sync to see logs here.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($logs->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $logs->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection

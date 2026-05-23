@extends('layouts.admin')

@section('content')

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="section-title mb-0">Sync Now</h4>
            <small class="text-muted">Fetch latest scholarships from all API sources and notify eligible students.</small>
        </div>
        <div class="text-end">
            <div class="text-muted" style="font-size:0.78rem;">Total syncs run</div>
            <div style="font-size:1.3rem;font-weight:700;color:#1B2A47;">{{ $totalSyncs }}</div>
        </div>
    </div>

    <div class="row g-3">

        {{-- Sync Control Card --}}
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                <div class="card-body p-4 d-flex flex-column">

                    {{-- Icon + Title --}}
                    <div class="text-center mb-4">
                        <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                            style="width:72px;height:72px;background:rgba(245,166,35,0.12);">
                            <i class="bi bi-arrow-repeat" style="font-size:2rem;color:#F5A623;"></i>
                        </div>
                        <h5 style="color:#1B2A47;font-weight:700;">Sync Scholarships</h5>
                        <p class="text-muted" style="font-size:0.83rem;">
                            Connects to CHED, DOST, and LGU mock API endpoints,
                            upserts new records into the database, and sends
                            email alerts to eligible students.
                        </p>
                    </div>

                    {{-- API Sources --}}
                    <div class="mb-4">
                        <div
                            style="font-size:0.75rem;font-weight:600;color:#B0BEC5;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.5rem;">
                            API Sources
                        </div>
                        @foreach ([['label' => 'CHED', 'url' => 'mock-api:8080/api/ched', 'color' => '#7C3AED'], ['label' => 'DOST', 'url' => 'mock-api:8080/api/dost', 'color' => '#7C3AED'], ['label' => 'LGU', 'url' => 'mock-api:8080/api/lgu', 'color' => '#059669']] as $src)
                            <div class="d-flex align-items-center gap-2 py-2 border-bottom">
                                <span class="badge rounded-pill px-2 py-1"
                                    style="background:{{ $src['color'] }}1a;color:{{ $src['color'] }};font-size:0.7rem;font-weight:700;min-width:48px;text-align:center;">
                                    {{ $src['label'] }}
                                </span>
                                <code style="font-size:0.75rem;color:#B0BEC5;">{{ $src['url'] }}</code>
                            </div>
                        @endforeach
                    </div>

                    {{-- Last Sync Info --}}
                    <div class="rounded-3 p-3 mb-4" style="background:#F4F6F9;">
                        <div
                            style="font-size:0.75rem;font-weight:600;color:#B0BEC5;text-transform:uppercase;letter-spacing:0.05em;">
                            Last Sync
                        </div>
                        @if ($lastSync)
                            <div style="font-size:0.88rem;color:#1B2A47;font-weight:600;margin-top:4px;">
                                {{ $lastSync->created_at->format('F d, Y h:i A') }}
                            </div>
                            <div style="font-size:0.75rem;">
                                @if ($lastSync->status === 'success')
                                    <span style="color:#059669;"><i class="bi bi-check-circle-fill me-1"></i>Success</span>
                                @else
                                    <span style="color:#DC2626;"><i class="bi bi-x-circle-fill me-1"></i>Failed</span>
                                @endif
                                &mdash; {{ $lastSync->source }} source
                            </div>
                        @else
                            <div class="text-muted" style="font-size:0.85rem;margin-top:4px;">No syncs run yet.</div>
                        @endif
                    </div>

                    {{-- Sync Button --}}
                    <button id="syncBtn" class="btn btn-amber w-100 py-3 mt-auto"
                        style="border-radius:10px;font-size:1rem;font-weight:700;">
                        <i class="bi bi-arrow-repeat me-2"></i> Sync Now
                    </button>

                    {{-- Divider --}}
                    <div class="d-flex align-items-center gap-2 my-3">
                        <hr class="flex-grow-1 m-0">
                        <span style="font-size:0.72rem;color:#B0BEC5;font-weight:600;">OR</span>
                        <hr class="flex-grow-1 m-0">
                    </div>

                    {{-- Notify All Button --}}
                    <button id="notifyAllBtn" class="btn w-100 py-2"
                        style="border-radius:10px;font-size:0.9rem;font-weight:600;background:rgba(37,99,235,0.08);color:#2563EB;border:1.5px solid rgba(37,99,235,0.2);">
                        <i class="bi bi-bell-fill me-2"></i> Notify All Students
                    </button>
                    <p class="text-muted text-center mt-2 mb-0" style="font-size:0.75rem;">
                        Re-sends notifications to all eligible students for active scholarships.<br>
                        Does <strong>not</strong> re-sync API data. Skips already-notified students.
                    </p>

                    {{-- Notify All Result --}}
                    <div id="notifyAllResult" class="mt-3 rounded-3 p-3 d-none"
                        style="background:rgba(37,99,235,0.06);border:1px solid rgba(37,99,235,0.15);">
                        <i class="bi bi-check-circle-fill me-2" style="color:#2563EB;"></i>
                        <span id="notifyAllText" style="font-size:0.84rem;color:#2563EB;font-weight:600;"></span>
                    </div>

                </div>
            </div>
        </div>

        {{-- Results Panel --}}
        <div class="col-12 col-lg-7">

            {{-- Idle State --}}
            <div id="idleState" class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center text-center p-5"
                    style="min-height:380px;">
                    <i class="bi bi-cloud-download" style="font-size:3rem;color:#B0BEC5;"></i>
                    <h6 class="mt-3 mb-1" style="color:#1B2A47;font-weight:600;">Ready to Sync</h6>
                    <p class="text-muted" style="font-size:0.83rem;max-width:280px;">
                        Click <strong>Sync Now</strong> to fetch the latest scholarships from all API sources,
                        or <strong>Notify All Students</strong> to re-send notifications without syncing.
                    </p>
                </div>
            </div>

            {{-- Loading State --}}
            <div id="loadingState" class="card border-0 shadow-sm h-100 d-none" style="border-radius:14px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center text-center p-5"
                    style="min-height:380px;">
                    <div class="spinner-border mb-3" style="color:#F5A623;width:3rem;height:3rem;" role="status"></div>
                    <h6 style="color:#1B2A47;font-weight:600;">Syncing...</h6>
                    <p class="text-muted" style="font-size:0.83rem;">Fetching from CHED, DOST, and LGU APIs. Please wait.
                    </p>
                </div>
            </div>

            {{-- Notify All Loading State --}}
            <div id="notifyLoadingState" class="card border-0 shadow-sm h-100 d-none" style="border-radius:14px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center text-center p-5"
                    style="min-height:380px;">
                    <div class="spinner-border mb-3" style="color:#2563EB;width:3rem;height:3rem;" role="status"></div>
                    <h6 style="color:#1B2A47;font-weight:600;">Notifying Students...</h6>
                    <p class="text-muted" style="font-size:0.83rem;">Checking eligibility and sending notifications. Please
                        wait.</p>
                </div>
            </div>

            {{-- Results State --}}
            <div id="resultsState" class="d-none">

                {{-- Summary Bar --}}
                <div class="row g-3 mb-3" id="summaryRow"></div>

                {{-- Per-source results --}}
                <div class="card border-0 shadow-sm" style="border-radius:14px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="section-title mb-0" style="font-size:0.9rem;">
                                <i class="bi bi-list-check me-2" style="color:#F5A623;"></i>
                                Results Per Source
                            </h6>
                            <small id="syncTimestamp" class="text-muted"></small>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size:0.84rem;">
                                <thead>
                                    <tr
                                        style="color:#B0BEC5;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.04em;">
                                        <th class="border-0 pb-2">Source</th>
                                        <th class="border-0 pb-2">Status</th>
                                        <th class="border-0 pb-2 text-center">Fetched</th>
                                        <th class="border-0 pb-2 text-center">Created</th>
                                        <th class="border-0 pb-2 text-center">Updated</th>
                                    </tr>
                                </thead>
                                <tbody id="resultsTableBody"></tbody>
                            </table>
                        </div>

                        {{-- Emails Sent --}}
                        <div id="emailsRow" class="mt-3 rounded-3 p-3 d-none"
                            style="background:rgba(5,150,105,0.06);border:1px solid rgba(5,150,105,0.15);">
                            <i class="bi bi-envelope-check-fill me-2" style="color:#059669;"></i>
                            <span id="emailsText" style="font-size:0.84rem;color:#059669;font-weight:600;"></span>
                        </div>

                        {{-- Sync Again --}}
                        <div class="mt-3 text-end">
                            <button id="syncAgainBtn" class="btn btn-amber px-4"
                                style="border-radius:8px;font-size:0.85rem;">
                                <i class="bi bi-arrow-repeat me-1"></i> Sync Again
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Error State --}}
            <div id="errorState" class="card border-0 shadow-sm h-100 d-none" style="border-radius:14px;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center text-center p-5"
                    style="min-height:380px;">
                    <i class="bi bi-x-circle-fill" style="font-size:3rem;color:#DC2626;"></i>
                    <h6 class="mt-3 mb-1" style="color:#1B2A47;font-weight:600;">Sync Failed</h6>
                    <p id="errorMsg" class="text-muted" style="font-size:0.83rem;max-width:300px;"></p>
                    <button id="retryBtn" class="btn btn-amber px-4 mt-2" style="border-radius:8px;">
                        <i class="bi bi-arrow-repeat me-1"></i> Retry
                    </button>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const syncBtn = document.getElementById('syncBtn');
        const syncAgainBtn = document.getElementById('syncAgainBtn');
        const retryBtn = document.getElementById('retryBtn');
        const notifyAllBtn = document.getElementById('notifyAllBtn');

        const idleState = document.getElementById('idleState');
        const loadingState = document.getElementById('loadingState');
        const notifyLoadingState = document.getElementById('notifyLoadingState');
        const resultsState = document.getElementById('resultsState');
        const errorState = document.getElementById('errorState');

        const csrfToken = (document.querySelector('meta[name="csrf-token"]') || {
            getAttribute: () => '{{ csrf_token() }}'
        }).getAttribute('content');

        const sourceColorMap = {
            'CHED': {
                bg: 'rgba(124,58,237,0.1)',
                color: '#7C3AED'
            },
            'DOST': {
                bg: 'rgba(124,58,237,0.1)',
                color: '#7C3AED'
            },
            'DOST_SEI': {
                bg: 'rgba(124,58,237,0.1)',
                color: '#7C3AED'
            },
            'LGU': {
                bg: 'rgba(5,150,105,0.1)',
                color: '#059669'
            },
        };

        function showState(state) {
            [idleState, loadingState, notifyLoadingState, resultsState, errorState]
            .forEach(el => {
                if (el) el.classList.add('d-none');
            });
            state.classList.remove('d-none');
        }

        // ── SYNC NOW ──────────────────────────────────────────────────────────────
        function runSync() {
            showState(loadingState);
            syncBtn.disabled = true;
            notifyAllBtn.disabled = true;
            syncBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Syncing...';

            fetch('{{ route('admin.sync.run') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                })
                .then(res => {
                    if (res.status === 419) throw new Error('Session expired. Please refresh the page.');
                    if (!res.ok) throw new Error('Server error: ' + res.status);
                    return res.json();
                })
                .then(data => {
                    if (!data.success) throw new Error(data.message || 'Sync returned unsuccessful.');
                    renderResults(data);
                })
                .catch(err => {
                    showState(errorState);
                    document.getElementById('errorMsg').textContent = err.message || 'An unexpected error occurred.';
                })
                .finally(() => {
                    syncBtn.disabled = false;
                    notifyAllBtn.disabled = false;
                    syncBtn.innerHTML = '<i class="bi bi-arrow-repeat me-2"></i> Sync Now';
                });
        }

        // ── NOTIFY ALL STUDENTS ───────────────────────────────────────────────────
        function runNotifyAll() {
            showState(notifyLoadingState);
            notifyAllBtn.disabled = true;
            syncBtn.disabled = true;
            notifyAllBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Notifying...';

            // Hide previous result
            const resultBox = document.getElementById('notifyAllResult');
            resultBox.classList.add('d-none');

            fetch('{{ route('admin.notify-all') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                })
                .then(res => {
                    if (res.status === 419) throw new Error('Session expired. Please refresh the page.');
                    if (!res.ok) throw new Error('Server error: ' + res.status);
                    return res.json();
                })
                .then(data => {
                    showState(idleState);

                    // Show result below the button
                    document.getElementById('notifyAllText').textContent = data.message;
                    resultBox.classList.remove('d-none');

                    // Color result based on outcome
                    if (data.notified > 0) {
                        resultBox.style.background = 'rgba(37,99,235,0.06)';
                        resultBox.style.border = '1px solid rgba(37,99,235,0.2)';
                        resultBox.querySelector('i').className = 'bi bi-check-circle-fill me-2';
                        resultBox.querySelector('i').style.color = '#2563EB';
                        resultBox.querySelector('span').style.color = '#2563EB';
                    } else {
                        resultBox.style.background = 'rgba(5,150,105,0.06)';
                        resultBox.style.border = '1px solid rgba(5,150,105,0.15)';
                        resultBox.querySelector('i').className = 'bi bi-check2-all me-2';
                        resultBox.querySelector('i').style.color = '#059669';
                        resultBox.querySelector('span').style.color = '#059669';
                    }
                })
                .catch(err => {
                    showState(idleState);
                    document.getElementById('notifyAllText').textContent = 'Error: ' + (err.message ||
                        'Something went wrong.');
                    resultBox.style.background = 'rgba(220,38,38,0.06)';
                    resultBox.style.border = '1px solid rgba(220,38,38,0.15)';
                    resultBox.classList.remove('d-none');
                })
                .finally(() => {
                    notifyAllBtn.disabled = false;
                    syncBtn.disabled = false;
                    notifyAllBtn.innerHTML = '<i class="bi bi-bell-fill me-2"></i> Notify All Students';
                });
        }

        function renderResults(data) {
            const summaryRow = document.getElementById('summaryRow');
            summaryRow.innerHTML = `
            <div class="col-4">
                <div class="card border-0 shadow-sm text-center p-3" style="border-radius:10px;">
                    <div style="font-size:1.6rem;font-weight:700;color:#1B2A47;">${data.total_fetched}</div>
                    <div class="text-muted" style="font-size:0.72rem;">Fetched</div>
                </div>
            </div>
            <div class="col-4">
                <div class="card border-0 shadow-sm text-center p-3" style="border-radius:10px;">
                    <div style="font-size:1.6rem;font-weight:700;color:#059669;">${data.total_created}</div>
                    <div class="text-muted" style="font-size:0.72rem;">New Records</div>
                </div>
            </div>
            <div class="col-4">
                <div class="card border-0 shadow-sm text-center p-3" style="border-radius:10px;">
                    <div style="font-size:1.6rem;font-weight:700;color:#F5A623;">${data.total_updated}</div>
                    <div class="text-muted" style="font-size:0.72rem;">Updated</div>
                </div>
            </div>
        `;

            const tbody = document.getElementById('resultsTableBody');
            tbody.innerHTML = '';
            data.sources.forEach(src => {
                const sc = sourceColorMap[src.source] || {
                    bg: 'rgba(176,190,197,0.15)',
                    color: '#B0BEC5'
                };
                const statusBadge = src.status === 'success' ?
                    `<span class="badge rounded-pill px-3 py-1" style="background:rgba(5,150,105,0.1);color:#059669;font-size:0.73rem;font-weight:600;"><i class="bi bi-check-circle-fill me-1"></i>Success</span>` :
                    `<span class="badge rounded-pill px-3 py-1" style="background:rgba(220,38,38,0.1);color:#DC2626;font-size:0.73rem;font-weight:600;"><i class="bi bi-x-circle-fill me-1"></i>Failed</span>`;

                tbody.innerHTML += `
                <tr>
                    <td>
                        <span class="badge rounded-pill px-3 py-1" style="background:${sc.bg};color:${sc.color};font-size:0.73rem;font-weight:700;">${src.source}</span>
                        ${src.error ? `<div style="font-size:0.7rem;color:#DC2626;margin-top:2px;">${src.error}</div>` : ''}
                    </td>
                    <td>${statusBadge}</td>
                    <td class="text-center fw-600" style="color:#1B2A47;">${src.fetched}</td>
                    <td class="text-center fw-600" style="color:#059669;">${src.created}</td>
                    <td class="text-center fw-600" style="color:#F5A623;">${src.updated}</td>
                </tr>
            `;
            });

            document.getElementById('syncTimestamp').textContent = data.timestamp ?? '';

            const emailsRow = document.getElementById('emailsRow');
            if (data.emails_sent > 0) {
                emailsRow.classList.remove('d-none');
                document.getElementById('emailsText').textContent =
                    `${data.emails_sent} email notification${data.emails_sent !== 1 ? 's' : ''} sent to eligible students.`;
            } else {
                emailsRow.classList.add('d-none');
            }

            showState(resultsState);
        }

        syncBtn.addEventListener('click', runSync);
        syncAgainBtn.addEventListener('click', runSync);
        retryBtn.addEventListener('click', runSync);
        notifyAllBtn.addEventListener('click', runNotifyAll);
    </script>
@endpush

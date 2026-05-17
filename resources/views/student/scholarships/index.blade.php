@extends('layouts.student')

@section('content')

<style>
    .filters-panel {
        background: #fff;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        position: sticky;
        top: 2rem;
        max-height: calc(100vh - 3rem);
        overflow-y: auto;
    }

    .filters-title {
        font-weight: 700;
        color: #1B2A47;
        font-size: 1rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #444;
        margin-bottom: 0.4rem;
    }

    .filter-select {
        background-color: #F0F2F5;
        border: 1.5px solid transparent;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
        color: #495057;
        width: 100%;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: border-color 0.2s;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%236c757d' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
    }

    .filter-select:focus {
        outline: none;
        border-color: #F5A623;
        background-color: #e8eaed;
    }

    .form-check-input:checked {
        background-color: #F5A623;
        border-color: #F5A623;
    }

    .form-check-label {
        font-size: 0.85rem;
        color: #444;
    }

    .btn-clear-filters {
        background: transparent;
        border: 1.5px solid #dee2e6;
        border-radius: 8px;
        color: #6c757d;
        font-size: 0.82rem;
        padding: 0.5rem;
        width: 100%;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: 0.2s;
        display: block;
        text-align: center;
        text-decoration: none;
    }

    .btn-clear-filters:hover {
        border-color: #F5A623;
        color: #F5A623;
    }

    .search-bar-wrapper {
        background: #fff;
        border-radius: 10px;
        padding: 0.6rem 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        flex: 1;
    }

    .search-bar-wrapper input {
        border: none;
        background: transparent;
        outline: none;
        font-size: 0.9rem;
        font-family: 'Poppins', sans-serif;
        width: 100%;
        color: #333;
    }

    .sort-select {
        background-color: #fff;
        border: 1.5px solid transparent;
        border-radius: 10px;
        padding: 0.6rem 2.2rem 0.6rem 1rem;
        font-size: 0.85rem;
        font-family: 'Poppins', sans-serif;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        color: #333;
        cursor: pointer;
        min-width: 150px;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%236c757d' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        transition: border-color 0.2s;
    }

    .sort-select:focus {
        outline: none;
        border-color: #F5A623;
    }

    .results-count {
        font-size: 0.85rem;
        color: #6c757d;
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
        font-size: 0.95rem;
        margin-bottom: 0;
        line-height: 1.4;
    }

    .badge-provider-pill {
        color: #fff;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
    }

    .badge-deadline-pill {
        font-size: 0.72rem;
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
        padding: 0.6rem;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        display: block;
        margin-top: auto;
        transition: background 0.2s;
    }

    .btn-view-details:hover {
        background: #0F1C33;
        color: #fff;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 3rem;
        color: #dee2e6;
        margin-bottom: 1rem;
        display: block;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 style="font-weight: 700; color: #1B2A47; margin: 0;">Browse Scholarships</h4>
</div>

<div class="row">
    {{-- FILTERS PANEL --}}
    <div class="col-md-3">
        <form method="GET" action="{{ route('student.scholarships') }}" id="filterForm" class="h-100">
            <div class="filters-panel">
                <div class="filters-title">
                    <i class="bi bi-sliders"></i> Filters
                </div>

                {{-- Provider --}}
                <div class="mb-3">
                    <div class="filter-label">Provider</div>
                    @foreach(['ched' => 'CHED', 'dost_sei' => 'DOST', 'lgu' => 'LGU', 'private' => 'Private'] as $val => $label)
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox"
                            name="provider[]"
                            value="{{ $val }}"
                            id="provider_{{ $val }}"
                            {{ request()->has('provider') && in_array($val, (array) request('provider')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="provider_{{ $val }}">{{ $label }}</label>
                    </div>
                    @endforeach
                </div>

                {{-- Municipality --}}
                <div class="mb-3">
                    <div class="filter-label">Municipality</div>
                    <select name="municipality" class="filter-select">
                        <option value="">All municipalities</option>
                        @foreach(['Basud','Capalonga','Daet','Jose Panganiban','Labo','Mercedes','Paracale','San Lorenzo Ruiz','San Vicente','Santa Elena','Talisay','Vinzons'] as $mun)
                        <option value="{{ $mun }}" {{ request('municipality') == $mun ? 'selected' : '' }}>{{ $mun }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Academic Level --}}
                <div class="mb-3">
                    <div class="filter-label">Academic Level</div>
                    <select name="year_level" class="filter-select">
                        <option value="">All levels</option>
                        <option value="1" {{ request('year_level') == '1' ? 'selected' : '' }}>1st Year</option>
                        <option value="2" {{ request('year_level') == '2' ? 'selected' : '' }}>2nd Year</option>
                        <option value="3" {{ request('year_level') == '3' ? 'selected' : '' }}>3rd Year</option>
                        <option value="4" {{ request('year_level') == '4' ? 'selected' : '' }}>4th Year</option>
                    </select>
                </div>

                {{-- Course --}}
                <div class="mb-3">
                    <div class="filter-label">Course/Program</div>
                    <select name="course" class="filter-select">
                        <option value="">All programs</option>
                        <optgroup label="Engineering & Technology">
                            <option value="BSIT" {{ request('course') == 'BSIT'  ? 'selected' : '' }}>BS Information Technology</option>
                            <option value="BSCS" {{ request('course') == 'BSCS'  ? 'selected' : '' }}>BS Computer Science</option>
                            <option value="BSCE" {{ request('course') == 'BSCE'  ? 'selected' : '' }}>BS Civil Engineering</option>
                            <option value="BSEE" {{ request('course') == 'BSEE'  ? 'selected' : '' }}>BS Electrical Engineering</option>
                            <option value="BSME" {{ request('course') == 'BSME'  ? 'selected' : '' }}>BS Mechanical Engineering</option>
                            <option value="BSCpE" {{ request('course') == 'BSCpE' ? 'selected' : '' }}>BS Computer Engineering</option>
                        </optgroup>
                        <optgroup label="Business & Accountancy">
                            <option value="BSBA" {{ request('course') == 'BSBA' ? 'selected' : '' }}>BS Business Administration</option>
                            <option value="BSA" {{ request('course') == 'BSA'  ? 'selected' : '' }}>BS Accountancy</option>
                            <option value="BSHM" {{ request('course') == 'BSHM' ? 'selected' : '' }}>BS Hospitality Management</option>
                            <option value="BSTM" {{ request('course') == 'BSTM' ? 'selected' : '' }}>BS Tourism Management</option>
                        </optgroup>
                        <optgroup label="Education">
                            <option value="BEED" {{ request('course') == 'BEED'         ? 'selected' : '' }}>BS Elementary Education</option>
                            <option value="BSED-English" {{ request('course') == 'BSED-English' ? 'selected' : '' }}>BS Secondary Education - English</option>
                            <option value="BSED-Math" {{ request('course') == 'BSED-Math'    ? 'selected' : '' }}>BS Secondary Education - Math</option>
                            <option value="BSED-Science" {{ request('course') == 'BSED-Science' ? 'selected' : '' }}>BS Secondary Education - Science</option>
                        </optgroup>
                        <optgroup label="Health Sciences">
                            <option value="BSN" {{ request('course') == 'BSN'  ? 'selected' : '' }}>BS Nursing</option>
                            <option value="BSMT" {{ request('course') == 'BSMT' ? 'selected' : '' }}>BS Medical Technology</option>
                            <option value="BSPT" {{ request('course') == 'BSPT' ? 'selected' : '' }}>BS Physical Therapy</option>
                        </optgroup>
                        <optgroup label="Agriculture & Environment">
                            <option value="BSAg" {{ request('course') == 'BSAg'   ? 'selected' : '' }}>BS Agriculture</option>
                            <option value="BSF" {{ request('course') == 'BSF'    ? 'selected' : '' }}>BS Forestry</option>
                            <option value="BSFISH" {{ request('course') == 'BSFISH' ? 'selected' : '' }}>BS Fisheries</option>
                        </optgroup>
                        <optgroup label="Arts & Social Sciences">
                            <option value="ABCOM" {{ request('course') == 'ABCOM'   ? 'selected' : '' }}>AB Communication</option>
                            <option value="ABPSYCH" {{ request('course') == 'ABPSYCH' ? 'selected' : '' }}>AB Psychology</option>
                            <option value="BSCRIM" {{ request('course') == 'BSCRIM'  ? 'selected' : '' }}>BS Criminology</option>
                        </optgroup>
                    </select>
                </div>

                {{-- Minimum GWA --}}
                <div class="mb-3">
                    <div class="filter-label">Minimum GWA</div>
                    <select name="gwa" class="filter-select">
                        <option value="">Any GWA</option>
                        <option value="1.00" {{ request('gwa') == '1.00' ? 'selected' : '' }}>1.00 (Highest)</option>
                        <option value="1.25" {{ request('gwa') == '1.25' ? 'selected' : '' }}>1.25</option>
                        <option value="1.50" {{ request('gwa') == '1.50' ? 'selected' : '' }}>1.50</option>
                        <option value="1.75" {{ request('gwa') == '1.75' ? 'selected' : '' }}>1.75</option>
                        <option value="2.00" {{ request('gwa') == '2.00' ? 'selected' : '' }}>2.00</option>
                        <option value="2.25" {{ request('gwa') == '2.25' ? 'selected' : '' }}>2.25</option>
                        <option value="2.50" {{ request('gwa') == '2.50' ? 'selected' : '' }}>2.50</option>
                        <option value="3.00" {{ request('gwa') == '3.00' ? 'selected' : '' }}>3.00</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-amber w-100 mb-2" style="border-radius: 8px; font-size: 0.85rem; padding: 0.6rem;">
                    Apply Filters
                </button>
                <a href="{{ route('student.scholarships') }}" class="btn-clear-filters">
                    Clear All Filters
                </a>
            </div>
        </form>
    </div>

    {{-- RESULTS --}}
    <div class="col-md-9">

        {{-- Search + Sort --}}
        <form method="GET" action="{{ route('student.scholarships') }}" id="searchForm">
            @foreach(request()->except(['search', 'sort', 'page']) as $key => $value)
            @if(is_array($value))
            @foreach($value as $v)
            <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
            @endforeach
            @else
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
            @endforeach

            <div class="d-flex gap-3 mb-3">
                <div class="search-bar-wrapper">
                    <i class="bi bi-search" style="color: #B0BEC5;"></i>
                    <input type="text" name="search"
                        placeholder="Search scholarships..."
                        value="{{ request('search') }}">
                </div>
                <select name="sort" class="sort-select" onchange="this.form.submit()">
                    <option value="relevance" {{ request('sort') == 'relevance' ? 'selected' : '' }}>Relevance</option>
                    <option value="deadline" {{ request('sort') == 'deadline'  ? 'selected' : '' }}>Deadline</option>
                    <option value="newest" {{ request('sort') == 'newest'    ? 'selected' : '' }}>Newest</option>
                    <option value="amount" {{ request('sort') == 'amount'    ? 'selected' : '' }}>Amount</option>
                </select>
            </div>
        </form>

        <div class="results-count">
            Showing {{ $scholarships->total() }} scholarship{{ $scholarships->total() != 1 ? 's' : '' }}
        </div>

        <div class="row">
            @forelse($scholarships as $scholarship)
            @php
            $deadline = \Carbon\Carbon::parse($scholarship->deadline)->startOfDay();
            $today = \Carbon\Carbon::now()->startOfDay();
            $daysLeft = max((int) $today->diffInDays($deadline, false), 0);

            $deadlineClass = $daysLeft <= 7 ? 'deadline-soon'
                : ($daysLeft <=30 ? 'deadline-ok' : 'deadline-far' );
                $deadlineIcon=$daysLeft <=7 ? 'bi-exclamation-circle-fill' : 'bi-clock' ;

                $providerColors=[ 'ched'=> '#7C3AED',
                'dost_sei' => '#7C3AED',
                'lgu' => '#059669',
                'private' => '#D97706',
                ];
                $providerKey = strtolower($scholarship->provider);
                $providerColor = $providerColors[$providerKey] ?? '#1B2A47';
                $providerLabel = strtoupper(str_replace('_sei', '', $scholarship->provider));
                @endphp

                <div class="col-md-6 mb-4">
                    <div class="scholarship-card">

                        {{-- Provider + Deadline pills --}}
                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                            <span class="badge-provider-pill" style="background:{{ $providerColor }};">
                                {{ $providerLabel }}
                            </span>
                            <span class="badge-deadline-pill {{ $deadlineClass }}">
                                <i class="bi {{ $deadlineIcon }}"></i>
                                {{ $daysLeft }}d left
                            </span>
                        </div>

                        {{-- Title --}}
                        <div class="scholarship-title mb-2">{{ $scholarship->title }}</div>

                        {{-- Description --}}
                        <div class="scholarship-desc">
                            {{ Str::limit($scholarship->description, 100) }}
                        </div>

                        {{-- Meta --}}
                        <div class="scholarship-meta">
                            <i class="bi bi-mortarboard-fill" style="color:#F5A623;"></i>
                            GWA Required: {{ $scholarship->minimum_gwa ?? 'Open to all' }}
                        </div>
                        <div class="scholarship-amount">
                            <i class="bi bi-cash-stack" style="color:#F5A623;"></i>
                            Amount: <span>{{ $scholarship->benefits ?? 'See details' }}</span>
                        </div>

                        {{-- Button --}}
                        <a href="{{ route('student.scholarships.show', $scholarship->id) }}" class="btn-view-details">
                            View Details
                        </a>

                    </div>
                </div>

                @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="bi bi-search"></i>
                        <p style="font-weight:600; color:#1B2A47;">No scholarships found</p>
                        <p style="font-size:0.85rem;">Try adjusting your filters or search term.</p>
                        <a href="{{ route('student.scholarships') }}" class="btn btn-amber btn-sm mt-2">Clear Filters</a>
                    </div>
                </div>
                @endforelse
        </div>

        {{-- Pagination --}}
        @if($scholarships->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $scholarships->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>
</div>

@endsection
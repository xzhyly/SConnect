@extends('layouts.admin')

@section('content')
    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('admin.scholarships') }}" class="text-muted text-decoration-none" style="font-size:0.82rem;">
                <i class="bi bi-arrow-left me-1"></i> Back to Scholarships
            </a>
            <h4 class="section-title mb-0 mt-1">Edit Scholarship</h4>
            <small class="text-muted">Update this manually added scholarship.</small>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius:14px;">
                <div class="card-body p-4">

                    {{-- Manual badge notice --}}
                    <div class="alert mb-4 d-flex align-items-center gap-2"
                        style="background:rgba(22,163,74,0.08);border:1px solid rgba(22,163,74,0.2);border-radius:10px;font-size:0.83rem;color:#15803D;">
                        <i class="bi bi-pencil-fill"></i>
                        <span>
                            <strong>Manual entry</strong> — changes here will not be overwritten by API sync.
                        </span>
                    </div>

                    <form action="{{ route('admin.scholarships.update', $scholarship->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- Scholarship Title --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold" style="font-size:0.83rem;">
                                    Scholarship Title <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="title" value="{{ old('title', $scholarship->title) }}"
                                    class="form-control @error('title') is-invalid @enderror"
                                    style="border-radius:8px;font-size:0.85rem;">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Organization Name --}}
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-semibold" style="font-size:0.83rem;">
                                    Organization / Provider Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="organization_name"
                                    value="{{ old('organization_name', $scholarship->organization_name) }}"
                                    class="form-control @error('organization_name') is-invalid @enderror"
                                    placeholder="e.g. SM Foundation, Globe Telecom"
                                    style="border-radius:8px;font-size:0.85rem;">
                                @error('organization_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Municipality --}}
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-semibold" style="font-size:0.83rem;">Municipality</label>
                                <select name="municipality" class="form-select @error('municipality') is-invalid @enderror"
                                    style="border-radius:8px;font-size:0.85rem;">
                                    <option value="">All Municipalities (Province-wide)</option>
                                    @foreach (['Basud', 'Capalonga', 'Daet', 'Jose Panganiban', 'Labo', 'Mercedes', 'Paracale', 'San Lorenzo Ruiz', 'San Vicente', 'Santa Elena', 'Talisay', 'Vinzons'] as $mun)
                                        <option value="{{ $mun }}"
                                            {{ old('municipality', $scholarship->municipality) === $mun ? 'selected' : '' }}>
                                            {{ $mun }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('municipality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Deadline --}}
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-semibold" style="font-size:0.83rem;">Deadline</label>
                                <input type="date" name="deadline"
                                    value="{{ old('deadline', $scholarship->deadline ? \Carbon\Carbon::parse($scholarship->deadline)->format('Y-m-d') : '') }}"
                                    class="form-control @error('deadline') is-invalid @enderror"
                                    style="border-radius:8px;font-size:0.85rem;">
                                @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Minimum GWA --}}
                            <div class="col-12 col-sm-6">
                                <label class="form-label fw-semibold" style="font-size:0.83rem;">
                                    Minimum GWA Required
                                </label>
                                <select name="minimum_gwa" class="form-select @error('minimum_gwa') is-invalid @enderror"
                                    style="border-radius:8px;font-size:0.85rem;">
                                    <option value="">No GWA Requirement</option>
                                    @foreach (['1.00', '1.25', '1.50', '1.75', '2.00', '2.25', '2.50', '2.75', '3.00'] as $gwa)
                                        <option value="{{ $gwa }}"
                                            {{ old('minimum_gwa', number_format($scholarship->minimum_gwa, 2)) == $gwa ? 'selected' : '' }}>
                                            {{ $gwa }} {{ $gwa === '1.00' ? '(Highest / Excellent)' : '' }}
                                            {{ $gwa === '3.00' ? '(Passing)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted" style="font-size:0.75rem;">
                                    PH scale: 1.00 = highest, 3.00 = passing.
                                </small>
                                @error('minimum_gwa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Required Course --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold" style="font-size:0.83rem;">
                                    Required Course / Program
                                </label>
                                <select name="required_course"
                                    class="form-select @error('required_course') is-invalid @enderror"
                                    style="border-radius:8px;font-size:0.85rem;">
                                    <option value="">Any Course (Open to All)</option>
                                    @foreach ([
            'BSIT' => 'BSIT — BS Information Technology',
            'BSCS' => 'BSCS — BS Computer Science',
            'BSED' => 'BSED — BS Education',
            'BEED' => 'BEED — BS Elementary Education',
            'BSBA' => 'BSBA — BS Business Administration',
            'BSN' => 'BSN — BS Nursing',
            'BSCE' => 'BSCE — BS Civil Engineering',
            'BSA' => 'BSA — BS Accountancy',
            'BSHRM' => 'BSHRM — BS Hotel & Restaurant Management',
            'BSCRIM' => 'BSCRIM — BS Criminology',
        ] as $code => $label)
                                        <option value="{{ $code }}"
                                            {{ old('required_course', $scholarship->required_course) === $code ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('required_course')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Application Link --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold" style="font-size:0.83rem;">
                                    Application Link / URL
                                </label>
                                <input type="url" name="application_link"
                                    value="{{ old('application_link', $scholarship->application_link) }}"
                                    class="form-control @error('application_link') is-invalid @enderror"
                                    placeholder="https://example.com/apply" style="border-radius:8px;font-size:0.85rem;">
                                @error('application_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold" style="font-size:0.83rem;">Description</label>
                                <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror"
                                    style="border-radius:8px;font-size:0.85rem;">{{ old('description', $scholarship->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Benefits --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold" style="font-size:0.83rem;">
                                    Benefits / Award
                                </label>
                                <textarea name="benefits" rows="2" class="form-control @error('benefits') is-invalid @enderror"
                                    style="border-radius:8px;font-size:0.85rem;">{{ old('benefits', $scholarship->benefits) }}</textarea>
                                @error('benefits')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Active toggle --}}
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                        role="switch" {{ old('is_active', $scholarship->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="is_active"
                                        style="font-size:0.83rem;">
                                        Active (visible to students)
                                    </label>
                                </div>
                            </div>

                        </div>{{-- end row --}}

                        {{-- Submit --}}
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-2 border-top">
                            <a href="{{ route('admin.scholarships') }}" class="btn btn-outline-secondary px-4"
                                style="border-radius:8px;">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-5" style="border-radius:8px;">
                                <i class="bi bi-check-lg me-1"></i> Save Changes
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.master')

@section('title', 'Installation Details')
@section('page_title', 'Installation Details')

@section('breadcrumb')
    <li class="breadcrumb-item">Installations</li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@push('css')
<style>
    .info-card {
        background: #fff;
        border-radius: 14px;
        padding: 20px;
        border: 1px solid #e6e6e6;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        height: 100%;
    }
    .section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 12px;
        color: #333;
        border-bottom: 1px solid #ddd;
        padding-bottom: 5px;
    }
    .img-preview {
        max-width: 380px;
        border-radius: 10px;
        border: 1px solid #ddd;
    }
    @media print {
        .no-print, nav, header, footer, .breadcrumb {
            display: none !important;
        }
        body {
            margin: 0;
            padding: 0;
            background: white;
        }
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card shadow" style="border-radius: 18px;">
            <div class="card-body">

                {{-- ACTION BUTTONS --}}
                <div class="d-flex justify-content-end gap-2 mb-3 no-print">
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="bi bi-printer"></i> Print
                    </button>

                    <a href="{{ route('installations.pdf', $installation->id) }}"
                       class="btn btn-success">
                        <i class="bi bi-download"></i> Download PDF
                    </a>
                </div>

                <div class="row g-4">

                    {{-- USER DETAILS --}}
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="section-title">User Information</div>

                            <p><strong>Clinic:</strong>
                                {{ $installation->user->clinic_name ?? 'N/A' }}</p>

                            <p><strong>Ward:</strong>
                                {{ $installation->user->ward->name ?? 'N/A' }}</p>

                            <p><strong>Name:</strong>
                                {{ $installation->user->name ?? 'N/A' }}</p>

                            <p><strong>Contact Number:</strong>
                                {{ $installation->user->phone ?? 'N/A' }}</p>

                            <p><strong>Email:</strong>
                                {{ $installation->user->email ?? 'N/A' }}</p>
                        </div>
                    </div>

                    {{-- INSTALLATION DETAILS --}}
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="section-title">Installation Information</div>

                            <p>
                                <strong>Installed On:</strong>
                                {{ $installation->installed_on
                                    ? \Carbon\Carbon::parse($installation->installed_on)->format('d M Y')
                                    : 'N/A' }}
                            </p>

                            <p>
                                <strong>Validity:</strong>
                                6 Months
                            </p>

                            <p>
                                <strong>Comments:</strong>
                                {{ $installation->comments ?: '—' }}
                            </p>
                        </div>
                    </div>

                </div>

                {{-- IMAGE --}}
                @if ($installation->image)
                    <div class="mt-4">
                        <h4 class="fw-bold mb-2">Installation Image</h4>

                        <img src="{{ asset('storage/app/public/' . $installation->image) }}"
                             class="img-preview"
                             alt="Installation Image">
                    </div>
                @endif

                {{-- BACK --}}
                <div class="mt-4 no-print">
                    <a href="{{ route('installations.index') }}"
                       class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- AUTO PRINT SUPPORT --}}
@if (request('print'))
<script>
    window.onload = () => window.print();
</script>
@endif
@endsection

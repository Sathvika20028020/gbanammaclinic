@extends('layouts.master')

@section('title', 'clinic Details')
@section('page_title', 'Clinic Details')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('complaints.index') }}">Clinic Complaints</a>
    </li>
    <li class="breadcrumb-item active">View</li>
@endsection

@push('css')
<style>
    .container-custom {
        max-width: 900px;
        margin: 0 auto;
    }

    .card-box {
        background: #ffffff;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .detail-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .detail-table td {
        padding: 12px 16px;
        border: 1px solid #dfdfdf;
        font-size: 15px;
        vertical-align: top;
    }

    .label-col {
        font-weight: 600;
        background: #f7f7f7;
        width: 35%;
    }

    .img-preview {
        max-width: 280px;
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
        }
    }
</style>
@endpush

@section('content')
<div class="container-custom">
    <div class="card-box">

        <h4 class="mb-3">Clinic  Details</h4>

        {{-- DETAILS + IMAGE IN SAME CARD --}}
        <div class="row g-3">

            {{-- LEFT : TABLE --}}
            <div class="col-md-7">
                <table class="detail-table">
                    <tr>
                        <td class="label-col">PHC</td>
                        <td>{{ $complaint->phc }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Clinic Name</td>
                        <td>{{ $complaint->clinic_name }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Doctor Name</td>
                        <td>{{ $complaint->doctor_name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Phone</td>
                        <td>{{ $complaint->phone }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Source</td>
                        <td class="text-capitalize">{{ $complaint->source }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Submitted At</td>
                        <td>
                            {{ $complaint->created_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label-col">Latitude</td>
                        <td>{{ $complaint->lat }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Longitude</td>
                        <td>{{ $complaint->lng }}</td>
                    </tr>
                </table>
            </div>

            {{-- RIGHT : IMAGE --}}
            <div class="col-md-5 text-center">
                @if ($complaint->image)
                    <img src="{{ $complaint->image }}"
                         class="img-preview"
                         alt="Clinic Image"
                         loading="lazy"
                         referrerpolicy="no-referrer">
                @else
                    <span class="text-muted">No image provided</span>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection

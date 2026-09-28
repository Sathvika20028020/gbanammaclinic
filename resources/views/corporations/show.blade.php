@extends('layouts.master')

@section('title', 'Corporation Details')
@section('page_title', 'Corporation Details')

@section('breadcrumb')
    <li class="breadcrumb-item">Corporations</li>
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
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .detail-table td {
            padding: 14px 18px;
            border: 1px solid #dfdfdf;
            font-size: 17px;
        }

        .label-col {
            font-weight: bold;
            background: #f7f7f7;
            width: 35%;
        }
    </style>
@endpush

@section('content')

    <div class="container-custom">
        <div class="card-box">

            <h4>Corporation Information</h4>
            <table class="detail-table">
                <tr>
                    <td class="label-col">Name</td>
                    <td>{{ $corporation->name }}</td>
                </tr>

                <tr>
                    <td class="label-col">Total Zones</td>
                    <td>{{ $corporation->zones->count() }}</td>
                </tr>

              

            </table>
            <h4 class="mt-4">Zones Under This Corporation</h4>
            @if ($corporation->zones->count() > 0)
                <table class="detail-table">
                    <thead>
                        <tr>
                            <td class="label-col">Zone Name</td>
                            <td>Total Constituencies</td>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($corporation->zones as $zone)
                            <tr>
                                <td>{{ $zone->name }}</td>
                                <td>{{ $zone->constituencies->count() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted mt-3">No zones found for this corporation.</p>
            @endif

        </div>
    </div>

@endsection

@extends('layouts.master')

@section('title', 'View Zone')
@section('page_title', 'Zone Details')

@section('breadcrumb')
    <li class="breadcrumb-item">Zones</li>
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
        font-size: 16px;
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

        <h4>Basic Details</h4>
        <table class="detail-table">
            <tr>
                <td class="label-col">Zone Name</td>
                <td>{{ $zone->name }}</td>
            </tr>

            <tr>
                <td class="label-col">Corporation</td>
                <td>{{ $zone->corporation->name ?? 'N/A' }}</td>
            </tr>


            <tr>
                <td class="label-col">Latitude</td>
                <td>{{ $zone->latitude }}</td>
            </tr>

            <tr>
                <td class="label-col">Longitude</td>
                <td>{{ $zone->longitude }}</td>
            </tr>
            
        </table>

      
        </table>

    </div>
</div>

@endsection

@extends('layouts.master')

@section('title', 'Ward Details')
@section('page_title', 'Ward View')

@section('breadcrumb')
    <li class="breadcrumb-item">Wards</li>
    <li class="breadcrumb-item active">{{ $ward->number }} - {{ $ward->name }}</li>
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
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.10);
    }

    .detail-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        margin-bottom: 20px;
    }

    .detail-table td {
        padding: 14px 18px;
        border: 1px solid #e3e3e3;
        font-size: 16px;
    }

    .label-col {
        width: 32%;
        font-weight: 600;
        background: #f7f7f7;
    }
</style>
@endpush

@section('content')

<div class="container-custom mt-3">
    <div class="card-box">

        <h4>Ward Details</h4>
        <table class="detail-table">
            <tr>
                <td class="label-col">Ward Number</td>
                <td>{{ $ward->number }}</td>
            </tr>
            <tr>
                <td class="label-col">Ward Name</td>
                <td>{{ $ward->name }}</td>
            </tr>
           
        </table>

        <h4>Location Details</h4>
        <table class="detail-table">
            <tr>
                <td class="label-col">Constituency</td>
                <td>{{ $ward->constituency->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label-col">Zone</td>
                <td>{{ $ward->constituency->zone->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label-col">Corporation</td>
                <td>{{ $ward->constituency->zone->corporation->name ?? 'N/A' }}</td>
            </tr>
        </table>

    </div>
</div>

@endsection

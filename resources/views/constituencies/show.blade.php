@extends('layouts.master')

@section('title', 'Constituency Details')
@section('page_title', 'Constituency View')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('constituencies.index') }}">Constituencies</a></li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@push('css')
    <style>
        .container-custom {
            max-width: 800px;
            margin: 0 auto;
        }
        .card-box {
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }
        .detail-table td {
            padding: 12px 16px;
            border: 1px solid #e5e5e5;
            font-size: 16px;
        }
        .label-col {
            background: #f8f8f8;
            font-weight: bold;
            width: 35%;
        }
    </style>
@endpush

@section('content')

<div class="container-custom">
    <div class="card-box">

        <h4>Constituency Details</h4>
        <table class="detail-table">
            <tr>
                <td class="label-col">Name</td>
                <td>{{ $constituency->name }}</td>
            </tr>

            <tr>
                <td class="label-col">Zone</td>
                <td>{{ $constituency->zone->name ?? 'N/A' }}</td>
            </tr>       

            <tr>
                <td class="label-col">Total Wards</td>
                <td>{{ $constituency->wards->count() }}</td>
            </tr>
        </table>

        <h4 class="mt-4">Wards Under This Constituency</h4>
        <table class="detail-table">
            <tr>
                <td class="label-col">Ward List</td>
                <td>
                    @if ($constituency->wards->count() > 0)
                        @foreach ($constituency->wards as $ward)
                            <span class="badge bg-primary m-1">
                                {{ $ward->number }} - {{ $ward->name }}
                            </span>
                        @endforeach
                    @else
                        No wards added yet.
                    @endif
                </td>
            </tr>
        </table>

    </div>
</div>

@endsection

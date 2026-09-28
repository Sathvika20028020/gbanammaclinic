@extends('layouts.master')

@section('title', 'PHC Details')
@section('page_title', 'PHC Details')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('phcs.index') }}">PHCs</a>
    </li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">

        <div class="card">
            <div class="card-body">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 fw-bold">PHC Information</h5>

                    <a href="{{ route('phcs.index') }}"
                       class="btn btn-sm btn-outline-secondary">
                        Back
                    </a>
                </div>

                {{-- DETAILS TABLE --}}
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="30%">PHC Name</th>
                            <td>{{ $phc->name }}</td>
                        </tr>

                        

                        <tr>
                            <th>Ward</th>
                            <td>
                                {{ $phc->ward->number ?? '—' }} - {{ $phc->ward->name ?? '—' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Constituency</th>
                            <td>{{ $phc->ward->constituency->name ?? '—' }}</td>
                        </tr>

                        <tr>
                            <th>Zone</th>
                            <td>{{ $phc->ward->constituency->zone->name ?? '—' }}</td>
                        </tr>

                        <tr>
                            <th>Corporation</th>
                            <td>{{ $phc->ward->constituency->zone->corporation->name ?? '—' }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>
@endsection

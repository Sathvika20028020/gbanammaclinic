@extends('layouts.master')

@section('title', 'View Clinic Issue')
@section('page_title', 'Clinic Issue Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('members_called.index') }}">Clinic Issues</a></li>
    <li class="breadcrumb-item active">Show</li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered mb-4">
            <tr>
                <th style="width: 30%;">Clinic Name</th>
                <td>Gbanamma Clinic</td>
            </tr>
            <tr>
                <th>Member / Caller Name</th>
                <td>Dr. Ramesh Kumar</td>
            </tr>
            <tr>
                <th>Contact Number</th>
                <td>9876543210</td>
            </tr>
            <tr>
                <th>Call Date & Time</th>
                <td>{{ date('d-M-Y H:i') }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td><span class="badge bg-warning text-dark">Pending</span></td>
            </tr>
            <tr>
                <th>Issue Description</th>
                <td>Network connectivity down since morning. Routine clinical systems are unable to sync data.</td>
            </tr>
        </table>

        <div class="d-flex justify-content-start gap-2">
            <a href="{{ route('members_called.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left me-1"></i> Back
            </a>
            <a href="{{ route('members_called.edit') }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection

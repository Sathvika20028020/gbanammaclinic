@extends('layouts.master')

@section('title', 'Edit Clinic Issue / Call')
@section('page_title', 'Edit Clinic Issue')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('members_called.index') }}">Clinic Issues</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form id="memberCalledForm" class="needs-validation" novalidate method="POST" action="{{ route('members_called.index') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Clinic Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="clinic_name" value="Gbanamma Clinic" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Member / Caller Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="member_name" value="Dr. Ramesh Kumar" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="contact_no" pattern="[0-9]{10}" maxlength="10" value="9876543210" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Call Date & Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control" name="call_time" value="{{ date('Y-m-d\TH:i') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" name="status" required>
                        <option value="pending" selected>Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="resolved">Resolved</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Issue Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="issue_description" rows="4" required>Network connectivity down since morning</textarea>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-2 mt-4">
                <a href="{{ route('members_called.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Issue</button>
            </div>
        </form>
    </div>
</div>
@endsection

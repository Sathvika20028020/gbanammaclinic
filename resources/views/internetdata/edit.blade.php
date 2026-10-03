@extends('layouts.master')

@section('title', 'Edit Internet Data')
@section('page_title', 'Edit Internet Data')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internetdata.index') }}">Internet Data</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header pb-0">
        <h5>Edit Internet Connection Details</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $user = $installation->user;
            $ward = $user?->ward ?? $installation->ward;
            $constituency = $ward?->constituency;
            $corporation = $constituency?->zone?->corporation;
        @endphp

        <form id="internetForm" class="needs-validation" novalidate method="POST" action="{{ route('internetdata.update', $installation->id) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Clinic Name</label>
                    <input type="text" class="form-control" value="{{ $user?->clinic_name ?? 'N/A' }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Corporation</label>
                    <input type="text" class="form-control" value="{{ $corporation?->name ?? 'BBMP' }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Constituency</label>
                    <input type="text" class="form-control" value="{{ $constituency?->name ?? 'N/A' }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ward</label>
                    <input type="text" class="form-control" value="{{ $ward?->name ?? 'N/A' }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Contact Person</label>
                    <input type="text" class="form-control" value="{{ $user?->name ?? 'N/A' }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Contact Number</label>
                    <input type="tel" class="form-control" value="{{ $user?->phone ?? 'N/A' }}" readonly>
                </div>

                <hr class="my-3">
                <h6 class="text-primary mb-3"><i class="fa fa-wifi me-1"></i> Connection & ISP Details</h6>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Internet Service Provider (ISP) <span class="text-danger">*</span></label>
                    <select class="form-select" name="provider" required>
                        <option value="ACT" {{ old('provider', $installation->provider) == 'ACT' ? 'selected' : '' }}>ACT</option>
                        <option value="Airtel" {{ old('provider', $installation->provider) == 'Airtel' ? 'selected' : '' }}>Airtel</option>
                        <option value="Excitel" {{ old('provider', $installation->provider) == 'Excitel' ? 'selected' : '' }}>Excitel</option>
                        <option value="Hathway" {{ old('provider', $installation->provider) == 'Hathway' ? 'selected' : '' }}>Hathway</option>
                        <option value="Jio" {{ old('provider', $installation->provider) == 'Jio' ? 'selected' : '' }}>Jio</option>
                        <option value="BSNL" {{ old('provider', $installation->provider) == 'BSNL' ? 'selected' : '' }}>BSNL</option>
                        <option value="Local" {{ old('provider', $installation->provider) == 'Local' ? 'selected' : '' }}>Local</option>
                        <option value="Other" {{ old('provider', $installation->provider) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <div class="invalid-feedback">Please select Provider.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Internet / Account ID <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="internet_id" value="{{ old('internet_id', $installation->internet_id) }}" required>
                    <div class="invalid-feedback">Please enter Internet ID.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Internet Password / Secret</label>
                    <input type="text" class="form-control" name="internet_password" value="{{ old('internet_password', $installation->internet_password) }}" placeholder="Leave blank to keep unchanged">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" name="status" required>
                        <option value="active" {{ old('status', $installation->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $installation->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="expired" {{ old('status', $installation->status) == 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                </div>

                <hr class="my-3">
                <h6 class="text-primary mb-3"><i class="fa fa-calendar me-1"></i> Current Recharge Information</h6>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Last Recharge Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="last_recharge_date" id="last_recharge_date" 
                           value="{{ old('last_recharge_date', optional($installation->last_recharge_date)->format('Y-m-d') ?? optional($installation->installed_on)->format('Y-m-d')) }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Plan Validity <span class="text-danger">*</span></label>
                    <select class="form-select" name="plan_validity" id="plan_validity" required>
                        <option value="1 Month" {{ old('plan_validity', $installation->plan_validity) == '1 Month' ? 'selected' : '' }}>1 Month</option>
                        <option value="3 Months" {{ old('plan_validity', $installation->plan_validity) == '3 Months' ? 'selected' : '' }}>3 Months</option>
                        <option value="6 Months" {{ old('plan_validity', $installation->plan_validity ?? '6 Months') == '6 Months' ? 'selected' : '' }}>6 Months</option>
                        <option value="1 Year" {{ old('plan_validity', $installation->plan_validity) == '1 Year' ? 'selected' : '' }}>1 Year</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Calculated Expiry Date</label>
                    <input type="date" class="form-control" name="expiry_date" id="expiry_date" 
                           value="{{ old('expiry_date', optional($installation->recharge_expiry_date)->format('Y-m-d')) }}" readonly>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-2 mt-4">
                <a href="{{ route('internetdata.show', $installation->id) }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary px-4">Update Internet Data</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rechargeDateInput = document.getElementById('last_recharge_date');
        const validitySelect = document.getElementById('plan_validity');
        const expiryDateInput = document.getElementById('expiry_date');

        function calculateExpiry() {
            if (!rechargeDateInput.value) return;
            const date = new Date(rechargeDateInput.value);
            const validity = validitySelect.value;

            if (validity === '1 Month') {
                date.setMonth(date.getMonth() + 1);
            } else if (validity === '3 Months') {
                date.setMonth(date.getMonth() + 3);
            } else if (validity === '6 Months') {
                date.setMonth(date.getMonth() + 6);
            } else if (validity === '1 Year') {
                date.setFullYear(date.getFullYear() + 1);
            }

            const yyyy = date.getFullYear();
            const mm = String(date.getMonth() + 1).padStart(2, '0');
            const dd = String(date.getDate()).padStart(2, '0');
            expiryDateInput.value = `${yyyy}-${mm}-${dd}`;
        }

        rechargeDateInput.addEventListener('change', calculateExpiry);
        validitySelect.addEventListener('change', calculateExpiry);
        if(!expiryDateInput.value) {
            calculateExpiry();
        }
    });
</script>
@endpush
@extends('layouts.master')

@section('title', 'Add Internet Data & Recharge')
@section('page_title', 'Internet Data')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internetdata.index') }}">Internet Data</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header pb-0">
        <h5>Add Internet Connection & Initial Recharge</h5>
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

        <form id="internetForm" class="needs-validation" novalidate method="POST" action="{{ route('internetdata.store') }}">
            @csrf
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Select Clinic / User <span class="text-danger">*</span></label>
                    <select class="form-select" name="user_id" id="user_select" required>
                        <option value="">-- Select Clinic --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" 
                                    data-clinic="{{ $user->clinic_name }}"
                                    data-contact="{{ $user->name }}"
                                    data-phone="{{ $user->phone }}"
                                    data-ward="{{ optional($user->ward)->name }}"
                                    data-constituency="{{ optional(optional($user->ward)->constituency)->name }}"
                                    data-corporation="{{ optional(optional(optional($user->ward)->constituency)->zone)->corporation->name ?? 'BBMP' }}"
                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->clinic_name ? $user->clinic_name . ' (' . $user->name . ')' : $user->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select a Clinic / User.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Corporation</label>
                    <input type="text" class="form-control" id="corporation" placeholder="Auto-filled from clinic" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Constituency</label>
                    <input type="text" class="form-control" id="constituency" placeholder="Auto-filled from clinic" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ward</label>
                    <input type="text" class="form-control" id="ward" placeholder="Auto-filled from clinic" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Contact Person</label>
                    <input type="text" class="form-control" name="contact_person" id="contact_person" placeholder="Contact person name" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Contact Number</label>
                    <input type="tel" class="form-control" name="contact_no" id="contact_no" placeholder="Phone number" readonly>
                </div>

                <hr class="my-3">
                <h6 class="text-primary mb-3"><i class="fa fa-wifi me-1"></i> Connection & ISP Details</h6>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Internet Service Provider (ISP) <span class="text-danger">*</span></label>
                    <select class="form-select" name="provider" required>
                        <option value="">Select Provider</option>
                        <option value="ACT" {{ old('provider') == 'ACT' ? 'selected' : '' }}>ACT</option>
                        <option value="Airtel" {{ old('provider') == 'Airtel' ? 'selected' : '' }}>Airtel</option>
                        <option value="Excitel" {{ old('provider') == 'Excitel' ? 'selected' : '' }}>Excitel</option>
                        <option value="Hathway" {{ old('provider') == 'Hathway' ? 'selected' : '' }}>Hathway</option>
                        <option value="Jio" {{ old('provider') == 'Jio' ? 'selected' : '' }}>Jio</option>
                        <option value="BSNL" {{ old('provider') == 'BSNL' ? 'selected' : '' }}>BSNL</option>
                        <option value="Local" {{ old('provider') == 'Local' ? 'selected' : '' }}>Local</option>
                        <option value="Other" {{ old('provider') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <div class="invalid-feedback">Please select Provider.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Internet / Account ID <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="internet_id" value="{{ old('internet_id') }}" placeholder="Enter Account / Internet ID" required>
                    <div class="invalid-feedback">Please enter Internet ID.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Internet Password / Secret</label>
                    <input type="text" class="form-control" name="internet_password" value="{{ old('internet_password') }}" placeholder="Enter Internet Password / Wi-Fi Key">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" name="status" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <hr class="my-3">
                <h6 class="text-primary mb-3"><i class="fa fa-calendar me-1"></i> Recharge Information</h6>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Last Recharge Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="last_recharge_date" id="last_recharge_date" value="{{ old('last_recharge_date', date('Y-m-d')) }}" required>
                    <div class="invalid-feedback">Please select Last Recharge Date.</div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Plan Validity <span class="text-danger">*</span></label>
                    <select class="form-select" name="plan_validity" id="plan_validity" required>
                        <option value="1 Month" {{ old('plan_validity') == '1 Month' ? 'selected' : '' }}>1 Month</option>
                        <option value="3 Months" {{ old('plan_validity') == '3 Months' ? 'selected' : '' }}>3 Months</option>
                        <option value="6 Months" {{ old('plan_validity', '6 Months') == '6 Months' ? 'selected' : '' }}>6 Months</option>
                        <option value="1 Year" {{ old('plan_validity') == '1 Year' ? 'selected' : '' }}>1 Year</option>
                    </select>
                    <div class="invalid-feedback">Please select Plan Validity.</div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Calculated Expiry Date</label>
                    <input type="date" class="form-control" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}" readonly>
                    <small class="text-muted">Auto-computed from recharge date & validity</small>
                </div>

            </div>

            <div class="d-flex justify-content-center gap-2 mt-4">
                <a href="{{ route('internetdata.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary px-4">Save Connection & Recharge</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userSelect = document.getElementById('user_select');
        const corpInput = document.getElementById('corporation');
        const constInput = document.getElementById('constituency');
        const wardInput = document.getElementById('ward');
        const contactInput = document.getElementById('contact_person');
        const phoneInput = document.getElementById('contact_no');

        function updateUserDetails() {
            const selected = userSelect.options[userSelect.selectedIndex];
            if (selected && selected.value) {
                corpInput.value = selected.getAttribute('data-corporation') || 'BBMP';
                constInput.value = selected.getAttribute('data-constituency') || '';
                wardInput.value = selected.getAttribute('data-ward') || '';
                contactInput.value = selected.getAttribute('data-contact') || '';
                phoneInput.value = selected.getAttribute('data-phone') || '';
            } else {
                corpInput.value = '';
                constInput.value = '';
                wardInput.value = '';
                contactInput.value = '';
                phoneInput.value = '';
            }
        }

        userSelect.addEventListener('change', updateUserDetails);
        if (userSelect.value) updateUserDetails();

        // Calculate Expiry Date
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
        calculateExpiry();
    });
</script>
@endpush

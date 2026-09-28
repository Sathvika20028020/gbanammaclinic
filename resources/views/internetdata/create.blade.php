@extends('layouts.master')

@section('title', 'Internet Data')
@section('page_title', 'Internet Data')

@section('breadcrumb')
    <li class="breadcrumb-item active">create</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endpush

@section('content')


<div class="card">
    <div class="card-body">
       <form id="internetForm" class="needs-validation" novalidate method="POST" action="{{ route('internetdata') }}">

    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">Clinic Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="clinic_name" placeholder="Enter clinic name" required>
            <div class="invalid-feedback">Please enter Clinic Name.</div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Corporation <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="corporation" placeholder="Enter corporation name" required>
            <div class="invalid-feedback">Please enter Corporation.</div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Constituency <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="constituency" placeholder="Enter constituency name" required>
            <div class="invalid-feedback">Please enter Constituency.</div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Ward <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="ward" placeholder="Enter ward name" required>
            <div class="invalid-feedback">Please enter Ward.</div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Contact Person <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="contact_person" placeholder="Enter contact person name" required>
            <div class="invalid-feedback">Please enter Contact Person.</div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Contact Number <span class="text-danger">*</span></label>
            <input type="tel" class="form-control" name="contact_no"
                   pattern="[0-9]{10}" maxlength="10" placeholder="Enter 10-digit phone number" required>
            <div class="invalid-feedback">
                Please enter a valid 10-digit Contact Number.
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Internet Service Provider <span class="text-danger">*</span></label>
            <select class="form-select" name="provider" required>
                <option value="">Select Provider</option>
                <option>ACT</option>
                <option>Airtel</option>
                <option>Excitel</option>
                <option>Hatway</option>
            </select>
            <div class="invalid-feedback">Please select Provider.</div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Internet ID <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="internet_id" placeholder="Enter internet ID" required>
            <div class="invalid-feedback">Please enter Internet ID.</div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Internet Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" name="internet_password" placeholder="Enter internet password" required>
            <div class="invalid-feedback">Please enter Internet Password.</div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Last Recharge Date <span class="text-danger">*</span></label>
            <input type="date" class="form-control" name="last_recharge" required>
            <div class="invalid-feedback">Please select Last Recharge Date.</div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Expiry Date <span class="text-danger">*</span></label>
            <input type="date" class="form-control" name="expiry_date" required>
            <div class="invalid-feedback">Please select Expiry Date.</div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Plan Validity <span class="text-danger">*</span></label>
            <select class="form-select" name="plan_validity" required>
                <option value="">Select Plan Validity</option>
                <option>1 Month</option>
                <option>3 Months</option>
                <option>6 Months</option>
                <option>1 Year</option>
            </select>
            <div class="invalid-feedback">Please select Plan Validity.</div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select class="form-select" name="status" required>
                <option value="">Select Status</option>
                <option>Active</option>
                <option>Inactive</option>
                <option>Expired</option>
            </select>
            <div class="invalid-feedback">Please select Status.</div>
        </div>

    </div>
<div class="d-flex justify-content-center mt-4">
    <button type="submit" class="btn btn-primary">
        Save
    </button>

   
</div>
</form>

    </div>


@endsection

@push('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#constituencies-table').DataTable();
    });
</script>
<script>
(() => {
    'use strict';

    const form = document.getElementById('internetForm');

    form.addEventListener('submit', function(e){
        if(!form.checkValidity()){
            e.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        e.preventDefault();

        if (typeof Swal !== 'undefined' && Swal.fire) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Internet Data Added Successfully.',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                form.submit();
            });
        } else {
            alert('Internet Data Added Successfully.');
            form.submit();
        }
    });

})();
</script>
@endpush

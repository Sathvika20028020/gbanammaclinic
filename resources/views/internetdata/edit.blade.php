@extends('layouts.master')

@section('title', 'Edit Internet Data')
@section('page_title', 'Edit Internet Data')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('internetdata') }}">Internet Data</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')

<div class="card">
    <div class="card-body">

        <form id="internetForm" class="needs-validation" novalidate>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Clinic Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="clinic_name"
                        value="Gbanamma Clinic" required>
                    <div class="invalid-feedback">Please enter Clinic Name.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Corporation <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="corporation"
                        value="BBMP" required>
                    <div class="invalid-feedback">Please enter Corporation.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Constituency <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="constituency"
                        value="Bommanahalli" required>
                    <div class="invalid-feedback">Please enter Constituency.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ward <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="ward"
                        value="Ward 189" required>
                    <div class="invalid-feedback">Please enter Ward.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="contact_person"
                        value="Ramesh Kumar" required>
                    <div class="invalid-feedback">Please enter Contact Person.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control"
                        name="contact_no"
                        value="9876543210"
                        pattern="[0-9]{10}"
                        maxlength="10"
                        required>
                    <div class="invalid-feedback">
                        Please enter a valid Contact Number.
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Internet Service Provider <span class="text-danger">*</span></label>
                    <select class="form-select" name="provider" required>
                        <option>ACT</option>
                        <option selected>Airtel</option>
                        <option>Excitel</option>
                        <option>Hatway</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Internet ID <span class="text-danger">*</span></label>
                    <input type="text" class="form-control"
                        name="internet_id"
                        value="AIR789654"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Internet Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="internet_password" value="password123" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Recharge</label>
                    <input type="date" class="form-control"
                        value="2026-07-09">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Expiry Date</label>
                    <input type="date" class="form-control"
                        value="2026-08-08">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Plan Validity <span class="text-danger">*</span></label>
                    <select class="form-select" name="plan_validity" required>
                        <option value="">Select Plan Validity</option>
                        <option selected>1 Month</option>
                        <option>3 Months</option>
                        <option>6 Months</option>
                        <option>1 Year</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select">
                        <option selected>Active</option>
                        <option>Inactive</option>
                        <option>Expired</option>
                    </select>
                </div>

            </div>

            <div class="text-center mt-4">
                <button class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Update
                </button>

               
            </div>

        </form>

    </div>
</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
(() => {

    const form = document.getElementById('internetForm');

    form.addEventListener('submit', function(e){

        e.preventDefault();

        if(!form.checkValidity()){
            e.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        Swal.fire({
            icon:'success',
            title:'Updated!',
            text:'Internet Data Updated Successfully.',
            confirmButtonColor:'#3085d6'
        }).then(()=>{
            window.location.href="{{ route('internetdata') }}";
        });

    });

})();
</script>

@endpush
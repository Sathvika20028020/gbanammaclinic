@extends('layouts.master')

@section('title', 'User Login - Add Ticket')
@section('page_title', 'Add Tickets')

@section('breadcrumb')
    <li class="breadcrumb-item">Tickets</li>
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">

                <form class="needs-validation"
                      novalidate
                      method="POST"
                      action="{{ route('tickets.store') }}"
                      id="adduserticket">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">

                            {{-- CLINIC NAME --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Clinic Name</label>
                                <input class="form-control"
                                       type="text"
                                       value="{{ $user->clinic_name ?? 'N/A' }}"
                                       readonly>
                            </div>

                            {{-- WARD --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Ward</label>
                                <input class="form-control"
                                       type="text"
                                       value="{{ optional($user->ward)->name ?? 'N/A' }}"
                                       readonly>
                            </div>

                        </div>

                        <div class="col-md-12">

                            {{-- CONTACT PERSON NAME (USER INPUT) --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Contact Person Name</label>
                                <input class="form-control @error('contact_person_name') is-invalid @enderror"
                                       type="text"
                                       name="contact_person_name"
                                       value="{{ old('contact_person_name') }}"
                                       placeholder="Enter Contact Person Name"
                                       required>

                                @error('contact_person_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please enter contact person name.</div>
                                @enderror
                            </div>
                        </div>
                         <div class="col-md-12">

                            {{-- CONTACT PERSON NAME (USER INPUT) --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Contact Number</label>
                                <input class="form-control @error('phone') is-invalid @enderror"
                                       type="text"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       placeholder="Enter Contact Person Name"
                                       required>

                                @error('contact_person_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please enter contact number.</div>
                                @enderror
                            </div>

                            {{-- ISSUE DESCRIPTION --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Issue Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          name="description"
                                          rows="3"
                                          placeholder="Enter Issue Description"
                                          required>{{ old('description') }}</textarea>

                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please enter an issue description.</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button class="btn btn-primary"
                                type="submit"
                                style="border-radius: 12px;">
                            Submit
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("adduserticket");

    if (!form) return;

    form.addEventListener("submit", function(event) {
        event.preventDefault();
        event.stopPropagation();

        if (form.checkValidity()) {
            Swal.fire({
                title: "Confirm Submission",
                text: "Are you sure you want to raise this ticket?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, submit it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        form.classList.add("was-validated");
    });

    @if (session('success'))
        Swal.fire({
            title: "Success!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonColor: "#3085d6"
        });
    @endif
});
</script>
@endpush

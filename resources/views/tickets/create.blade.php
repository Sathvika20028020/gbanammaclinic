@extends('layouts.master')

@section('title', auth()->user()->hasRole('admin') ? 'Admin - Raise Ticket' : 'User Login - Add Ticket')
@section('page_title', 'Add Tickets')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('tickets.index') }}">Tickets</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0">
                <h5>{{ auth()->user()->hasRole('admin') ? 'Raise Ticket on Behalf of Clinic / User' : 'Raise New Issue Ticket' }}</h5>
            </div>
            <div class="card-body">

                <form class="needs-validation"
                      novalidate
                      method="POST"
                      action="{{ route('tickets.store') }}"
                      id="adduserticket">
                    @csrf

                    <div class="row">

                        @role('admin')
                            {{-- ADMIN VIEW: SELECT CLINIC / USER --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Select Clinic / User <span class="text-danger">*</span></label>
                                <select class="form-select @error('user_id') is-invalid @enderror" name="user_id" id="user_select" required>
                                    <option value="">-- Select Clinic / User --</option>
                                    @if(isset($users))
                                        @foreach($users as $u)
                                            <option value="{{ $u->id }}"
                                                    data-clinic="{{ $u->clinic_name }}"
                                                    data-ward="{{ optional($u->ward)->name ?? 'N/A' }}"
                                                    data-contact="{{ $u->name }}"
                                                    data-phone="{{ $u->phone }}"
                                                    {{ old('user_id') == $u->id ? 'selected' : '' }}>
                                                {{ $u->clinic_name ? $u->clinic_name . ' (' . $u->name . ')' : $u->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please select a clinic / user.</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Clinic Name</label>
                                <input class="form-control" type="text" id="clinic_name_display" placeholder="Select clinic above" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ward</label>
                                <input class="form-control" type="text" id="ward_name_display" placeholder="Select clinic above" readonly>
                            </div>
                        @else
                            {{-- REGULAR USER VIEW: FIXED CLINIC AND WARD --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Clinic Name</label>
                                <input class="form-control"
                                       type="text"
                                       value="{{ $user->clinic_name ?? 'N/A' }}"
                                       readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ward</label>
                                <input class="form-control"
                                       type="text"
                                       value="{{ optional($user->ward)->name ?? 'N/A' }}"
                                       readonly>
                            </div>
                        @endrole

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Contact Person Name <span class="text-danger">*</span></label>
                            <input class="form-control @error('contact_person_name') is-invalid @enderror"
                                   type="text"
                                   name="contact_person_name"
                                   id="contact_person_name"
                                   value="{{ old('contact_person_name', !auth()->user()->hasRole('admin') ? $user->name : '') }}"
                                   placeholder="Enter Contact Person Name"
                                   required>

                            @error('contact_person_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Please enter contact person name.</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Contact Number <span class="text-danger">*</span></label>
                            <input class="form-control @error('phone') is-invalid @enderror"
                                   type="text"
                                   name="phone"
                                   id="phone"
                                   value="{{ old('phone', !auth()->user()->hasRole('admin') ? $user->phone : '') }}"
                                   pattern="[0-9]{10}"
                                   maxlength="10"
                                   placeholder="Enter 10-digit Phone Number"
                                   required>

                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Issue Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      name="description"
                                      rows="4"
                                      placeholder="Enter the issue reported by the clinic caller..."
                                      required>{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="invalid-feedback">Please enter an issue description.</div>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('tickets.index') }}" class="btn btn-secondary me-2" style="border-radius: 12px;">Cancel</a>
                        <button class="btn btn-primary"
                                type="submit"
                                style="border-radius: 12px;">
                            Raise Ticket
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
    @role('admin')
    const userSelect = document.getElementById('user_select');
    const clinicDisplay = document.getElementById('clinic_name_display');
    const wardDisplay = document.getElementById('ward_name_display');
    const contactInput = document.getElementById('contact_person_name');
    const phoneInput = document.getElementById('phone');

    function syncUserFields() {
        if (!userSelect) return;
        const opt = userSelect.options[userSelect.selectedIndex];
        if (opt && opt.value) {
            clinicDisplay.value = opt.getAttribute('data-clinic') || 'N/A';
            wardDisplay.value = opt.getAttribute('data-ward') || 'N/A';
            if (!contactInput.value || contactInput.dataset.touched !== 'true') {
                contactInput.value = opt.getAttribute('data-contact') || '';
            }
            if (!phoneInput.value || phoneInput.dataset.touched !== 'true') {
                phoneInput.value = opt.getAttribute('data-phone') || '';
            }
        } else {
            clinicDisplay.value = '';
            wardDisplay.value = '';
        }
    }

    if (userSelect) {
        userSelect.addEventListener('change', syncUserFields);
        contactInput.addEventListener('input', () => contactInput.dataset.touched = 'true');
        phoneInput.addEventListener('input', () => phoneInput.dataset.touched = 'true');
        if (userSelect.value) syncUserFields();
    }
    @endrole

    const form = document.getElementById("adduserticket");
    if (!form) return;

    form.addEventListener("submit", function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add("was-validated");
    });
});
</script>
@endpush

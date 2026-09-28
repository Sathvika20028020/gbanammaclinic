@extends('layouts.master')

@section('title', 'Admin Dashboard - Add User')
@section('page_title', 'Add User')

@section('breadcrumb')
    <li class="breadcrumb-item">Users</li>
    <li class="breadcrumb-item active">Add</li>
@endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.users.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    {{-- BASIC DETAILS --}}
                    <h4 class="fw-bold mt-2">Basic Details</h4>
                    <div class="row g-3 mt-1 mb-4">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ward</label>
                            <select name="ward_id" id="wardSelect"
                                class="form-select select2 @error('ward_id') is-invalid @enderror" required>
                                <option value="">Select Ward</option>
                                @foreach ($wards as $ward)
                                    <option value="{{ $ward->id }}"
                                        {{ old('ward_id') == $ward->id ? 'selected' : '' }}>
                                        {{ $ward->number }} - {{ $ward->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ward_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Clinic Name</label>
                            <input type="text" name="clinic_name"
                                class="form-control @error('clinic_name') is-invalid @enderror"
                                value="{{ old('clinic_name') }}" required>
                            @error('clinic_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Latitude</label>
                            <input type="text" id="latitude" name="latitude"
                                class="form-control @error('latitude') is-invalid @enderror"
                                value="{{ old('latitude') }}">
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Longitude</label>
                            <input type="text" id="longitude" name="longitude"
                                class="form-control @error('longitude') is-invalid @enderror"
                                value="{{ old('longitude') }}">
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Internet Status</label>
                            <select name="internet_status"
                                class="form-select @error('internet_status') is-invalid @enderror" required>
                                <option value="">Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            @error('internet_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- COMMUNICATION DETAILS --}}
                    <h4 class="fw-bold">Communication Details</h4>
                    <div class="row g-3 mt-1 mb-4">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="tel" name="phone" maxlength="10"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- PLAN DETAILS --}}
                    <h4 class="fw-bold">Plan Details</h4>
                    <div class="row g-3 mt-1">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Internet Speed</label>
                            <input type="text" class="form-control" value="300 Mbps" readonly>
                            <input type="hidden" name="internet_speed" value="300 Mbps">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Package</label>
                            <input type="text" class="form-control" value="Unlimited" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Validity</label>
                            <input type="text" class="form-control" value="6 Months" readonly>
                            <input type="hidden" name="validity" value="6">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Items Provided</label>
                            <input type="text" class="form-control" value="Router, Cable, Adapter" readonly>
                            <input type="hidden" name="items_provided[]" value="Router">
                            <input type="hidden" name="items_provided[]" value="Cable">
                            <input type="hidden" name="items_provided[]" value="Adapter">
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-primary px-4" type="submit">Submit</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $('#wardSelect').select2({
        placeholder: 'Search ward...',
        width: '100%'
    });

    document.addEventListener('DOMContentLoaded', function () {

        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        if (!navigator.geolocation) {
            console.warn('Geolocation not supported');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function (position) {

                // Do NOT override manually entered values
                if (!latInput.value) {
                    latInput.value = position.coords.latitude;
                }

                if (!lngInput.value) {
                    lngInput.value = position.coords.longitude;
                }

            },
            function (error) {
                console.warn('Geolocation error:', error.message);
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    });
</script>
@endpush

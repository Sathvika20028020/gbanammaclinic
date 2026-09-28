@extends('layouts.master')

@section('title', 'Admin - Installation Form')
@section('page_title', 'Installation Form')

@section('breadcrumb')
    <li class="breadcrumb-item">Installation</li>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endpush

@section('content')
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow" style="border-radius: 20px;">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('installations.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data"
                          id="installationForm">
                        @csrf

                        <input type="hidden" name="latitude" id="lat">
                        <input type="hidden" name="longitude" id="lng">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">User Name</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->clinic_name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Upload Image</label>
                            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Upload GPS Image</label>
                            <input type="file" name="gps_image" id="gpsImageInput" class="form-control" accept="image/*">
                            <div class="form-text">Attach an image containing GPS coordinates if available.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Installed On</label>
                            <input type="date" 
                                   name="installed_on" 
                                   class="form-control fw-bold" 
                                   value="{{ date('Y-m-d') }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Comments</label>
                            <textarea name="comments" 
                                      class="form-control" 
                                      rows="2" 
                                      placeholder="Enter Your Comments..."></textarea>
                        </div>

                        <div id="gps-status" class="small mb-3 text-muted">
                            <i class="fa fa-map-marker"></i> Detecting location...
                        </div>

                        <div class="text-center mt-3">
                            <button type="submit" 
                                    id="submitBtn"
                                    class="btn btn-primary px-4 fw-bold" 
                                    style="border-radius: 10px;">
                                <span id="btnText">Submit Installation</span>
                                <span id="btnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- SweetAlert2 is usually in master layout, but adding here just in case --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Compressor.js is required for speed --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/compressorjs/1.2.1/compressor.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- 1. GPS LOGIC ---
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('lat').value = position.coords.latitude;
                    document.getElementById('lng').value = position.coords.longitude;
                    document.getElementById('gps-status').innerHTML = 
                        '<span class="text-success"><i class="fa fa-check-circle"></i> Location captured.</span>';
                },
                function(error) {
                    document.getElementById('gps-status').innerHTML = 
                        '<span class="text-warning"><i class="fa fa-exclamation-triangle"></i> Location denied.</span>';
                }
            );
        }

        // --- 2. COMPRESSION LOGIC (COMPATIBLE WITH REDIRECT CONTROLLER) ---
        const form = document.getElementById('installationForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');

        form.addEventListener('submit', function(e) {
            // If we have already compressed, let the form submit naturally
            if (form.dataset.compressed === "true") return;

            e.preventDefault(); // Pause to compress

            submitBtn.disabled = true;
            btnText.innerText = "Compressing Photos...";
            btnSpinner.classList.remove('d-none');

            const fileInputs = form.querySelectorAll('input[type="file"]');
            let promises = [];

            fileInputs.forEach(input => {
                const file = input.files[0];
                if (file) {
                    promises.push(new Promise((resolve) => {
                        new Compressor(file, {
                            quality: 0.6,
                            maxWidth: 1200,
                            success(result) {
                                // Important: This creates a new DataTransfer to inject the compressed file back into the input
                                const dataTransfer = new DataTransfer();
                                dataTransfer.items.add(new File([result], file.name, { type: result.type }));
                                input.files = dataTransfer.files;
                                resolve();
                            },
                            error() { resolve(); }
                        });
                    }));
                }
            });

            // Wait for compression, then submit naturally
            Promise.all(promises).then(() => {
                btnText.innerText = "Uploading (Fast)...";
                form.dataset.compressed = "true"; // Mark as done
                form.submit(); // THIS TRIGGER'S YOUR CONTROLLER'S REDIRECT
            });
        });
    });
</script>

{{-- ✅ THIS PART SHOWS THE SWEETALERT AFTER THE REDIRECT --}}
@if(session('success'))
<script>
    Swal.fire({
        title: 'Done!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonColor: '#3085d6'
    });
</script>
@endif
@endpush
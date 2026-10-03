@extends('layouts.master')

@section('title', 'Resolve Ticket #' . ($ticket->id ?? 'N/A'))
@section('page_title', 'Resolve Ticket')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('tickets.index') }}">Tickets</a></li>
    <li class="breadcrumb-item active">Resolve #{{ $ticket->id }}</li>
@endsection

@section('content')
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-sm-12">

                <div class="card shadow" style="border-radius: 15px;">
                    <div class="card-header d-flex justify-content-between align-items-center pb-0">
                        <h5>Resolve Ticket #{{ $ticket->id }} - {{ $ticket->user->clinic_name ?? 'N/A' }}</h5>
                        <a href="{{ route('tickets.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Clinic Name</label>
                                <input type="text" class="form-control" value="{{ $ticket->user->clinic_name ?? 'N/A' }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ward</label>
                                <input type="text" class="form-control" value="{{ optional($ticket->user->ward)->name ?? 'N/A' }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Contact Person Name</label>
                                <input type="text" class="form-control" value="{{ $ticket->contact_person_name ?? 'N/A' }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Contact Number</label>
                                <input type="text" class="form-control" value="{{ $ticket->phone ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                        {{-- REPORTED ISSUE DESCRIPTION --}}
                        <div class="card border border-primary mb-4">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0 text-primary"><i class="fa fa-exclamation-circle me-1"></i> Reported Issue Description</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0 fs-6 text-dark" style="white-space: pre-wrap;">{{ $ticket->description }}</p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <form action="{{ route('tickets.update', $ticket->id) }}" method="POST"
                            enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <h6 class="text-success mb-3"><i class="fa fa-reply me-1"></i> Admin Reply & Resolution Details</h6>

                            {{-- Status --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Update Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="Pending"
                                        {{ trim(strtolower(old('status', $ticket->status))) === 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="Resolved"
                                        {{ trim(strtolower(old('status', $ticket->status))) === 'resolved' ? 'selected' : '' }}>
                                        Resolved
                                    </option>
                                    <option value="Irrelevant"
                                        {{ trim(strtolower(old('status', $ticket->status))) === 'irrelevant' ? 'selected' : '' }}>
                                        Irrelevant
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Admin Reply / Remarks --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Admin Reply / Resolution Remarks <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('admin_remarks') is-invalid @enderror" 
                                          name="admin_remarks" 
                                          rows="4" 
                                          placeholder="Type your resolution reply or remarks for the clinic..." 
                                          required>{{ old('admin_remarks', $ticket->admin_remarks) }}</textarea>

                                @error('admin_remarks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please provide resolution remarks / reply.</div>
                                @enderror
                            </div>

                            {{-- Admin Image / Attachment --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Resolution Proof / Attachment (Optional Image)</label>
                                <input type="file" name="admin_image" accept="image/*"
                                    class="form-control @error('admin_image') is-invalid @enderror">

                                @error('admin_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($ticket->admin_image)
                                    <div class="mt-2">
                                        <small class="text-muted d-block mb-1">Current Attachment:</small>
                                        <a href="{{ asset('storage/app/public/' . $ticket->admin_image) }}" target="_blank">
                                            <img src="{{ asset('storage/app/public/' . $ticket->admin_image) }}"
                                                 alt="Current Resolution Image"
                                                 style="max-width: 150px; border-radius: 8px; border: 1px solid #ddd;">
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('tickets.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fa fa-save me-1"></i> Save Reply & Update Status
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

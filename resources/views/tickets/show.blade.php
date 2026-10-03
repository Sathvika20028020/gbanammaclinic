@extends('layouts.master')

@section('title', 'View Ticket #' . $ticket->id)
@section('page_title', 'Ticket Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('tickets.index') }}">Tickets</a></li>
    <li class="breadcrumb-item active">View #{{ $ticket->id }}</li>
@endsection

@section('content')

@php
    $status = strtolower($ticket->status ?? '');
    $badgeClass = match ($status) {
        'resolved'   => 'bg-success',
        'pending'    => 'bg-warning text-dark',
        'irrelevant' => 'bg-danger',
        default      => 'bg-secondary',
    };
@endphp

<div class="row">
    <div class="col-sm-12">
        <div class="card shadow" style="border-radius: 15px;">
            <div class="card-header d-flex justify-content-between align-items-center pb-0">
                <h5>Ticket #{{ $ticket->id }} - {{ $ticket->user->clinic_name ?? 'Clinic Ticket' }}</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('tickets.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-arrow-left me-1"></i> Back to Tickets
                    </a>
                    @role('admin')
                        <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil-square me-1"></i> Resolve / Reply
                        </a>
                    @endrole
                </div>
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

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Current Status</label>
                        <div>
                            <span class="badge {{ $badgeClass }} fs-6">{{ ucfirst($ticket->status) }}</span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Created At</label>
                        <input type="text" class="form-control" value="{{ $ticket->created_at ? $ticket->created_at->format('d-M-Y h:i A') : 'N/A' }}" readonly>
                    </div>
                </div>

                {{-- ISSUE DESCRIPTION --}}
                <div class="card border mb-4">
                    <div class="card-header bg-light py-2">
                        <h6 class="mb-0 text-primary"><i class="fa fa-exclamation-circle me-1"></i> Issue Description</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0 fs-6 text-dark" style="white-space: pre-wrap;">{{ $ticket->description }}</p>
                    </div>
                </div>

                {{-- ADMIN REPLY / REMARKS --}}
                <div class="card border mb-4 {{ $ticket->admin_remarks ? 'border-success' : 'border-secondary' }}">
                    <div class="card-header bg-light py-2">
                        <h6 class="mb-0 text-success"><i class="fa fa-reply me-1"></i> Admin Reply & Resolution Remarks</h6>
                    </div>
                    <div class="card-body">
                        @if ($ticket->admin_remarks)
                            <p class="mb-0 fs-6 text-dark" style="white-space: pre-wrap;">{{ $ticket->admin_remarks }}</p>
                        @else
                            <p class="text-muted fst-italic mb-0">No admin reply / resolution remarks added yet.</p>
                        @endif

                        {{-- Attached Resolution Image --}}
                        @if ($ticket->admin_image)
                            <div class="mt-3 pt-3 border-top">
                                <label class="form-label fw-bold text-muted">Resolution Proof / Attachment:</label><br>
                                <a href="{{ asset('storage/app/public/' . $ticket->admin_image) }}" target="_blank">
                                    <img src="{{ asset('storage/app/public/' . $ticket->admin_image) }}"
                                         alt="Resolution Image"
                                         class="img-fluid rounded border shadow-sm"
                                         style="max-width: 320px; max-height: 240px; object-fit: cover;">
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

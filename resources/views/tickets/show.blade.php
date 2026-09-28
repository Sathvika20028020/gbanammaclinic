@extends('layouts.master')

@section('title', 'Admin Dashboard - View Ticket')
@section('page_title', 'View Ticket')

@section('breadcrumb')
    <li class="breadcrumb-item">Tickets</li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow" style="border-radius: 20px;">
                <div class="card-body">

                    {{-- Clinic --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Clinic Name</label>
                        <input type="text" class="form-control"
                               value="{{ $ticket->user->clinic_name ?? 'N/A' }}" readonly>
                    </div>

                    {{-- Ward --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ward</label>
                        <input type="text" class="form-control"
                               value="{{ $ticket->user->ward->name ?? 'N/A' }}" readonly>
                    </div>

                    {{-- Communication Person --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Communication Person</label>
                        <input type="text" class="form-control"
                               value="{{ $ticket->contact_person_name ?? 'N/A' }}" readonly>
                    </div>

                    {{-- Issue Description --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Issue Description</label>
                        <textarea class="form-control" rows="3" readonly>{{ $ticket->description }}</textarea>
                    </div>

                    <hr>

                    {{-- Attached Image --}}
                    @if ($ticket->admin_image)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Attached Image</label><br>

                            <img src="{{ asset('storage/app/public/' . $ticket->admin_image) }}"
                                 alt="Admin Uploaded Image"
                                 style="max-width: 260px; border-radius: 10px; border: 1px solid #ddd;">
                        </div>
                    @endif

                    {{-- Admin Remarks --}}
                    @if ($ticket->admin_remarks)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Admin Remarks</label>
                            <textarea class="form-control" rows="2" readonly>{{ $ticket->admin_remarks }}</textarea>
                        </div>
                    @endif

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <input type="text" class="form-control" value="{{ $ticket->status }}" readonly>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@extends('layouts.master')

@section('title', 'Admin Dashboard - Resolve Ticket #' . ($ticket->id ?? 'N/A'))
@section('page_title', 'Resolve Ticket')

@section('breadcrumb')
    <li class="breadcrumb-item">Tickets</li>
    <li class="breadcrumb-item active">Resolve</li>
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-12">

                <div class="card shadow" style="border-radius: 20px;">
                    <div class="card-body">
                        <h3 class="fw-bold mb-3">User Details</h3>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Clinic Name</label>
                            <input type="text" class="form-control" value="{{ $ticket->user->clinic_name ?? 'N/A' }}"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ward</label>
                            <input type="text" class="form-control" value="{{ $ticket->user->ward->name ?? 'N/A' }}"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Communication Person Name</label>
                            <input type="text" class="form-control" value="{{ $ticket->contact_person_name ?? 'N/A' }}"
                                readonly>
                        </div>

                        {{-- Issue Description --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Issue Description</label>
                            <textarea class="form-control" readonly style="height:auto; white-space:normal;">{{ $ticket->description }}</textarea>
                        </div>

                        <hr>

                        <form action="{{ route('tickets.update', $ticket->id) }}" method="POST"
                            enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            {{-- Admin Image --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Upload Image</label>
                                <input type="file" name="admin_image" accept="image/*"
                                    class="form-control @error('admin_image') is-invalid @enderror">

                                @error('admin_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($ticket->admin_image)
                                    <small class="text-muted d-block mt-1">
                                        Current: {{ basename($ticket->admin_image) }}
                                    </small>
                                @endif
                            </div>

                            {{-- Remarks --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Remarks</label>
                                <textarea class="form-control @error('admin_remarks') is-invalid @enderror" name="admin_remarks" rows="2">{{ old('admin_remarks', $ticket->admin_remarks) }}</textarea>

                                @error('admin_remarks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>

                                    <option value="Pending"
                                        {{ trim(strtolower(old('status', $ticket->status))) === 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>

                                    <option value="Irrelevant"
                                        {{ trim(strtolower(old('status', $ticket->status))) === 'irrelevant' ? 'selected' : '' }}>
                                        Irrelevant
                                    </option>

                                    <option value="Resolved"
                                        {{ trim(strtolower(old('status', $ticket->status))) === 'resolved' ? 'selected' : '' }}>
                                        Resolved
                                    </option>

                                </select>


                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4 fw-bold" style="border-radius: 10px;">
                                    Update Ticket
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

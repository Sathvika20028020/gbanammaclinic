@extends('layouts.master')

@section('title', 'View Internet Data & Recharges')
@section('page_title', 'Internet Data Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('internetdata.index') }}">Internet Data</a></li>
    <li class="breadcrumb-item active">Show</li>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@php
    $user = $installation->user;
    $ward = $user?->ward ?? $installation->ward;
    $constituency = $ward?->constituency;
    $corporation = $constituency?->zone?->corporation;
    $computedStatus = $installation->computed_status;
    $badgeClass = match($computedStatus) {
        'active' => 'bg-success',
        'expiring_soon' => 'bg-warning text-dark',
        'expired' => 'bg-danger',
        default => 'bg-secondary'
    };
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center pb-0">
                <h5>{{ $user?->clinic_name ?? 'Clinic Details' }}</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('internetdata.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-arrow-left me-1"></i> Back
                    </a>
                    <a href="{{ route('internetdata.edit', $installation->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i> Edit Info
                    </a>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRechargeModal">
                        <i class="bi bi-plus-circle me-1"></i> Add New Recharge
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-primary border-bottom pb-2 mb-3"><i class="fa fa-hospital-o me-1"></i> Clinic & Location Details</h6>
                        <table class="table table-bordered table-sm">
                            <tr>
                                <th class="w-40 bg-light">Clinic Name</th>
                                <td><strong>{{ $user?->clinic_name ?? 'N/A' }}</strong></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Corporation</th>
                                <td>{{ $corporation?->name ?? 'BBMP' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Constituency</th>
                                <td>{{ $constituency?->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Ward</th>
                                <td>{{ $ward ? $ward->name . ' (' . ($ward->number ?? '') . ')' : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Contact Person</th>
                                <td>{{ $user?->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Contact Number</th>
                                <td>{{ $user?->phone ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-primary border-bottom pb-2 mb-3"><i class="fa fa-wifi me-1"></i> ISP & Credentials</h6>
                        <table class="table table-bordered table-sm">
                            <tr>
                                <th class="w-40 bg-light">Internet Provider (ISP)</th>
                                <td><span class="badge bg-primary">{{ $installation->provider ?? 'Not Set' }}</span></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Internet ID / Account</th>
                                <td><code>{{ $installation->internet_id ?? 'N/A' }}</code></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Password / Key</th>
                                <td>{{ $installation->internet_password ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Current Plan Validity</th>
                                <td>{{ $installation->plan_validity ?? '6 Months' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Current Expiry Date</th>
                                <td><strong>{{ $installation->recharge_expiry_date ? $installation->recharge_expiry_date->format('d-M-Y') : ($installation->expiry_date ?? 'N/A') }}</strong></td>
                            </tr>
                            <tr>
                                <th class="bg-light">Status</th>
                                <td><span class="badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $computedStatus)) }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Recharge History --}}
                <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
                    <h5 class="mb-0 text-dark"><i class="fa fa-history me-1"></i> Recharge History ({{ $installation->recharges->count() }})</h5>
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRechargeModal">
                        <i class="bi bi-plus me-1"></i> Log Recharge
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Recharge Date</th>
                                <th>Expiry Date</th>
                                <th>Plan Validity</th>
                                <th>Amount</th>
                                <th>Receipt / Ref No</th>
                                <th>Remarks</th>
                                <th>Logged By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($installation->recharges as $idx => $recharge)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td><strong>{{ $recharge->recharge_date ? $recharge->recharge_date->format('d-M-Y') : 'N/A' }}</strong></td>
                                    <td><span class="text-danger fw-bold">{{ $recharge->expiry_date ? $recharge->expiry_date->format('d-M-Y') : 'N/A' }}</span></td>
                                    <td>{{ $recharge->plan_validity }}</td>
                                    <td>{{ $recharge->amount ? '₹' . number_format($recharge->amount, 2) : '—' }}</td>
                                    <td>{{ $recharge->receipt_no ?? '—' }}</td>
                                    <td>{{ $recharge->remarks ?? '—' }}</td>
                                    <td><small>{{ optional($recharge->creator)->name ?? 'System' }}</small></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">No recharge history logged yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Add Recharge Modal --}}
<div class="modal fade" id="addRechargeModal" tabindex="-1" aria-labelledby="addRechargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('internetdata.recharge.store', $installation->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addRechargeModalLabel">Add New Recharge</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Recharge Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="recharge_date" id="modal_recharge_date" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Plan Validity <span class="text-danger">*</span></label>
                        <select class="form-select" name="plan_validity" id="modal_plan_validity" required>
                            <option value="1 Month">1 Month</option>
                            <option value="3 Months">3 Months</option>
                            <option value="6 Months" selected>6 Months</option>
                            <option value="1 Year">1 Year</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Expiry Date</label>
                        <input type="date" class="form-control" name="expiry_date" id="modal_expiry_date" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Amount (₹)</label>
                        <input type="number" step="0.01" class="form-control" name="amount" placeholder="e.g. 1500.00">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Receipt / Transaction Reference</label>
                        <input type="text" class="form-control" name="receipt_no" placeholder="e.g. TXN-123456">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Remarks / Notes</label>
                        <textarea class="form-control" name="remarks" rows="2" placeholder="Optional notes..."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Recharge</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rechargeDateInput = document.getElementById('modal_recharge_date');
        const validitySelect = document.getElementById('modal_plan_validity');
        const expiryDateInput = document.getElementById('modal_expiry_date');

        function calculateModalExpiry() {
            if (!rechargeDateInput.value) return;
            const date = new Date(rechargeDateInput.value);
            const validity = validitySelect.value;

            if (validity === '1 Month') {
                date.setMonth(date.getMonth() + 1);
            } else if (validity === '3 Months') {
                date.setMonth(date.getMonth() + 3);
            } else if (validity === '6 Months') {
                date.setMonth(date.getMonth() + 6);
            } else if (validity === '1 Year') {
                date.setFullYear(date.getFullYear() + 1);
            }

            const yyyy = date.getFullYear();
            const mm = String(date.getMonth() + 1).padStart(2, '0');
            const dd = String(date.getDate()).padStart(2, '0');
            expiryDateInput.value = `${yyyy}-${mm}-${dd}`;
        }

        rechargeDateInput.addEventListener('change', calculateModalExpiry);
        validitySelect.addEventListener('change', calculateModalExpiry);
        calculateModalExpiry();
    });
</script>
@endpush
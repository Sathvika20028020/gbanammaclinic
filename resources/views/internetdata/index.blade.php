@extends('layouts.master')

@section('title', 'Internet Data & Recharges')
@section('page_title', 'Internet Data')

@section('breadcrumb')
    <li class="breadcrumb-item active">Internet Data</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endpush

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Internet Connections & Recharge Tracker</h4>

            <div class="d-flex gap-2">
                <a href="{{ route('internetdata.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Add Connection / Recharge
                </a>
                <a href="{{ route('internetdata.export') }}" class="btn btn-secondary" id="exportBtn">
                    <i class="bi bi-download me-1"></i> Export CSV
                </a>
            </div>
        </div>

        <form method="GET" action="{{ route('internetdata.index') }}" class="row mb-4">
            <div class="col-md-2">
                <label for="corporation_filter" class="form-label">Corporation</label>
                <select class="form-select" name="corporation" id="corporation_filter" onchange="this.form.submit()">
                    <option value="">All Corporations</option>
                    @foreach($corporations as $corp)
                        <option value="{{ $corp->name }}" {{ request('corporation') == $corp->name ? 'selected' : '' }}>{{ $corp->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="constituency_filter" class="form-label">Constituency</label>
                <select class="form-select" name="constituency" id="constituency_filter" onchange="this.form.submit()">
                    <option value="">All Constituencies</option>
                    @foreach($constituencies as $const)
                        <option value="{{ $const->name }}" {{ request('constituency') == $const->name ? 'selected' : '' }}>{{ $const->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="service_type_filter" class="form-label">ISP Provider</label>
                <select class="form-select" name="provider" id="service_type_filter" onchange="this.form.submit()">
                    <option value="">All Providers</option>
                    <option value="ACT" {{ request('provider') == 'ACT' ? 'selected' : '' }}>ACT</option>
                    <option value="Airtel" {{ request('provider') == 'Airtel' ? 'selected' : '' }}>Airtel</option>
                    <option value="Excitel" {{ request('provider') == 'Excitel' ? 'selected' : '' }}>Excitel</option>
                    <option value="Hathway" {{ request('provider') == 'Hathway' ? 'selected' : '' }}>Hathway</option>
                    <option value="Jio" {{ request('provider') == 'Jio' ? 'selected' : '' }}>Jio</option>
                    <option value="BSNL" {{ request('provider') == 'BSNL' ? 'selected' : '' }}>BSNL</option>
                    <option value="Local" {{ request('provider') == 'Local' ? 'selected' : '' }}>Local</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="from_date_filter" class="form-label">From Date</label>
                <input type="date" class="form-control" name="from_date" id="from_date_filter" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-2">
                <label for="to_date_filter" class="form-label">To Date</label>
                <input type="date" class="form-control" name="to_date" id="to_date_filter" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end gap-1">
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-filter"></i> Filter</button>
                <a href="{{ route('internetdata.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="display" id="internet-table" style="width:100%">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Clinic Name</th>
                        <th>Corporation</th>
                        <th>Constituency</th>
                        <th>Ward</th>
                        <th>Contact Person</th>
                        <th>Contact No</th>
                        <th>ISP Provider</th>
                        <th>Internet ID</th>
                        <th>Last Recharge</th>
                        <th>Expiry Date</th>
                        <th>Plan Validity</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($installations as $index => $ins)
                        @php
                            $user = $ins->user;
                            $ward = $user?->ward ?? $ins->ward;
                            $constituency = $ward?->constituency;
                            $corporation = $constituency?->zone?->corporation;
                            $computedStatus = $ins->computed_status;
                            $badgeClass = match($computedStatus) {
                                'active' => 'bg-success',
                                'expiring_soon' => 'bg-warning text-dark',
                                'expired' => 'bg-danger',
                                default => 'bg-secondary'
                            };
                            $badgeText = match($computedStatus) {
                                'active' => 'Active',
                                'expiring_soon' => 'Expiring Soon',
                                'expired' => 'Expired',
                                default => ucfirst($computedStatus)
                            };
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $user?->clinic_name ?? 'N/A' }}</strong></td>
                            <td>{{ $corporation?->name ?? 'BBMP' }}</td>
                            <td>{{ $constituency?->name ?? 'N/A' }}</td>
                            <td>{{ $ward ? $ward->name . ' (' . ($ward->number ?? '') . ')' : 'N/A' }}</td>
                            <td>{{ $user?->name ?? 'N/A' }}</td>
                            <td>{{ $user?->phone ?? 'N/A' }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $ins->provider ?? 'N/A' }}</span></td>
                            <td><code>{{ $ins->internet_id ?? 'N/A' }}</code></td>
                            <td>{{ $ins->last_recharge_date ? $ins->last_recharge_date->format('d-M-Y') : ($ins->installed_on ? $ins->installed_on->format('d-M-Y') : 'N/A') }}</td>
                            <td>{{ $ins->recharge_expiry_date ? $ins->recharge_expiry_date->format('d-M-Y') : ($ins->expiry_date ?? 'N/A') }}</td>
                            <td>{{ $ins->plan_validity ?? '6 Months' }}</td>
                            <td><span class="badge {{ $badgeClass }}">{{ $badgeText }}</span></td>
                            <td class="text-nowrap text-center">
                                <a href="{{ route('internetdata.show', $ins->id) }}" class="btn btn-info btn-sm me-1" title="View Details & Recharges">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                                <a href="{{ route('internetdata.edit', $ins->id) }}" class="btn btn-warning btn-sm" title="Edit Internet Credentials">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" class="text-center text-muted py-4">No internet data records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#internet-table').DataTable({
            order: [[0, 'asc']]
        });
    });
</script>
@endpush

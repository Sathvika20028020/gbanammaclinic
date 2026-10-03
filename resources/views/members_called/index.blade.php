@extends('layouts.master')

@section('title', 'Clinic Issues')
@section('page_title', 'Clinic Issues / Calls')

@section('breadcrumb')
    <li class="breadcrumb-item active">Clinic Issues</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Logged Issues & Member Calls</h4>

            <div class="d-flex gap-2">
                <a href="{{ route('members_called.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Add Issue / Call
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="display" id="clinic-issues-table" style="width:100%">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Clinic Name</th>
                        <th>Member / Doctor Name</th>
                        <th>Contact Number</th>
                        <th>Issue Reported</th>
                        <th>Call Date & Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Gbanamma Clinic</td>
                        <td>Dr. Ramesh Kumar</td>
                        <td>9876543210</td>
                        <td>Network connectivity down since morning</td>
                        <td>{{ date('d-M-Y H:i') }}</td>
                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                        <td class="text-nowrap">
                            <a href="{{ route('members_called.show') }}" class="btn btn-info btn-sm me-2">
                                <i class="fas fa-eye me-1"></i>View
                            </a>
                            <a href="{{ route('members_called.edit') }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                        </td>
                    </tr>
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
        $('#clinic-issues-table').DataTable();
    });
</script>
@endpush

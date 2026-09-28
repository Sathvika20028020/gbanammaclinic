@extends('layouts.master')

@section('title', 'Constituencies')
@section('page_title', 'Constituencies')

@section('breadcrumb')
    <li class="breadcrumb-item active">Constituencies</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-body">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"></h4>
    @role('admin')
        <a href="{{ route('constituencies.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Constituency
        </a>    
    @endrole
</div>

<div class="table-responsive">
    <table class="display" id="constituencies-table" style="width:100%">
        <thead>
            <tr>
                <th>Sl.No</th>
                <th>Name</th>
                <th>Zone</th>
                <th>Ward Count</th>
              
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($constituencies as $index => $constituency)
                <tr id="row-{{ $constituency->id }}">
                    <td>{{ $index + 1 }}</td>

                    <td>{{ $constituency->name }}</td>

                    <td>{{ $constituency->zone->name ?? 'N/A' }}</td>

                    <td>{{ $constituency->wards_count ?? $constituency->wards->count() }}</td>

                   
                    <td>
                        <button class="btn btn-sm btn-info"
                                onclick="window.location.href='{{ route('constituencies.show', $constituency->id) }}'">
                            <i class="bi bi-eye"></i>
                        </button>
                            <button class="btn btn-sm btn-primary"
                                    onclick="window.location.href='{{ route('constituencies.edit', $constituency->id) }}'">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No constituencies found.</td>
                </tr>
            @endforelse
        </tbody>

    </table>
</div>

    </div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#constituencies-table').DataTable();
    });
</script>
@endpush

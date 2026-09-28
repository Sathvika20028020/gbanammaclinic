@extends('layouts.master')

@section('title', 'Zones List')
@section('page_title', 'Zones')

@section('breadcrumb')
    <li class="breadcrumb-item">Zones</li>
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endpush

@section('content')
<data class="card">
    <div class="card-body">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"></h4>
    @role('admin')
        <a href="{{ route('zones.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Zone
        </a>
    @endrole
</div>

<div class="table-responsive">
    <table class="display" id="zones-table" style="width:100%">
        <thead>
            <tr>
                <th>Sl.No</th>
                <th>Zone Name</th>
                <th>Corporation</th>
                
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($zones as $index => $zone)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $zone->name }}</td>
                    <td>{{ $zone->corporation->name ?? 'N/A' }}</td>

                  

                    <td>
                        <a href="{{ route('zones.show', $zone->id) }}"
                           class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i>
                        </a>
                      
                            <a href="{{ route('zones.edit', $zone->id) }}"
                               class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                     
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No zones found.</td>
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
        $('#zones-table').DataTable();
    });
</script>
@endpush

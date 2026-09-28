@extends('layouts.master')

@section('title', 'Corporations')
@section('page_title', 'Corporations')

@section('breadcrumb')
    <li class="breadcrumb-item active">Corporations</li>
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
            <a href="{{ route('corporations.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Corporation
            </a>
        @endrole
    </div>

    <div class="table-responsive">
        <table class="display" id="corporations-table" style="width:100%">
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>Name</th>
                    <th>Total Zones</th>
                
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($corporations as $index => $corporation)
                    <tr id="row-{{ $corporation->id }}">
                        <td>{{ $corporation->id }}</td>

                        <td>{{ $corporation->name ?? 'N/A' }}</td>

                        <td>{{ $corporation->zones->count() }}</td>


                        <td class="d-flex">
                            <button class="btn btn-sm btn-info me-2"
                                    onclick="window.location.href='{{ route('corporations.show', $corporation->id) }}'">
                                <i class="bi bi-eye"></i>
                            </button>
                           
                                <button class="btn btn-sm btn-primary me-2"
                                        onclick="window.location.href='{{ route('corporations.edit', $corporation->id) }}'">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                           
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">No corporations found.</td>
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
            $('#corporations-table').DataTable({
                pageLength: 10,
            });
        });
    </script>
@endpush

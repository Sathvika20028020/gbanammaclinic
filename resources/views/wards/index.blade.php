@extends('layouts.master')

@section('title', 'Wards')
@section('page_title', 'Wards')

@section('breadcrumb')
    <li class="breadcrumb-item">Wards</li>
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
            <a href="{{ route('wards.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Ward
            </a>
        @endrole
    </div>

    <div class="table-responsive mt-3">
        <table class="display" id="wards-table" style="width:100%">
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>Ward Number</th>
                    <th>Ward Name</th>
                    <th>Constituency</th>
                    <th>Zone</th>
                    <th>Corporation</th>
                   
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($wards as $index => $ward)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $ward->number }}</td>
                        <td>{{ $ward->name }}</td>
                        <td>{{ $ward->constituency->name ?? '-' }}</td>
                        <td>{{ $ward->constituency->zone->name ?? '-' }}</td>
                        <td>{{ $ward->constituency->zone->corporation->name ?? '-' }}</td>                   
                        <td>
                            <div class="d-flex flex-column flex-md-row">
                                <a href="{{ route('wards.show', $ward->id) }}" 
                               class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('wards.edit', $ward->id) }}" 
                               class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            </div>                           
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#wards-table').DataTable();
        });
    </script>
@endpush

@extends('layouts.master')

@section('title', 'PHCs')
@section('page_title', 'PHCs')

@section('breadcrumb')
    <li class="breadcrumb-item">PHCs</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 add"></h4>

        <a href="{{ route('phcs.create') }}" class="btn btn-primary text-white">
            <i class="bi bi-plus-circle me-1"></i> Add PHC
        </a>
    </div>

    <div class="table-responsive">
        <table class="display" id="data-source-1" style="width:100%">
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>PHC Name</th>
                    <th>Ward</th>
                    <th>Constituency</th>
                    <th>Zone</th>
                    <th>Corporation</th>
                 
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($phcs as $index => $phc)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>{{ $phc->name }}</td>

                        <td>
                            {{ $phc->ward->number ?? '—' }}
                            - {{ $phc->ward->name ?? '—' }}
                        </td>

                        <td>{{ optional($phc->ward->constituency)->name ?? '—' }}</td>

                        <td>{{ optional($phc->ward->constituency->zone)->name ?? '—' }}</td>

                        <td>{{ optional($phc->ward->constituency->zone->corporation)->name ?? '—' }}</td>

                      

                        {{-- ACTIONS --}}
                        <td class="text-nowrap">

                            {{-- EDIT --}}
                            <button class="btn btn-sm btn-primary me-2" title="Edit"
                                    onclick="window.location.href='{{ route('phcs.edit', $phc->id) }}'">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            {{-- VIEW --}}
                            <button class="btn btn-sm btn-info me-2" title="View"
                                    onclick="window.location.href='{{ route('phcs.show', $phc->id) }}'">
                                <i class="bi bi-eye"></i>
                            </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            No PHCs found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endpush

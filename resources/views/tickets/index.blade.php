@extends('layouts.master')

@section('title', 'User - Tickets')
@section('page_title', 'Tickets')

@section('breadcrumb')
    <li class="breadcrumb-item">Tickets</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 add"></h4>

        
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Ticket
        </a>
    </div>

    <div class="table-responsive">
        <table class="display" id="data-source-1" style="width:100%">
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>Clinic Name</th>
                    <th>Ward</th>
                    <th>Communication Person Number</th>
                    <th>Issue Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($tickets as $index => $ticket)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>{{ optional($ticket->user)->clinic_name ?? 'N/A' }}</td>

                  
                        <td>{{ optional(optional($ticket->user)->ward)->name ?? 'N/A' }}</td>

                
                        <td>{{ $ticket->phone ?? 'N/A' }}</td>

                      
                        <td>{{ \Illuminate\Support\Str::limit($ticket->description ?? '—', 80) }}</td>

                        {{-- STATUS BADGE --}}
                        <td>
                            @php
                                $status = strtolower($ticket->status ?? '');
                                $badgeClass = match ($status) {
                                    'resolved'   => 'badge bg-success',
                                    'pending'    => 'badge bg-warning text-dark',
                                    'irrelevant' => 'badge bg-danger',
                                    default      => 'badge bg-secondary',
                                };
                            @endphp

                            <span class="{{ $badgeClass }}">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </td>

                        <td class="text-nowrap">
                           
                            @role('admin')
                                <button class="btn btn-sm btn-primary me-2" title="Edit"
                                        onclick="window.location.href='{{ route('tickets.edit', $ticket->id) }}'">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            @endrole

                          
                            <button class="btn btn-sm btn-info me-2" title="View"
                                    onclick="window.location.href='{{ route('tickets.show', $ticket->id) }}'">
                                <i class="bi bi-eye"></i>
                            </button>
                          
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No tickets found for your current view.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
</div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endpush

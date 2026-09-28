@extends('layouts.master')

@section('title', 'Clinic Complaints')
@section('page_title', 'Clinic Complaints')

@section('breadcrumb')
    <li class="breadcrumb-item">Clinic Complaints</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-body">
{{-- ACTION BAR --}}
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('complaints.export.pdf') }}"
       class="btn btn-danger">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
    </a>
</div>

<div class="table-responsive">
    <table class="display" id="data-source-1" style="width:100%">
        <thead>
            <tr>
                <th>Sl No.</th>
                <th>PHC</th>
                <th>Clinic</th>
                <th>Doctor</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($complaints as $index => $c)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $c->phc }}</td>
                    <td>{{ $c->clinic_name }}</td>
                    <td>{{ $c->doctor_name ?? '—' }}</td>

                    {{-- IMPORTANT: phone stays string --}}
                    <td>{{ $c->phone }}</td>

                    <td class="text-nowrap">
                        <button class="btn btn-sm btn-info"
                                title="View"
                                onclick="window.location.href='{{ route('complaints.show', $c->id) }}'">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        No complaints found.
                    </td>
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

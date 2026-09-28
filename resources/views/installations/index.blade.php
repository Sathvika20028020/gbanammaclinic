@extends('layouts.master')

@section('title', 'Installation Records')
@section('page_title', 'Installations')

@section('breadcrumb')
    <li class="breadcrumb-item">Installations List</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endpush

@section('content')
<div class="card">
    <div class="card-body">
    <div class="d-flex justify-content-end align-items-center mb-4">
        @role('admin')
            <a href="{{ route('installations.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Installation
            </a>
        @endrole
    </div>

    <div class="table-responsive">
        <table class="display" id="data-source-1" style="width:100%">
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>User Name</th>
                    <th>Clinic Name</th>
                    <th>Ward Name</th>
                    <th>Ward Number</th>
                    <th>Constituency</th>
                    <th>Zone</th>
                    <th>Corporation</th>
                    <th>Installed On</th>
                    <th class="text-center">GPS Image</th>
                    <th>Comments</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($installations as $index => $ins)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ optional($ins->user)->name ?? 'N/A' }}</td>
                        <td>{{ optional($ins->user)->clinic_name ?? 'N/A' }}</td>
                        <td>{{ optional(optional($ins->user)->ward)->name ?? 'N/A' }}</td>
                        <td>{{ optional(optional($ins->user)->ward)->number ?? 'N/A' }}</td>
                        <td>{{ optional(optional($ins->ward)->constituency)->name ?? 'N/A' }}</td>
                        <td>{{ optional(optional($ins->ward)->constituency->zone)->name ?? 'N/A' }}</td>
                        <td>{{ optional(optional($ins->ward)->constituency->zone->corporation)->name ?? 'N/A' }}</td>
                        <td>{{ $ins->installed_on ?? 'N/A' }}</td>

                        {{-- GPS IMAGE LINK (no thumbnail, opens in new tab) --}}
                        <td class="text-center">
                            @if ($ins->gps_image)
                                <a href="{{ asset('storage/app/public/' . $ins->gps_image) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-secondary"
                                   title="View GPS Image">
                                    <i class="bi bi-geo-alt me-1"></i>View
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        <td>{{ \Illuminate\Support\Str::limit($ins->comments ?? '—', 50) }}</td>

                        <td class="text-center text-nowrap">
                            {{-- VIEW DETAILS --}}
                            <a href="{{ route('installations.show', $ins->id) }}"
                               class="btn btn-sm btn-info me-1" title="View">
                                <i class="bi bi-eye"></i>
                            </a>

                            @role('admin')
                                {{-- DOWNLOAD PDF --}}
                                <a href="{{ route('installations.declaration.pdf', $ins->id) }}"
                                   class="btn btn-sm btn-outline-primary me-1"
                                   title="Download Declaration PDF">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>

                                {{-- DELETE FORM --}}
                                <form action="{{ route('installations.destroy', $ins->id) }}"
                                      method="POST"
                                      class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="btn btn-sm btn-danger delete-btn"
                                            title="Delete Installation">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endrole
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">No installation records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
    {{-- DataTables JS --}}
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>

    {{-- SweetAlert2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            // --- 1. Delete Confirmation Logic ---
            document.querySelectorAll('.delete-btn').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();

                    const form = this.closest('.delete-form');

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This installation record and its images will be permanently deleted!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it",
                        cancelButtonText: "Cancel",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // --- 2. Success Alert ---
            @if (session('success'))
                Swal.fire({
                    title: "Success!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            // --- 3. Error Alert ---
            @if (session('error'))
                Swal.fire({
                    title: "Error!",
                    text: "{{ session('error') }}",
                    icon: "error"
                });
            @endif

        });
    </script>
@endpush
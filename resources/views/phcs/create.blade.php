@extends('layouts.master')

@section('title', 'Create PHC')
@section('page_title', 'Create PHC')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('phcs.index') }}">PHCs</a>
    </li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@push('css')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-md-8">

        <div class="card">
            <div class="card-body">

                <form method="POST"
                      action="{{ route('phcs.store') }}"
                      class="needs-validation"
                      novalidate>
                    @csrf

                    {{-- PHC NAME --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">PHC Name</label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Enter PHC name"
                               required>

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- WARD (SEARCHABLE) --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ward</label>
                        <select name="ward_id"
                                id="wardSelect"
                                class="form-select select2 @error('ward_id') is-invalid @enderror"
                                required>
                            <option value="">Select Ward</option>

                            @foreach ($wards as $ward)
                                <option value="{{ $ward->id }}"
                                    {{ old('ward_id') == $ward->id ? 'selected' : '' }}>
                                    {{ $ward->number }} - {{ $ward->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('ward_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ACTIONS --}}
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            Save PHC
                        </button>

                        <a href="{{ route('phcs.index') }}"
                           class="btn btn-secondary px-4">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
   
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#wardSelect').select2({
                placeholder: 'Search ward by number or name',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush

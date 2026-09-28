@extends('layouts.master')

@section('title', 'Edit PHC')
@section('page_title', 'Edit PHC')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('phcs.index') }}">PHCs</a>
    </li>
    <li class="breadcrumb-item active">Edit</li>
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

                {{-- GLOBAL ERRORS --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('phcs.update', $phc->id) }}"
                      class="needs-validation"
                      novalidate>
                    @csrf
                    @method('PUT')

                    {{-- PHC NAME --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">PHC Name</label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $phc->name) }}"
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
                                    {{ old('ward_id', $phc->ward_id) == $ward->id ? 'selected' : '' }}>
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
                            Update PHC
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
    <!-- Select2 JS -->
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

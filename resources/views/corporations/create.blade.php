@extends('layouts.master')

@section('title', 'Add Corporation')
@section('page_title', 'Add Corporation')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('corporations.index') }}">Corporations</a></li>
    <li class="breadcrumb-item active">Add</li>
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow" style="border-radius: 16px;">
            <div class="card-body">

                <h4 class="mb-3">Corporation Details</h4>

                <form action="{{ route('corporations.store') }}" method="POST">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Corporation Name</label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter corporation name"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle me-1"></i> Save
                        </button>
                        <a href="{{ route('corporations.index') }}" class="btn btn-secondary px-4">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection

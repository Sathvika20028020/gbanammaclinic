@extends('layouts.master')

@section('title', 'Edit Corporation')
@section('page_title', 'Edit Corporation')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('corporations.index') }}">Corporations</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@push('css')
<style>
    .container-custom {
        max-width: 800px;
        margin: 0 auto;
    }
    .card-box {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')
<div class="container-custom">
    <div class="card-box">

        <form action="{{ route('corporations.update', $corporation->id) }}" method="POST">
            @csrf
            @method('PUT')

            <h4>Update Details</h4>
            <hr>

            {{-- Corporation Name --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Corporation Name <span class="text-danger">*</span></label>
                <input type="text" name="name"
                       value="{{ old('name', $corporation->name) }}"
                       class="form-control @error('name') is-invalid @enderror"
                       required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="1" {{ $corporation->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $corporation->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <hr>

            {{-- Submit --}}
            <div class="d-flex justify-content-end">
                <a href="{{ route('corporations.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

        </form>

    </div>
</div>
@endsection

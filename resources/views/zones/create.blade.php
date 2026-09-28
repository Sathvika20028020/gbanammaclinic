@extends('layouts.master')

@section('title', 'Add Zone')
@section('page_title', 'Create Zone')

@section('breadcrumb')
    <li class="breadcrumb-item">Zones</li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@push('css')
    <style>
        .card-custom {
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, .08);
        }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-custom">

            <form action="{{ route('zones.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Zone Name</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required>
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Corporation</label>
                    <select name="corporation_id"
                            class="form-select @error('corporation_id') is-invalid @enderror"
                            required>
                        <option value="">Select corporation</option>
                        @foreach($corporations as $corp)
                            <option value="{{ $corp->id }}">{{ $corp->name }}</option>
                        @endforeach
                    </select>
                    @error('corporation_id')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Latitude</label>
                        <input type="text" name="latitude"
                               class="form-control"
                               value="{{ old('latitude') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Longitude</label>
                        <input type="text" name="longitude"
                               class="form-control"
                               value="{{ old('longitude') }}">
                    </div>
                </div>            

                <button class="btn btn-primary px-4">Save</button>
                <a href="{{ route('zones.index') }}" class="btn btn-outline-secondary">Cancel</a>

            </form>
        </div>
    </div>
</div>
@endsection

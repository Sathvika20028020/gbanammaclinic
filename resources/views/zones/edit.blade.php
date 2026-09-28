@extends('layouts.master')

@section('title', 'Edit Zone')
@section('page_title', 'Edit Zone')

@section('breadcrumb')
    <li class="breadcrumb-item">Zones</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@push('css')
<style>
    .card-custom {
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .form-label {
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="card card-custom">

            <h4 class="mb-3">Update Zone Details</h4>
            <form action="{{ route('zones.update', $zone->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Zone Name --}}
                <div class="mb-3">
                    <label class="form-label">Zone Name</label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $zone->name) }}"
                           placeholder="Enter Zone Name"
                           required>
                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                {{-- Corporation --}}
                <div class="mb-3">
                    <label class="form-label">Corporation</label>
                    <select name="corporation_id"
                            class="form-select @error('corporation_id') is-invalid @enderror"
                            required>
                        @foreach($corporations as $corp)
                            <option value="{{ $corp->id }}"
                                {{ $corp->id == $zone->corporation_id ? 'selected' : '' }}>
                                {{ $corp->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('corporation_id')<span class="text-danger">{{ $message }}</span>@enderror
                </div>

                <div class="row">
                    {{-- Latitude --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Latitude</label>
                        <input type="text"
                               name="latitude"
                               class="form-control"
                               value="{{ old('latitude', $zone->latitude) }}"
                               placeholder="12.123456">
                    </div>

                    {{-- Longitude --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Longitude</label>
                        <input type="text"
                               name="longitude"
                               class="form-control"
                               value="{{ old('longitude', $zone->longitude) }}"
                               placeholder="77.123456">
                    </div>
                </div>

             
                {{-- Buttons --}}
                <div class="text-end">
                    <a href="{{ route('zones.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button class="btn btn-success px-4" type="submit">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

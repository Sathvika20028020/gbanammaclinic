@extends('layouts.master')

@section('title', 'Edit Constituency')
@section('page_title', 'Edit Constituency')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('constituencies.index') }}">Constituencies</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@push('css')
<style>
    .container-custom {
        max-width: 800px;
        margin: auto;
    }
    label .text-danger {
        color: #dc3545 !important;
        font-weight: bold;
    }
</style>
@endpush

@section('content')

<div class="container-custom">
    <div class="card shadow p-4" style="border-radius: 12px;">

        <form action="{{ route('constituencies.update', $constituency->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-3">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text"
                       name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $constituency->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Number --}}
            <div class="mb-3">
                <label class="form-label">Number <span class="text-danger">*</span></label>
                <input type="text"
                       name="number"
                       class="form-control @error('number') is-invalid @enderror"
                       value="{{ old('number', $constituency->number) }}" required>
                @error('number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Corporation --}}
            <div class="mb-3">
                <label class="form-label">Corporation <span class="text-danger">*</span></label>
                <select name="corporation_id"
                        class="form-control @error('corporation_id') is-invalid @enderror" required>
                    <option value="">Select</option>
                    @foreach($corporations as $corp)
                        <option value="{{ $corp->id }}"
                            {{ $corp->id == $constituency->zone->corporation_id ? 'selected' : '' }}>
                            {{ $corp->name }}
                        </option>
                    @endforeach
                </select>
                @error('corporation_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Zone --}}
            <div class="mb-3">
                <label class="form-label">Zone <span class="text-danger">*</span></label>
                <select name="zone_id"
                        class="form-control @error('zone_id') is-invalid @enderror" required>
                    <option value="">Select</option>
                    @foreach($zones as $zone)
                        <option value="{{ $zone->id }}"
                            {{ $zone->id == $constituency->zone_id ? 'selected' : '' }}>
                            {{ $zone->name }}
                        </option>
                    @endforeach
                </select>
                @error('zone_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Latitude --}}
            <div class="mb-3">
                <label class="form-label">Latitude <span class="text-danger">*</span></label>
                <input type="text"
                       name="latitude"
                       class="form-control @error('latitude') is-invalid @enderror"
                       value="{{ old('latitude', $constituency->latitude) }}" required>
                @error('latitude')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Longitude --}}
            <div class="mb-3">
                <label class="form-label">Longitude <span class="text-danger">*</span></label>
                <input type="text"
                       name="longitude"
                       class="form-control @error('longitude') is-invalid @enderror"
                       value="{{ old('longitude', $constituency->longitude) }}" required>
                @error('longitude')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="text-end">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-check-circle"></i> Save Changes
                </button>
                <a href="{{ route('constituencies.index') }}" class="btn btn-secondary px-4">
                    Cancel
                </a>
            </div>

        </form>

    </div>
</div>

@endsection

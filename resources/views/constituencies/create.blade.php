@extends('layouts.master')

@section('title', 'Add Constituency')
@section('page_title', 'Add Constituency')

@section('breadcrumb')
<li class="breadcrumb-item active">Add Constituency</li>
@endsection

@section('content')
<div class="card shadow p-4">

    <form action="{{ route('constituencies.store') }}" method="POST" class="row g-3">
        @csrf

        <div class="col-md-6">
            <label class="form-label">Zone <span class="text-danger">*</span></label>
            <select name="zone_id" id="zoneSelect"
                class="form-select @error('zone_id') is-invalid @enderror" required>
                <option value="">Select Zone</option>
                @foreach($zones as $zone)
                    <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                @endforeach
            </select>
            @error('zone_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">Corporation</label>
            <input type="text" id="corporationName" class="form-control" readonly>
        </div>

        <div class="col-md-6">
            <label class="form-label">Constituency Name *</label>
            <input type="text" name="name"
                class="form-control @error('name') is-invalid @enderror" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">Number *</label>
            <input type="text" name="number"
                class="form-control @error('number') is-invalid @enderror" required>
            @error('number') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">Latitude</label>
            <input type="text" name="latitude" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Longitude</label>
            <input type="text" name="longitude" class="form-control">
        </div>

        <div class="text-center mt-3">
            <button class="btn btn-success px-4" type="submit">Save</button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
    const zoneData = @json($zones);

    document.getElementById('zoneSelect').addEventListener('change', function() {
        let zoneId = this.value;
        let zone = zoneData.find(z => z.id == zoneId);
        document.getElementById('corporationName').value = zone ? zone.corporation.name : '';
    });
</script>
@endpush

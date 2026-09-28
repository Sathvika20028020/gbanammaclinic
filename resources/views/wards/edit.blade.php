@extends('layouts.master')

@section('title', 'Edit Ward')
@section('page_title', 'Edit Ward')

@section('breadcrumb')
    <li class="breadcrumb-item">Wards</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@push('css')
<style>
    .required-star { color: red; margin-left: 2px; }
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-sm-12">

        <div class="card shadow-sm" style="border-radius: 20px;">
            <div class="card-body">

                <form action="{{ route('wards.update', $ward->id) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <h5 class="mb-3">Edit Ward</h5>

                    {{-- Constituency --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Constituency <span class="required-star">*</span>
                        </label>
                        <select name="constituency_id"
                                class="form-select @error('constituency_id') is-invalid @enderror"
                                required>
                            @foreach($constituencies as $const)
                                <option value="{{ $const->id }}"
                                    {{ $const->id == $ward->constituency_id ? 'selected' : '' }}>
                                    {{ $const->zone->name }} - {{ $const->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('constituency_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    {{-- Ward Number --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Ward Number <span class="required-star">*</span>
                        </label>
                        <input type="text" name="number"
                            class="form-control @error('number') is-invalid @enderror"
                            value="{{ old('number', $ward->number) }}"
                            required>
                        @error('number') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    {{-- Ward Name --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Ward Name <span class="required-star">*</span>
                        </label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $ward->name) }}"
                            required>
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

            

                    <div class="text-center mt-4">
                        <button class="btn btn-primary px-4" type="submit">Update</button>
                        <a href="{{ route('wards.show', $ward->id) }}" class="btn btn-dark px-4 ms-2">Back</a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection

@extends('layouts.master')

@section('title', 'Add Ward')
@section('page_title', 'Add Ward')

@section('breadcrumb')
    <li class="breadcrumb-item">Wards</li>
    <li class="breadcrumb-item active">Add</li>
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

                <form action="{{ route('wards.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <h5 class="mb-3">Basic Details</h5>

                    {{-- Constituency --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Constituency <span class="required-star">*</span>
                        </label>
                        <select name="constituency_id"
                            class="form-select @error('constituency_id') is-invalid @enderror"
                            required>
                            <option value="">Select Constituency</option>
                            @foreach($constituencies as $const)
                                <option value="{{ $const->id }}"
                                    {{ old('constituency_id') == $const->id ? 'selected' : '' }}>
                                    {{ $const->name }}
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
                            value="{{ old('number') }}"
                            placeholder="Example: 105"
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
                            value="{{ old('name') }}"
                            placeholder="Enter ward name"
                            required>
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>


                    <div class="text-center mt-4">
                        <button class="btn btn-primary px-4" type="submit">Submit</button>
                        <a href="{{ route('wards.index') }}" class="btn btn-dark px-4 ms-2">Cancel</a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection

@extends('layouts.master')

@section('title', 'User Profile Edit')
@section('page_title', 'Edit User')

@section('breadcrumb')
    <li class="breadcrumb-item">Edit User</li>
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST"
                      class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <h4 class="mt-2">Basic Details</h4>
                    <div class="row g-3 mt-1 mb-4">

                        {{-- Ward --}}
                        <div class="col-md-6">
                            <label class="form-label">Ward</label>
                            <select name="ward_id"
                                class="form-select @error('ward_id') is-invalid @enderror" required>
                                <option value="">Select Ward</option>
                                @foreach ($wards as $ward)
                                    <option value="{{ $ward->id }}"
                                        {{ old('ward_id', $user->ward_id) == $ward->id ? 'selected' : '' }}>
                                        {{ $ward->number }} - {{ $ward->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ward_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Clinic Name --}}
                        <div class="col-md-6">
                            <label class="form-label">Clinic Name</label>
                            <input type="text" name="clinic_name"
                                class="form-control @error('clinic_name') is-invalid @enderror"
                                value="{{ old('clinic_name', $user->clinic_name) }}" required>
                            @error('clinic_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Password Optional --}}
                        <div class="col-md-6">
                            <label class="form-label">New Password (optional)</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Internet Status --}}
                        <div class="col-md-6">
                            <label class="form-label">Internet Status</label>
                            <select name="internet_status"
                                class="form-select @error('internet_status') is-invalid @enderror" required>
                                <option value="active" {{ old('internet_status', $user->internet_status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('internet_status', $user->internet_status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('internet_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Latitude --}}
                        <div class="col-md-6">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude"
                                class="form-control @error('latitude') is-invalid @enderror"
                                value="{{ old('latitude', $user->latitude) }}"
                                placeholder="e.g., 12.9716">
                            @error('latitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Longitude --}}
                        <div class="col-md-6">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude"
                                class="form-control @error('longitude') is-invalid @enderror"
                                value="{{ old('longitude', $user->longitude) }}"
                                placeholder="e.g., 77.5946">
                            @error('longitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                    </div>


                    <h4>Communication Details</h4>
                    <div class="row g-3 mt-1 mb-4">

                        {{-- Name --}}
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $user->phone) }}" maxlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                    </div>


                    <h4>Plan Details</h4>
                    <div class="row g-3 mt-1">

                        {{-- Internet Speed --}}
                        <div class="col-md-6">
                            <label class="form-label">Internet Speed</label>
                            <input type="text" name="internet_speed"
                                class="form-control @error('internet_speed') is-invalid @enderror"
                                value="{{ old('internet_speed', $user->internet_speed) }}" required>
                            @error('internet_speed') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Bandwidth --}}
                        <div class="col-md-6">
                            <label class="form-label">Bandwidth</label>
                            <input type="text" name="bandwidth"
                                class="form-control @error('bandwidth') is-invalid @enderror"
                                value="{{ old('bandwidth', $user->bandwidth) }}" required>
                            @error('bandwidth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                    </div>


                    <div class="text-center mt-4">
                        <button class="btn btn-primary px-4" type="submit">Update</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $('input[name="latitude"], input[name="longitude"]').on('input', function() {
        this.value = this.value
            .replace(/[^0-9.\-]/g, '')
            .replace(/(\..*?)\..*/g, '$1');
    });
</script>
@endpush

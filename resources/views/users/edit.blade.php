@extends('layouts.master')

@section('title', 'Admin Dashboard - Edit User')
@section('page_title', 'Edit')

@section('breadcrumb')
    <li class="breadcrumb-item">Edit</li>
@endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <h4 class="mt-2">Basic Details</h4>
                    <div class="row g-3 mt-1 mb-4">

                        <div class="col-md-6">
                            <label class="form-label">Ward</label>
                            <select name="ward_id" id="wardSelect"
                                class="form-select select2 @error('ward_id') is-invalid @enderror" required>
                                <option value="">Select Ward</option>
                                @foreach ($wards as $ward)
                                    <option value="{{ $ward->id }}"
                                        {{ $user->ward_id == $ward->id ? 'selected' : '' }}>
                                        {{ $ward->number }} - {{ $ward->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ward_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Clinic Name</label>
                            <input type="text" name="clinic_name"
                                class="form-control @error('clinic_name') is-invalid @enderror"
                                value="{{ old('clinic_name', $user->clinic_name) }}" required>
                            @error('clinic_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password (optional) -->
                        <div class="col-md-6">
                            <label class="form-label">New Password (optional)</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Leave blank to keep current password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="internet_status" class="form-select @error('internet_status') is-invalid @enderror" required>
                                <option value="active" {{ $user->internet_status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $user->internet_status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('internet_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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

                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $user->phone) }}"
                                maxlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

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

                        <div class="col-md-6">
                            <label class="form-label">Internet Speed</label>
                            <input type="text" name="internet_speed"
                                class="form-control @error('internet_speed') is-invalid @enderror"
                                value="{{ old('internet_speed', $user->internet_speed) }}" required>
                            @error('internet_speed') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Package</label>
                            <input type="text" class="form-control" value="Unlimited" readonly>
                            <input type="hidden" name="bandwidth" value="Unlimited">
                        </div>

                        <!-- VALIDITY (readonly) -->
                        <div class="col-md-6">
                            <label class="form-label">Validity</label>
                            <input type="text" class="form-control" value="6 Months" readonly>
                            <input type="hidden" name="validity" value="6">
                        </div>

                        <!-- ITEMS PROVIDED (readonly like validity) -->
                        <div class="col-md-6">
                            <label class="form-label">Items Provided</label>
                            <input type="text" class="form-control text-muted" 
                                   value="Router, Cable, Adapter" readonly>

                            <input type="hidden" name="items_provided[]" value="Router">
                            <input type="hidden" name="items_provided[]" value="Cable">
                            <input type="hidden" name="items_provided[]" value="Adapter">
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#wardSelect').select2({
            placeholder: "Search ward...",
            allowClear: true,
            width: '100%'
        });
    });

    $('input[name="latitude"], input[name="longitude"]').on('input', function() {
        this.value = this.value
            .replace(/[^0-9.\-]/g, '')
            .replace(/(\..*?)\..*/g, '$1');
    });
</script>
@endpush

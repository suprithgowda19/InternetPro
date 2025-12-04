@extends('layouts.master')

@section('title', 'Admin Dashboard - Add User')
@section('page_title', 'Add')

@section('breadcrumb')
    <li class="breadcrumb-item">Add</li>
@endsection

@push('css')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.users.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <h4 class="mt-2">Basic Details</h4>
                        <div class="row g-3 mt-1 mb-4">

                            <div class="col-md-6">
                                <label class="form-label">Ward</label>
                                <select name="ward_id" id="wardSelect"
                                    class="form-select select2 @error('ward_id') is-invalid @enderror" required>
                                    <option value="">Select Ward</option>
                                    @foreach ($wards as $ward)
                                        <option value="{{ $ward->id }}"
                                            {{ old('ward_id') == $ward->id ? 'selected' : '' }}>
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
                                    value="{{ old('clinic_name') }}" placeholder="Enter clinic name" required>
                                @error('clinic_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            
                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                    required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="internet_status" class="form-select @error('internet_status') is-invalid @enderror" required>
                                    <option value="">Select Status</option>
                                    <option value="active" {{ old('internet_status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('internet_status') == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <h4>Communication Details</h4>
                        <div class="row g-3 mt-1 mb-4">

                            {{-- Name --}}
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="Enter name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                                    placeholder="Enter 10-digit number" pattern="[0-9]{10}" maxlength="10"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    placeholder="Enter email address" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <h4>Plan Details</h4>
                        <div class="row g-3 mt-1">

                            {{-- Internet Speed --}}
                            <div class="col-md-6">
                                <label class="form-label">Internet Speed</label>
                                <input type="text" name="internet_speed"
                                    class="form-control @error('internet_speed') is-invalid @enderror"
                                    value="{{ old('internet_speed') }}" placeholder="e.g., 50 Mbps" required>
                                @error('internet_speed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Bandwidth --}}
                            <div class="col-md-6">
                                <label class="form-label">Bandwidth</label>
                                <input type="text" name="bandwidth"
                                    class="form-control @error('bandwidth') is-invalid @enderror"
                                    value="{{ old('bandwidth') }}" placeholder="e.g., 100 GB" required>
                                @error('bandwidth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-primary px-4" type="submit">Submit</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#wardSelect').select2({
                placeholder: "Search ward...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush

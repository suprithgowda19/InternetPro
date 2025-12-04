@extends('layouts.master')

@section('title', 'User Login - Edit Profile')
@section('page_title', 'Profile')

@section('breadcrumb')
    <li class="breadcrumb-item">Profile</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" 
                          class="needs-validation" novalidate id="screenForm">
                        @csrf
                        @method('PUT')

                        <h4 class="mt-2">Basic Details</h4>
                        <div class="row g-3 mt-1 mb-4">

                            <div class="col-md-6">
                                <label class="form-label">Ward</label>
                                <select name="ward" class="form-select @error('ward') is-invalid @enderror" required>
                                    <option value="">Select Option</option>
                                    <option value="Ward 1" {{ old('ward', $user->ward) == 'Ward 1' ? 'selected' : '' }}>Ward 1</option>
                                    <option value="Ward 2" {{ old('ward', $user->ward) == 'Ward 2' ? 'selected' : '' }}>Ward 2</option>
                                    <option value="Ward 3" {{ old('ward', $user->ward) == 'Ward 3' ? 'selected' : '' }}>Ward 3</option>
                                </select>
                                @error('ward') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Clinic Name</label>
                                <input type="text" name="clinic_name"
                                    class="form-control @error('clinic_name') is-invalid @enderror"
                                    value="{{ old('clinic_name', $user->clinic_name) }}" required>
                                @error('clinic_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter new password (optional)">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Internet Status</label>
                                <select name="internet_status"
                                    class="form-select @error('internet_status') is-invalid @enderror" required>
                                    <option value="Active" {{ old('internet_status', $user->internet_status) == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('internet_status', $user->internet_status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="Pending" {{ old('internet_status', $user->internet_status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                                @error('internet_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                    value="{{ old('phone', $user->phone) }}" maxlength="10" pattern="[0-9]{10}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col">
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

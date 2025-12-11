@extends('layouts.master')

@section('title', 'Admin - Installation Form')
@section('page_title', 'Installation Form')

@section('breadcrumb')
    <li class="breadcrumb-item">Installation</li>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endpush

@section('content')
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow" style="border-radius: 20px;">
                <div class="card-body">

                    <form action="{{ route('installations.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf

                        <!-- USER SELECTION -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">User Name</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->clinic_name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- IMAGE -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Upload Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <!-- INSTALLATION DATE -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Installed On</label>
                            <input type="date" 
                                   name="installed_on" 
                                   class="form-control fw-bold" 
                                   required>
                        </div>

                        <!-- COMMENTS -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Comments</label>
                            <textarea name="comments" 
                                      class="form-control" 
                                      rows="2" 
                                      placeholder="Enter Your Comments..."></textarea>
                        </div>

                        <!-- SUBMIT -->
                        <div class="text-center mt-3">
                            <button type="submit" 
                                    class="btn btn-primary px-4 fw-bold" 
                                    style="border-radius: 10px;">
                                Submit
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endpush

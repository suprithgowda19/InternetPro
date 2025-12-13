@extends('layouts.master')

@section('title', 'Complaint Details')
@section('page_title', 'Complaint Details')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('complaints.index') }}">Complaints</a>
    </li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-8">

            {{-- Complaint Details --}}
            <div class="card predominent-card">
                <div class="card-header">
                    <h5 class="mb-0">Clinic Information</h5>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">PHC</div>
                        <div class="col-md-8">{{ $complaint->phc }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Clinic Name</div>
                        <div class="col-md-8">{{ $complaint->clinic_name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Doctor Name</div>
                        <div class="col-md-8">{{ $complaint->doctor_name ?? 'N/A' }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Phone</div>
                        <div class="col-md-8">{{ $complaint->phone }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Source</div>
                        <div class="col-md-8 text-capitalize">{{ $complaint->source }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Submitted At</div>
                        <div class="col-md-8">
                            {{ $complaint->created_at?->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Location --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Location</h5>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Latitude</div>
                        <div class="col-md-8">{{ $complaint->lat }}</div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 fw-bold">Longitude</div>
                        <div class="col-md-8">{{ $complaint->lng }}</div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Right Column --}}
        <div class="col-lg-4">

            {{-- Image --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Clinic Image</h5>
                </div>

                <div class="card-body text-center">

                    @if ($complaint->image_path)
                        <img src="{{ asset('storage/' . $complaint->image_path) }}" class="img-fluid rounded border"
                            alt="Clinic Image">
                    @else
                        <p class="text-muted mb-0">Image not available</p>
                    @endif

                </div>
            </div>



        </div>
    </div>

@endsection

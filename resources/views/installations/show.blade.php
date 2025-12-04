@extends('layouts.master')

@section('title', 'Installation Details')
@section('page_title', 'Installation Details')

@section('breadcrumb')
    <li class="breadcrumb-item">Installations</li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow" style="border-radius: 20px;">
                <div class="card-body">

                    <h4 class="mb-4 fw-bold">Installation Details</h4>

                    <div class="row g-4">

                        {{-- User Info --}}
                        <div class="col-md-6">
                            <div class="border p-3 rounded">
                                <h5 class="fw-bold mb-3">User Information</h5>

                                <p class="mb-1">
                                    <strong>Name:</strong>
                                    {{ optional($installation->user)->name ?? 'N/A' }}
                                </p>

                                <p class="mb-1">
                                    <strong>Clinic:</strong>
                                    {{ optional($installation->user)->clinic_name ?? 'N/A' }}
                                </p>

                                <p class="mb-1">
                                    <strong>Ward:</strong>
                                    {{ optional(optional($installation->user)->ward)->name ?? 'N/A' }}
                                </p>

                                <p class="mb-1">
                                    <strong>Phone:</strong>
                                    {{ optional($installation->user)->phone ?? 'N/A' }}
                                </p>

                                <p class="mb-1">
                                    <strong>Email:</strong>
                                    {{ optional($installation->user)->email ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        {{-- Installation Info --}}
                        <div class="col-md-6">
                            <div class="border p-3 rounded">
                                <h5 class="fw-bold mb-3">Installation Information</h5>

                                <p class="mb-1">
                                    <strong>Installed On:</strong>
                                    @if ($installation->installed_on)
                                        {{ \Carbon\Carbon::parse($installation->installed_on)->format('d M Y') }}
                                    @else
                                        N/A
                                    @endif
                                </p>

                                <p class="mb-1">
                                    <strong>Comments:</strong>
                                    {{ $installation->comments ?? '—' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Image Section --}}
                    @if ($installation->image)
                        <div class="mt-4">
                            <h5 class="fw-bold mb-2">Installation Image</h5>

                            <img src="{{ asset('storage/' . $installation->image) }}"
                                 alt="Installation Image"
                                 class="img-thumbnail"
                                 style="max-width: 350px; border-radius: 10px;">
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('installations.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

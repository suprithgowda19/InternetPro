@extends('layouts.master')

@section('title', 'Admin Dashboard - View Ticket')
@section('page_title', 'View Ticket')

@section('breadcrumb')
    <li class="breadcrumb-item">Tickets</li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow" style="border-radius: 20px;">
                <div class="card-body">

                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Clinic Name</label>
                        <input type="text" class="form-control"
                            value="{{ optional($ticket->user)->clinic_name ?? 'N/A' }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ward</label>
                        <input type="text" class="form-control"
                            value="{{ optional(optional($ticket->user)->ward)->name ?? 'N/A' }}" readonly>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Communication Person Name</label>
                        <input type="text" class="form-control" value="{{ optional($ticket->user)->name ?? 'N/A' }}"
                            readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Issue Description</label>
                        <textarea class="form-control" rows="3" readonly>{{ $ticket->description }}</textarea>
                    </div>

                    <hr>

                    @if ($ticket->admin_image && Storage::disk('public')->exists($ticket->admin_image))
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Attached Image</label><br>
                            <img src="{{ Storage::url($ticket->admin_image) }}"
                                style="max-width: 220px; border-radius: 10px; border: 1px solid #ddd;">
                        </div>
                    @endif

                    @if ($ticket->admin_remarks)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Admin Remarks</label>
                            <textarea class="form-control" rows="2" readonly>{{ $ticket->admin_remarks }}</textarea>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <input type="text" class="form-control" value="{{ $ticket->status }}" readonly>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

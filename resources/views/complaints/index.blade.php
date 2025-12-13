@extends('layouts.master')

@section('title', 'Clinic Complaints')
@section('page_title', 'Clinic Complaints')

@section('breadcrumb')
    <li class="breadcrumb-item">Complaints List</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endpush

@section('content')

    <div class="d-flex justify-content-end align-items-center mb-4">
        @role('admin')
            {{-- No create button for complaints (API driven) --}}
        @endrole
    </div>

    <div class="table-responsive">
        <table class="display" id="data-source-1" style="width:100%">
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>PHC</th>
                    <th>Clinic Name</th>
                    <th>Doctor Name</th>
                    <th>Phone</th>
                    <th>Image Status</th>
                    <th>Submitted On</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($complaints as $index => $c)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>{{ $c->phc }}</td>

                        <td>{{ $c->clinic_name }}</td>

                        <td>{{ $c->doctor_name ?? 'N/A' }}</td>

                        <td>{{ $c->phone }}</td>

                        <td>
                            <span class="badge 
                                {{ $c->image_status === 'completed' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($c->image_status) }}
                            </span>
                        </td>

                        <td>{{ $c->created_at?->format('d M Y H:i') ?? 'N/A' }}</td>

                        <td class="text-nowrap">
                            <a href="{{ route('complaints.show', $c->id) }}"
                               class="btn btn-sm btn-info me-1" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            No complaint records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            // Success popup after redirect
            @if (session('success'))
                Swal.fire({
                    title: "Success!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonColor: "#3085d6"
                });
            @endif

        });
    </script>
@endpush

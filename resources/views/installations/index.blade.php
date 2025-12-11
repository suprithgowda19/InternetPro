@extends('layouts.master')

@section('title', 'Installation Records')
@section('page_title', 'Installations')

@section('breadcrumb')
    <li class="breadcrumb-item">Installations List</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endpush

@section('content')

    <div class="d-flex justify-content-end align-items-center mb-4">
        @role('admin')
            <a href="{{ route('installations.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Installation
            </a>
        @endrole
    </div>

    <div class="table-responsive">
        <table class="display" id="data-source-1" style="width:100%">
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>User Name</th>
                    <th>Clinic Name</th>
                    <th>Ward</th>
                    <th>Installed On</th>
                    <th>Comments</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($installations as $index => $ins)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ optional($ins->user)->name ?? 'N/A' }}</td>
                        <td>{{ optional($ins->user)->clinic_name ?? 'N/A' }}</td>

                     
                        <td>{{ optional(optional($ins->user)->ward)->name ?? 'N/A' }}</td>

                        <td>{{ $ins->installed_on ?? 'N/A' }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($ins->comments ?? '—', 50) }}</td>

                        <td class="text-nowrap">
                            <a href="{{ route('installations.show', $ins->id) }}"
                               class="btn btn-sm btn-info me-1" title="View">
                                <i class="bi bi-eye"></i>
                            </a>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No installation records found.</td>
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
            // Delete with SweetAlert confirmation
            document.querySelectorAll('.delete-btn').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();

                    const form = this.closest('.delete-form');

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This installation record will be permanently deleted.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

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

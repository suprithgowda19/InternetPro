@extends('layouts.master')

@section('title', 'User List')
@section('page_title', 'Users')

@section('breadcrumb')
    <li class="breadcrumb-item">Users</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">

    <style>
        .toggle-switch {
            position: relative;
            width: 46px;
            height: 24px;
        }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider {
            position: absolute; inset: 0; background: #d3d3d3;
            border-radius: 50px; cursor: pointer; transition: .3s;
        }
        .toggle-slider:before {
            content: ""; position: absolute; height: 18px; width: 18px;
            top: 3px; left: 3px; background: #fff; border-radius: 50%;
            transition: .3s;
        }
        input:checked + .toggle-slider { background: #2196F3; }
        input:checked + .toggle-slider:before { transform: translateX(22px); }
    </style>
@endpush


@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"></h4>

        @role('admin')
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary text-white">
                <i class="bi bi-plus-circle me-1"></i> Add User
            </a>
        @endrole
    </div>

    <div class="table-responsive">
        <table class="display" id="users-table" style="width:100%">
            <thead>
                <tr>
                    <th>Sl.No</th>
                    <th>Name</th>
                    <th>Ward</th>
                    <th>Clinic</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Internet Speed</th>
                    <th>Bandwidth</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $index => $user)
                    <tr id="row-{{ $user->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->ward->name ?? 'N/A' }}</td>

                        <td>{{ $user->clinic_name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->internet_speed }}</td>
                        <td>{{ $user->bandwidth }}</td>

                        <td>
                            @role('admin')
                                <label class="toggle-switch">
                                    <input type="checkbox"
                                           class="status-toggle"
                                           data-id="{{ $user->id }}"
                                           {{ $user->internet_status === 'active' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            @else
                                <label class="toggle-switch">
                                    <input type="checkbox" disabled
                                           {{ $user->internet_status === 'active' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            @endrole
                        </td>

                        <td class="d-flex">

                            <button class="btn btn-sm btn-info me-2"
                                onclick="window.location.href='{{ route('admin.users.show', $user->id) }}'">
                                <i class="bi bi-eye"></i>
                            </button>

                            @role('user')
                                <button class="btn btn-sm btn-primary me-2"
                                    onclick="window.location.href='{{ route('admin.users.edit', $user->id) }}'">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            @endrole
                        
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">No users found.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

@endsection


@push('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#users-table').DataTable();
        });

        // STATUS TOGGLE (with rollback + alerts) 
        $(document).on('change', '.status-toggle', function() {

            let checkbox = $(this);
            let userId = checkbox.data('id');
            let newState = checkbox.is(':checked') ? 'active' : 'inactive';
            let rollbackState = !checkbox.is(':checked');

            $.ajax({
                url: "{{ route('admin.users.updateStatus') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: userId,
                    internet_status: newState
                },
                success: function(res) {
                    if (res.error) {
                        checkbox.prop("checked", rollbackState);
                        Swal.fire("Blocked", res.message, "error");
                    } else {
                        Swal.fire("Updated", "Status changed successfully.", "success");
                    }
                },
                error: function() {
                    checkbox.prop("checked", rollbackState);
                    Swal.fire("Error", "Something went wrong.", "error");
                }
            });
        });


        // -------------- DELETE USER (SweetAlert + AJAX) --------------
        $(document).on('click', '.delete-btn', function() {

            let id = $(this).data('id');
            let url = $(this).data('url');

            Swal.fire({
                title: "Are you sure?",
                text: "This user cannot be restored!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Delete"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: { _token: "{{ csrf_token() }}", _method: "DELETE" },
                        success: function() {
                            $("#row-" + id).remove();
                            Swal.fire("Deleted!", "User removed successfully.", "success");
                        },
                        error: function() {
                            Swal.fire("Error", "Failed to delete user.", "error");
                        }
                    });

                }
            });
        });
    </script>
@endpush

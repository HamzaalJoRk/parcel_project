@extends('layouts.adminDashboard')

@section('content')
@if ($errors->any())
<?php toastr(__('Make sure to add all required information'),'warning'); ?>
@endif
<div class="content-body">
    <h3 class="mb-2">Roles List</h3>


    <!-- Role cards -->
    <div class="row">
        @foreach ($roles as $role)
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span>Total {{ $role->users_count }} users</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                        <div class="role-heading mb-2">
                            <h4 class="fw-bolder">{{ $role->name }}</h4>
                        </div>
                        <div>
                            <a href="{{ route('roles.edit', $role->id) }}" class="text-body"><i class="fas fa-edit font-medium-3 me-1"></i></i></a>
                            <a href="#" class="text-body delete-role" data-role-id="{{ $role->id }}">
                                <i class="fas fa-trash font-medium-3"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endforeach


        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="d-flex align-items-end justify-content-center h-100">
                            <img src="../../../app-assets/images/illustration/faq-illustrations.svg" class="img-fluid mt-2" alt="Image" width="85" />
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="card-body text-sm-end text-center ps-sm-0">
                            <a href="javascript:void(0)" data-bs-target="#addRoleModal" data-bs-toggle="modal" class="stretched-link text-nowrap add-new-role">
                                <span class="btn btn-primary mb-1">Add New Role</span>
                            </a>
                            <p class="mb-0">Add role, if it does not exist</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Role cards -->


    <!-- Add Role Modal -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5 pb-5">
                        <div class="text-center mb-4">
                            <h1 class="role-title">Add New Role</h1>
                            <p>Set role permissions</p>
                        </div>
                        <!-- Add role form -->
                        <form id="addRoleForm" class="row" action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            <div class="col-12">
                                <label class="form-label" for="modalRoleName">Role Name</label>
                                <input type="text" id="modalRoleName" name="name" class="form-control" placeholder="Enter role name" tabindex="-1" data-msg="Please enter role name" />
                            </div>
                            <div class="col-12">
                                <h4 class="mt-2 pt-50">Role Permissions</h4>
                                <!-- Permission table -->
                                <div class="table-responsive">
                                    <table class="table table-flush-spacing">
                                        <tbody>
                                            <tr>
                                                <td class="text-nowrap fw-bolder">
                                                    Administrator Access
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system">
                                                        <i data-feather="info"></i>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="selectAll" />
                                                        <label class="form-check-label" for="selectAll"> Select All </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap fw-bolder"></td>
                                                <td>
                                                    <div>
                                                        @foreach ($permissions as $permission)
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="form-check-input permission-checkbox" type="checkbox" id="permission{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="permission{{ $permission->id }}">{{ $permission->name }}</label>
                                                        </div>
                                                        @endforeach

                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Permission table -->
                            </div>
                            <div class="col-12 text-center mt-2">
                                <button type="submit" class="btn btn-primary me-1">Add</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                    Discard
                                </button>
                            </div>
                        </form>
                        <!--/ Add role form -->
                    </div>
                </div>
            </div>
    </div>
    <!--/ Add Role Modal -->

</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        $('.delete-role').on('click', function (e) {
            e.preventDefault();

            var roleId = $(this).data('role-id');

            Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/roles/' + roleId,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (error) {
                        console.error('Error deleting role:', error);
                    }
                });
            }
        });
        });
    });
</script>
<script defer src="../../../app-assets/js/scripts/pages/modal-add-role.js"></script>

@endsection

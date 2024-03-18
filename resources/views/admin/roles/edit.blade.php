@extends('layouts.adminDashboard')

@section('content')
@if ($errors->any())
<?php toastr(__('Make sure to add all required information'),'warning'); ?>
@endif
<div>
    <div class=" modal-dialog-centered modal-add-new-role">
        <div class="modal-content">
            <div class="modal-body px-5 pb-5">
                <div class="text-center mb-4">
                    <h1 class="role-title">Edit Role : {{$role->name}}</h1>
                </div>
                <!-- Add role form -->
                <form id="addRoleForm" class="row" action="{{ route('roles.update', ['role' => $role->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                        <label class="form-label" for="modalRoleName">Role Name</label>
                        <input type="text" id="modalRoleName" name="name" class="form-control" placeholder="Enter role name" tabindex="-1" data-msg="Please enter role name" value={{$role->name}}>
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
                                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Allows full access to the system">
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
                        <button type="submit" class="btn btn-primary me-1">Update</button>
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        $('#selectAll').change(function () {
            $('.permission-checkbox').prop('checked', $(this).prop('checked'));
        });

        $('.permission-checkbox').change(function () {
            if ($('.permission-checkbox:checked').length === $('.permission-checkbox').length) {
                $('#selectAll').prop('checked', true);
            } else {
                $('#selectAll').prop('checked', false);
            }
        });
    });
</script>
@endsection

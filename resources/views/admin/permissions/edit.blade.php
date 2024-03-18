@extends('layouts.adminDashboard')

@section('content')
@if ($errors->any())
<?php toast(__('Make sure to add all required information'),'error'); ?>
@endif
<div>
    <div class=" modal-dialog-centered modal-add-new-role">
        <div class="modal-content">
            <div class="modal-body px-5 pb-5">
                <div class="text-center mb-4">
                    <h1 class="role-title">Edit Permission : {{$permission->name}}</h1>
                </div>
                <!-- edit Permission form -->
                <form id="addRoleForm" class="row" action="{{ route('permissions.update', ['permission' => $permission->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                        <label class="form-label" for="modalRoleName">Permission Name</label>
                        <input type="text" name="editPermissionName" class="form-control" placeholder="Enter permission name" tabindex="-1" data-msg="Please enter permission name" value={{$permission->name}}>
                    </div>
                    <div class="col-12 text-center mt-2">
                        <button type="submit" class="btn btn-primary me-1">Update</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                            Discard
                        </button>
                    </div>
                </form>
                <!--/ edit Permission form -->
            </div>
        </div>
    </div>
</div>
@endsection

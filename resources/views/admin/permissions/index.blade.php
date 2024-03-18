@extends('layouts.adminDashboard')

@section('content')
<h3>Permissions List</h3>

 <!-- Basic table -->
 <section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div><a href="#" class="btn btn-primary float-end m-2 mb-0" data-bs-toggle="modal" data-bs-target="#addPermissionModal">Add New Permission</a></div>

                <table class="datatables-basic table">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Name</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @foreach ($permissions as $permission)
                    <tr>
                        <td>{{$permission->id}}</td>
                        <td>{{$permission->name}}</td>
                        <td>{{$permission->created_at}}</td>
                        <td>
                            <a href="{{ route('permissions.edit', $permission->id) }}" class="create-new btn btn-primary btn-sm">
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-danger btn-sm delete-permission" data-permission-id="{{ $permission->id }}">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</section>
<!--/ Basic table -->

<!-- Add Permission Modal -->
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 pb-5">
                <div class="text-center mb-2">
                    <h1 class="mb-1">Add New Permission</h1>
                    <p>Permissions you may use and assign to your users</p>
                </div>
                <form id="addPermissionForm" class="row" action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div class="col-12">
                        <label class="form-label" for="modalPermissionName">Permission Name</label>
                        <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control" placeholder="Permission Name" autofocus data-msg="Please enter permission name" />
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary mt-2 me-1">Create Permission</button>
                        <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                            Discard
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Add Permission Modal -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        $('.delete-permission').on('click', function (e) {
            e.preventDefault();

            var permissionId = $(this).data('permission-id');

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
                    url: '/permissions/' + permissionId,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (error) {
                        console.error('Error deleting permission:', error);
                    }
                });
            }
        });
        });
    });
</script>
@endsection

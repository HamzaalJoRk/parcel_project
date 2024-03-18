@extends('layouts.adminDashboard')

@section('content')
@if ($errors->any())
<?php toastr(__('Make sure to add all required information'),'warning'); ?>
@endif
  <!-- Basic multiple Column Form section start -->
  <section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
              {{--   <div class="card-header">
                    <h4 class="card-title">Multiple Column</h4>
                </div> --}}
                <div class="card-body">
                    <form class="form" action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="first-name-column">Name</label>
                                    <input type="text" id="first-name-column" class="form-control" placeholder="Name" name="name" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="email-id-column">Email</label>
                                    <input type="email" id="email-id-column" class="form-control" name="email" placeholder="Email" />
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label class="form-label" for="select2-basic">Role</label>
                                <select class="select2 form-select" id="select2-basic" name="role">
                                    <option value="">Without Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-6 mb-2 form-password-toggle">
                                        <label class="form-label" for="newPassword">Password</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control" type="password" id="newPassword" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                            <span class="input-group-text cursor-pointer">
                                                <i data-feather="eye"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-2 form-password-toggle">
                                        <label class="form-label" for="confirmPassword">Confirm Password</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control" type="password" name="password_confirmation" id="confirmPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                            <span class="input-group-text cursor-pointer">
                                                <i data-feather="eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary me-1">Add</button>
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Basic Floating Label Form section end -->

@endsection

@extends('layouts.app')
@section('title', 'Edit User')

@section('breadcrumb-title')
<h3>Edit User</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{ route('voters.index') }}">Users</a></li>
<li class="breadcrumb-item"><a href="{{ route('voters.show', $user) }}">{{ $user->name }}</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5>Edit User Information</h5>
                </div>
                <form class="form theme-form" action="{{ route('voters.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col">
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Full Name <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">User ID <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" name="user_id" value="{{ old('user_id', $user->user_id) }}" required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Category <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="category" value="{{ old('category', $user->category) }}" required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Email <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Level</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="number" name="level" value="{{ old('level', $user->level) }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Phone Number</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="tel" name="phone" value="{{ old('phone', $user->phone) }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">New Password</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="password" name="password">
                                        <small class="text-muted">Leave blank to keep current password. Minimum 6 characters if changing.</small>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label">Roles</label>
                                    <div class="col-sm-9">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_admin">
                                                Admin
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_admin">
                                                ECC
                                            </label>
                                        </div>
                           
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-sm-9 offset-sm-3">
                            <button class="btn btn-primary" type="submit">Update User</button>
                            <a href="{{ route('voters.show', $user) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


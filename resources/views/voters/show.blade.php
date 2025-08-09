@extends('layouts.app')
@section('title', 'View User')

@section('breadcrumb-title')
<h3>User Details</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{ route('voters.index') }}">Users</a></li>
<li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-xl-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>User Information</h5>
                    <div>
                        <a href="{{ route('voters.edit', $user) }}" class="btn btn-warning">
                            <i class="fa fa-edit"></i> Edit User
                        </a>
                        <a href="{{ route('voters.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label fw-bold">Full Name:</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ $user->name }}</p>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label fw-bold">User ID:</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ $user->user_id }}</p>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label fw-bold">Category:</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ $user->category }}</p>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label fw-bold">Email:</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ $user->email }}</p>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label fw-bold">Level:</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ $user->level ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label fw-bold">Phone Number:</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ $user->phone ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label fw-bold">Email Verified:</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success">Yes</span>
                                            <small class="text-muted">({{ $user->email_verified_at->format('M d, Y') }})</small>
                                        @else
                                            <span class="badge bg-warning">No</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label fw-bold">Roles:</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">
                                        @if($user->is_admin)
                                            <span class="badge bg-danger">Admin</span>
                                        @endif
                                        @if($user->is_admin)
                                            <span class="badge bg-primary">ECC</span>
                                        @endif
                                        @if(!$user->is_admin && !$user->is_admin)
                                            <span class="badge bg-secondary">User</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label fw-bold">Created At:</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ $user->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label fw-bold">Last Updated:</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext">{{ $user->updated_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


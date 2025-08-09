@extends('layouts.app')
@section('title', 'Users')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
@endsection

@section('breadcrumb-title')
<h3>User Management</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Users</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>All Users</h5>
                    <a href="{{ route('voters.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Create New User
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive product-table">
                        <table class="display" id="basic-1">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>User ID</th>
                                    <th>Email</th>
                                    <th>Level</th>
                                    <th>Phone</th>
                                    <th>Roles</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->user_id }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->level ?? '-' }}</td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td>
                                        @if($user->is_admin)
                                            <span class="badge bg-danger">Admin</span>
                                        @endif
                                        @if($user->is_admin)
                                            <span class="badge bg-primary">ECC</span>
                                        @endif
                                        @if(!$user->is_admin && !$user->is_admin)
                                            <span class="badge bg-secondary">User</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('voters.show', $user) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('voters.edit', $user) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('voters.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/product-list-custom.js')}}"></script>
@endsection

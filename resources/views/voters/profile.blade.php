@extends('layouts.app')
@section('title', 'Settings')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Edit Profile</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Edit Profile</li>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12 col-xl-6 xl-100">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-9">
              <div class="card">
                <div class="card-header">
                  <h5>Edit Profile</h5>
                </div>					
                <form class="form theme-form" action="{{route('user.update')}}" method="POST">
                  @csrf
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        
						            <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label">Full Name</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="text" name="name" value="{{$user->name}}" readonly required>
                          </div>
                        </div>

                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label">User ID</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="number" value="{{$user->user_id}}" readonly name="user_id">
                          </div>
                        </div>

                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label">Email</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="text" value="{{$user->email}}" readonly name="email">
                          </div>
                        </div>

                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label">Level</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="number" value="{{$user->level}}" readonly name="level">
                          </div>
                        </div>

                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label">Phone Number</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="tel" value="{{$user->phone}}" required="" name="phone">
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="col-sm-9 offset-sm-3">
                      <button class="btn btn-outline-primary" type="submit">Update</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
@endsection
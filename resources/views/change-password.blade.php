@extends('layouts.app')
@section('title', 'Change Password')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Change Password</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-absolute">
				<div class="card-header bg-primary">
					<h5 class="text-white">Change Password</h5>
				</div>
				
				<form class="form theme-form" action="{{route('password.change')}}" method="POST">
	              @csrf
				  <div class="card-body">
	              <div class="card-body">
	                <div class="row">
	                  <div class="col">
	                    <div class="mb-3 row">
	                      <label class="col-sm-3 col-form-label">Old Password</label>
	                      <div class="col-sm-9">
	                        <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="current_password" placeholder="Enter current password">
	                        @error('current_password')
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $message }}</strong>
		                        </span>
		                    @enderror
	                      </div>
	                    </div>
	                    <div class="mb-3 row">
	                      <label class="col-sm-3 col-form-label">New Password</label>
	                      <div class="col-sm-9">
	                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" maxlength="14" placeholder="Enter a new password">
	                        @error('password')
		                        <span class="invalid-feedback" role="alert">
		                            <strong>{{ $message }}</strong>
		                        </span>
		                    @enderror
	                      </div>
	                    </div>
	                    <div class="mb-3 row">
	                      <label class="col-sm-3 col-form-label">Re-enter new password</label>
	                      <div class="col-sm-9">
	                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password">
	                      </div>
	                    </div>
	                  </div>
	                
						<div class="col-sm-9 offset-sm-3">
							<button class="btn btn-outline-primary" type="submit">Change Password</button>
						</div>
					</div>
	              </div>
				</div>
	            </form>
				
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
@endsection


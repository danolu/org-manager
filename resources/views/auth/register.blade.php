@extends('layouts.auth')
@section('title', 'Login')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12 p-0">
         <div class="login-card">
            <div>
               <div class="d-flex justify-content-center">
                  <a class="logo text-start" href="{{ route('dashboard')}}">
                     <img class="img-fluid for-light" src="{{asset('assets/images/logo/logo.png')}}" alt="looginpage">
                     <img class="img-fluid for-dark" src="{{asset('assets/images/logo/logo_dark.png')}}" alt="looginpage">
                  </a>
               </div>
               <div class="login-main">
                  <form class="theme-form" method="POST" action="{{ route('login.submit') }}">
                     @csrf
                     <h5>Register</h5>

					 <div class="form-group">
                        <label class="col-form-label">Full Name*</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" required name="name" value="{{ old('name') }}" autocomplete="name" autofocus placeholder="Enter your full name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                     </div>

					 <div class="form-group">
                        <label class="col-form-label">Email*</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="name" required name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Enter your full name">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                     </div>

                     <div class="form-group">
                        <label class="col-form-label">User ID*</label>
                        <input type="number" class="form-control required @error('username') is-invalid @enderror" id="user_id" name="user_id" value="{{ old('user_id') }}" autocomplete="user_id" placeholder="User ID">
                        @error('user_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                     </div>

					 <div class="form-group">
                        <label class="col-form-label">Level*</label>
						<select name="level" id="level" required autocomplete="level" class="form-control required @error('level') is-invalid @enderror">
							<option value="">Select level </option>
							<option value="100"{{(old('level')=='100')?' selected="selected"':''}}>100</option>
							<option value="200"{{(old('level')=='200')?' selected="selected"':''}}>200</option>
							<option value="300"{{(old('level')=='300')?' selected="selected"':''}}>300</option>
							<option value="400"{{(old('level')=='400')?' selected="selected"':''}}>400</option>
							<option value="500"{{(old('level')=='500')?' selected="selected"':''}}>500</option>
							<option value="600"{{(old('level')=='600')?' selected="selected"':''}}>600</option>
						</select>
                        @error('level')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                     </div>

                     <div class="form-group">
                        <label class="col-form-label">Password (Mininum of 8 characters)*</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="current-password" placeholder="*********">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror               
                     </div>
					 <div class="form-group">
                        <label class="col-form-label">Confirm Password*</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password_confirm" name="password_confirmation" autocomplete="current-password" placeholder="*********">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror               
                     </div>
                     <div class="form-group mb-0">
                        <button class="btn btn-primary btn-block" type="submit">Register</button>
                     </div>
                     <p class="mt-4 mb-0">Already have an account?<a class="ms-2" href="{{ route('login') }}">Sign In</a></p>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
@endsection
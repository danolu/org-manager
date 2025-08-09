@extends('layouts.auth')
@section('title', 'Reset Password')

@section('css')
@endsection

@section('style')
@endsection


@section('content')
<!-- tap on top starts-->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on tap ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper">
   <div class="container-fluid p-0">
      <div class="row">
         <div class="col-12">
            <div class="login-card">
               <div>
                  <div>
                     <a class="logo" href="{{ route('dashboard') }}">
                        <img class="img-fluid for-light" src="{{asset('assets/images/logo/logo.png')}}" alt="looginpage">
                        <img class="img-fluid for-dark" src="{{asset('assets/images/logo/logo.png')}}" alt="looginpage">
                     </a>
                  </div>
                  <div class="login-main">
                     <form class="theme-form" method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <h4>Create New Password</h4>
                        <div class="mb-3">
                           <label class="col-form-label">Email</label>
                           <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" autocomplete="email" required autofocus>
                           @error('email')
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                 </span>
                           @enderror  
                           <div class="show-hide"><span class="show"></span></div>
                        </div>
                        <div class="mb-3">
                           <label class="col-form-label">New Password</label>
                           <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                           @error('password')
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                 </span>
                           @enderror  
                           <div class="show-hide"><span class="show"></span></div>
                        </div>
                        <div class="mb-3">
                           <label class="col-form-label">Retype Password</label>
                           <input type="password" class="form-control" id="password_confirm" name="password_confirmation" placeholder="Password confirmation." required>
                        </div>
                        <div class="mb-3 mb-0">
                           <button class="btn btn-primary btn-block" type="submit">RESET PASSWORD</button>
                        </div>
                        <p class="mt-4 mb-0"><a class="ml-2" href="{{ route('login') }}">Sign in here</a></p>
                     </form>
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
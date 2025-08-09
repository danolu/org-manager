@extends('layouts.auth')
@section('title', 'Forgot Password')

@section('css')
@endsection

@section('style')
@endsection


@section('content')
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<div class="page-wrapper">
   <div class="container-fluid p-0">
      <div class="row">
         <div class="col-12">
            <div class="login-card">
               <div>
                  <div>
                     <a class="logo" href="{{ route('dashboard') }}">
                        <img class="img-fluid for-light" src="{{asset('assets/images/logo/logo.png')}}" alt="looginpage">
                        <img class="img-fluid for-dark" src="{{asset('assets/images/logo/logo_dark.png')}}" alt="looginpage">
                     </a>
                  </div>
                  <div class="login-main">
                     @if (session('status'))
                        <div class="alert alert-success" role="alert">
                           {{ session('status') }}
                        </div>
                     @endif
                     <form class="theme-form" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <h5>Reset Your Password</h5>
                        <div class="mb-3">
                           <label class="col-form-label">Enter Your Email</label>
                           <input type="email" class="form-control mb-1 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                           @error('email')
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                 </span>
                           @enderror  
                        </div>
                        <div class="mb-3">
                              <button class="btn btn-primary btn-block m-t-10" type="submit">SEND RESET LINK</button>
                        </div>
                        <p class="mt-4 mb-0">Hippocampus triggered?<a class="ml-2" href="{{ route('login') }}"> Sign in.</a></p>
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
<script src="{{ asset('assets/js/sidebar-menu.js')}}"></script>
@endsection
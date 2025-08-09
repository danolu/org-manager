@extends('layouts.auth')
@section('title', 'Login')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
   <div class="max-w-md w-full">
      <div class="bg-white rounded-lg shadow-lg p-8">
         <div class="flex justify-center mb-8">
            <a href="{{ route('dashboard')}}">
               <img class="h-16 w-auto" src="{{ $settings->logo ?? '' }}" alt="{{ $settings->name ?? '' }} Logo">
            </a>
         </div>

         <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Sign In</h2>

            <div class="form-group">
               <label class="block text-sm font-medium text-gray-700 mb-2">User ID or Email</label>
               <input type="text" class="form-control @error('login') is-invalid @enderror" id="login" name="login" value="{{ old('login') }}" autocomplete="username" autofocus placeholder="Enter User ID or Email">
               @error('login')
                   <span class="invalid-feedback block" role="alert">
                       <strong>{{ $message }}</strong>
                   </span>
               @enderror
            </div>

            <div class="form-group">
               <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
               <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="current-password" placeholder="Password">
               @error('password')
                   <span class="invalid-feedback block" role="alert">
                       <strong>{{ $message }}</strong>
                   </span>
               @enderror
            </div>

            <div class="mb-6">
               <div class="flex items-center">
                  <input id="checkbox1" type="checkbox" name="remember" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                  <label class="ml-2 block text-sm text-gray-600" for="checkbox1">Remember me</label>
               </div>
               <button class="btn-primary btn-block mt-4" type="submit">SIGN IN</button>
            </div>

            <p class="text-center text-sm text-gray-600">
               Forgot password?
               <a class="text-primary hover:text-primary/80 font-medium ml-1" href="{{ route('password.request') }}">Reset</a>
            </p>

         </form>
      </div>
   </div>
</div>
@endsection

@section('script')
@endsection
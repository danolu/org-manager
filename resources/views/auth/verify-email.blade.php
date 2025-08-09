@extends('layouts.auth')
@section('title', 'Verify Email')

@section('css')
@endsection

@section('style')
@endsection


@section('content')
<div class="tap-top"><i data-feather="chevrons-up"></i></div>


@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-12 p-0">
         <div class="login-card">
            <div class="card-header">Verify Your Email Address</div>
                <div class="login-main">
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                           <h6>A verification link has been sent to your email address. Kindly check your email for the link to get verified before proceeding. <br> </h6>
                        </div>
                    @endif
                    <form method="get" class="d-inline" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="p-2 btn btn-primary btn-block p-0 m-0 align-baseline">Resend Verification Link</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
@endsection
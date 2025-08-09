@extends('layouts.auth')
@section('title', 'Maintenance')

@section('css')
@endsection

@section('style')
@endsection


@section('content')
<div class="tap-top"><i data-feather="chevrons-up"></i></div>

<div class="page-wrapper">
   <div class="error-wrapper maintenance-bg">
      <div class="container">
         <ul class="maintenance-icons">
            <li><i class="fa fa-cog"></i></li>
            <li><i class="fa fa-cog"></i></li>
            <li><i class="fa fa-cog"></i></li>
         </ul>
         <div class="maintenance-heading">
            <h2 class="headline">MAINTENANCE</h2>
         </div>
         <h4 class="sub-content">We are currently working on serving you better. <br>Thank You For Patience</h4>
      </div>
   </div>
</div>
@endsection

@section('script')
@endsection
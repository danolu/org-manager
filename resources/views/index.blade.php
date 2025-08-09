@extends('layouts.app')
@section('title', 'Dashboard')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h4>Dashboard</h4>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">

   <h6 class="text-xl font-semibold text-gray-800 mb-4"> Welcome, {{$user->name}}. </h6>
   <hr class="mb-6 border-gray-300">

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

      <div>
        <a href="{{ route('election')}}">
          <div class="card hover:shadow-lg transition-shadow">
            <div class="card-body bg-primary text-white">
              <span class="font-medium">Cast Your Votes</span>
               <div class="flex items-end gap-1 mt-2">
                   <h4 class="mb-0 mt-1"></h4>
               </div>
               <div class="mt-4 opacity-20"><i data-feather="check-square"></i>
               </div>
            </div>
          </div>
        </a>
      </div>


      <div>
        <a href="{{ route('user.edit')}}">
          <div class="card hover:shadow-lg transition-shadow">
            <div class="card-body bg-blue-400 text-white">
              <span class="font-medium">Edit Profile</span>
               <div class="flex items-end gap-1 mt-2">
                   <h4 class="mb-0 mt-1"></h4>
               </div>
               <div class="mt-4 opacity-20"><i data-feather="user"></i>
               </div>
            </div>
         </div>
        </a>
      </div>

      <div>
        <a href="{{ route('password.change')}}">
          <div class="card hover:shadow-lg transition-shadow">
            <div class="card-body bg-secondary text-white">
              <span class="font-medium">Change Password</span>
               <div class="flex items-end gap-1 mt-2">
                   <h4 class="mb-0 mt-1"></h4>
               </div>
               <div class="mt-4 opacity-20"><i data-feather="lock"></i>
               </div>
            </div>
          </div>
        </a>
      </div>

    </div>
</div>

@endsection

@section('script')
@endsection
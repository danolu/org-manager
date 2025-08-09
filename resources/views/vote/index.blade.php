@extends('layouts.app')
@section('title', 'Dashboard')

@section('breadcrumb-title')
<h3>{{date('Y')}} Elections</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Elections</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="col-sm-12 col-xxl-6 box-col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="pb-2">{{ $user->category }}</h5>
                <p>Hello {{ $user->name }}, kindly select your preferred candidates to vote. Do not select more than ten(10) candidates.</p>
            </div>
            <form method="POST" action="{{ url()->current() }}">
    @csrf

    @if ($maxVote === 1)
        {{-- Render Yes/No per candidate --}}
        @foreach ($candidates as $slug => $name)
            <hr />
            <h4 class="text-center p-4">{{ strtoupper($name) }}</h4>
            <div class="card-body megaoptions-border-space-sm d-flex justify-content-center">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card" onclick="selectRadio('{{ $slug }}')">
                            <div class="media p-20 align-items-center">
                                <div class="form-check radio radio-success">
                                    <input class="form-check-input" id="{{ $slug }}" type="radio" name="{{ $slug }}" value="y">
                                    <label class="form-check-label mega-title-badge text-success" for="{{ $slug }}">YES</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card" onclick="selectRadio('{{ $slug }}-no')">
                            <div class="media p-20 align-items-center">
                                <div class="form-check radio radio-danger">
                                    <input class="form-check-input" id="{{ $slug }}-no" type="radio" name="{{ $slug }}" value="n">
                                    <label class="form-check-label mega-title-badge text-danger" for="{{ $slug }}-no">NO</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        {{-- Render multiple choice selection (choose up to 10) --}}
        <p class="text-center">You may vote for up to {{ $maxVote }} congressmen.</p>
        <div class="row">
            @foreach ($candidates as $slug => $name)
                <div class="col-md-4">
                    <div class="card m-2">
                        <div class="card-body d-flex align-items-center">
                            <div class="form-check checkbox checkbox-primary">
                                <input class="form-check-input" type="checkbox" id="{{ $slug }}" name="votes[]" value="{{ $slug }}">
                                <label class="form-check-label" for="{{ $slug }}">{{ $name }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="text-center mt-4">
        <button class="btn btn-primary" type="submit">Submit Vote</button>
    </div>
</form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function selectRadio(id) {
        document.getElementById(id).checked = true;
    }
</script>
@endsection
@extends('layouts.app')
@section('title', 'Election Results')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/prism.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Election Results</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Election Results</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(empty($results))
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No election results available yet.
                        </div>
                    </div>
                </div>
            @else
                @foreach($results as $result)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>
                                {{ $result['position']->name }}
                                <span class="badge badge-primary ml-2">
                                    @if($result['position']->type === 'single')
                                        Single Choice
                                    @elseif($result['position']->type === 'multiple')
                                        Multiple Choice (Max: {{ $result['position']->max_vote }})
                                    @else
                                        Yes/No
                                    @endif
                                </span>
                            </h5>
                            <div class="card-header-right d-flex">
                                <ul class="list-unstyled card-option">
                                    <li><i class="fa fa-spin fa-cog"></i></li>
                                    <li><i class="icofont icofont-maximize full-card"></i></li>
                                    <li><i class="icofont icofont-minus minimize-card"></i></li>
                                    <li><i class="icofont icofont-refresh reload-card"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(empty($result['results']))
                                <p class="text-muted">No votes cast for this position yet.</p>
                            @else
                                <div class="user-status table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">Rank</th>
                                                <th width="10%">Photo</th>
                                                <th width="30%">Candidate</th>
                                                <th width="15%">Tag</th>
                                                <th width="15%">Votes</th>
                                                <th width="25%">Vote Distribution</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalVotes = array_sum(array_column($result['results'], 'votes'));
                                            @endphp
                                            @foreach($result['results'] as $index => $candidateResult)
                                                @php
                                                    $percentage = $totalVotes > 0 ? ($candidateResult['votes'] / $totalVotes) * 100 : 0;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">
                                                        @if($index === 0 && $candidateResult['votes'] > 0)
                                                            <i class="fas fa-trophy text-warning fa-2x"></i>
                                                        @else
                                                            {{ $index + 1 }}
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if($candidateResult['candidate']->photo)
                                                            <img src="{{ asset('storage/' . $candidateResult['candidate']->photo) }}"
                                                                 alt="{{ $candidateResult['candidate']->name }}"
                                                                 class="img-thumbnail rounded-circle"
                                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center"
                                                                 style="width: 60px; height: 60px;">
                                                                <i class="fas fa-user fa-2x text-white"></i>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ $candidateResult['candidate']->name }}</strong>
                                                    </td>
                                                    <td>
                                                        @if($candidateResult['candidate']->tag)
                                                            <span class="badge badge-info">{{ $candidateResult['candidate']->tag }}</span>
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <h5 class="mb-0">
                                                            <span class="badge badge-success">{{ $candidateResult['votes'] }}</span>
                                                        </h5>
                                                    </td>
                                                    <td>
                                                        <div class="progress" style="height: 25px;">
                                                            <div class="progress-bar bg-success"
                                                                 role="progressbar"
                                                                 style="width: {{ $percentage }}%;"
                                                                 aria-valuenow="{{ $percentage }}"
                                                                 aria-valuemin="0"
                                                                 aria-valuemax="100">
                                                                {{ number_format($percentage, 1) }}%
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-light">
                                                <th colspan="4" class="text-right">Total Votes:</th>
                                                <th colspan="2">
                                                    <span class="badge badge-primary badge-lg">{{ $totalVotes }}</span>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="text-right mt-2">
                                    <a href="{{ route('results.position', $result['position']->slug) }}"
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-chart-bar"></i> View Detailed Results
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

@endsection
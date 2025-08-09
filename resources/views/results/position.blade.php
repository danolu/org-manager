@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Detailed Results: {{ $position->name }}</h3>
                    <a href="{{ route('results') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i> Back to All Results
                    </a>
                </div>
                <div class="card-body">
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

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Position Type:</strong>
                                        @if($position->type === 'single')
                                            <span class="badge badge-primary">Single Choice</span>
                                        @elseif($position->type === 'multiple')
                                            <span class="badge badge-info">Multiple Choice (Max: {{ $position->max_vote }})</span>
                                        @else
                                            <span class="badge badge-warning">Yes/No</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Total Candidates:</strong> {{ count($results) }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Total Votes Cast:</strong> 
                                        @php
                                            $totalVotes = array_sum(array_column($results, 'yes_votes'));
                                        @endphp
                                        {{ $totalVotes }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(empty($results))
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> No votes have been cast for this position yet.
                        </div>
                    @else
                        <div class="row">
                            @foreach($results as $index => $result)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 {{ $index === 0 && $result['yes_votes'] > 0 ? 'border-warning' : '' }}">
                                        @if($index === 0 && $result['yes_votes'] > 0)
                                            <div class="card-header bg-warning text-white text-center">
                                                <i class="fas fa-trophy fa-2x"></i>
                                                <h5 class="mb-0 mt-2">Leading Candidate</h5>
                                            </div>
                                        @endif
                                        <div class="card-body text-center">
                                            @if($result['candidate']->photo)
                                                <img src="{{ asset('storage/' . $result['candidate']->photo) }}" 
                                                     alt="{{ $result['candidate']->name }}" 
                                                     class="img-thumbnail rounded-circle mb-3" 
                                                     style="width: 150px; height: 150px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                                     style="width: 150px; height: 150px;">
                                                    <i class="fas fa-user fa-5x text-white"></i>
                                                </div>
                                            @endif

                                            <h4 class="card-title">{{ $result['candidate']->name }}</h4>
                                            
                                            @if($result['candidate']->tag)
                                                <p class="card-text">
                                                    <span class="badge badge-info badge-lg">{{ $result['candidate']->tag }}</span>
                                                </p>
                                            @endif

                                            <hr>

                                            <div class="row">
                                                <div class="col-6">
                                                    <h5 class="text-success">
                                                        <i class="fas fa-thumbs-up"></i> Yes
                                                    </h5>
                                                    <h2 class="mb-0">
                                                        <span class="badge badge-success">{{ $result['yes_votes'] }}</span>
                                                    </h2>
                                                </div>
                                                <div class="col-6">
                                                    <h5 class="text-danger">
                                                        <i class="fas fa-thumbs-down"></i> No
                                                    </h5>
                                                    <h2 class="mb-0">
                                                        <span class="badge badge-danger">{{ $result['no_votes'] }}</span>
                                                    </h2>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="mb-2">
                                                <strong>Total Votes:</strong> 
                                                <span class="badge badge-primary badge-lg">{{ $result['total_votes'] }}</span>
                                            </div>

                                            @if($result['total_votes'] > 0)
                                                @php
                                                    $yesPercentage = ($result['yes_votes'] / $result['total_votes']) * 100;
                                                    $noPercentage = ($result['no_votes'] / $result['total_votes']) * 100;
                                                @endphp
                                                <div class="progress mb-2" style="height: 30px;">
                                                    <div class="progress-bar bg-success" 
                                                         role="progressbar" 
                                                         style="width: {{ $yesPercentage }}%;" 
                                                         aria-valuenow="{{ $yesPercentage }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100">
                                                        {{ number_format($yesPercentage, 1) }}%
                                                    </div>
                                                    <div class="progress-bar bg-danger" 
                                                         role="progressbar" 
                                                         style="width: {{ $noPercentage }}%;" 
                                                         aria-valuenow="{{ $noPercentage }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100">
                                                        {{ number_format($noPercentage, 1) }}%
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header bg-secondary text-white">
                                        <h5 class="mb-0">Summary Table</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Rank</th>
                                                        <th>Candidate</th>
                                                        <th>Tag</th>
                                                        <th>Yes Votes</th>
                                                        <th>No Votes</th>
                                                        <th>Total Votes</th>
                                                        <th>Approval Rate</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($results as $index => $result)
                                                        <tr>
                                                            <td class="text-center">
                                                                @if($index === 0 && $result['yes_votes'] > 0)
                                                                    <i class="fas fa-trophy text-warning fa-lg"></i>
                                                                @else
                                                                    {{ $index + 1 }}
                                                                @endif
                                                            </td>
                                                            <td>{{ $result['candidate']->name }}</td>
                                                            <td>
                                                                @if($result['candidate']->tag)
                                                                    <span class="badge badge-info">{{ $result['candidate']->tag }}</span>
                                                                @else
                                                                    <span class="text-muted">N/A</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="badge badge-success">{{ $result['yes_votes'] }}</span>
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="badge badge-danger">{{ $result['no_votes'] }}</span>
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="badge badge-primary">{{ $result['total_votes'] }}</span>
                                                            </td>
                                                            <td>
                                                                @if($result['total_votes'] > 0)
                                                                    @php
                                                                        $approvalRate = ($result['yes_votes'] / $result['total_votes']) * 100;
                                                                    @endphp
                                                                    <div class="progress" style="height: 25px;">
                                                                        <div class="progress-bar {{ $approvalRate >= 50 ? 'bg-success' : 'bg-danger' }}" 
                                                                             role="progressbar" 
                                                                             style="width: {{ $approvalRate }}%;" 
                                                                             aria-valuenow="{{ $approvalRate }}" 
                                                                             aria-valuemin="0" 
                                                                             aria-valuemax="100">
                                                                            {{ number_format($approvalRate, 1) }}%
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <span class="text-muted">N/A</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


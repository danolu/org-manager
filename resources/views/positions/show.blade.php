@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Position Details: {{ $position->name }}</h3>
                    <div>
                        <a href="{{ route('positions.edit', $position) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('positions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
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

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Position Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Position Name:</th>
                                    <td>{{ $position->name }}</td>
                                </tr>
                                <tr>
                                    <th>Vote Type:</th>
                                    <td>
                                        @if($position->type === 'single')
                                            <span class="badge badge-primary">Single Choice</span>
                                            <small class="text-muted d-block mt-1">Voters select one candidate from all</small>
                                        @elseif($position->type === 'multiple')
                                            <span class="badge badge-info">Multiple Choice</span>
                                            <small class="text-muted d-block mt-1">Voters can select up to {{ $position->max_vote }} candidates</small>
                                        @else
                                            <span class="badge badge-warning">Yes/No</span>
                                            <small class="text-muted d-block mt-1">Voters vote yes or no for each candidate</small>
                                        @endif
                                    </td>
                                </tr>
                                @if($position->type === 'multiple')
                                    <tr>
                                        <th>Max Votes:</th>
                                        <td>{{ $position->max_vote }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Category Restriction:</th>
                                    <td>
                                        @if($position->category)
                                            <span class="badge badge-success">{{ $position->category }}</span>
                                            <small class="text-muted d-block mt-1">Only {{ $position->category }} users can vote</small>
                                        @else
                                            <span class="text-muted">None</span>
                                            <small class="text-muted d-block mt-1">All users can vote</small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>URL Slug:</th>
                                    <td><code>{{ $position->slug }}</code></td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $position->created_at->format('F d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated:</th>
                                    <td>{{ $position->updated_at->format('F d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5>Statistics</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Total Candidates:</th>
                                    <td>
                                        <span class="badge badge-secondary badge-lg">{{ $position->candidates->count() }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Votes Cast:</th>
                                    <td>
                                        <span class="badge badge-success badge-lg">{{ $position->votes->count() }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h5>Candidates for this Position</h5>
                            @if($position->candidates->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Name</th>
                                                <th>Tag</th>
                                                <th>Photo</th>
                                                <th>Added On</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($position->candidates as $index => $candidate)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $candidate->name }}</td>
                                                    <td>
                                                        @if($candidate->tag)
                                                            <span class="badge badge-info">{{ $candidate->tag }}</span>
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($candidate->photo)
                                                            <img src="{{ asset('storage/' . $candidate->photo) }}" 
                                                                 alt="{{ $candidate->name }}" 
                                                                 class="img-thumbnail" 
                                                                 style="max-width: 50px; max-height: 50px;">
                                                        @else
                                                            <span class="text-muted">No photo</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $candidate->created_at->format('M d, Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> No candidates have been added to this position yet.
                                    <a href="{{ route('candidates.create') }}" class="alert-link">Add a candidate</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


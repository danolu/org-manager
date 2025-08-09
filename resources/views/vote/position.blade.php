@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Vote for {{ $position->name }}</h3>
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

                    @if($candidates->isEmpty())
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> No candidates available for this position.
                        </div>
                    @else
                        <form action="{{ route('vote', $position->slug) }}" method="POST">
                            @csrf

                            @if($position->isYesNo())
                                {{-- Yes/No Vote Type - Vote for ALL candidates --}}
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Vote <strong>Yes</strong> or <strong>No</strong> for <strong>each candidate</strong> below.
                                </div>

                                @foreach($candidates as $candidate)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-md-2 text-center">
                                                    @if($candidate->photo)
                                                        <img src="{{ asset('storage/' . $candidate->photo) }}"
                                                             alt="{{ $candidate->name }}"
                                                             class="img-thumbnail rounded-circle"
                                                             style="width: 100px; height: 100px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                                             style="width: 100px; height: 100px;">
                                                            <i class="fas fa-user fa-3x text-white"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <h4 class="mb-1">{{ $candidate->name }}</h4>
                                                    @if($candidate->tag)
                                                        <p class="text-muted mb-0">
                                                            <span class="badge badge-info">{{ $candidate->tag }}</span>
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group mb-0">
                                                        <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                                            <label class="btn btn-outline-success">
                                                                <input type="radio" name="vote_{{ $candidate->id }}" value="yes" required> Yes
                                                            </label>
                                                            <label class="btn btn-outline-danger">
                                                                <input type="radio" name="vote_{{ $candidate->id }}" value="no" required> No
                                                            </label>
                                                        </div>
                                                        @error("vote_{$candidate->id}")
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            @elseif($position->isSingle())
                                {{-- Single Choice Vote Type --}}
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Select <strong>one</strong> candidate for this position.
                                </div>

                                <div class="row">
                                    @foreach($candidates as $candidate)
                                        <div class="col-md-6 mb-3">
                                            <div class="card h-100 candidate-card">
                                                <div class="card-body text-center">
                                                    @if($candidate->photo)
                                                        <img src="{{ asset('storage/' . $candidate->photo) }}" 
                                                             alt="{{ $candidate->name }}" 
                                                             class="img-thumbnail rounded-circle mb-3" 
                                                             style="width: 120px; height: 120px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                                             style="width: 120px; height: 120px;">
                                                            <i class="fas fa-user fa-4x text-white"></i>
                                                        </div>
                                                    @endif
                                                    <h5 class="card-title">{{ $candidate->name }}</h5>
                                                    @if($candidate->tag)
                                                        <p class="card-text">
                                                            <span class="badge badge-info">{{ $candidate->tag }}</span>
                                                        </p>
                                                    @endif
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" 
                                                               id="candidate_{{ $candidate->id }}" 
                                                               name="{{ $inputName }}" 
                                                               value="{{ $candidate->id }}" 
                                                               class="custom-control-input" 
                                                               required>
                                                        <label class="custom-control-label" for="candidate_{{ $candidate->id }}">
                                                            Select this candidate
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            @elseif($position->isMultiple())
                                {{-- Multiple Choice Vote Type --}}
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Select up to <strong>{{ $position->max_vote }}</strong> candidates for this position.
                                </div>

                                <div class="row">
                                    @foreach($candidates as $candidate)
                                        <div class="col-md-6 mb-3">
                                            <div class="card h-100 candidate-card">
                                                <div class="card-body text-center">
                                                    @if($candidate->photo)
                                                        <img src="{{ asset('storage/' . $candidate->photo) }}" 
                                                             alt="{{ $candidate->name }}" 
                                                             class="img-thumbnail rounded-circle mb-3" 
                                                             style="width: 120px; height: 120px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                                             style="width: 120px; height: 120px;">
                                                            <i class="fas fa-user fa-4x text-white"></i>
                                                        </div>
                                                    @endif
                                                    <h5 class="card-title">{{ $candidate->name }}</h5>
                                                    @if($candidate->tag)
                                                        <p class="card-text">
                                                            <span class="badge badge-info">{{ $candidate->tag }}</span>
                                                        </p>
                                                    @endif
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" 
                                                               id="candidate_{{ $candidate->id }}" 
                                                               name="candidates[]" 
                                                               value="{{ $candidate->id }}" 
                                                               class="custom-control-input candidate-checkbox">
                                                        <label class="custom-control-label" for="candidate_{{ $candidate->id }}">
                                                            Select this candidate
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-vote-yea"></i> Submit Vote
                                </button>
                                <a href="{{ url('/election') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .candidate-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .candidate-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        @if($position->isMultiple())
            // Limit checkbox selection to max_vote
            const maxVotes = {{ $position->max_vote }};
            
            $('.candidate-checkbox').on('change', function() {
                const checkedCount = $('.candidate-checkbox:checked').length;
                
                if (checkedCount > maxVotes) {
                    $(this).prop('checked', false);
                    alert('You can only select up to ' + maxVotes + ' candidates.');
                }
            });
        @endif

        // Make card clickable
        $('.candidate-card').on('click', function() {
            const input = $(this).find('input[type="radio"], input[type="checkbox"]');
            
            @if($position->isSingle())
                input.prop('checked', true);
            @elseif($position->isMultiple())
                const checkedCount = $('.candidate-checkbox:checked').length;
                if (!input.is(':checked') && checkedCount >= {{ $position->max_vote }}) {
                    alert('You can only select up to {{ $position->max_vote }} candidates.');
                } else {
                    input.prop('checked', !input.is(':checked'));
                }
            @endif
        });
    });
</script>
@endpush
@endsection


@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Position</h3>
                </div>
                <form action="{{ route('positions.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="name">Position Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="e.g., President, Vice President, Senator"
                                   required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Enter the name of the position</small>
                        </div>

                        <div class="form-group">
                            <label for="type">Vote Type <span class="text-danger">*</span></label>
                            <select class="form-control @error('type') is-invalid @enderror"
                                    id="type"
                                    name="type"
                                    required>
                                <option value="">-- Select Vote Type --</option>
                                <option value="single" {{ old('type') === 'single' ? 'selected' : '' }}>
                                    Single Choice (Select one candidate from all)
                                </option>
                                <option value="multiple" {{ old('type') === 'multiple' ? 'selected' : '' }}>
                                    Multiple Choice (Select up to maximum limit)
                                </option>
                                <option value="yes-no" {{ old('type') === 'yes-no' ? 'selected' : '' }}>
                                    Yes/No (Vote yes or no for each candidate)
                                </option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Choose how voters will select candidates for this position</small>
                        </div>

                        <div class="form-group" id="max_vote_group" style="display: none;">
                            <label for="max_vote">Maximum Votes Allowed <span class="text-danger">*</span></label>
                            <input type="number"
                                   class="form-control @error('max_vote') is-invalid @enderror"
                                   id="max_vote"
                                   name="max_vote"
                                   value="{{ old('max_vote', 2) }}"
                                   min="1"
                                   max="10">
                            @error('max_vote')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Maximum number of candidates a voter can select (only for multiple choice)</small>
                        </div>

                        <div class="form-group">
                            <label for="category">Category Restriction (Optional)</label>
                            <input type="text"
                                   class="form-control @error('category') is-invalid @enderror"
                                   id="category"
                                   name="category"
                                   value="{{ old('category') }}"
                                   placeholder="e.g., 100l, 200l, 300l">
                            @error('category')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Leave blank to allow all users to vote. Enter a category (e.g., "100l") to restrict voting to users in that category only.</small>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Position
                        </button>
                        <a href="{{ route('positions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Show/hide max_vote field based on type selection
        $('#type').on('change', function() {
            if ($(this).val() === 'multiple') {
                $('#max_vote_group').show();
                $('#max_vote').prop('required', true);
            } else {
                $('#max_vote_group').hide();
                $('#max_vote').prop('required', false);
            }
        });

        // Trigger on page load if type is already selected
        if ($('#type').val() === 'multiple') {
            $('#max_vote_group').show();
            $('#max_vote').prop('required', true);
        }
    });
</script>
@endpush
@endsection


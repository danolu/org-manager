@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Candidate</h1>
    <form action="{{ route('candidates.update', $candidate) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Type</label>
            <select name="type" class="form-control" required>
                <option value="senator" {{ $candidate->type == 'senator' ? 'selected' : '' }}>Senator</option>
                <option value="congressman" {{ $candidate->type == 'congressman' ? 'selected' : '' }}>Congressman</option>
                <option value="executive" {{ $candidate->type == 'executive' ? 'selected' : '' }}>Executive</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Level</label>
            <input type="text" name="level" class="form-control" value="{{ $candidate->level }}">
        </div>

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $candidate->title }}">
        </div>

        <div class="mb-3">
            <label>Candidate Name</label>
            <input type="text" name="name" class="form-control" value="{{ $candidate->name }}" required>
        </div>

        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
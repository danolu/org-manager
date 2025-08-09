@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Candidate</h1>
    <form action="{{ route('candidates.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Type</label>
            <select name="type" class="form-control" required>
                <option value="">Select type</option>
                <option value="senator">Senator</option>
                <option value="congressman">Congressman</option>
                <option value="executive">Executive</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Level (for senators/congressmen)</label>
            <input type="text" name="level" class="form-control" placeholder="e.g., 100, 200">
        </div>

        <div class="mb-3">
            <label>Title (for executives)</label>
            <input type="text" name="title" class="form-control" placeholder="e.g., President">
        </div>

        <div class="mb-3">
            <label>Candidate Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
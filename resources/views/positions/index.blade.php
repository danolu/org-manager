@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Positions Management</h3>
                    <a href="{{ route('positions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Position
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

                    <div class="table-responsive">
                        <table id="positionsTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Position Name</th>
                                    <th>Type</th>
                                    <th>Max Votes</th>
                                    <th>Category</th>
                                    <th>Candidates</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($positions as $index => $position)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $position->name }}</td>
                                        <td>
                                            @if($position->type === 'single')
                                                <span class="badge badge-primary">Single Choice</span>
                                            @elseif($position->type === 'multiple')
                                                <span class="badge badge-info">Multiple Choice</span>
                                            @else
                                                <span class="badge badge-warning">Yes/No</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($position->type === 'multiple')
                                                {{ $position->max_vote ?? 'N/A' }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($position->category)
                                                <span class="badge badge-success">{{ $position->category }}</span>
                                            @else
                                                <span class="text-muted">All Users</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $position->candidates_count }}</span>
                                        </td>
                                        <td>{{ $position->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('positions.show', $position) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('positions.edit', $position) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('positions.destroy', $position) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this position?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No positions found. Create one to get started!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#positionsTable').DataTable({
            "responsive": true,
            "autoWidth": false,
            "order": [[0, "asc"]]
        });
    });
</script>
@endpush
@endsection

